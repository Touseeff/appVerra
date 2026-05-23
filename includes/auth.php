<?php
require_once __DIR__ . '/db.php';

function auth_session_start(): void {
    if (session_status() !== PHP_SESSION_NONE) return;

    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_name('appverra_admin');
    session_start();
}

function current_user(): ?array {
    auth_session_start();
    if (empty($_SESSION['admin_user_id'])) return null;

    if (isset($_SESSION['admin_last_seen']) &&
        (time() - $_SESSION['admin_last_seen']) > ADMIN_SESSION_TIMEOUT) {
        auth_logout();
        return null;
    }
    $_SESSION['admin_last_seen'] = time();

    return db_one(
        'SELECT id, username, email FROM users WHERE id = ? LIMIT 1',
        'i', [$_SESSION['admin_user_id']]
    );
}

function require_auth(): array {
    $user = current_user();
    if ($user) return $user;

    $next = urlencode($_SERVER['REQUEST_URI'] ?? '/admin/');
    header('Location: /admin/login.php?next=' . $next, true, 302);
    exit;
}

function auth_login(int $user_id): void {
    auth_session_start();
    session_regenerate_id(true);
    $_SESSION['admin_user_id']   = $user_id;
    $_SESSION['admin_last_seen'] = time();
}

function auth_logout(): void {
    auth_session_start();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

// Simple file-based rate limiter for login attempts.
function rate_limit_check(string $key, int $max = 5, int $window = 900): bool {
    $dir = __DIR__ . '/../storage/ratelimit';
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    $file = $dir . '/' . preg_replace('/[^a-z0-9_-]/i', '', $key) . '.txt';

    $now = time();
    $attempts = [];
    if (is_file($file)) {
        $raw = @file_get_contents($file);
        $attempts = array_filter(array_map('intval', explode("\n", trim($raw ?? ''))),
            fn($t) => $t > ($now - $window));
    }
    return count($attempts) < $max;
}

function rate_limit_record(string $key): void {
    $dir = __DIR__ . '/../storage/ratelimit';
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    $file = $dir . '/' . preg_replace('/[^a-z0-9_-]/i', '', $key) . '.txt';
    @file_put_contents($file, time() . "\n", FILE_APPEND | LOCK_EX);
}
