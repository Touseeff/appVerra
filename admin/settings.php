<?php
require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$user = require_auth();

$msg = null; $err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $current = (string)($_POST['current_password'] ?? '');
    $new     = (string)($_POST['new_password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    $row = db_one('SELECT password_hash FROM users WHERE id = ? LIMIT 1', 'i', [$user['id']]);
    if (!$row || !password_verify($current, $row['password_hash'])) {
        $err = 'Current password is incorrect.';
    } elseif (strlen($new) < 10) {
        $err = 'New password must be at least 10 characters.';
    } elseif ($new !== $confirm) {
        $err = 'New passwords do not match.';
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        db_exec('UPDATE users SET password_hash = ? WHERE id = ?', 'si', [$hash, $user['id']]);
        $msg = 'Password updated.';
    }
}

layout_start('Settings');
if ($msg) echo '<div class="alert alert-success">' . htmlspecialchars($msg) . '</div>';
if ($err) echo '<div class="alert alert-error">'   . htmlspecialchars($err) . '</div>';
?>
<section class="panel" style="max-width: 480px;">
  <h2 style="margin-bottom: 1rem;">Change password</h2>
  <form method="post" autocomplete="off">
    <?= csrf_field() ?>
    <div class="field"><label>Current password</label><input type="password" name="current_password" required></div>
    <div class="field"><label>New password (min 10 chars)</label><input type="password" name="new_password" required minlength="10"></div>
    <div class="field"><label>Confirm new password</label><input type="password" name="confirm_password" required minlength="10"></div>
    <button class="btn-primary" type="submit">Update password</button>
  </form>
</section>

<section class="panel">
  <h2 style="margin-bottom: 1rem;">Account</h2>
  <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
</section>
<?php layout_end();
