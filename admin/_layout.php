<?php
// Shared admin layout — call layout_start($title) at the top, layout_end() at the bottom.
require_once __DIR__ . '/../includes/auth.php';

function layout_start(string $title): void {
    $user = require_auth();
    $current = $_SERVER['REQUEST_URI'] ?? '';
    $pending_count = count_pending_imports();
    ?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?> — AppVerra Admin</title>
<link rel="icon" href="/favicon.ico">
<link rel="stylesheet" href="/admin/assets/admin.css">
</head>
<body class="admin-body">
<aside class="sidebar-nav">
  <a class="brand" href="/admin/dashboard.php">AppVerra<span>Admin</span></a>
  <nav>
    <a href="/admin/dashboard.php" class="<?= str_contains($current, 'dashboard') ? 'active' : '' ?>">Dashboard</a>
    <a href="/admin/posts/" class="<?= str_contains($current, '/posts') ? 'active' : '' ?>">Posts</a>
    <a href="/admin/posts/create.php">+ New post</a>
    <a href="/admin/import-pending.php" class="<?= str_contains($current, 'import-pending') ? 'active' : '' ?>">
      Import drafts<?php if ($pending_count > 0): ?>
        <span style="background:#dc2626;color:#fff;border-radius:10px;padding:.1rem .5rem;font-size:.75rem;margin-left:.4rem;"><?= $pending_count ?></span>
      <?php endif ?>
    </a>
    <a href="/admin/media/" class="<?= str_contains($current, '/media') ? 'active' : '' ?>">Media</a>
    <a href="/admin/settings.php" class="<?= str_contains($current, 'settings') ? 'active' : '' ?>">Settings</a>
  </nav>
  <div class="sidebar-foot">
    <span><?= htmlspecialchars($user['username']) ?></span>
    <a href="/admin/logout.php">Log out</a>
  </div>
</aside>
<main class="admin-main">
<header class="admin-header"><h1><?= htmlspecialchars($title) ?></h1></header>
<div class="admin-content">
<?php
}

function layout_end(): void {
    ?></div>
</main>
</body>
</html><?php
}

function count_pending_imports(): int {
    $dir = realpath(__DIR__ . '/../blog_factory/queue/pending');
    if (!$dir || !is_dir($dir)) return 0;
    $files = glob($dir . '/*.md') ?: [];
    return count($files);
}

function flash_set(string $type, string $msg): void {
    auth_session_start();
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function flash_render(): string {
    auth_session_start();
    if (empty($_SESSION['flash'])) return '';
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return '<div class="alert alert-' . htmlspecialchars($f['type']) . '">'
         . htmlspecialchars($f['msg']) . '</div>';
}
