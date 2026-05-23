<?php
// AppVerra DB config — DO NOT commit real production credentials.
// This file is denied via root .htaccess; still, prefer env vars on Hostinger if available.

if (!defined('APPVERRA_DB_LOADED')) {
    define('APPVERRA_DB_LOADED', true);

    // Real credentials live in `includes/config.local.php` (gitignored).
    // That file is loaded first if present; defaults below are safe placeholders.
    if (is_file(__DIR__ . '/config.local.php')) {
        require __DIR__ . '/config.local.php';
    }
    if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'CHANGE_ME_DB_NAME');
    if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'CHANGE_ME_DB_USER');
    if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') ?: 'CHANGE_ME_DB_PASS');
    define('DB_CHARSET', 'utf8mb4');

    // Admin session timeout (seconds). 4 hours.
    define('ADMIN_SESSION_TIMEOUT', 4 * 3600);

    // Upload limits.
    define('UPLOAD_MAX_BYTES', 5 * 1024 * 1024);
    define('UPLOAD_ALLOWED_MIME', ['image/png', 'image/jpeg', 'image/webp', 'image/gif']);

    // Production safety.
    if (getenv('APP_ENV') === 'production') {
        ini_set('display_errors', '0');
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    }
}
