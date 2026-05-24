<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

require_once __DIR__ . '/includes/db.php';

echo "=== Actual DB state ===\n\n";

$rows = db_all('SELECT id, slug, title, featured_image, status FROM posts ORDER BY id');
foreach ($rows as $r) {
    printf("#%-3d [%s] slug=%s\n", $r['id'], $r['status'], $r['slug']);
    printf("    title:           %s\n", substr($r['title'], 0, 100));
    printf("    featured_image:  %s\n", $r['featured_image'] ?: '(empty)');
    echo "\n";
}
echo "Total: " . count($rows) . " posts\n";
