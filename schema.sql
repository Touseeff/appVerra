-- AppVerra Blog Admin — MySQL schema
-- Run once on the new Hostinger database.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS users (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  email         VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
  id                 INT AUTO_INCREMENT PRIMARY KEY,
  slug               VARCHAR(200) NOT NULL UNIQUE,
  title              VARCHAR(255) NOT NULL,
  excerpt            TEXT,
  content            LONGTEXT NOT NULL,
  featured_image     VARCHAR(255) DEFAULT NULL,
  featured_image_alt VARCHAR(255) DEFAULT NULL,
  meta_title         VARCHAR(255) DEFAULT NULL,
  meta_description   VARCHAR(500) DEFAULT NULL,
  og_image           VARCHAR(255) DEFAULT NULL,
  canonical_url      VARCHAR(255) DEFAULT NULL,
  status             ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
  publish_at         DATETIME DEFAULT NULL,
  author_id          INT DEFAULT NULL,
  author_name        VARCHAR(120) DEFAULT NULL,
  author_url         VARCHAR(255) DEFAULT NULL,
  views              INT NOT NULL DEFAULT 0,
  created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_posts_author FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_status_publish (status, publish_at),
  INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS media (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  filename      VARCHAR(255) NOT NULL,
  url           VARCHAR(500) NOT NULL,
  webp_url      VARCHAR(500) DEFAULT NULL,
  original_name VARCHAR(255) DEFAULT NULL,
  mime_type     VARCHAR(80)  DEFAULT NULL,
  size_bytes    INT DEFAULT NULL,
  uploaded_by   INT DEFAULT NULL,
  uploaded_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_media_user FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_uploaded_at (uploaded_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- Seed admin user.
-- IMPORTANT: change the password immediately after first login via /admin/settings.
-- The hash below is for password: ChangeMeNow!2026
-- Generate your own with PHP: password_hash('your-pass', PASSWORD_DEFAULT)
INSERT INTO users (username, email, password_hash)
VALUES ('admin', 'info@appverra.co', '$2y$12$D2km5VImi01oWR1tfE7/jeR5NOYZWYb7bK6bp.TQnDP/YOm8UozM6')
ON DUPLICATE KEY UPDATE email = VALUES(email);
