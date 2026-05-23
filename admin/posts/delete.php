<?php
require_once __DIR__ . '/../_layout.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../includes/post_helpers.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); exit('POST only');
}
csrf_verify();

$id = (int)($_POST['id'] ?? 0);
$mode = $_POST['mode'] ?? 'soft';
if ($id <= 0) { http_response_code(400); exit('Missing id'); }

$post = db_one('SELECT id, slug, status FROM posts WHERE id = ? LIMIT 1', 'i', [$id]);
if (!$post) { http_response_code(404); exit('Post not found'); }

if ($mode === 'hard') {
    db_exec('DELETE FROM posts WHERE id = ?', 'i', [$id]);
    flash_set('success', 'Post permanently deleted.');
} else {
    $newSlug = '_deleted_' . substr(bin2hex(random_bytes(3)), 0, 5) . '_' . $post['slug'];
    db_exec(
        'UPDATE posts SET status = "draft", slug = ? WHERE id = ?',
        'si', [substr($newSlug, 0, 200), $id]
    );
    flash_set('success', 'Post moved to drafts and hidden.');
}

post_regenerate_sitemap();
header('Location: /admin/posts/', true, 302);
exit;
