<?php
/**
 * One-time migration: pull the 9 existing static .php blog posts into the
 * `posts` MySQL table. Safe to re-run — skips slugs that already exist.
 *
 * USAGE (browser, requires admin login):
 *   1. Log in at /admin/login.php
 *   2. Visit /migrations/migrate_existing_blogs.php?confirm=YES_MIGRATE
 *   3. Review the report, then delete the static .php files manually.
 *
 * USAGE (CLI):
 *   php migrations/migrate_existing_blogs.php
 */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/slugify.php';
require_once __DIR__ . '/../includes/post_helpers.php';

$is_cli = (PHP_SAPI === 'cli');

if (!$is_cli) {
    require_once __DIR__ . '/../includes/auth.php';
    require_auth();
    if (($_GET['confirm'] ?? '') !== 'YES_MIGRATE') {
        header('Content-Type: text/plain');
        echo "Append ?confirm=YES_MIGRATE to run.\n";
        exit;
    }
    header('Content-Type: text/plain; charset=utf-8');
}

$root = realpath(__DIR__ . '/..');

$blogs = [
    'why-unity-is-still-a-powerhouse-for-indie-game-development-in-2025',
    'ai-react-native-integration-building-smarter-mobile-experiences',
    'developing-flutter-apps-for-emerging-use-cases-iot-wearables-and-pwas',
    'handling-state-management-chaos-in-full-stack-apps-practical-solutions',
    'low-ad-budgets-creative-mobile-app-marketing-hacks-that-work',
    'voice-commerce-in-2025-how-to-enable-hands-fee-shopping-in-your-app',
    'accessibility-in-react-native-bridging-gaps-for-inclusive-apps',
    'security-privacy-and-compliance-in-flutter-apps-best-practices-for-2025',
    'unity-pricing-changes-explained-what-developers-need-to-know-in-2025',
];

// Determine an author_id — use first user in table.
$author = db_one('SELECT id FROM users ORDER BY id ASC LIMIT 1');
$author_id = $author['id'] ?? null;

echo "AppVerra blog migration\n";
echo "=======================\n\n";

$created = 0; $skipped = 0; $failed = 0;

foreach ($blogs as $slug) {
    $path = $root . '/' . $slug . '.php';
    if (!is_file($path)) {
        echo "[SKIP] $slug — file not found\n"; $skipped++; continue;
    }
    $existing = db_one('SELECT id FROM posts WHERE slug = ? LIMIT 1', 's', [$slug]);
    if ($existing) {
        echo "[SKIP] $slug — already in DB (id={$existing['id']})\n"; $skipped++; continue;
    }

    $raw = file_get_contents($path);
    if ($raw === false) { echo "[FAIL] $slug — could not read\n"; $failed++; continue; }

    // Extract $meta_title, $meta_discription, $og_image (single-quoted or double-quoted).
    $meta_title = extract_php_var($raw, 'meta_title') ?? humanize_slug($slug);
    $meta_desc  = extract_php_var($raw, 'meta_discription') ?? '';
    $og_image   = extract_php_var($raw, 'og_image') ?? '';

    // Get content between the header include and the footer include.
    $content_html = extract_content_block($raw);
    if ($content_html === '') {
        echo "[FAIL] $slug — could not extract content body\n"; $failed++; continue;
    }
    // Strip the redundant <h1> banner section if present — blog-post.php re-adds it.
    $content_html = preg_replace(
        '#<section class="terms_privacy_banner[^"]*"[^>]*>.*?</section>#is',
        '', $content_html
    );

    $title   = humanize_slug($slug);  // Human title (meta_title is often SEO-tuned)
    $excerpt = post_excerpt_from_content($content_html, 200);

    db_exec('
        INSERT INTO posts
            (slug, title, excerpt, content, featured_image,
             meta_title, meta_description, og_image,
             status, publish_at, author_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, "published", NOW(), ?)
    ',
        'ssssssssi',
        [
            $slug, $title, $excerpt, $content_html,
            'assets/images/blog-img.webp',
            $meta_title, $meta_desc, $og_image,
            $author_id
        ]
    );
    echo "[OK]   $slug\n";
    $created++;
}

post_regenerate_sitemap();

echo "\nDone — created: $created · skipped: $skipped · failed: $failed\n";
echo "\nNext step: visually verify each URL, then DELETE the 9 static .php files:\n";
foreach ($blogs as $slug) echo "  rm " . $slug . ".php\n";

// ---- helpers ----

function extract_php_var(string $php, string $var): ?string {
    // Match: $var = "..."; or $var = '...';
    if (preg_match('/\$' . preg_quote($var, '/') . '\s*=\s*(["\'])(.*?)\1\s*;/s', $php, $m)) {
        return trim($m[2]);
    }
    return null;
}

function extract_content_block(string $php): string {
    // Take everything after the first PHP closing tag, before the footer include.
    $after_header = preg_split('/\?>\s*/', $php, 2);
    if (count($after_header) < 2) return '';
    $body = $after_header[1];

    $open = '<' . '?php';
    foreach ([
        $open . ' include("footer.php")',
        $open . " include('footer.php')",
        $open . ' include "footer.php"',
        $open . " include 'footer.php'",
    ] as $needle) {
        $pos = strpos($body, $needle);
        if ($pos !== false) { $body = substr($body, 0, $pos); break; }
    }

    // The static blog template wraps the actual article inside
    //   <section class="tac_sec case-study"> ... <div class="col-md-6">REAL CONTENT</div> ...
    // alongside a left-column TOC sidebar and a trailing <script> that drives
    // the pinned-TOC scroll behavior. We only want the inner HTML of col-md-6 —
    // blog-post.php re-adds the hero banner and a fresh sidebar, and the TOC
    // script can't survive sanitization anyway.
    $inner = extract_col_md_6_inner($body);
    return trim($inner !== '' ? $inner : $body);
}

function extract_col_md_6_inner(string $html): string {
    if ($html === '' || !class_exists('DOMDocument')) return '';

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    // Force UTF-8 + wrap so partial HTML parses cleanly.
    $wrapped = '<?xml encoding="UTF-8"><div id="__root">' . $html . '</div>';
    $doc->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    // Find the first <div> with class containing "col-md-6" — that's the article body.
    $nodes = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' col-md-6 ')]");
    if (!$nodes || $nodes->length === 0) return '';

    $target = $nodes->item(0);
    $out = '';
    foreach ($target->childNodes as $child) {
        $out .= $doc->saveHTML($child);
    }
    return $out;
}

function humanize_slug(string $slug): string {
    $words = explode('-', $slug);
    $small = ['a','an','the','and','or','for','of','in','on','to','vs','is','it','as'];
    $out = [];
    foreach ($words as $i => $w) {
        if ($i > 0 && in_array($w, $small, true)) { $out[] = $w; continue; }
        $out[] = ucfirst($w);
    }
    return implode(' ', $out);
}
