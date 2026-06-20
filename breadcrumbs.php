<?php
/**
 * breadcrumbs.php — reusable visible breadcrumb trail for static landing pages.
 *
 * Styled to sit on a dark hero background (matches the blog-post.php breadcrumb).
 * Drive it with the SAME $breadcrumbs array used for build_breadcrumb_schema(),
 * so the visible trail and the JSON-LD never drift:
 *
 *   $breadcrumbs = [
 *       ['name' => 'Home',     'url' => 'https://appverra.co/'],
 *       ['name' => 'Services', 'url' => 'https://appverra.co/our-services'],
 *       ['name' => 'iOS App Development', 'url' => 'https://appverra.co/services/ios-app-development'],
 *   ];
 *   include $_SERVER['DOCUMENT_ROOT'] . '/breadcrumbs.php';
 *
 * The final crumb renders as the current page (not a link).
 */
if (!empty($breadcrumbs) && is_array($breadcrumbs)):
    $__bc_last    = count($breadcrumbs) - 1;
    // Optional: set $breadcrumb_align = 'center' before include for centered heroes (case studies, blog).
    $__bc_justify = (!empty($breadcrumb_align) && $breadcrumb_align === 'center') ? 'center' : 'flex-start';
?>
<nav aria-label="Breadcrumb" class="site-breadcrumb" style="margin:0 0 1.2rem;">
  <ol style="list-style:none;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:.4rem;align-items:center;justify-content:<?= $__bc_justify ?>;color:#C3C9CE;font-size:.9rem;">
    <?php foreach ($breadcrumbs as $__bc_i => $__bc): ?>
      <?php if ($__bc_i > 0): ?><li aria-hidden="true" style="opacity:.6;">›</li><?php endif; ?>
      <?php if ($__bc_i === $__bc_last || empty($__bc['url'])): ?>
        <li aria-current="page" style="color:#fff;"><?= htmlspecialchars($__bc['name']) ?></li>
      <?php else: ?>
        <li><a href="<?= htmlspecialchars($__bc['url']) ?>" style="color:#C3C9CE;text-decoration:underline;"><?= htmlspecialchars($__bc['name']) ?></a></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ol>
</nav>
<?php endif; ?>
