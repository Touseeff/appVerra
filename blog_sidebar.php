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
    <div class="sidebar__box" style="background:linear-gradient(150deg,#1a1830,#6243FA);border-radius:14px;padding:22px;color:#fff;">
        <img src="/assets/images/app-launch-checklist-cover.webp" loading="lazy" width="820" height="1060" alt="Free App Launch Checklist PDF" style="width:100%;max-width:150px;border-radius:8px;box-shadow:0 12px 30px rgba(0,0,0,.3);margin-bottom:14px;">
        <h3 class="sidebar__title" style="color:#fff;">Free App Launch Checklist</h3>
        <p style="color:#d7d3f2;font-size:14px;margin:6px 0 14px;">Ship on the App Store &amp; Google Play with nothing forgotten. A print-and-tick PDF — no email required.</p>
        <a href="/app-launch-checklist" style="display:inline-block;background:#B2FF00;color:#1a1830;font-weight:800;padding:10px 18px;border-radius:40px;font-size:14px;text-decoration:none;">Get the free PDF →</a>
    </div>
    <div class="sidebar__box">
        <h3 class="sidebar__title">About Author</h3>
        <p><strong><?= htmlspecialchars($sitename ?? 'Appverra') ?></strong> helps businesses ship high-quality mobile and web apps — from concept to launch.</p>
    </div>
</aside>
