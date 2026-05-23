<?php
require_once __DIR__ . '/../_layout.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/csrf.php';

require_auth();
$picker = !empty($_GET['picker']);
$target = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['target'] ?? '');

$items = db_all('SELECT id, filename, url, webp_url, uploaded_at FROM media ORDER BY uploaded_at DESC LIMIT 200');
?>
<?php if ($picker): ?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><title>Pick image</title>
<link rel="stylesheet" href="/admin/assets/admin.css">
</head><body class="admin-body"><main class="admin-main" style="width:100%;"><div class="admin-content">
<h2>Pick an image</h2>
<form method="post" action="/admin/media/upload.php" enctype="multipart/form-data" style="margin-bottom:1.5rem;">
  <?= csrf_field() ?>
  <input type="file" name="file" accept="image/png,image/jpeg,image/webp,image/gif" required>
  <button type="submit" class="btn-primary">Upload</button>
</form>
<div class="media-grid">
  <?php foreach ($items as $m): $u = $m['webp_url'] ?: $m['url']; ?>
    <div class="media-item">
      <img src="<?= htmlspecialchars($u) ?>" alt="">
      <div class="actions">
        <button type="button" class="btn-secondary"
                onclick="window.opener.postMessage({appverraPick:true, target:'<?= htmlspecialchars($target) ?>', url:'<?= htmlspecialchars($u) ?>'}, '*'); window.close();">
          Use
        </button>
      </div>
    </div>
  <?php endforeach ?>
</div>
</div></main></body></html>
<?php exit; endif; ?>

<?php layout_start('Media library'); echo flash_render(); ?>
<section class="panel">
  <div class="panel-head"><h2>Upload new image</h2></div>
  <form method="post" action="/admin/media/upload.php" enctype="multipart/form-data" style="display:flex; gap:.75rem; align-items:center;">
    <?= csrf_field() ?>
    <input type="file" name="file" accept="image/png,image/jpeg,image/webp,image/gif" required>
    <button type="submit" class="btn-primary">Upload</button>
    <span class="muted">Max 5 MB. PNG/JPG/WebP/GIF. PNG &amp; JPG auto-convert to WebP.</span>
  </form>
</section>

<section class="panel">
  <h2 style="margin-bottom:1rem;">All uploads</h2>
  <?php if (!$items): ?>
    <p class="muted">No uploads yet.</p>
  <?php else: ?>
    <div class="media-grid">
      <?php foreach ($items as $m): $u = $m['webp_url'] ?: $m['url']; ?>
        <div class="media-item">
          <img src="<?= htmlspecialchars($u) ?>" alt="">
          <div class="actions">
            <input type="text" readonly value="<?= htmlspecialchars($u) ?>"
                   onclick="this.select(); navigator.clipboard.writeText(this.value);"
                   style="flex:1; font-size:.75rem; padding:.25rem;">
          </div>
        </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</section>
<?php layout_end(); ?>
