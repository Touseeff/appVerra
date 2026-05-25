<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_auth();

$results = [];

$files_to_invalidate = [
    __DIR__ . '/../includes/csrf.php',
    __DIR__ . '/../includes/auth.php',
    __DIR__ . '/../includes/post_helpers.php',
    __DIR__ . '/../blog-post.php',
    __DIR__ . '/../header.php',
    __DIR__ . '/import-pending.php',
    __DIR__ . '/posts/edit.php',
    __DIR__ . '/posts/create.php',
];

foreach ($files_to_invalidate as $f) {
    $real = realpath($f);
    if ($real && function_exists('opcache_invalidate')) {
        $ok = opcache_invalidate($real, true);
        $results[] = basename($real) . ': ' . ($ok ? 'invalidated' : 'failed');
    } else {
        $results[] = basename($f) . ': ' . ($real ? 'no opcache func' : 'file not found');
    }
}

$image_updates = [
    [14, '/assets/images/blog/flutterflow-to-flutter-migration.jpg'],
];

foreach ($image_updates as [$id, $path]) {
    $post = db_one('SELECT id, title, featured_image, og_image FROM posts WHERE id = ? LIMIT 1', 'i', [$id]);
    if ($post) {
        db_exec('UPDATE posts SET featured_image = ?, og_image = ? WHERE id = ?', 'ssi', [$path, $path, $id]);
        $results[] = "Post #{$id} ({$post['title']}): image updated to {$path}";
    } else {
        $results[] = "Post #{$id}: not found";
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo "=== Fix Deploy Results ===\n\n";
echo "OPcache invalidation:\n";
foreach (array_slice($results, 0, count($files_to_invalidate)) as $r) {
    echo "  - {$r}\n";
}
echo "\nDB updates:\n";
foreach (array_slice($results, count($files_to_invalidate)) as $r) {
    echo "  - {$r}\n";
}
echo "\nDone. You can delete this file now.\n";
