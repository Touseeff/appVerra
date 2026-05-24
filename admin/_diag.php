<?php
/**
 * ONE-SHOT diagnostic — runs WITHOUT _layout.php so it survives even when
 * the layout itself is broken. DELETE after debugging.
 */

ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

echo "=== AppVerra admin diagnostic v2 ===\n\n";

$repo_root = realpath(__DIR__ . '/..');
echo "Repo root:      $repo_root\n";
echo "PHP version:    " . PHP_VERSION . "\n";
echo "Server time:    " . date('c') . "\n\n";

echo "--- Full listing of includes/ ---\n";
$inc = $repo_root . '/includes';
if (is_dir($inc)) {
    foreach (scandir($inc) as $f) {
        if ($f === '.' || $f === '..') continue;
        $abs = $inc . '/' . $f;
        $size = is_file($abs) ? filesize($abs) : '-';
        $perms = substr(sprintf('%o', fileperms($abs)), -4);
        $mtime = date('c', filemtime($abs));
        echo sprintf("  %-30s %-10s %s   %s\n", $f, $size . 'B', $perms, $mtime);
    }
} else {
    echo "  includes/ directory not found\n";
}
echo "\n";

echo "--- Env vars (whichever path Hostinger uses) ---\n";
foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'APP_ENV'] as $k) {
    $v = getenv($k);
    $shown = $v === false ? '(unset)' : ($k === 'DB_PASS' ? str_repeat('*', strlen($v)) : $v);
    echo sprintf("  %s = %s\n", $k, $shown);
}
echo "\n";

echo "--- Constants after loading config.php ---\n";
require_once $repo_root . '/includes/config.php';
foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $k) {
    $v = defined($k) ? constant($k) : '(undefined)';
    $shown = $k === 'DB_PASS' ? str_repeat('*', strlen($v)) : $v;
    echo sprintf("  %s = %s\n", $k, $shown);
}
echo "\n";

echo "--- DB connection attempt ---\n";
try {
    require_once $repo_root . '/includes/db.php';
    $row = db_one('SELECT COUNT(*) AS c FROM posts');
    echo "  DB OK. posts count: " . ($row['c'] ?? '?') . "\n";

    $olor = db_all('SELECT id, slug, title, status FROM posts WHERE slug = "olor" LIMIT 5');
    echo "  Posts with slug=olor: " . count($olor) . "\n";
    foreach ($olor as $p) {
        echo "    #{$p['id']} [{$p['status']}] " . substr($p['title'], 0, 80) . "\n";
    }
} catch (\Throwable $e) {
    echo "  DB EXCEPTION: " . $e->getMessage() . "\n";
}
echo "\n=== end ===\n";
