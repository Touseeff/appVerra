<?php
// Shared form partial for create.php / edit.php.
// Expects: $post (array with defaults), $action_url, $submit_label, $is_edit
require_once __DIR__ . '/../../includes/csrf.php';
?>
<form method="post" action="<?= htmlspecialchars($action_url) ?>" class="post-form">
  <?= csrf_field() ?>
  <?php if ($is_edit): ?>
    <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
  <?php endif ?>

  <div class="form-grid">
    <div>
      <section class="form-section">
        <div class="field">
          <label>Title <span style="color:#dc2626;">*</span></label>
          <input type="text" name="title" required maxlength="255"
                 value="<?= htmlspecialchars($post['title'] ?? '') ?>"
                 oninput="autoSlug(this.value)">
        </div>

        <div class="field">
          <label>Slug
            <span class="hint" id="slug-hint">URL: appverra.co/<span id="slug-preview"><?= htmlspecialchars($post['slug'] ?? '') ?></span></span>
          </label>
          <input type="text" name="slug" id="slug-input" maxlength="180"
                 pattern="[a-z0-9-]+"
                 value="<?= htmlspecialchars($post['slug'] ?? '') ?>"
                 oninput="document.getElementById('slug-preview').textContent = this.value">
          <div class="hint">Lowercase letters, digits, dashes only. Leave blank to auto-generate from title.</div>
        </div>

        <div class="field">
          <label>Excerpt (shown on blog listing cards)</label>
          <textarea name="excerpt" maxlength="500"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
        </div>

        <div class="field">
          <label>Featured image</label>
          <input type="url" name="featured_image" id="featured_image"
                 placeholder="/uploads/2026/05/example.webp"
                 value="<?= htmlspecialchars($post['featured_image'] ?? '') ?>">
          <button type="button" class="btn-secondary" style="margin-top:.5rem;"
                  onclick="openMediaPicker('featured_image')">Choose from Media Library</button>
          <?php if (!empty($post['featured_image'])): ?>
            <img class="image-preview" src="<?= htmlspecialchars($post['featured_image']) ?>" alt="" style="max-height:160px;">
          <?php endif ?>
        </div>

        <div class="field">
          <label>Content <span style="color:#dc2626;">*</span></label>
          <textarea name="content" id="content-editor" required><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
        </div>
      </section>

      <section class="form-section">
        <h3>SEO</h3>
        <div class="field">
          <label>Meta title
            <span class="char-counter" id="cc-meta-title">0 / 70</span>
          </label>
          <input type="text" name="meta_title" maxlength="255" id="meta_title"
                 value="<?= htmlspecialchars($post['meta_title'] ?? '') ?>"
                 oninput="updateCounter('cc-meta-title', this.value, 70)">
          <div class="hint">Overrides the title in the &lt;title&gt; tag. Leave blank to use the post title.</div>
        </div>
        <div class="field">
          <label>Meta description
            <span class="char-counter" id="cc-meta-desc">0 / 160</span>
          </label>
          <textarea name="meta_description" maxlength="500" id="meta_description"
                    oninput="updateCounter('cc-meta-desc', this.value, 160)"><?= htmlspecialchars($post['meta_description'] ?? '') ?></textarea>
        </div>
        <div class="field">
          <label>OG image (social share preview)</label>
          <input type="url" name="og_image" id="og_image"
                 placeholder="Defaults to featured image or site logo"
                 value="<?= htmlspecialchars($post['og_image'] ?? '') ?>">
          <button type="button" class="btn-secondary" style="margin-top:.5rem;"
                  onclick="openMediaPicker('og_image')">Choose from Media Library</button>
        </div>
        <div class="field">
          <label>Canonical URL (optional)</label>
          <input type="url" name="canonical_url"
                 value="<?= htmlspecialchars($post['canonical_url'] ?? '') ?>">
        </div>
      </section>
    </div>

    <aside>
      <section class="form-section">
        <h3>Publish</h3>
        <div class="field">
          <div class="radio-row">
            <?php $s = $post['status'] ?? 'draft'; ?>
            <label><input type="radio" name="status" value="draft"     <?= $s==='draft'?'checked':'' ?>     onchange="toggleSchedule(this.value)"> Draft</label>
            <label><input type="radio" name="status" value="scheduled" <?= $s==='scheduled'?'checked':'' ?> onchange="toggleSchedule(this.value)"> Scheduled</label>
            <label><input type="radio" name="status" value="published" <?= $s==='published'?'checked':'' ?> onchange="toggleSchedule(this.value)"> Published</label>
          </div>
        </div>
        <div class="field" id="schedule-field" style="display:<?= ($s==='scheduled')?'block':'none' ?>;">
          <label>Publish at</label>
          <input type="datetime-local" name="publish_at"
                 value="<?= htmlspecialchars(isset($post['publish_at']) ? str_replace(' ', 'T', substr($post['publish_at'], 0, 16)) : '') ?>">
        </div>
        <button type="submit" class="btn-primary" style="width:100%;">
          <?= htmlspecialchars($submit_label) ?>
        </button>
        <?php if ($is_edit): ?>
          <a href="/<?= htmlspecialchars($post['slug']) ?>" target="_blank" rel="noopener"
             class="btn-secondary" style="display:block; text-align:center; margin-top:.75rem;">View on site</a>
          <form method="post" action="/admin/posts/delete.php" style="margin-top:.75rem;"
                onsubmit="return confirm('Delete this post? This soft-deletes — recoverable from Drafts.');">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
            <button type="submit" class="btn-danger" style="width:100%;">Delete post</button>
          </form>
        <?php endif ?>
      </section>
    </aside>
  </div>
</form>

<script src="/admin/assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
function autoSlug(title) {
  var input = document.getElementById('slug-input');
  if (input.dataset.touched) return;
  var s = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 180);
  input.value = s;
  document.getElementById('slug-preview').textContent = s;
}
document.getElementById('slug-input').addEventListener('input', function () { this.dataset.touched = '1'; });

function updateCounter(id, value, max) {
  var el = document.getElementById(id);
  el.textContent = value.length + ' / ' + max;
  el.style.color = value.length > max ? '#dc2626' : '#6b7280';
}
updateCounter('cc-meta-title', document.getElementById('meta_title').value, 70);
updateCounter('cc-meta-desc',  document.getElementById('meta_description').value, 160);

function toggleSchedule(v) {
  document.getElementById('schedule-field').style.display = (v === 'scheduled') ? 'block' : 'none';
}

function openMediaPicker(targetId) {
  var w = window.open('/admin/media/index.php?picker=1&target=' + encodeURIComponent(targetId),
                      'mediapicker', 'width=900,height=700');
}
window.addEventListener('message', function (e) {
  if (e.data && e.data.appverraPick) {
    var t = document.getElementById(e.data.target);
    if (t) t.value = e.data.url;
  }
});

if (typeof tinymce !== 'undefined') {
  tinymce.init({
    selector: '#content-editor',
    license_key: 'gpl',
    height: 600,
    menubar: false,
    plugins: 'link image lists code table autoresize',
    toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link image table | code',
    block_formats: 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Blockquote=blockquote',
    valid_elements: '*[*]',
    extended_valid_elements: 'section[id|class]',
    images_upload_url: '/admin/media/upload.php?tinymce=1',
    images_upload_credentials: true,
    relative_urls: false,
    convert_urls: false,
    promotion: false
  });
}
</script>
