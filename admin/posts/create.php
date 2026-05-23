<?php
require_once __DIR__ . '/../_layout.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../includes/slugify.php';
require_once __DIR__ . '/../../includes/post_helpers.php';

$user = require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $data = post_collect_form();
    $errors = post_validate($data);

    if (!$errors) {
        $slug = trim($data['slug']) !== '' ? slugify($data['slug']) : slugify($data['title']);
        $slug = slug_unique($slug);

        $id = db_exec(
            'INSERT INTO posts
               (slug, title, excerpt, content, featured_image,
                meta_title, meta_description, og_image, canonical_url,
                status, publish_at, author_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            'sssssssssssi',
            [
                $slug, $data['title'], $data['excerpt'], $data['content'], $data['featured_image'],
                $data['meta_title'], $data['meta_description'], $data['og_image'], $data['canonical_url'],
                $data['status'], $data['publish_at'], $user['id']
            ]
        );

        post_regenerate_sitemap();
        flash_set('success', 'Post created.');
        header('Location: /admin/posts/edit.php?id=' . $id, true, 302);
        exit;
    }
}

$post = array_merge([
    'id' => 0, 'title' => '', 'slug' => '', 'excerpt' => '', 'content' => '',
    'featured_image' => '', 'meta_title' => '', 'meta_description' => '',
    'og_image' => '', 'canonical_url' => '', 'status' => 'draft', 'publish_at' => null,
], $_POST);

$action_url   = '/admin/posts/create.php';
$submit_label = 'Save draft';
$is_edit      = false;

layout_start('New post');
if (!empty($errors)) {
    echo '<div class="alert alert-error">' . htmlspecialchars(implode(' · ', $errors)) . '</div>';
}
include __DIR__ . '/_form.php';
layout_end();
