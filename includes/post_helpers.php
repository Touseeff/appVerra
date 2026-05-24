<?php
require_once __DIR__ . '/db.php';

function post_collect_form(): array {
    $status = $_POST['status'] ?? 'draft';
    if (!in_array($status, ['draft', 'scheduled', 'published'], true)) $status = 'draft';

    $publish_at = trim($_POST['publish_at'] ?? '');
    if ($publish_at !== '') {
        $publish_at = str_replace('T', ' ', $publish_at) . ':00';
    } else {
        $publish_at = ($status === 'published') ? date('Y-m-d H:i:s') : null;
    }

    return [
        'title'              => trim($_POST['title'] ?? ''),
        'slug'               => trim($_POST['slug'] ?? ''),
        'excerpt'            => trim($_POST['excerpt'] ?? ''),
        'content'            => post_sanitize_html($_POST['content'] ?? ''),
        'featured_image'     => trim($_POST['featured_image'] ?? ''),
        'featured_image_alt' => trim($_POST['featured_image_alt'] ?? ''),
        'meta_title'         => trim($_POST['meta_title'] ?? ''),
        'meta_description'   => trim($_POST['meta_description'] ?? ''),
        'og_image'           => trim($_POST['og_image'] ?? ''),
        'canonical_url'      => trim($_POST['canonical_url'] ?? ''),
        'author_name'        => trim($_POST['author_name'] ?? ''),
        'author_url'         => trim($_POST['author_url'] ?? ''),
        'status'             => $status,
        'publish_at'         => $publish_at,
    ];
}

// Defaults used in the public template when a post has no explicit author.
// Centralized so blog-post.php and JSON-LD agree.
function post_author_display(array $post): array {
    $name = trim((string)($post['author_name'] ?? ''));
    $url  = trim((string)($post['author_url']  ?? ''));
    if ($name === '') $name = 'AppVerra Editorial';
    if ($url  === '') $url  = 'https://appverra.co/about-us';
    return ['name' => $name, 'url' => $url];
}

function post_validate(array $data): array {
    $errors = [];
    if ($data['title'] === '')   $errors[] = 'Title is required.';
    if ($data['content'] === '') $errors[] = 'Content is required.';
    if ($data['status'] === 'scheduled' && empty($data['publish_at'])) {
        $errors[] = 'Scheduled posts need a publish date.';
    }
    if ($data['slug'] !== '' && !preg_match('/^[a-z0-9-]+$/', $data['slug'])) {
        $errors[] = 'Slug may only contain lowercase letters, digits, and dashes.';
    }
    return $errors;
}

// Minimal HTML allow-list filter for WYSIWYG content.
// Strips <script>, <style>, <iframe>, on* attributes, javascript: URLs.
function post_sanitize_html(string $html): string {
    $html = preg_replace('#<(script|style|iframe|object|embed)\b[^>]*>.*?</\1>#is', '', $html);
    $html = preg_replace('#<(script|style|iframe|object|embed)\b[^>]*/?>#i', '', $html);
    $html = preg_replace('#\son[a-z]+\s*=\s*"[^"]*"#i', '', $html);
    $html = preg_replace("#\son[a-z]+\s*=\s*'[^']*'#i", '', $html);
    $html = preg_replace('#\son[a-z]+\s*=\s*[^\s>]+#i', '', $html);
    $html = preg_replace('#(href|src)\s*=\s*"\s*javascript:[^"]*"#i', '$1="#"', $html);
    $html = preg_replace("#(href|src)\s*=\s*'\s*javascript:[^']*'#i", '$1="#"', $html);
    return $html;
}

function post_excerpt_from_content(string $html, int $len = 200): string {
    $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
    if (mb_strlen($text) <= $len) return $text;
    return rtrim(mb_substr($text, 0, $len)) . '…';
}

