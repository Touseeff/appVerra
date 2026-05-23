<?php
require_once __DIR__ . '/../includes/auth.php';
if (current_user()) {
    header('Location: /admin/dashboard.php', true, 302);
} else {
    header('Location: /admin/login.php', true, 302);
}
exit;
