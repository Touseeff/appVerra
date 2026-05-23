<?php
require_once __DIR__ . '/db.php';

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text === '' ? 'post' : substr($text, 0, 180);
}

function slug_unique(string $base, ?int $exclude_id = null): string {
    $base = slugify($base);
    $slug = $base;
    $n = 2;
    while (true) {
        if ($exclude_id) {
            $row = db_one('SELECT id FROM posts WHERE slug = ? AND id <> ? LIMIT 1', 'si', [$slug, $exclude_id]);
        } else {
            $row = db_one('SELECT id FROM posts WHERE slug = ? LIMIT 1', 's', [$slug]);
        }
        if (!$row) return $slug;
        $slug = $base . '-' . $n++;
        if ($n > 50) return $base . '-' . substr(bin2hex(random_bytes(3)), 0, 5);
    }
}
