<?php
/**
 * ONE-SHOT cleanup — fix broken featured_image paths on existing posts.
 *
 * Background: all 9 migrated posts have featured_image = 'assets/images/blogs.webp'
 * but that file is a 404 on the server. The real file is 'assets/images/blog-img.webp'.
 * This page does one UPDATE swapping the path everywhere it appears.
 *
 * DELETE THIS FILE after running once.
 */

require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/post_helpers.php';

require_auth();

$BROKEN = 'assets/images/blogs.webp';
$FIXED  = 'assets/images/blog-img.webp';

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    if (($_POST['action'] ?? '') === 'fix') {
        $affected = db_exec(
            'UPDATE posts SET featured_image = ? WHERE featured_image = ?',
            'ss', [$FIXED, $BROKEN]
        );
        post_regenerate_sitemap();
        $message = ['type' => 'success', 'text' => "Updated $affected posts. featured_image now points to $FIXED. You can delete admin/_oneshot_fix_images.php now."];
    }
}

$broken_posts = db_all(
    'SELECT id, slug, title, featured_image, status FROM posts WHERE featured_image = ? LIMIT 50',
    's', [$BROKEN]
);

layout_start('One-shot: fix broken blog images');
?>
<section class="panel">
  <div class="panel-head">
    <h2>Fix broken <code>featured_image</code> paths</h2>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-<?= htmlspecialchars($message['type']) ?>"><?= $message['text'] ?></div>
  <?php endif ?>

  <p class="muted">
    The 9 migrated blog posts point <code>featured_image</code> at
    <code><?= htmlspecialchars($BROKEN) ?></code>, but that file returns 404 on the server.
    The real file is <code><?= htmlspecialchars($FIXED) ?></code> (which exists).
    Clicking Fix runs one <code>UPDATE</code> that swaps the path on every post matching the broken value.
  </p>

  <?php if (!$broken_posts): ?>
    <p style="color:#16a34a;font-weight:600;margin-top:1rem;">
      ✓ No posts found with the broken image path. Either it's already fixed or there's nothing to do.
    </p>
    <p class="muted" style="margin-top:1rem;">
      Next: delete <code>admin/_oneshot_fix_images.php</code> from the repo.
    </p>
  <?php else: ?>
    <table class="data-table" style="margin-top:1rem;">
      <thead><tr><th>ID</th><th>Title</th><th>Status</th><th>Current featured_image</th></tr></thead>
      <tbody>
        <?php foreach ($broken_posts as $p): ?>
          <tr>
            <td><?= (int)$p['id'] ?></td>
            <td><?= htmlspecialchars($p['title']) ?></td>
            <td><span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
            <td><code><?= htmlspecialchars($p['featured_image']) ?></code></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <form method="post" style="margin-top:1rem;"
          onsubmit="return confirm('Run UPDATE on <?= count($broken_posts) ?> posts? This sets featured_image to <?= htmlspecialchars($FIXED) ?> on every row currently pointing to <?= htmlspecialchars($BROKEN) ?>.');">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="fix">
      <button type="submit" class="btn-primary">Fix <?= count($broken_posts) ?> posts</button>
    </form>
  <?php endif ?>
</section>
<?php layout_end(); ?>