/**
 * Extract Q&A pairs from the post body for FAQPage JSON-LD schema.
 *
 * Convention (from blog_factory/voice/style_guide.md):
 *   <h2 ...>FAQs on …</h2>           ← any h2 whose text contains "FAQ" (case-insensitive)
 *   <p><strong>Question?</strong><br>Answer text.</p>
 *   <p><strong>Question?</strong><br>Answer text.</p>
 *   …
 *   <h2>...</h2>                      ← stops at the next h2
 *
 * Returns: [['question' => '…', 'answer' => '…'], …] or [] if no parseable FAQ.
 */
function post_extract_faqs(string $html): array {
    // Locate the FAQ h2 — match the whole h2 tag, then capture everything up to
    // the next h2 (or end of string).
    if (!preg_match(
        '#<h2[^>]*>\s*[^<]*\bFAQ[^<]*</h2>\s*(.*?)(?=<h2[\s>]|$)#is',
        $html,
        $m
    )) {
        return [];
    }
    $block = $m[1];
    // Each Q&A pair: <p><strong>Q</strong><br>Answer</p>
    if (!preg_match_all(
        '#<p[^>]*>\s*<strong[^>]*>(.*?)</strong>\s*(?:<br\s*/?>|:)\s*(.*?)</p>#is',
        $block,
        $pairs,
        PREG_SET_ORDER
    )) {
        return [];
    }
    $faqs = [];
    foreach ($pairs as $p) {
        $q = trim(strip_tags($p[1]));
        $a = trim(strip_tags($p[2]));
        // Strip leading "Q:" if the author prefixed it.
        $q = preg_replace('/^Q\s*:\s*/i', '', $q);
        if ($q === '' || $a === '') continue;
        $faqs[] = ['question' => $q, 'answer' => $a];
    }
    return $faqs;
}

/**
 * Rough reading-time estimate. ~225 wpm is the standard for English prose.
 * Returns minutes, minimum 1.
 */
function post_reading_minutes(string $html): int {
    $words = str_word_count(strip_tags($html));
    return max(1, (int)ceil($words / 225));
}

/**
 * Convert any MySQL DATETIME string to ISO 8601 (with timezone offset) for
 * <time datetime="…"> and JSON-LD datePublished / dateModified fields.
 */
function post_iso8601(?string $dt): string {
    if (!$dt) return '';
    $ts = strtotime($dt);
    return $ts ? date('c', $ts) : '';
}

function post_regenerate_sitemap(): void {
    $root  = realpath(__DIR__ . '/..');
    if (!$root) return;
    $file  = $root . '/sitemap.xml';
    $base  = 'https://appverra.co';

    $static_pages = [
        '/', '/about-us', '/contact-us', '/our-services', '/our-work', '/blogs',
        '/flutter-app-development', '/react-native-developer', '/unity-game-development',
        '/full-stack-development', '/mobile-app-marketing', '/ecommerce',
        '/cage-case-study', '/reactosphere-case-study', '/toriino-case-study', '/yuno-case-study',
        '/personal-finance-and-budgeting-tool', '/meditation-and-mental-wellness-app',
        '/event-planning-and-ticketing-app',
        '/privacy-policy', '/terms-and-condition',
    ];

    $today = date('Y-m-d');
    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($static_pages as $p) {
        $xml .= "  <url><loc>{$base}{$p}</loc><lastmod>{$today}</lastmod></url>\n";
    }
    $posts = db_all('
        SELECT slug, COALESCE(publish_at, updated_at) AS lastmod
        FROM posts
        WHERE status = "published"
           OR (status = "scheduled" AND publish_at <= NOW())
        ORDER BY lastmod DESC
    ');
    foreach ($posts as $p) {
        $loc = $base . '/' . htmlspecialchars($p['slug'], ENT_QUOTES | ENT_XML1);
        $mod = substr($p['lastmod'] ?? $today, 0, 10);
        $xml .= "  <url><loc>{$loc}</loc><lastmod>{$mod}</lastmod></url>\n";
    }
    $xml .= '</urlset>' . "\n";
    @file_put_contents($file, $xml);
}
