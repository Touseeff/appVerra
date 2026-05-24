<?php
require_once __DIR__ . '/includes/db.php';

$slug = $_GET['slug'] ?? '';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));

if ($slug === '') {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$post = db_one('
    SELECT id, slug, title, excerpt, content, featured_image,
           meta_title, meta_description, og_image, canonical_url,
           status, publish_at, updated_at
    FROM posts
    WHERE slug = ?
      AND (status = "published"
        OR (status = "scheduled" AND publish_at <= NOW()))
    LIMIT 1
', 's', [$slug]);

if (!$post) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

// Wire metadata into header.php's expected variables.
$meta_title       = $post['meta_title']       ?: $post['title'];
$meta_discription = $post['meta_description'] ?: $post['excerpt'];
$og_image         = $post['og_image']
                 ?: $post['featured_image']
                 ?: 'https://appverra.co/assets/images/logo.webp';
$page_check       = 'blog-page';
$canonical_override = $post['canonical_url'] ?: null;

include __DIR__ . '/header.php';

// Best-effort view counter — fire-and-forget.
@db_exec('UPDATE posts SET views = views + 1 WHERE id = ?', 'i', [(int)$post['id']]);
?>
<section class="terms_privacy_banner mainBanner">
    <div class="container">
        <h1 class="heading55px light text-center">
            <span class="revealUp">
                <span><?= htmlspecialchars($post['title']) ?></span>
            </span>
        </h1>
    </div>
</section>

<?php if (!empty($post['featured_image'])): ?>
<section class="blog-hero-image">
  <div class="container">
    <img src="<?= htmlspecialchars($post['featured_image']) ?>"
         alt="<?= htmlspecialchars($post['title']) ?>"
         class="img-fluid rounded"
         style="width:100%; max-height:520px; object-fit:cover; margin-bottom:1.5rem;"
         loading="lazy">
  </div>
</section>
<?php endif; ?>

<section class="tac_sec case-study">
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <article class="blog-content">
                    <?= $post['content'] /* WYSIWYG content; sanitized in post_helpers.php on save */ ?>
                </article>
                <hr style="margin: 2.5rem 0;">
                <?php include __DIR__ . '/blog_sidebar.php'; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
