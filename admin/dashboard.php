<?php
require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/../includes/db.php';

$counts = db_one('
  SELECT
    SUM(status = "published") AS published,
    SUM(status = "draft")     AS drafts,
    SUM(status = "scheduled") AS scheduled,
    COUNT(*)                  AS total
  FROM posts
') ?? ['published' => 0, 'drafts' => 0, 'scheduled' => 0, 'total' => 0];

$recent = db_all('
  SELECT id, title, status, updated_at
  FROM posts
  ORDER BY updated_at DESC
  LIMIT 8
');

layout_start('Dashboard');
echo flash_render();
?>
<section class="stat-grid">
  <div class="stat"><span class="stat-num"><?= (int)$counts['published'] ?></span><span>Published</span></div>
  <div class="stat"><span class="stat-num"><?= (int)$counts['drafts'] ?></span><span>Drafts</span></div>
  <div class="stat"><span class="stat-num"><?= (int)$counts['scheduled'] ?></span><span>Scheduled</span></div>
  <div class="stat"><span class="stat-num"><?= (int)$counts['total'] ?></span><span>Total</span></div>
</section>

<section class="panel">
  <div class="panel-head">
    <h2>Recent activity</h2>
    <a class="btn-secondary" href="/admin/posts/create.php">+ New post</a>
  </div>
  <?php if (!$recent): ?>
    <p class="muted">No posts yet. <a href="/admin/posts/create.php">Create your first one</a>.</p>
  <?php else: ?>
    <table class="data-table">
      <thead><tr><th>Title</th><th>Status</th><th>Updated</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($recent as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['title']) ?></td>
          <td><span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
          <td><?= htmlspecialchars($p['updated_at']) ?></td>
          <td><a href="/admin/posts/edit.php?id=<?= (int)$p['id'] ?>">Edit</a></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>
</section>
<?php layout_end(); ?>
