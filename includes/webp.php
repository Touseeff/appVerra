<?php

function image_to_webp(string $src_path, string $dst_path, int $quality = 85): bool {
    if (!function_exists('imagewebp')) return false;
    $info = @getimagesize($src_path);
    if (!$info) return false;

    switch ($info[2]) {
        case IMAGETYPE_JPEG: $img = @imagecreatefromjpeg($src_path); break;
        case IMAGETYPE_PNG:  $img = @imagecreatefrompng($src_path);  break;
        case IMAGETYPE_GIF:  $img = @imagecreatefromgif($src_path);  break;
        case IMAGETYPE_WEBP: return @copy($src_path, $dst_path);
        default: return false;
    }
    if (!$img) return false;

    if ($info[2] === IMAGETYPE_PNG) {
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
    }

    $ok = @imagewebp($img, $dst_path, $quality);
    imagedestroy($img);
    return $ok;
}

function sanitize_upload_filename(string $original): string {
    $ext  = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $name = pathinfo($original, PATHINFO_FILENAME);
    $name = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    $name = trim($name, '-');
    if ($name === '') $name = 'image';
    $name = substr($name, 0, 60);
    $suffix = substr(bin2hex(random_bytes(3)), 0, 6);
    return $name . '-' . $suffix . ($ext ? '.' . $ext : '');
}
