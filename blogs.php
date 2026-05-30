<?php
require_once __DIR__ . '/includes/db.php';

$meta_title       = "Appverra Blogs — Insights on App Development & Marketing";
$meta_discription = "Stay updated with Appverra: expert blog posts on React Native, Flutter, game dev, mobile marketing & full-stack tips to inspire your digital journey";
$page_class       = "contact_us-page";
$og_image         = "https://appverra.co/assets/images/blog-img.webp";
include("header.php");

db_exec('UPDATE posts SET status = "published" WHERE status = "scheduled" AND publish_at <= NOW()', '', []);

$posts = db_all('
    SELECT id, slug, title, excerpt, featured_image, publish_at, created_at
    FROM posts
    WHERE status = "published"
    ORDER BY COALESCE(publish_at, created_at) DESC
    LIMIT 100
');
?>
<section class="hero_banner mainBanner innerBanner">
    <marquee behavior="scroll" direction="left" scrollamount="5" class="pageTitle"> Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs Our Blogs </marquee>
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-7">
                <span class="revealUp d-inline-block mb-md-4 mb-sm-3 mb-2">
                <span class="heading26px light">Our Blogs</span>
                </span>
                <h1 class="heading70px m-0 light">
                    <span class="revealUp">
                    <span>
                    Insights, Updates & Ideas <span class="secondColor">from Appverra </span>
                    </span>
                    </span>
                </h1>
                <svg class="animated_svg2 mb-3" width="672" height="36" viewBox="0 0 672 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 32C199.013 20.5125 606.673 -9.88059 663.31 11.341C719.946 32.5627 249.686 20.1834 7.47644 11.341" stroke="#B3FF00" stroke-width="7" stroke-linecap="round"/>
                </svg>
                <span class="revealUp">
                    <span>
                        <p style="color: #C3C9CE;">Explore expert articles, product updates, and helpful resources designed to keep you informed and inspired. Stay connected with the latest tips, stories, and news from our team and community.</p>
                    </span>
                </span>
                <div class="btn_set">
                    <span class="btn_wrap" data-aos="fade-up" data-aos-delay="600">
                    <a href="javascript:;" class="theme_btn pop_btn">
                    <span class="btnTextWrap"><span>Get Started</span><span>Get Started</span></span>
                    <span class="iconCircle"><span class="iconWrap"><i data-feather="arrow-right"></i><i data-feather="arrow-right"></i></span></span>
                    </a>
                    </span>
                    <span class="btn_wrap" data-aos="fade-up" data-aos-delay="600">
                    <a href="tel:<?= $tel ?>" class="theme_btn">
                    <span class="btnTextWrap"><span>Call Now</span><span>Call Now</span></span>
                    <span class="iconCircle"><span class="iconWrap"><i data-feather="phone"></i><i data-feather="phone"></i></span></span>
                    </a>
                    </span>
                    <span class="btn_wrap" data-aos="fade-up" data-aos-delay="600">
                    <a href="javascript:;" class="theme_btn chat">
                    <span class="btnTextWrap"><span>Chat Now</span><span>Chat Now</span></span>
                    <span class="iconCircle"><span class="iconWrap"><i data-feather="message-circle"></i><i data-feather="message-circle"></i></span></span>
                    </a>
                    </span>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <img src="assets/images/blog-banner-img.webp" loading="lazy" class="contact-banner-img img-fluid" alt="" data-aos="fade-up" data-aos-delay="600"/>
            </div>
        </div>
    </div>
</section>

<section class="contact_us blogs">
    <div class="container">
        <span class="border rounded-pill py-2 px-4 d-inline-block uppercase heading18px mb-4 mx-auto d-table dark bg-white">Our Blogs</span>
        <h2 class="heading70px text-center dark m-0">
            <span class="revealUp"><span>Our <span class="secondColor">Blogs</span></span></span>
        </h2>
        <svg class="animated_svg2 mb-3 w-50 mx-auto d-table" width="672" height="36" viewBox="0 0 672 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 32C199.013 20.5125 606.673 -9.88059 663.31 11.341C719.946 32.5627 249.686 20.1834 7.47644 11.341" stroke="#B3FF00" stroke-width="7" stroke-linecap="round"/>
        </svg>

        <div class="row mt-4 g-0">
            <?php if (!$posts): ?>
                <div class="col-12 text-center py-5">
                    <p>No blog posts yet — check back soon.</p>
                </div>
            <?php else: foreach ($posts as $i => $p):
                $img = $p['featured_image'] ?: 'assets/images/blog-img.webp';
                $delay = 300 + (($i % 3) * 100);
            ?>
                <div class="col-lg-4 p-2 aos-init aos-animate" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                    <div class="ow_row">
                        <img src="<?= htmlspecialchars($img) ?>" loading="lazy" class="ow_img img-fluid" width="616" height="377" alt="<?= htmlspecialchars($p['title']) ?>">
                        <div class="p-3 p-lg-4">
                            <h3 class="heading22px dark"><?= htmlspecialchars($p['title']) ?></h3>
                            <?php $pd = $p['publish_at'] ?: $p['created_at']; ?>
                            <?php if ($pd): ?><p class="blog-card-date" style="color:#8a8f98;font-size:.85rem;margin:.25rem 0 .5rem;"><time datetime="<?= htmlspecialchars(date('c', strtotime($pd))) ?>"><?= htmlspecialchars(date('M j, Y', strtotime($pd))) ?></time></p><?php endif; ?>
                            <span class="btn_wrap">
                                <a href="<?= htmlspecialchars($p['slug']) ?>" class="theme_btn black_btn">
                                    <span class="btnTextWrap"><span>Learn More</span><span>Learn More</span></span>
                                    <span class="iconCircle">
                                        <span class="iconWrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                <polyline points="12 5 19 12 12 19"></polyline>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                <polyline points="12 5 19 12 12 19"></polyline>
                                            </svg>
                                        </span>
                                    </span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php include("footer.php"); ?>
