<?php
require_once __DIR__ . '/../_layout.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../includes/slugify.php';
require_once __DIR__ . '/../../includes/post_helpers.php';

require_auth();

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
if ($id <= 0) { http_response_code(400); exit('Missing id'); }

$post = db_one('SELECT * FROM posts WHERE id = ? LIMIT 1', 'i', [$id]);
if (!$post) { http_response_code(404); exit('Post not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $data = post_collect_form();
    $errors = post_validate($data);

    if (!$errors) {
        $slug = trim($data['slug']) !== '' ? slugify($data['slug']) : slugify($data['title']);
        $slug = slug_unique($slug, $id);

        db_exec(
            'UPDATE posts SET
                slug = ?, title = ?, excerpt = ?, content = ?,
                featured_image = ?, featured_image_alt = ?,
                meta_title = ?, meta_description = ?, og_image = ?, canonical_url = ?,
                author_name = ?, author_url = ?,
                status = ?, publish_at = ?
             WHERE id = ?',
            'ssssssssssssssi',
            [
                $slug, $data['title'], $data['excerpt'], $data['content'],
                $data['featured_image'], $data['featured_image_alt'],
                $data['meta_title'], $data['meta_description'], $data['og_image'], $data['canonical_url'],
                $data['author_name'], $data['author_url'],
                $data['status'], $data['publish_at'], $id
            ]
        );
        post_regenerate_sitemap();
        flash_set('success', 'Post saved.');
        header('Location: /admin/posts/edit.php?id=' . $id, true, 302);
        exit;
    }

    $post = array_merge($post, $data);
}

$action_url   = '/admin/posts/edit.php?id=' . $id;
$submit_label = match ($post['status']) {
    'scheduled' => 'Schedule',
    'published' => 'Update post',
    default     => 'Save draft',
};
$is_edit      = true;

layout_start('Edit post');
echo flash_render();
if ($errors) echo '<div class="alert alert-error">' . htmlspecialchars(implode(' · ', $errors)) . '</div>';
include __DIR__ . '/_form.php';
layout_end();
