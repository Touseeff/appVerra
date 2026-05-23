<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';

auth_session_start();
$error = '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rl_key = 'login_' . md5($ip);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    if (!rate_limit_check($rl_key, 5, 900)) {
        $error = 'Too many failed attempts. Try again in 15 minutes.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        $user = db_one(
            'SELECT id, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1',
            'ss', [$username, $username]
        );

        if ($user && password_verify($password, $user['password_hash'])) {
            auth_login((int)$user['id']);
            $next = $_GET['next'] ?? '/admin/dashboard.php';
            if (!preg_match('#^/admin/#', $next)) $next = '/admin/dashboard.php';
            header('Location: ' . $next, true, 302);
            exit;
        }
        rate_limit_record($rl_key);
        $error = 'Invalid credentials.';
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in — AppVerra Admin</title>
<link rel="icon" href="/favicon.ico">
<link rel="stylesheet" href="/admin/assets/admin.css">
</head>
<body class="auth-body">
  <main class="auth-card">
    <h1>AppVerra Admin</h1>
    <p class="auth-sub">Sign in to manage blog posts.</p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
      <?= csrf_field() ?>
      <label>Username or email
        <input type="text" name="username" required autofocus>
      </label>
      <label>Password
        <input type="password" name="password" required>
      </label>
      <button type="submit" class="btn-primary">Sign in</button>
    </form>
  </main>
</body>
</html>
