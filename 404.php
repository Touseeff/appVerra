<?php
$meta_title = "Page Not Found — AppVerra";
$meta_discription = "The page you're looking for doesn't exist. Return to AppVerra's homepage.";
$page_class = "error-page";
http_response_code(404);
include("header.php");
?>

<section class="hero_banner mainBanner innerBanner" style="min-height:70vh; display:flex; align-items:center;">
    <div class="container text-center">
        <h1 class="heading70px light" style="font-size:8rem; line-height:1;">404</h1>
        <h2 class="heading40px light mb-3">Page Not Found</h2>
        <p style="color:#C3C9CE; max-width:480px; margin:0 auto 2rem;">The page you're looking for doesn't exist or has been moved.</p>
        <span class="btn_wrap">
            <a href="<?php echo $siteurl; ?>" class="theme_btn">
                <span class="btnTextWrap">
                    <span>Back to Home</span>
                    <span>Back to Home</span>
                </span>
                <span class="iconCircle">
                    <span class="iconWrap">
                        <i data-feather="arrow-right"></i>
                        <i data-feather="arrow-right"></i>
                    </span>
                </span>
            </a>
        </span>
    </div>
</section>

<?php include("footer.php"); ?>
