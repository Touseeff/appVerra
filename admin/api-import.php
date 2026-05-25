<?php
/**
 * Auto-import pending blog drafts via cron or CLI.
 *
 * Authentication:
 *   - CLI: no auth needed (php api-import.php)
 *   - HTTP: requires ?token=SECRET matching blog_factory/.import-token
 *
 * Kill switch: create blog_factory/.auto-import-disabled to halt all imports.
 *
 * Hostinger cron example (every 2 hours):
 *   0 */2 * * * wget -q -O /dev/null "https://appverra.co/admin/api-import.php?token=YOUR_TOKEN"
 */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/slugify.php';
require_once __DIR__ . '/../includes/post_helpers.php';
require_once __DIR__ . '/../includes/webp.php';

$ROOT         = realpath(__DIR__ . '/..');
$PENDING_DIR  = $ROOT . '/blog_factory/queue/pending';
$IMPORTED_DIR = $ROOT . '/blog_factory/queue/imported';
$TOKEN_FILE   = $ROOT . '/blog_factory/.import-token';
$KILL_FILE    = $ROOT . '/blog_factory/.auto-import-disabled';
$LOG_FILE     = $ROOT . '/blog_factory/auto-import.log';

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    header('Content-Type: application/json; charset=utf-8');
}

if (is_file($KILL_FILE)) {
    respond(200, 'paused', 'Auto-import is disabled. Remove blog_factory/.auto-import-disabled to resume.');
}

if (!$is_cli) {
    $expected_token = trim(@file_get_contents($TOKEN_FILE) ?: '');
    $provided_token = $_GET['token'] ?? '';
    if ($expected_token === '' || !hash_equals($expected_token, (string)$provided_token)) {
        respond(403, 'unauthorized', 'Invalid or missing token.');
    }
}

if (!is_dir($PENDING_DIR)) {
    respond(200, 'empty', 'No pending directory found.');
}

$files = glob($PENDING_DIR . '/*.md') ?: [];
if (empty($files)) {
    respond(200, 'empty', 'No pending drafts.');
}

sort($files);
$results = [];

foreach ($files as $file) {
    $slug = basename($file, '.md');
    $result = auto_import_post($slug, $PENDING_DIR, $IMPORTED_DIR, $ROOT);
    $results[] = $result;
    append_log($LOG_FILE, $result);
}

$imported = array_filter($results, fn($r) => $r['ok']);
$failed   = array_filter($results, fn($r) => !$r['ok']);

respond(200, 'done', sprintf(
    'Imported %d post(s), %d failed.',
    count($imported),
    count($failed)
), $results);

// ---------- helpers ----------

function auto_import_post(string $slug, string $pending_dir, string $imported_dir, string $repo_root): array {
    $md_file = $pending_dir . '/' . $slug . '.md';
    if (!is_file($md_file)) {
        return ['ok' => false, 'slug' => $slug, 'error' => 'File not found'];
    }

    $raw = @file_get_contents($md_file);
    if ($raw === false) {
        return ['ok' => false, 'slug' => $slug, 'error' => 'Cannot read file'];
    }

    if (!preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)$/s', $raw, $m)) {
        return ['ok' => false, 'slug' => $slug, 'error' => 'Cannot parse frontmatter'];
    }

    $fm   = parse_yaml($m[1]);
    $body = $m[2];

    $img_path = resolve_image_path($slug, $fm, $pending_dir, $repo_root);

    $publish_at = date('Y-m-d H:i:s', strtotime('+4 hours'));

    $data = [
        'slug'               => trim((string)($fm['slug'] ?? $slug)),
        'title'              => trim((string)($fm['title'] ?? '')),
        'excerpt'            => trim((string)($fm['excerpt'] ?? '')),
        'content'            => post_sanitize_html($body),
        'featured_image'     => $img_path,
        'featured_image_alt' => trim((string)($fm['featured_image_alt'] ?? '')),
        'meta_title'         => trim((string)($fm['meta_title'] ?? '')),
        'meta_description'   => trim((string)($fm['meta_description'] ?? '')),
        'og_image'           => $img_path,
        'canonical_url'      => trim((string)($fm['canonical_url'] ?? '')),
        'author_name'        => trim((string)($fm['author_name'] ?? '')),
        'author_url'         => trim((string)($fm['author_url']  ?? '')),
        'status'             => 'scheduled',
        'publish_at'         => $publish_at,
    ];

    $errors = post_validate($data);
    if ($errors) {
        return ['ok' => false, 'slug' => $slug, 'error' => 'Validation: ' . implode(' | ', $errors)];
    }

    $final_slug = slug_unique(slugify((string)($fm['slug'] ?? $slug)));

    $post_id = db_exec(
        'INSERT INTO posts
           (slug, title, excerpt, content,
            featured_image, featured_image_alt,
            meta_title, meta_description, og_image, canonical_url,
            author_name, author_url,
            status, publish_at, author_id)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        'ssssssssssssssi',
        [
            $final_slug, $data['title'], $data['excerpt'], $data['content'],
            $data['featured_image'], $data['featured_image_alt'],
            $data['meta_title'], $data['meta_description'], $data['og_image'], $data['canonical_url'],
            $data['author_name'], $data['author_url'],
            $data['status'], $data['publish_at'], 1
        ]
    );

    post_regenerate_sitemap();

    if (!is_dir($imported_dir)) @mkdir($imported_dir, 0755, true);
    @rename($md_file, $imported_dir . '/' . $slug . '-' . date('Ymd-His') . '.md');

    return [
        'ok'         => true,
        'slug'       => $final_slug,
        'post_id'    => $post_id,
        'status'     => 'scheduled',
        'publish_at' => $publish_at,
    ];
}

