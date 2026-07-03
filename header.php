<?php 

    $siteurl = "https://appverra.co/";

    $sitename = "Appverra";

    $sitenumber = "(213) 714-7176";

    $tel = "2137147176";

    $siteemail = "info@appverra.co";

    $siteaddress = "20 N Moore St, New York, NY 10013, United States";

    $fullpageurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $pageurl   = "https://$_SERVER[HTTP_HOST]";

    $category = str_replace("/","",$_SERVER['REQUEST_URI']);

    $base_url = $siteurl;

    $document_root = $_SERVER['DOCUMENT_ROOT']."/";

    $ip = $_SERVER['REMOTE_ADDR'];

    if(session_status() === PHP_SESSION_NONE) session_start();

    // Skip the geo lookup for crawlers/bots. They don't need geo-personalization,
    // the blocking call adds up to 1s of latency to every crawl, and serving bots
    // geo-varied content risks inconsistent indexing. Humans still get it.
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $is_bot = (bool) preg_match('/bot|crawl|spider|slurp|gptbot|oai-searchbot|chatgpt|claudebot|anthropic|perplexity|applebot|google-extended|ccbot|bytespider|facebookexternalhit|embedly|slackbot|telegrambot|whatsapp|bingpreview/i', $ua);

    $cache_key = 'loc_' . md5($ip);
    if(!$is_bot && !isset($_SESSION[$cache_key])) {
        $ctx = stream_context_create(['http' => ['timeout' => 1, 'ignore_errors' => true]]);
        $raw = @file_get_contents("http://ip-api.com/json/{$ip}", false, $ctx);
        $_SESSION[$cache_key] = $raw ?: '{}';
    }
    $location = $is_bot ? [] : (json_decode($_SESSION[$cache_key] ?? '{}', true) ?? []);

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

    <!-- Resource Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

    <!-- Preload LCP hero background images -->
    <link rel="preload" as="image" href="/assets/images/banner-bg1.webp" fetchpriority="high">
    <link rel="preload" as="image" href="/assets/images/banner-bg2.webp">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="512x512" href="/assets/images/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/site.webmanifest">

    <!-- Critical CSS — render-blocking (above the fold) -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/reponsive.css">

    <!-- Non-critical CSS — loaded async, no render blocking -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Manrope:wght@200..800&display=swap" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/fonts/fonts.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/css/slick.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/css/slick-theme.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="/assets/css/aos.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" media="print" onload="this.media='all'">

    <!-- Noscript fallback for all async CSS -->
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Manrope:wght@200..800&display=swap">
      <link rel="stylesheet" href="/assets/fonts/fonts.css">
      <link rel="stylesheet" href="/assets/css/slick.css">
      <link rel="stylesheet" href="/assets/css/slick-theme.css">
      <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="/assets/css/aos.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    </noscript>

    <!-- Per-page critical CSS (e.g. homepage hero overrides) -->
    <?php if(!empty($extra_head_css)): ?><style><?= $extra_head_css ?></style><?php endif; ?>

    <!-- Title & Core Meta -->
    <title><?= $meta_title ?></title>
    <meta name="description" content="<?= $meta_discription ?>">
    <meta name="keywords" content="mobile app development company USA, iOS app development, Android app development, React Native developer, Flutter app development, Unity game development, full stack development company, app development agency New York, hire mobile app developers USA, custom mobile app development, cross-platform app development, game development company USA, ecommerce app development, mobile app marketing agency, app development services USA">
    <meta name="robots" content="<?= !empty($page_robots) ? $page_robots : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' ?>">
    <meta name="author" content="Appverra">
    <link rel="canonical" href="<?= !empty($canonical_override) ? htmlspecialchars($canonical_override, ENT_QUOTES) : $fullpageurl ?>">

    <?php
      if(empty($og_image)) $og_image = "https://appverra.co/assets/images/logo.webp";
      // og:type — pages can override (blog-post.php sets "article").
      $__og_type = !empty($og_type) ? $og_type : 'website';
    ?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= htmlspecialchars($__og_type, ENT_QUOTES) ?>">
    <meta property="og:url" content="<?= $fullpageurl ?>">
    <meta property="og:title" content="<?= $meta_title ?>">
    <meta property="og:description" content="<?= $meta_discription ?>">
    <meta property="og:image" content="<?= $og_image ?>">
    <?php if (!empty($og_image_alt)): ?>
    <meta property="og:image:alt" content="<?= htmlspecialchars($og_image_alt, ENT_QUOTES) ?>">
    <?php endif; ?>
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Appverra">
    <meta property="og:locale" content="en_US">
    <?php if ($__og_type === 'article' && !empty($article_meta)): ?>
      <?php if (!empty($article_meta['published_time'])): ?>
    <meta property="article:published_time" content="<?= htmlspecialchars($article_meta['published_time'], ENT_QUOTES) ?>">
      <?php endif; ?>
      <?php if (!empty($article_meta['modified_time'])): ?>
    <meta property="article:modified_time" content="<?= htmlspecialchars($article_meta['modified_time'], ENT_QUOTES) ?>">
      <?php endif; ?>
      <?php if (!empty($article_meta['author'])): ?>
    <meta property="article:author" content="<?= htmlspecialchars($article_meta['author'], ENT_QUOTES) ?>">
      <?php endif; ?>
      <?php if (!empty($article_meta['section'])): ?>
    <meta property="article:section" content="<?= htmlspecialchars($article_meta['section'], ENT_QUOTES) ?>">
      <?php endif; ?>
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= $fullpageurl ?>">
    <meta name="twitter:title" content="<?= $meta_title ?>">
    <meta name="twitter:description" content="<?= $meta_discription ?>">
    <meta name="twitter:image" content="<?= $og_image ?>">
    <?php if (!empty($og_image_alt)): ?>
    <meta name="twitter:image:alt" content="<?= htmlspecialchars($og_image_alt, ENT_QUOTES) ?>">
    <?php endif; ?>

    <!-- Schema: Organization + LocalBusiness (combined) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": ["Organization", "LocalBusiness"],
      "name": "Appverra",
      "alternateName": "Appverra Mobile App Development Agency",
      "url": "https://appverra.co/",
      "logo": "https://appverra.co/assets/images/logo.webp",
      "image": "https://appverra.co/assets/images/logo.webp",
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
      "description": "Appverra is a founder-led mobile app development agency. 150+ apps shipped for 700+ customers. Our apps have millions of downloads. We deliver Flutter, React Native, and full-stack builds in 6 weeks for startups and SMBs across the US, Canada, and UK.",
      "areaServed": ["US", "CA", "GB"],
      "priceRange": "$$",
      "openingHours": "Mo-Fr 09:00-18:00",
      "knowsAbout": [
        "Flutter app development",
        "React Native app development",
        "Mobile app development for startups",
        "MVP development",
        "Marketplace app development",
        "On-demand app development",
        "Full-stack mobile development"
      ],
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "App development packages",
        "itemListElement": [
          { "@type": "Offer", "name": "Discovery Sprint", "price": "1997", "priceCurrency": "USD", "description": "90-minute scoping call plus Figma prototype and fixed-bid SOW" },
          { "@type": "Offer", "name": "Starter App",    "price": "7997",  "priceCurrency": "USD" },
          { "@type": "Offer", "name": "Launch App",     "price": "14997", "priceCurrency": "USD" },
          { "@type": "Offer", "name": "Growth App",     "price": "29997", "priceCurrency": "USD" },
          { "@type": "Offer", "name": "Scale App",      "price": "59997", "priceCurrency": "USD" },
          { "@type": "Offer", "name": "Enterprise App", "price": "99997", "priceCurrency": "USD" }
        ]
      },
      "sameAs": [
        "https://www.facebook.com/AppVerra.Official",
        "https://www.linkedin.com/company/Appverra",
        "https://www.instagram.com/appverraco/",
        "https://x.com/appverra1"
      ]
    }
    </script>

    <!-- Schema: WebSite -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Appverra",
      "url": "https://appverra.co/"
    }
    </script>

    <?php
      // $schema_extra accepts either:
      //   - a string (one JSON-LD blob — legacy callers)
      //   - an array of strings (multiple blobs; each becomes its own <script>)
      // Use the array form for blog posts (BlogPosting + FAQPage + BreadcrumbList).
      if (!empty($schema_extra)) {
        $__schema_blobs = is_array($schema_extra) ? $schema_extra : [$schema_extra];
        foreach ($__schema_blobs as $__blob) {
          if (trim((string)$__blob) === '') continue;
          echo '<script type="application/ld+json">' . "\n" . $__blob . "\n" . '</script>' . "\n";
        }
      }
    ?>

