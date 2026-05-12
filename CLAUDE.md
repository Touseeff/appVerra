# AppVerra Website

## Project Overview
Corporate marketing website for AppVerra, a full-service app development agency based in San Jose, CA. PHP-based site with no database — all config is hardcoded.

- **Live URL:** https://appverra.co/
- **Local:** http://localhost/AppVerra/ (XAMPP)
- **Contact:** info@appverra.co | +1-408-412-9970

## Tech Stack
- **Backend:** PHP (no framework, no Composer, no database)
- **Frontend:** HTML5, CSS3, Bootstrap, jQuery, vanilla JS
- **Animations:** GSAP + ScrollTrigger, AOS (Animate on Scroll)
- **Sliders:** Owl Carousel, Slick, Swiper
- **Icons:** Feather, FontAwesome
- **Fonts:** Aeonik, Apercu (local), Bricolage Grotesque, Manrope (Google)

## Directory Structure
```
AppVerra/
├── index.php                  # Homepage
├── header.php                 # Shared header, site config vars, all CSS/JS imports
├── footer.php                 # Shared footer
├── mail.php                   # Contact form handler (sends email, logs IP)
├── thankyou.php               # Post-form redirect page
├── contact-us.php             # Contact page
├── about-us.php               # About page
├── our-work.php               # Portfolio listing
├── our-services.php           # Services overview
├── blogs.php                  # Blog listing
├── privacy-policy.php
├── terms-and-condition.php
│
├── [service pages]            # flutter-app-development.php, react-native-developer.php,
│                              # unity-game-development.php, full-stack-development.php,
│                              # mobile-app-marketing.php, ecommerce.php, etc.
│
├── [blog posts]               # 19 individual blog article pages
│
├── [case studies]             # cage-case-study.php, reactosphere-case-study.php,
│                              # toriino-case-study.php, yuno-case-study.php
│
├── [portfolio pages]          # personal-finance-and-budgeting-tool.php, etc.
│
├── [reusable sections]        # contact-us-section.php, testimonials-section.php,
│                              # awards-section.php, cta-section.php,
│                              # industries-section.php, technology-expert-section.php,
│                              # blog_sidebar.php, poppup.php
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
$sitenumber  = "+1-408-412-9970"
$siteemail   = "info@appverra.co"
$siteaddress = "325 First St, San Jose, CA 95113, USA"
```

## Key Patterns

### Page Structure
Every page follows this pattern:
```php
<?php include('header.php'); ?>
<!-- page content -->
<?php include('footer.php'); ?>
```

### Reusable Sections
Include shared sections with:
```php
<?php include('contact-us-section.php'); ?>
<?php include('testimonials-section.php'); ?>
<?php include('cta-section.php'); ?>
```

### Contact Form Flow
`contact-us.php` → POST → `mail.php` (sends email via PHP `mail()`, captures IP via ip-api.com) → redirect to `thankyou.php`

### Animations
- Scroll parallax: add class `.scrollY` or `.scrollX` to elements
- Spin animation: add class `.spin`
- On-scroll reveal: use AOS `data-aos=""` attributes
- All GSAP logic lives in `assets/js/custom.js`

### Images
Each image typically has two versions — use WebP for performance:
- `assets/images/example.png` — fallback
- `assets/images/example.webp` — preferred

## No Build Process
No npm, no Composer, no build steps. Edit files directly and refresh the browser.
