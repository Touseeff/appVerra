<?php
require_once __DIR__ . '/includes/db.php';
$nav_posts = db_all('
    SELECT slug, title FROM posts
    WHERE status = "published"
       OR (status = "scheduled" AND publish_at <= NOW())
    ORDER BY COALESCE(publish_at, created_at) DESC
    LIMIT 9
');
?>
<aside class="sidebar">
    <div class="sidebar__box">
        <h3 class="sidebar__title">Quick Navigation</h3>
        <ul class="sidebar__list">
            <?php foreach ($nav_posts as $np): ?>
                <li><a href="/<?= htmlspecialchars($np['slug']) ?>"><?= htmlspecialchars($np['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="sidebar__box">
        <h3 class="sidebar__title">About Author</h3>
        <p><strong><?= htmlspecialchars($sitename ?? 'Appverra') ?></strong> helps businesses ship high-quality mobile and web apps — from concept to launch.</p>
    </div>
</aside>
