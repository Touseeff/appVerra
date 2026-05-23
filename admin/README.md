# AppVerra Blog Admin — Deploy Guide

Self-serve admin panel for managing blog posts on appverra.co. Plain PHP + MySQL, no framework, no build step.

## What this gives you

- `/admin/login.php` — secure admin login (single account, bcrypt, rate-limited)
- `/admin/dashboard.php` — post counts + recent activity
- `/admin/posts/` — full CRUD with WYSIWYG editor (TinyMCE)
- `/admin/media/` — image uploads with automatic WebP conversion
- `/admin/settings.php` — change your password
- Draft / Scheduled / Published workflow
- Per-post SEO fields (meta title, meta description, OG image, canonical)
- Auto-regenerated `sitemap.xml` on every save

## Prerequisites

- Hostinger shared hosting (or any PHP 8.1+ host with MySQL)
- PHP GD extension (for WebP conversion — already present on Hostinger)
- A MySQL database created via hPanel

## Deploy steps

### 1. Push these files to your server

Either use Hostinger's Git integration (pull from `https://github.com/Touseeff/appVerra.git` after committing this branch), or upload the new folders via File Manager:

```
/admin/            (admin panel)
/includes/         (backend helpers)
/uploads/          (image storage — chmod 755)
/migrations/       (one-time scripts)
blog-post.php      (dynamic blog template)
schema.sql         (DB schema)
```

Also push the **modified** files: `blogs.php`, `blog_sidebar.php`, `.htaccess`.

### 2. Create the MySQL database

In **hPanel → MySQL Databases**:
- Database name: `appverra` (or whatever you choose)
- Username + password: note these for step 3

Then in **phpMyAdmin**, paste the contents of `schema.sql` and run it. This creates `users`, `posts`, `media` tables and seeds one admin account.

### 3. Configure DB credentials

Edit `/includes/config.php` and replace the defaults with your real Hostinger DB credentials:

```php
define('DB_HOST', 'localhost');     // usually localhost on Hostinger
define('DB_NAME', 'u123_appverra'); // your actual DB name
define('DB_USER', 'u123_admin');
define('DB_PASS', 'YOUR_REAL_PASSWORD');
```

Or, better, set them as environment variables in hPanel so they never live in code.

The root `.htaccess` already denies direct access to `config.php` and `*.sql`.

### 4. Log in and change the password IMMEDIATELY

Default credentials (from `schema.sql`):
- **Username:** `admin`
- **Password:** `ChangeMeNow!2026`

1. Visit `https://appverra.co/admin/login.php`
2. Sign in
3. Go to **Settings → Change password**
4. Pick a strong password (10+ chars)

If the seed hash doesn't work (PHP version mismatch), generate your own:

```bash
php -r "echo password_hash('your-pass-here', PASSWORD_DEFAULT) . PHP_EOL;"
```

Then in phpMyAdmin:
```sql
UPDATE users SET password_hash = '<the-hash>' WHERE username = 'admin';
```

### 5. Migrate the 9 existing static blog posts

While logged in, visit:
```
https://appverra.co/migrations/migrate_existing_blogs.php?confirm=YES_MIGRATE
```

You'll see a per-post status report. Each post's article body (the `<div class="col-md-6">` block) is extracted via DOMDocument — the old TOC sidebar and pinned-scroll JavaScript are **deliberately dropped**, since the new template (`blog-post.php`) renders its own layout and the inline scripts can't survive HTML sanitization anyway.

#### How to verify BEFORE deleting the static files

Because the root `.htaccess` rewrite serves `slug.php` whenever the static file exists, you cannot test the migrated DB version at the public URL until the static file is gone. Two safe ways to preview:

**Option A — direct preview URL** (recommended). Bypass the rewrite entirely:
```
https://appverra.co/blog-post.php?slug=why-unity-is-still-a-powerhouse-for-indie-game-development-in-2025
```
This always serves the DB version. Use this to verify every post BEFORE deleting anything.

**Option B — one-at-a-time rename test.** Rename a single static file to `.php.bak` (e.g. via Hostinger File Manager). The slug now falls through the rewrite and hits `blog-post.php` automatically. If it looks good, proceed; if not, rename back to `.php` to restore.

Once you're satisfied each post renders correctly, **delete the 9 static `.php` files**:

```
why-unity-is-still-a-powerhouse-for-indie-game-development-in-2025.php
ai-react-native-integration-building-smarter-mobile-experiences.php
developing-flutter-apps-for-emerging-use-cases-iot-wearables-and-pwas.php
handling-state-management-chaos-in-full-stack-apps-practical-solutions.php
low-ad-budgets-creative-mobile-app-marketing-hacks-that-work.php
voice-commerce-in-2025-how-to-enable-hands-fee-shopping-in-your-app.php
accessibility-in-react-native-bridging-gaps-for-inclusive-apps.php
security-privacy-and-compliance-in-flutter-apps-best-practices-for-2025.php
unity-pricing-changes-explained-what-developers-need-to-know-in-2025.php
```

