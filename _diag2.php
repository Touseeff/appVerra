<?php
/**
 * Diag #2 — same checks as admin/_diag.php but runs from REPO ROOT instead
 * of /admin/. If admin's PHP environment differs from the root (separate pool,
 * open_basedir, .user.ini, etc.), this script reveals it.
 *
 * DELETE after debugging.
 */

ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

echo "=== AppVerra ROOT-level diagnostic ===\n\n";
echo "PHP version:    " . PHP_VERSION . "\n";
echo "Script dir:     " . __DIR__ . "\n";
echo "Document root:  " . ($_SERVER['DOCUMENT_ROOT'] ?? '?') . "\n";
echo "open_basedir:   " . (ini_get('open_basedir') ?: '(none)') . "\n";
echo "Server time:    " . date('c') . "\n\n";

echo "--- Full listing of includes/ ---\n";
$inc = __DIR__ . '/includes';
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

echo "--- file_exists checks (multiple methods) ---\n";
$cfg = __DIR__ . '/includes/config.local.php';
echo "  file_exists:    " . (file_exists($cfg) ? 'YES' : 'NO') . "\n";
echo "  is_file:        " . (is_file($cfg) ? 'YES' : 'NO') . "\n";
echo "  is_readable:    " . (is_readable($cfg) ? 'YES' : 'NO') . "\n";
echo "  realpath:       " . (realpath($cfg) ?: '(false)') . "\n";
$g = @glob($inc . '/config.local*');
echo "  glob match:     " . (empty($g) ? '(none)' : implode(', ', $g)) . "\n";
echo "\n";

echo "--- Env vars ---\n";
foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'APP_ENV'] as $k) {
    $v = getenv($k);
    $shown = $v === false ? '(unset)' : ($k === 'DB_PASS' ? str_repeat('*', strlen($v)) : $v);
    echo sprintf("  getenv(%s) = %s\n", $k, $shown);
    if (isset($_SERVER[$k])) echo sprintf("  \$_SERVER[%s] = %s\n", $k, $k === 'DB_PASS' ? '***' : $_SERVER[$k]);
    if (isset($_ENV[$k])) echo sprintf("  \$_ENV[%s] = %s\n", $k, $k === 'DB_PASS' ? '***' : $_ENV[$k]);
}
echo "\n";

echo "--- Load config.php + show resolved constants ---\n";
require_once __DIR__ . '/includes/config.php';
foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $k) {
    $v = defined($k) ? constant($k) : '(undefined)';
    $shown = $k === 'DB_PASS' ? str_repeat('*', strlen($v)) : $v;
    echo sprintf("  %s = %s\n", $k, $shown);
}
echo "\n";

echo "--- DB connection attempt (via includes/db.php) ---\n";
try {
    require_once __DIR__ . '/includes/db.php';
    $row = db_one('SELECT COUNT(*) AS c FROM posts');
    echo "  DB OK. posts count: " . ($row['c'] ?? '?') . "\n";

    $broken = db_one("SELECT COUNT(*) AS c FROM posts WHERE featured_image = 'assets/images/blogs.webp'");
    echo "  Posts with broken image path: " . ($broken['c'] ?? '?') . "\n";

    $olor = db_all("SELECT id, slug, title FROM posts WHERE slug = 'olor' LIMIT 5");
    echo "  Posts with slug=olor: " . count($olor) . "\n";
    foreach ($olor as $p) {
        echo "    #{$p['id']}: " . substr($p['title'], 0, 80) . "\n";
    }
} catch (\Throwable $e) {
    echo "  DB EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n=== end ===\n";
