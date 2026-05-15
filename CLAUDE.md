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
├── favicon.ico                # Favicon at root (required for Google + Chrome)
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
    ├── images/                # PNG, WebP, SVG, GIF + favicon assets
    │   ├── favicon.ico        # Also kept here as backup
    │   ├── favicon-32x32.png
    │   ├── favicon-16x16.png
    │   ├── apple-touch-icon.png   # 180x180 for iOS
    │   ├── android-chrome-192x192.png
    │   ├── android-chrome-512x512.png
    │   ├── site.webmanifest
    │   └── logo.webp          # Used as og:image sitewide
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
- `favicon.ico` served directly from root (do NOT rewrite it — breaks Google + Chrome)
- GZIP compression
- 1-year browser caching for images, CSS, JS, fonts, videos
- Security headers (X-Frame-Options, XSS, nosniff)

## Favicon Setup
Favicon files generated via realfavicongenerator.net. The `favicon.ico` **must be at the site root** (`public_html/favicon.ico`) for Google Search Console and Chrome bookmarks/history to show it.

```html
<!-- In header.php -->
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
<link rel="manifest" href="/assets/images/site.webmanifest">
```

**Why browser tab works but Chrome/Google doesn't:** Chrome bookmarks, history, new tab shortcuts, and Google Search Console all fetch `/favicon.ico` directly — they ignore HTML `<link>` tags. The file must exist at root with correct `image/x-icon` content type.

## Social Share (og:image / twitter:image)
Default og:image is set in `header.php`:
```php
if(empty($og_image)) $og_image = "https://appverra.co/assets/images/logo.webp";
```

Every page sets `$og_image` before `include('header.php')`. This controls the preview image on WhatsApp, Facebook, Instagram, X, LinkedIn. All pages currently use `logo.webp`. Service pages use their own banner images.

**To override per page:**
```php
<?php $og_image = "https://appverra.co/assets/images/your-image.webp"; ?>
```

## Key Patterns

### Page Structure
```php
<?php
$meta_title      = "Page Title Here";
$meta_discription = "Page description here.";
$page_class      = "page-class-name";
$og_image        = "https://appverra.co/assets/images/logo.webp"; // optional override
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

## Deployment (Hostinger)
Changes are committed to GitHub (`main` branch). To go live, deploy via:
1. Hostinger Git integration — pull from `https://github.com/Touseeff/appVerra.git`
2. Or manually upload changed files via Hostinger File Manager to `public_html/`

**Critical files that must be at Hostinger root (`public_html/`):**
- `favicon.ico` — must be at root, not in a subfolder
- `.htaccess` — controls all rewrites, caching, security
- `header.php` — controls all SEO/favicon/og tags sitewide

## No Build Process
No npm, no Composer, no build steps. Edit files directly and refresh the browser.