After deletion, the catch-all `.htaccess` rule routes each slug to `blog-post.php` automatically — old URLs keep working, SEO juice is preserved.

### 6. Install TinyMCE (required for the WYSIWYG editor)

The post editor expects TinyMCE 7 at `/admin/assets/tinymce/tinymce.min.js`. Two options:

**Option A — self-host (recommended, no external dependency):**
1. Download the TinyMCE community ZIP from https://www.tiny.cloud/get-tiny/self-hosted/
2. Extract the ZIP into `/admin/assets/tinymce/` (so the file `/admin/assets/tinymce/js/tinymce/tinymce.min.js` exists)
3. Verify `https://appverra.co/admin/assets/tinymce/js/tinymce/tinymce.min.js` returns 200

The form is already configured with `license_key: 'gpl'` (no API key required for self-hosted GPL builds).

**Option B — CDN (quick start):** edit `admin/posts/_form.php` and change
```html
<script src="/admin/assets/tinymce/tinymce.min.js"></script>
```
to
```html
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
```
(For production, get a free API key from tiny.cloud.)

### 7. Set folder permissions

Make sure `/uploads/` and `/storage/ratelimit/` are writable by PHP:

```bash
chmod 755 uploads
chmod 755 storage   # will auto-create on first failed login
```

## File structure reference

```
appverra/
├── admin/                  ← admin panel
│   ├── login.php  logout.php  index.php  dashboard.php  settings.php
│   ├── _layout.php         (shared chrome for admin pages)
│   ├── .htaccess           (noindex header)
│   ├── posts/
│   │   ├── index.php       (list with filters)
│   │   ├── create.php  edit.php  delete.php  _form.php
│   ├── media/
│   │   ├── index.php       (library grid)
│   │   └── upload.php      (POST endpoint, JSON response)
│   └── assets/
│       ├── admin.css       (minimal admin styles)
│       └── tinymce/        ← YOU INSTALL THIS (see step 6)
│
├── includes/
│   ├── config.php          ← edit your DB creds here
│   ├── db.php  auth.php  csrf.php  slugify.php  webp.php
│   └── post_helpers.php    (form parsing + sanitization + sitemap)
│
├── uploads/                ← user-uploaded images
│   ├── .htaccess           (disables PHP execution)
│   └── YYYY/MM/...
│
├── migrations/
│   └── migrate_existing_blogs.php
│
├── blog-post.php           ← dynamic single-post template
├── blogs.php               ← DB-driven listing (modified)
├── blog_sidebar.php        ← DB-driven nav (modified)
├── schema.sql
└── .htaccess               ← adds blog-slug catch-all (modified)
```

## How blog routing works

1. User visits `/why-unity-is-still-a-powerhouse...`
2. `.htaccess` checks: does `why-unity...` exist as a file? No. Does `why-unity....php` exist? No (we deleted it).
3. Falls through to the catch-all rule → rewrites to `/blog-post.php?slug=why-unity-...`
4. `blog-post.php` queries the DB, renders header + content + sidebar + footer.

Other clean URLs (e.g. `/about-us`, `/our-services`) still resolve via the existing `.php` rewrite because those static files still exist.

## Security notes

- All SQL uses prepared statements (`mysqli_stmt_prepare`).
- All HTML output is escaped via `htmlspecialchars()`. WYSIWYG content goes through an allow-list filter that strips `<script>`, `<style>`, `<iframe>`, `on*` event handlers, and `javascript:` URLs.
- File uploads MIME-sniff via `finfo` (not just extension). `.php` execution is disabled in `/uploads/`.
- CSRF tokens on every form. Login is rate-limited (5 failures / 15 min per IP).
- Admin session: HttpOnly, Secure, SameSite=Strict cookies. 4-hour timeout.
- `/admin/` sends `X-Robots-Tag: noindex, nofollow`.

## Common issues

**"Class mysqli not found"** — your Hostinger plan needs the MySQLi PHP extension enabled. It's on by default; if not, enable it in hPanel → PHP Configuration.

**"imagewebp() not found"** — GD extension missing. Enable it in hPanel. Without it, uploads still work but won't auto-convert to WebP.

**Migration says "could not extract content body"** — the static blog file has a non-standard structure. Open it manually, check the content sits between `?>` and `<?php include('footer.php'); ?>`, then re-run.

**Sitemap not updating** — `sitemap.xml` needs to be writable. `chmod 644 sitemap.xml` and ensure the directory is `755`.
