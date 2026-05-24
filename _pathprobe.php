<?php
/**
 * Probes which filesystem paths PHP can actually read on this Hostinger account.
 * Tells us whether the "config.local.php above public_html" trick is viable
 * or blocked by an invisible open_basedir restriction.
 *
 * DELETE after debugging.
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

echo "=== PHP filesystem reach probe ===\n\n";
echo "open_basedir (ini_get): " . (ini_get('open_basedir') ?: '(empty)') . "\n";
echo "Document root:          " . ($_SERVER['DOCUMENT_ROOT'] ?? '?') . "\n";
echo "Server software:        " . ($_SERVER['SERVER_SOFTWARE'] ?? '?') . "\n";
echo "Script real path:       " . realpath(__FILE__) . "\n\n";

echo "--- Candidate paths for the home-dir config.local.php ---\n";
$candidates = [
    '/home/u751124526/config.local.php',
    '/home/u751124526/private/config.local.php',
    '/home/u751124526/files/config.local.php',
    '/home/u751124526/domains/appverra.co/config.local.php',
    '/home/u751124526/domains/appverra.co/private_html/config.local.php',
    '/usr/home/u751124526/config.local.php',
    '/tmp/config.local.php',
];
foreach ($candidates as $p) {
    $exists   = @file_exists($p);
    $readable = @is_readable($p);
    $size     = $exists ? @filesize($p) : 0;
    echo sprintf("  %-72s exists:%-3s readable:%-3s size:%dB\n",
        $p, $exists ? 'YES' : 'NO', $readable ? 'YES' : 'NO', $size);
}
echo "\n";

echo "--- Can we list /home/u751124526/ at all? ---\n";
$home = '/home/u751124526';
if (@is_dir($home)) {
    $items = @scandir($home);
    if ($items === false) {
        echo "  is_dir=YES but scandir failed (likely open_basedir restriction)\n";
    } else {
        echo "  scandir OK. Entries found:\n";
        foreach ($items as $i) {
            if ($i === '.' || $i === '..') continue;
            echo "    - $i\n";
        }
    }
} else {
    echo "  is_dir($home) = NO (path blocked or doesn't exist)\n";
}
echo "\n";

echo "--- Final test: can we connect to MySQL via env vars set in hPanel? ---\n";
echo "  getenv(DB_USER) = " . (getenv('DB_USER') ?: '(unset)') . "\n";
echo "  \$_SERVER[DB_USER] = " . ($_SERVER['DB_USER'] ?? '(unset)') . "\n";

echo "\n=== end ===\n";