function resolve_image_path(string $slug, array $fm, string $pending_dir, string $repo_root): string {
    $fm_path = trim((string)($fm['featured_image'] ?? ''));

    if ($fm_path !== '' && str_starts_with($fm_path, '/assets/images/blog/')) {
        $abs = $repo_root . $fm_path;
        if (is_file($abs)) return $fm_path;
    }

    $candidates = [
        $repo_root . '/assets/images/blog/' . $slug . '.jpg',
        $repo_root . '/assets/images/blog/' . $slug . '.webp',
        $pending_dir . '/images/' . $slug . '.jpg',
        $pending_dir . '/images/' . $slug . '.webp',
    ];
    foreach ($candidates as $c) {
        if (is_file($c)) {
            if (str_contains($c, '/assets/images/blog/')) {
                return '/assets/images/blog/' . basename($c);
            }
            $dest = $repo_root . '/assets/images/blog/' . $slug . '.' . pathinfo($c, PATHINFO_EXTENSION);
            if (@copy($c, $dest)) {
                return '/assets/images/blog/' . basename($dest);
            }
        }
    }

    return $fm_path ?: '';
}

function parse_yaml(string $yaml): array {
    $out = [];
    foreach (preg_split("/\r?\n/", $yaml) as $line) {
        $line = rtrim($line);
        if ($line === '' || $line[0] === '#') continue;
        if (!preg_match('/^([a-zA-Z_][a-zA-Z0-9_]*)\s*:\s*(.*)$/', $line, $m)) continue;
        $key = $m[1];
        $val = trim($m[2]);
        if (strlen($val) >= 2) {
            $first = $val[0]; $last = $val[strlen($val) - 1];
            if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                $val = substr($val, 1, -1);
                if ($first === '"') $val = str_replace('\\"', '"', $val);
            }
        }
        if (preg_match('/^-?\d+$/', $val))       $val = (int)$val;
        elseif (preg_match('/^-?\d+\.\d+$/', $val)) $val = (float)$val;
        $out[$key] = $val;
    }
    return $out;
}

function append_log(string $file, array $result): void {
    $entry = json_encode(array_merge(['timestamp' => date('c')], $result), JSON_UNESCAPED_SLASHES) . "\n";
    @file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
}

function respond(int $http, string $status, string $message, array $details = []): void {
    global $is_cli;
    if ($is_cli) {
        echo "[$status] $message\n";
        if ($details) {
            foreach ($details as $d) {
                $ok = $d['ok'] ? 'OK' : 'FAIL';
                echo "  [$ok] {$d['slug']}: " . ($d['error'] ?? "post #{$d['post_id']}, publishes at {$d['publish_at']}") . "\n";
            }
        }
        exit($http >= 400 ? 1 : 0);
    }
    http_response_code($http);
    echo json_encode(['status' => $status, 'message' => $message, 'results' => $details], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}
