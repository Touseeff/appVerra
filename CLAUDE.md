# AppVerra Website

## Project Overview
Corporate marketing website for AppVerra, a full-service app development agency based in New York, USA. PHP-based site with no database — all config is hardcoded in `header.php`.

- **Live URL:** https://appverra.co/
- **Local:** http://localhost/appverse/ (XAMPP)
- **GitHub:** https://github.com/Touseeff/appVerra
- **Contact:** info@appverra.co | (213) 714-7176
- **Address:** 20 N Moore St, New York, NY 10013, United States

## Social Media
- Facebook: https://www.facebook.com/AppVerra.Official
- LinkedIn: https://www.linkedin.com/company/appverra
- Instagram: https://www.instagram.com/appverraco/
- X (Twitter): https://x.com/appverra1

## Tech Stack
- **Backend:** PHP (no framework, no Composer, no database)
- **Frontend:** HTML5, CSS3, Bootstrap, jQuery, vanilla JS
- **Animations:** GSAP + ScrollTrigger, AOS (Animate on Scroll)
- **Sliders:** Owl Carousel, Slick, Swiper
- **Icons:** Feather, FontAwesome
- **Fonts:** Aeonik, Apercu (local), Bricolage Grotesque, Manrope (Google)

## Directory Structure
```
appverse/
├── index.php                  # Homepage
├── header.php                 # Shared header, site config vars, all CSS/JS imports, SEO meta
├── footer.php                 # Shared footer with copyright
├── mail.php                   # Contact form handler (sends email via PHP mail())
├── thankyou.php               # Post-form redirect page
├── poppup.php                 # Popup form (included on all pages)
├── contact-us.php             # Contact page
├── about-us.php               # About page
├── our-work.php               # Portfolio listing
├── our-services.php           # Services overview
├── blogs.php                  # Blog listing
├── privacy-policy.php
├── terms-and-condition.php
├── sitemap.xml                # SEO sitemap (clean URLs, no .php)
├── robots.txt                 # Search engine crawl rules
├── .htaccess                  # HTTPS, GZIP, caching, .php extension removal
│
├── [service pages]            # flutter-app-development.php, react-native-developer.php,
│                              # unity-game-development.php, full-stack-development.php,
│                              # mobile-app-marketing.php, ecommerce.php
│
├── [blog posts]               # 9 individual blog article pages
│
├── [case studies]             # cage-case-study.php, reactosphere-case-study.php,
│                              # toriino-case-study.php, yuno-case-study.php
│
├── [portfolio pages]          # personal-finance-and-budgeting-tool.php,
│                              # meditation-and-mental-wellness-app.php,
│                              # event-planning-and-ticketing-app.php
│
├── [reusable sections]        # contact-us-section.php, testimonials-section.php,
│                              # awards-section.php, cta-section.php,
│                              # industries-section.php, technology-expert-section.php,
│                              # blog_sidebar.php
│
└── assets/
    ├── css/
    │   ├── style.css          # Main stylesheet (54KB)
    │   └── reponsive.css      # Responsive rules (14KB)
    ├── js/
    │   └── custom.js          # GSAP animations, AOS init, parallax, scroll effects
    ├── images/                # 515 files: PNG, WebP, SVG, GIF
    ├── fonts/                 # 79 font files (EOT, TTF, WOFF, WOFF2)
    └── videos/                # 16 MP4 files
```

## Site Configuration
All site-wide settings are PHP variables at the top of `header.php`:
```php
$siteurl     = "https://appverra.co/"
$sitename    = "AppVerra"
$sitenumber  = "(213) 714-7176"
$tel         = "2137147176"
$siteemail   = "info@appverra.co"
$siteaddress = "20 N Moore St, New York, NY 10013, United States"
```

## SEO Setup (header.php)
Every page automatically gets:
- Title + meta description (set per page via `$meta_title` / `$meta_discription`)
- Keywords meta (USA mobile app keywords)
- Canonical URL (dynamic)
- Open Graph tags (Facebook/social preview)
- Twitter Card tags
- Google Site Verification: `eU5DoRpCn817G_9sXwTBQk9uB-d4IAtUEAm6BUulBiQ`
- Schema: LocalBusiness + WebSite (with all social sameAs links)
- Robots: index, follow

## .htaccess Features
- Force HTTPS redirect
- Remove www
- **Remove .php extension from all URLs** (301 redirect + internal rewrite)
- GZIP compression
- 1-year browser caching for images, CSS, JS, fonts, videos
- Security headers (X-Frame-Options, XSS, nosniff)

## Key Patterns

### Page Structure
```php
<?php
$meta_title      = "Page Title Here";
$meta_discription = "Page description here.";
$page_class      = "page-class-name";
include('header.php');
?>
<!-- page content -->
<?php include('footer.php'); ?>
```

### URL Structure
All pages use clean URLs (no .php):
- `appverra.co/about-us` → serves `about-us.php`
- `appverra.co/our-work` → serves `our-work.php`

### Contact Form Flow
Both forms POST to `/mail` (not `mail.php` — avoids .htaccess 301 redirect breaking POST):
`contact-us-section.php` or `poppup.php` → POST `/mail` → `mail.php` → redirect `/thankyou`

### Popup Form
- File: `poppup.php` — included on all pages via `header.php`
- Submit button uses class `popup_submit_btn` (NOT `pop_btn` — avoids JS conflict)
- JS trigger for opening popup uses `.pop_btn:not(.popup_submit_btn)`

### Testimonials
- File: `testimonials-section.php`
- Avatar photos from randomuser.me CDN
- Names: Rachel Torres, Daniel Foster, Priya Sharma, Marcus Rowe, Nina Caldwell, Ethan Brooks

### Footer Copyright
`© 2026 AppVerra — Powered by Artistic Web Services`

### Animations
- Scroll parallax: add class `.scrollY` or `.scrollX`
- Spin animation: add class `.spin`
- On-scroll reveal: use AOS `data-aos=""` attributes
- All GSAP logic in `assets/js/custom.js`

### Images
Each image has two versions — use WebP for performance:
- `assets/images/example.png` — fallback
- `assets/images/example.webp` — preferred
- All images have `loading="lazy"` for page speed

## Email Setup (Hostinger)
- Handler: `mail.php` uses PHP `mail()` with `From: AppVerra <info@appverra.co>`
- **Requires:** `info@appverra.co` email account created in Hostinger panel
- Form actions use `/mail` (clean URL) to avoid POST→GET conversion by .htaccess

## Favicon
```html
<link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
```

## No Build Process
No npm, no Composer, no build steps. Edit files directly and refresh the browser.
