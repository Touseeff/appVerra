<?php 

    $siteurl = "https://appverra.co/";

    $sitename = "AppVerra";

    $sitenumber = "(213) 714-7176";

    $tel = "2137147176";

    $siteemail = "info@appverra.co";

    $siteaddress = "20 N Moore St, New York, NY 10013, United States";

    $fullpageurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $pageurl   = "https://$_SERVER[HTTP_HOST]";

    $category = str_replace("/","",$_SERVER['REQUEST_URI']);

    $base_url = "<?php echo $siteurl; ?>";

    $document_root = $_SERVER['DOCUMENT_ROOT']."/";

    $ip = $_SERVER['REMOTE_ADDR'];

    $locationData = file_get_contents("http://ip-api.com/json/{$ip}");

    $location = json_decode($locationData, true);

    $isp = $location['isp'] ?? '';

    $org = $location['org'] ?? '';

    $country = $location['country'] ?? '';

    $region = $location['regionName'] ?? '';

    $city = $location['city'] ?? '';

?>



<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="eU5DoRpCn817G_9sXwTBQk9uB-d4IAtUEAm6BUulBiQ" />

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Preload critical fonts -->
    <link rel="preload" as="style" type="font/woff2" crossorigin href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Manrope:wght@200..800&display=swap">

    <!-- Load stylesheet without blocking render -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Manrope:wght@200..800&display=swap" media="print" onload="this.media='all'">

    <!-- Fallback noscript for users with JS disabled -->
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Manrope:wght@200..800&display=swap">
    </noscript>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="shortcut icon" href="assets/images/favicon-32x32.png">

    <!-- Critical CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="assets/css/style.css" media="all">
    <link rel="stylesheet" href="assets/css/reponsive.css" media="all">

    <!-- Preload Non-Critical CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css"  >
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css"  >
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css"  >
    <link rel="stylesheet" type="text/css" href="assets/fonts/fonts.css"  >
    <link rel="stylesheet" type="text/css" href="assets/css/aos.css"  >

    <!-- Load FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" media="all">

    <!-- Title & Core Meta -->
    <title><?= $meta_title ?></title>
    <meta name="description" content="<?= $meta_discription ?>">
    <meta name="keywords" content="mobile app development company USA, iOS app development, Android app development, React Native developer, Flutter app development, Unity game development, full stack development company, app development agency New York, hire mobile app developers USA, custom mobile app development, cross-platform app development, game development company USA, ecommerce app development, mobile app marketing agency, app development services USA">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="AppVerra">
    <link rel="canonical" href="<?= $fullpageurl ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $fullpageurl ?>">
    <meta property="og:title" content="<?= $meta_title ?>">
    <meta property="og:description" content="<?= $meta_discription ?>">
    <meta property="og:image" content="https://appverra.co/assets/images/banner-bg1.webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="AppVerra">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= $fullpageurl ?>">
    <meta name="twitter:title" content="<?= $meta_title ?>">
    <meta name="twitter:description" content="<?= $meta_discription ?>">
    <meta name="twitter:image" content="https://appverra.co/assets/images/banner-bg1.webp">

    <!-- Schema: LocalBusiness -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "AppVerra",
      "url": "https://appverra.co/",
      "logo": "https://appverra.co/assets/images/logo.webp",
      "telephone": "(213) 714-7176",
      "email": "info@appverra.co",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "20 N Moore St",
        "addressLocality": "New York",
        "addressRegion": "NY",
        "postalCode": "10013",
        "addressCountry": "US"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 40.7209,
        "longitude": -74.0096
      },
      "description": "AppVerra is a leading mobile app development company in the USA specializing in iOS, Android, React Native, Flutter, Unity game development, full-stack solutions, and mobile app marketing.",
      "areaServed": "US",
      "priceRange": "$$",
      "openingHours": "Mo-Fr 09:00-18:00",
      "sameAs": [
        "https://appverra.co/",
        "https://www.facebook.com/AppVerra.Official",
        "https://www.linkedin.com/company/appverra",
        "https://www.instagram.com/appverraco/",
        "https://x.com/appverra1"
      ]
    }
    </script>

    <!-- Schema: WebSite with SearchAction -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "AppVerra",
      "url": "https://appverra.co/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://appverra.co/?s={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

