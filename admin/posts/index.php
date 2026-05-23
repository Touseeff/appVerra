<?php
require_once __DIR__ . '/../_layout.php';
require_once __DIR__ . '/../../includes/db.php';

$status = $_GET['status'] ?? 'all';
$q      = trim($_GET['q'] ?? '');

$where = ['1=1'];
$types = '';
$params = [];

if (in_array($status, ['draft', 'scheduled', 'published'], true)) {
    $where[] = 'status = ?';
    $types  .= 's';
    $params[] = $status;
}
if ($q !== '') {
    $where[] = '(title LIKE ? OR slug LIKE ?)';
    $types  .= 'ss';
    $like = '%' . $q . '%';
    $params[] = $like;
    $params[] = $like;
}

$sql = 'SELECT id, title, slug, status, publish_at, updated_at
        FROM posts WHERE ' . implode(' AND ', $where) . '
        ORDER BY updated_at DESC LIMIT 200';

$posts = db_all($sql, $types, $params);

layout_start('Posts');
echo flash_render();
?>
<div class="toolbar">
  <form method="get" style="display:flex; gap:.75rem; flex-wrap:wrap;">
    <input type="search" name="q" placeholder="Search title or slug" value="<?= htmlspecialchars($q) ?>">
    <select name="status" onchange="this.form.submit()">
      <option value="all"<?= $status==='all'?' selected':'' ?>>All statuses</option>
      <option value="draft"<?= $status==='draft'?' selected':'' ?>>Draft</option>
      <option value="scheduled"<?= $status==='scheduled'?' selected':'' ?>>Scheduled</option>
      <option value="published"<?= $status==='published'?' selected':'' ?>>Published</option>
    </select>
    <button class="btn-secondary" type="submit">Filter</button>
  </form>
  <a class="btn-primary" style="margin-left:auto;" href="/admin/posts/create.php">+ New post</a>
</div>

<section class="panel">
  <?php if (!$posts): ?>
    <p class="muted">No posts match. <a href="/admin/posts/create.php">Create one</a>.</p>
  <?php else: ?>
    <table class="data-table">
      <thead><tr>
        <th>Title</th><th>Slug</th><th>Status</th><th>Publish at</th><th>Updated</th><th></th>
      </tr></thead>
      <tbody>
      <?php foreach ($posts as $p): ?>
        <tr>
          <td><a href="/admin/posts/edit.php?id=<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['title']) ?></a></td>
          <td><code><?= htmlspecialchars($p['slug']) ?></code></td>
          <td><span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
          <td><?= htmlspecialchars($p['publish_at'] ?? '—') ?></td>
          <td><?= htmlspecialchars($p['updated_at']) ?></td>
          <td style="white-space:nowrap;">
            <a href="/admin/posts/edit.php?id=<?= (int)$p['id'] ?>">Edit</a>
            &nbsp;·&nbsp;
            <a href="/<?= htmlspecialchars($p['slug']) ?>" target="_blank" rel="noopener">View</a>
          </td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>
</section>
<?php layout_end(); ?>
