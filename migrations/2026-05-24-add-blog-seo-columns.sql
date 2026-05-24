-- Migration: add per-post SEO columns for BlogPosting schema, author byline,
-- and accessible featured-image alt text.
--
-- Run once on the live Hostinger DB via phpMyAdmin:
--   1. hPanel → MySQL Databases → phpMyAdmin
--   2. Select database u751124526_appverra (or whatever yours is named)
--   3. SQL tab → paste this file → Go
--
-- Safe to run twice — IF NOT EXISTS guards (MySQL 8+) make it idempotent.
-- If your MySQL doesn't support IF NOT EXISTS on ADD COLUMN, just ignore the
-- "duplicate column" error on a re-run.

ALTER TABLE posts
  ADD COLUMN IF NOT EXISTS author_name        VARCHAR(120) DEFAULT NULL AFTER author_id,
  ADD COLUMN IF NOT EXISTS author_url         VARCHAR(255) DEFAULT NULL AFTER author_name,
  ADD COLUMN IF NOT EXISTS featured_image_alt VARCHAR(255) DEFAULT NULL AFTER featured_image;