</head>



   <body class="<?php echo $page_class?>">

   <div class=" responsive_menu">

        <span class="closeBtn">+</span>

        <ul class="navigation">

            <li><a href="<?php echo $siteurl; ?>" class="mainAnchor" targetFrom="seo">Home</a></li>

            <li><a href="about-us.php" class="mainAnchor" targetFrom="smm">About</a></li>

            <li><a href="javascript:;" class="hasDrop mainAnchor" targetFrom="servicesMenu">Services <i class="arrow_right"></i></a></li>

            <li><a href="our-work.php" class="mainAnchor" >Work</a></li>

            <li><a href="contact-us.php" class="mainAnchor">Contact Us</a></li>

            <!-- PAID MARKETING SUBMENU -->

            <ul class="megaMenu" targetTo="servicesMenu">

                <div class="cls_menu"><i class="arrow_right"></i> Back</div>

                <li><a href="unity-game-development.php">Unity Game Development</a></li>

                <li><a href="react-native-developer.php">React Native Development</a></li>

                <li><a href="flutter-app-development.php">Flutter App Development</a></li>

                <li><a href="full-stack-development.php">Full Stack Development</a></li>

                <li><a href="mobile-app-marketing.php">Mobile App Marketing</a></li>

                <li><a href="ecommerce.php">Ecommerce </a></li>

            </ul>

            <!-- PAID MARKETING SUBMENU -->

           

        </ul>

   </div>

   <div id="smooth-wrapper">

        <div id="smooth-content">

            <header>

                <!-- <nav class="container">

                    <div class="row align-items-center">

                        <div class="col-3" >

                            <a href="<?php echo $siteurl; ?>">

                            <img src="assets/images/logo.webp" alt="Logo" loading="lazy" class="logo img-fluid" width="180" height="42">

                            </a>

                        </div>

                        <div class="col-6">

                            <div class="top_nav">

                                <ul class="navigation d-none d-lg-flex">

                                    <li data-aos="fade-down" data-aos-delay="100">

                                        <a href="<?php echo $siteurl; ?>">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/> </svg>

                                            Home

                                        </a>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="200">

                                        <a href="about-us.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg> 

                                            About

                                        </a>

                                    </li>

                                    <li class="services_btn" data-aos="fade-down" data-aos-delay="300">

                                        <a href="our-services.php">

                                            Services

                                        </a>

                                        <i class="fa fa-angle-down" aria-hidden="true"></i>

                                        <ul class="servicesDropdown">

                                            <li><a href="unity-game-development.php"><span>Unity Game Development</span></a></li>

                                            <li><a href="react-native-developer.php"><span>React Native Development</span></a></li>

                                            <li><a href="flutter-app-development.php"><span>Flutter App Development</span></a></li>

                                            <li><a href="full-stack-development.php"><span>Full Stack Development</span></a></li>

                                            <li><a href="mobile-app-marketing.php"><span>Mobile App Marketing</span></a></li>

                                            <li><a href="ecommerce.php"><span>Ecommerce</span></a></li>

                                        </ul>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="400">

                                        <a href="our-work.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg>

                                            Work

                                        </a>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="500">

                                        <a href="blogs.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg>

                                            Blogs

                                        </a>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="600">

                                        <a href="contact-us.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg>

                                            contact

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="col-3">

                            <div class="hamBurger d-block d-lg-none">

                                <div></div>

                                <div></div>

                                <div></div>

                            </div>

                            <ul class="get_stated_ul d-none d-lg-flex">

                                <li>

                                    <div class="btn_set">
                                        <a href="javascript:;" class="theme_btn pop_btn">

                                            <span class="btnTextWrap">

                                                <span>Get Started</span>

                                                <span>Get Started</span>

                                            </span>

                                            <span class="iconCircle">

                                                <span class="iconWrap">

                                                    <i data-feather="arrow-right"></i>

                                                    <i data-feather="arrow-right"></i>

                                                </span>

                                            </span>

                                        </a>
                                        <a href="tel:<?= $sitenumber ?>" class="call_now"><i data-feather="phone"></i></a>
                                        <script>
                                            let call_now = document.querySelector('.call_now');

                                            setInterval(() => {
                                                call_now.classList.add('telephoneVibration');
                                                setTimeout(() => {
                                                    call_now.classList.remove('telephoneVibration');
                                                }, 1000);
                                            }, 2500);
                                        </script>
                                    </div>

                                </li>

                            </ul>

                        </div>

                    </div>

                </nav> -->

                <nav class="container">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-3 offset-lg-4 ps-lg-5" >

                            <a href="<?php echo $siteurl; ?>">

                            <img src="assets/images/logo.webp" alt="Logo" loading="lazy" class="logo img-fluid" width="180" height="42">

                            </a>

                        </div>

                        <!-- <div class="col-6">

                            <div class="top_nav">

                                <ul class="navigation d-none d-lg-flex">

                                    <li data-aos="fade-down" data-aos-delay="100">

                                        <a href="<?php echo $siteurl; ?>">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/> </svg>

                                            Home

                                        </a>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="200">

                                        <a href="about-us.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg> 

                                            About

                                        </a>

                                    </li>

                                    <li class="services_btn" data-aos="fade-down" data-aos-delay="300">

                                        <a href="our-services.php">

                                            Services

                                        </a>

                                        <i class="fa fa-angle-down" aria-hidden="true"></i>

                                        <ul class="servicesDropdown">

                                            <li><a href="unity-game-development.php"><span>Unity Game Development</span></a></li>

                                            <li><a href="react-native-developer.php"><span>React Native Development</span></a></li>

                                            <li><a href="flutter-app-development.php"><span>Flutter App Development</span></a></li>

                                            <li><a href="full-stack-development.php"><span>Full Stack Development</span></a></li>

                                            <li><a href="mobile-app-marketing.php"><span>Mobile App Marketing</span></a></li>

                                            <li><a href="ecommerce.php"><span>Ecommerce</span></a></li>

                                        </ul>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="400">

                                        <a href="our-work.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg>

                                            Work

                                        </a>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="500">

                                        <a href="blogs.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg>

                                            Blogs

                                        </a>

                                    </li>

                                    <li data-aos="fade-down" data-aos-delay="600">

                                        <a href="contact-us.php">

                                            <svg class="animated_underline" width="66" height="10" viewBox="0 0 66 10" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M2 7.5C16.8333 4.33334 56.5 -3 64 7.5" stroke="#B3FF00" stroke-width="4" stroke-linecap="round"/></svg>

                                            contact

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div> -->

                        <div class="col-lg-5 col-9">

                            <div class="hamBurger">

                                <div></div>

                                <div></div>

                                <div></div>

                            </div>

                            <ul class="get_stated_ul">

                                <li>

                                    <div class="btn_set">
                                        <a href="javascript:;" class="theme_btn pop_btn">

                                            <span class="btnTextWrap">

                                                <span>Get Started</span>

                                                <span>Get Started</span>

                                            </span>

                                            <span class="iconCircle">

                                                <span class="iconWrap">

                                                    <i data-feather="arrow-right"></i>

                                                    <i data-feather="arrow-right"></i>

                                                </span>

                                            </span>

                                        </a>
                                        <a href="tel:<?= $sitenumber ?>" class="call_now"><i data-feather="phone"></i></a>
                                        <script>
                                            let call_now = document.querySelector('.call_now');

                                            setInterval(() => {
                                                call_now.classList.add('telephoneVibration');
                                                setTimeout(() => {
                                                    call_now.classList.remove('telephoneVibration');
                                                }, 1000);
                                            }, 2500);
                                        </script>
                                    </div>

                                </li>

                            </ul>

                        </div>

                    </div>

                </nav>

           </header>