<?php
// AppVerra DB config — DO NOT commit real production credentials.
// This file is denied via root .htaccess; still, prefer env vars on Hostinger if available.

if (!defined('APPVERRA_DB_LOADED')) {
    define('APPVERRA_DB_LOADED', true);

    // Real credentials live in `config.local.php` (gitignored).
    // We try multiple locations in priority order:
    //   1. includes/config.local.php (in-repo location — convenient but Hostinger
    //      Git deploys can wipe it on push)
    //   2. /home/u751124526/config.local.php (home dir — OUTSIDE public_html, so
    //      Git deploys never touch it. Recommended for production.)
    //   3. Env vars via getenv() — works if Hostinger PHP-FPM picks them up.
    //   4. CHANGE_ME placeholders below — fatal at first DB query (intentional).
    foreach ([
        __DIR__ . '/config.local.php',
        // Above public_html — survives Hostinger Git deploys (which only manage
        // public_html). This is the recommended production location. Upload via
        // hPanel File Manager → domains/appverra.co/ → upload config.local.php.
        '/home/u751124526/domains/appverra.co/config.local.php',
        // Last-ditch fallback: user home dir (works only if open_basedir allows).
        '/home/u751124526/config.local.php',
    ] as $candidate) {
        if (is_file($candidate) && is_readable($candidate)) {
            require $candidate;
            break;
        }
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
