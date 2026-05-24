<?php
/**
 * ONE-SHOT diagnostic — runs WITHOUT _layout.php so it survives even when
 * the layout itself is broken. Hit this URL while debugging the 500 error.
 *
 * DELETE THIS FILE after debugging.
 */

// Force errors visible for this one page only.
ini_set('display_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

echo "=== AppVerra admin diagnostic ===\n\n";

echo "PHP version:    " . PHP_VERSION . "\n";
echo "Server time:    " . date('c') . "\n";
echo "Document root:  " . ($_SERVER['DOCUMENT_ROOT'] ?? '?') . "\n";
echo "Script path:    " . __FILE__ . "\n";
echo "Real path:      " . realpath(__FILE__) . "\n\n";

echo "--- Required files: existence + mtime ---\n";
$repo_root = realpath(__DIR__ . '/..');
$files = [
    'admin/_layout.php',
    'admin/import-pending.php',
    'admin/dashboard.php',
    'includes/auth.php',
    'includes/csrf.php',
    'includes/db.php',
    'includes/post_helpers.php',
    'includes/slugify.php',
    'includes/webp.php',
    'includes/config.local.php',
    'blog_factory/queue/pending',
    'blog_factory/queue/pending/images',
    'blog_factory/queue/topics.yaml',
];
foreach ($files as $f) {
    $abs = $repo_root . '/' . $f;
    $exists = file_exists($abs);
    $mtime = $exists ? date('c', filemtime($abs)) : 'MISSING';
    echo sprintf("%-40s %s   %s\n", $f, $exists ? 'OK' : 'MISSING', $mtime);
}
echo "\n";

echo "--- _layout.php first 40 lines ---\n";
$layout = $repo_root . '/admin/_layout.php';
if (file_exists($layout)) {
    $lines = array_slice(file($layout), 0, 40);
    foreach ($lines as $i => $line) {
        echo sprintf("%3d: %s", $i + 1, $line);
    }
} else {
    echo "_layout.php not found at $layout\n";
}
echo "\n";

echo "--- Try loading _layout.php ---\n";
try {
    require_once $repo_root . '/admin/_layout.php';
    echo "Loaded OK. Functions defined:\n";
    foreach (['layout_start', 'layout_end', 'flash_set', 'flash_render', 'count_pending_imports'] as $fn) {
        echo "  $fn: " . (function_exists($fn) ? 'defined' : 'NOT defined') . "\n";
    }
} catch (\Throwable $e) {
    echo "EXCEPTION loading _layout.php: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
echo "\n";

echo "--- DB connection test ---\n";
try {
    require_once $repo_root . '/includes/db.php';
    $row = db_one('SELECT COUNT(*) AS c FROM posts');
    echo "DB OK. posts table count: " . ($row['c'] ?? '?') . "\n";

    $olor = db_all('SELECT id, slug, title, status FROM posts WHERE slug = "olor" LIMIT 5');
    echo "Posts with slug=olor: " . count($olor) . "\n";
    foreach ($olor as $p) {
        echo "  #{$p['id']} [{$p['status']}] " . substr($p['title'], 0, 80) . "\n";
    }
} catch (\Throwable $e) {
    echo "DB EXCEPTION: " . $e->getMessage() . "\n";
}
echo "\n";

echo "--- Last 30 lines of error_log (if accessible) ---\n";
foreach ([ini_get('error_log'), '/home/u751124526/logs/error_log', $repo_root . '/error_log'] as $log) {
    if ($log && file_exists($log) && is_readable($log)) {
        echo "Source: $log\n";
        $contents = file($log);
        $tail = array_slice($contents, -30);
        echo implode('', $tail);
        break;
    }
}
echo "\n=== end ===\n";
