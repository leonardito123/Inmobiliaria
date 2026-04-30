-- Migration: 004_create_testimonials_sessions_cache.sql

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id`           SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `author_name`  VARCHAR(100) NOT NULL,
  `author_title` VARCHAR(150),
  `body`         TEXT NOT NULL,
  `rating`       TINYINT UNSIGNED DEFAULT 5,
  `country_code` CHAR(2),
  `active`       BOOLEAN DEFAULT TRUE,
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id`         CHAR(64) PRIMARY KEY,
  `payload`    MEDIUMBLOB NOT NULL,
  `expires_at` TIMESTAMP NOT NULL,
  INDEX `idx_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key`        VARCHAR(255) PRIMARY KEY,
  `value`      MEDIUMBLOB NOT NULL,
  `expires_at` TIMESTAMP NOT NULL,
  INDEX `idx_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
