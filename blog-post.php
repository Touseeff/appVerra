<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/post_helpers.php';

$slug = $_GET['slug'] ?? '';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));

if ($slug === '') {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$post = db_one('
    SELECT id, slug, title, excerpt, content,
           featured_image, featured_image_alt,
           meta_title, meta_description, og_image, canonical_url,
           author_name, author_url,
           status, publish_at, created_at, updated_at
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

// --- Derived metadata shared by template + JSON-LD ---
$author       = post_author_display($post);
$published_dt = $post['publish_at'] ?: $post['created_at'];
$modified_dt  = $post['updated_at'] ?: $published_dt;
$published_iso = post_iso8601($published_dt);
$modified_iso  = post_iso8601($modified_dt);
$reading_min   = post_reading_minutes((string)$post['content']);
$post_url      = 'https://appverra.co/' . $post['slug'];

$featured_alt = trim((string)$post['featured_image_alt']) !== ''
    ? $post['featured_image_alt']
    : $post['title'];

// --- Wire into header.php's variables ---
$meta_title         = $post['meta_title']       ?: $post['title'];
$meta_discription   = $post['meta_description'] ?: $post['excerpt'];
$og_image           = $post['og_image']
                   ?: $post['featured_image']
                   ?: 'https://appverra.co/assets/images/logo.webp';
$og_image_alt       = $featured_alt;
$og_type            = 'article';
$page_check         = 'blog-page';
$canonical_override = $post['canonical_url'] ?: null;

$article_meta = [
    'published_time' => $published_iso,
    'modified_time'  => $modified_iso,
    'author'         => $author['url'],
    'section'        => 'Blog',
];

// --- JSON-LD: BlogPosting + BreadcrumbList + (optional) FAQPage ---
$schema_description = $post['excerpt']
    ?: $post['meta_description']
    ?: post_excerpt_from_content((string)$post['content'], 200);

$blog_posting_schema = [
    '@context'         => 'https://schema.org',
    '@type'            => 'BlogPosting',
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $post_url],
    'headline'         => $post['title'],
    'description'      => $schema_description,
    'image'            => [$og_image],
    'author'           => [
        '@type' => 'Person',
        'name'  => $author['name'],
        'url'   => $author['url'],
    ],
    'publisher'        => [
        '@type' => 'Organization',
        'name'  => 'Appverra',
        'logo'  => [
            '@type' => 'ImageObject',
            'url'   => 'https://appverra.co/assets/images/logo.webp',
        ],
    ],
    'datePublished'    => $published_iso,
    'dateModified'     => $modified_iso,
    'url'              => $post_url,
    'inLanguage'       => 'en-US',
];

$breadcrumb_schema = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://appverra.co/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => 'https://appverra.co/blogs'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $post['title'], 'item' => $post_url],
    ],
];

$schema_extra = [
    json_encode($blog_posting_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
    json_encode($breadcrumb_schema,  JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
];

$faqs = post_extract_faqs((string)$post['content']);
if ($faqs) {
    $faq_schema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type'          => 'Question',
            'name'           => $f['question'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['answer']],
        ], $faqs),
    ];
    $schema_extra[] = json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

include __DIR__ . '/header.php';

// Best-effort view counter — fire-and-forget.
@db_exec('UPDATE posts SET views = views + 1 WHERE id = ?', 'i', [(int)$post['id']]);
?>
<section class="terms_privacy_banner mainBanner">
    <div class="container">
        <nav aria-label="Breadcrumb" class="blog-breadcrumb" style="margin-bottom:1rem;">
          <ol style="list-style:none;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:.4rem;justify-content:center;color:#C3C9CE;font-size:.9rem;">
            <li><a href="/" style="color:#C3C9CE;text-decoration:underline;">Home</a></li>
            <li aria-hidden="true">›</li>
            <li><a href="/blogs" style="color:#C3C9CE;text-decoration:underline;">Blog</a></li>
            <li aria-hidden="true">›</li>
            <li aria-current="page" style="color:#fff;"><?= htmlspecialchars($post['title']) ?></li>
          </ol>
        </nav>
        <h1 class="heading55px light text-center">
            <span class="revealUp">
                <span><?= htmlspecialchars($post['title']) ?></span>
            </span>
        </h1>
        <p class="blog-byline text-center" style="color:#C3C9CE;font-size:.95rem;margin-top:1rem;">
          By <a href="<?= htmlspecialchars($author['url']) ?>" rel="author" style="color:#fff;text-decoration:underline;"><?= htmlspecialchars($author['name']) ?></a>
          <?php if ($published_iso): ?>
            · Published <time datetime="<?= htmlspecialchars($published_iso) ?>"><?= htmlspecialchars(date('M j, Y', strtotime($published_dt))) ?></time>
          <?php endif; ?>
          <?php if ($modified_iso && $modified_iso !== $published_iso && date('Ymd', strtotime($modified_dt)) !== date('Ymd', strtotime($published_dt))): ?>
            · Updated <time datetime="<?= htmlspecialchars($modified_iso) ?>"><?= htmlspecialchars(date('M j, Y', strtotime($modified_dt))) ?></time>
          <?php endif; ?>
          · <?= $reading_min ?> min read
        </p>
    </div>
</section>

<?php if (!empty($post['featured_image'])): ?>
<section class="blog-hero-image">
  <div class="container">
    <img src="<?= htmlspecialchars($post['featured_image']) ?>"
         alt="<?= htmlspecialchars($featured_alt) ?>"
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
