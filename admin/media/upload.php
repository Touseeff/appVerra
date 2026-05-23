<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/webp.php';

$user = require_auth();

$is_tinymce = isset($_GET['tinymce']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'POST only']);
    exit;
}

// TinyMCE sends file as 'file', form picker uses 'file' too. CSRF only for non-tinymce.
if (!$is_tinymce) csrf_verify();

header('Content-Type: application/json');

if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded']);
    exit;
}

$f = $_FILES['file'];
if ($f['size'] > UPLOAD_MAX_BYTES) {
    http_response_code(400);
    echo json_encode(['error' => 'File too large (max 5 MB)']);
    exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($f['tmp_name']);
if (!in_array($mime, UPLOAD_ALLOWED_MIME, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Unsupported file type: ' . $mime]);
    exit;
}

$filename = sanitize_upload_filename($f['name']);
$year     = date('Y');
$month    = date('m');
$rel_dir  = "/uploads/{$year}/{$month}";
$abs_dir  = realpath(__DIR__ . '/../..') . $rel_dir;
if (!is_dir($abs_dir)) @mkdir($abs_dir, 0755, true);

$abs_path = $abs_dir . '/' . $filename;
if (!@move_uploaded_file($f['tmp_name'], $abs_path)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save file']);
    exit;
}

$url      = $rel_dir . '/' . $filename;
$webp_url = null;
if (in_array($mime, ['image/png', 'image/jpeg', 'image/gif'], true)) {
    $webp_path = preg_replace('/\.[^.]+$/', '.webp', $abs_path);
    if (image_to_webp($abs_path, $webp_path)) {
        $webp_url = preg_replace('/\.[^.]+$/', '.webp', $url);
    }
}

db_exec(
    'INSERT INTO media (filename, url, webp_url, original_name, mime_type, size_bytes, uploaded_by)
     VALUES (?, ?, ?, ?, ?, ?, ?)',
    'sssssii',
    [$filename, $url, $webp_url, $f['name'], $mime, (int)$f['size'], (int)$user['id']]
);

// TinyMCE expects { location: "url" }
if ($is_tinymce) {
    echo json_encode(['location' => $webp_url ?: $url]);
} else {
    echo json_encode(['url' => $webp_url ?: $url, 'original' => $url, 'webp' => $webp_url]);
}
