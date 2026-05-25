<?php
require_once __DIR__ . '/auth.php';

if (function_exists('opcache_invalidate')) {
    opcache_invalidate(__FILE__, true);
}

function csrf_token(): string {
    auth_session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        session_write_close();
        auth_session_start();
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

function csrf_ensure(): void {
    csrf_token();
}

function csrf_verify(): void {
    auth_session_start();
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], (string)$token)) {
        http_response_code(403);
        exit('CSRF token mismatch.');
    }
}