</head>



   <body class="<?php echo $page_class?>">

   <div class=" responsive_menu">

        <span class="closeBtn">+</span>

        <ul class="navigation">

            <li><a href="<?php echo $siteurl; ?>" class="mainAnchor" targetFrom="seo">Home</a></li>

            <li><a href="/about-us" class="mainAnchor" targetFrom="smm">About</a></li>

            <li><a href="javascript:;" class="hasDrop mainAnchor" targetFrom="servicesMenu">Services <i class="arrow_right"></i></a></li>

            <li><a href="/industries" class="mainAnchor">Industries</a></li>

            <li><a href="/locations" class="mainAnchor">Locations</a></li>

            <li><a href="/our-work" class="mainAnchor" >Work</a></li>

            <li><a href="/blogs" class="mainAnchor">Blogs</a></li>

            <li><a href="/app-launch-checklist" class="mainAnchor">Free Guide</a></li>

            <li><a href="/contact-us" class="mainAnchor">Contact Us</a></li>

            <!-- PAID MARKETING SUBMENU -->

            <ul class="megaMenu" targetTo="servicesMenu">

                <div class="cls_menu"><i class="arrow_right"></i> Back</div>

                <li><a href="/our-services">All Services</a></li>

                <li><a href="/services/ios-app-development">iOS App Development</a></li>

                <li><a href="/services/android-app-development">Android App Development</a></li>

                <li><a href="/services/cross-platform-app-development">Cross-Platform App Development</a></li>

                <li><a href="/services/flutter-app-development">Flutter App Development</a></li>

                <li><a href="/services/react-native-app-development">React Native Development</a></li>

                <li><a href="/services/web-app-development">Web App Development</a></li>

                <li><a href="/services/full-stack-development">Full Stack Development</a></li>

                <li><a href="/services/mobile-app-marketing">Mobile App Marketing</a></li>

                <li><a href="/services/ecommerce-app-development">Ecommerce App Development</a></li>

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

                            <img src="/assets/images/logo-sm.webp" srcset="/assets/images/logo-sm.webp 360w, /assets/images/logo.webp 600w" sizes="(max-width:576px) 113px, 180px" alt="Appverra logo" loading="lazy" class="logo img-fluid" width="180" height="42">

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

                            <img src="/assets/images/logo-sm.webp" srcset="/assets/images/logo-sm.webp 360w, /assets/images/logo.webp 600w" sizes="(max-width:576px) 113px, 180px" alt="Appverra logo" loading="lazy" class="logo img-fluid" width="180" height="42">

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