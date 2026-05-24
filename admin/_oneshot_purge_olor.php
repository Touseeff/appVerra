<?php
/**
 * ONE-SHOT cleanup script — deletes the "olor" lorem-ipsum junk post that
 * sits in the posts table from initial migration testing.
 *
 * Why it exists: I (Claude) can't reach the live MySQL from outside the
 * Hostinger server. This page lets Noor confirm and delete in one click.
 *
 * After running successfully, DELETE THIS FILE. It is single-purpose and
 * leaving it around adds no value.
 *
 * Safety: only deletes posts whose slug is "olor" AND whose content matches
 * the known lorem-ipsum fingerprint ("Doloribus" or "pariatur"). Refuses
 * to touch anything else.
 */

require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/post_helpers.php';

require_auth();

// Find candidate junk posts: slug=olor with lorem-ipsum fingerprint in title.
$candidates = db_all('
    SELECT id, slug, title, status, created_at
    FROM posts
    WHERE slug = "olor"
      AND (title LIKE "%Doloribus%" OR title LIKE "%pariatur%" OR title LIKE "%Lorem%")
    LIMIT 5
');

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        // Re-verify before delete — never trust a POST id alone.
        $row = db_one('
            SELECT id, slug, title FROM posts
            WHERE id = ?
              AND slug = "olor"
              AND (title LIKE "%Doloribus%" OR title LIKE "%pariatur%" OR title LIKE "%Lorem%")
            LIMIT 1
        ', 'i', [$id]);
        if (!$row) {
            $message = ['type' => 'error', 'text' => 'Safety check failed: post not in junk allowlist. Refused.'];
        } else {
            db_exec('DELETE FROM posts WHERE id = ?', 'i', [$id]);
            post_regenerate_sitemap();
            $message = ['type' => 'success', 'text' => "Deleted junk post #{$row['id']} (slug: {$row['slug']}, title: " . htmlspecialchars($row['title']) . "). Sitemap regenerated. You can now delete admin/_oneshot_purge_olor.php from the repo."];
            // Refresh candidates after delete.
            $candidates = [];
        }
    }
}

layout_start('One-shot: purge junk post');
?>
<section class="panel">
  <div class="panel-head">
    <h2>Purge junk lorem-ipsum post</h2>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-<?= htmlspecialchars($message['type']) ?>"><?= $message['text'] ?></div>
  <?php endif ?>

  <p class="muted">
    This page finds any post with slug <code>olor</code> whose title contains
    lorem-ipsum fingerprints (Doloribus / pariatur / Lorem) and lets you delete it.
    Safe by design — the WHERE clause is repeated on the actual DELETE, so a
    crafted POST with a different id will be rejected.
  </p>

  <?php if (!$candidates): ?>
    <p style="color:#16a34a;font-weight:600;margin-top:1rem;">
      ✓ No junk posts found matching the safety filter. You're clean.
    </p>
    <p class="muted" style="margin-top:1rem;">
      Next step: delete <code>admin/_oneshot_purge_olor.php</code> from the repo
      (Claude will do this in a follow-up commit) since this page has no further purpose.
    </p>
  <?php else: ?>
    <table class="data-table" style="margin-top:1rem;">
      <thead><tr><th>ID</th><th>Slug</th><th>Title</th><th>Status</th><th>Created</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($candidates as $c): ?>
          <tr>
            <td><?= (int)$c['id'] ?></td>
            <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
            <td><?= htmlspecialchars($c['title']) ?></td>
            <td><span class="badge badge-<?= $c['status'] ?>"><?= $c['status'] ?></span></td>
            <td><?= htmlspecialchars($c['created_at']) ?></td>
            <td>
              <form method="post" style="display:inline;"
                    onsubmit="return confirm('Permanently delete this post? It looks like lorem-ipsum junk, but verify the title above.');">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <button type="submit" class="btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>
</section>
<?php layout_end(); ?>
