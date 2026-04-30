-- Migration: 001_create_properties_table.sql
-- HAVRE ESTATES · MySQL 8.3 · utf8mb4_unicode_ci

CREATE TABLE IF NOT EXISTS `properties` (
  `id`           BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `slug`         VARCHAR(200) UNIQUE NOT NULL,
  `type`         ENUM('venta','renta','desarrollo') NOT NULL,
  `country_code` CHAR(2) NOT NULL COMMENT 'MX · CO · CL',
  `city`         VARCHAR(100),
  `price`        DECIMAL(18,2),
  `currency`     CHAR(3) COMMENT 'MXN · COP · CLP',
  `bedrooms`     TINYINT UNSIGNED,
  `bathrooms`    TINYINT UNSIGNED,
  `sqm`          DECIMAL(10,2),
  `lat`          DECIMAL(10,8),
  `lng`          DECIMAL(11,8),
  `status`       ENUM('available','reserved','sold') DEFAULT 'available',
  `featured`     BOOLEAN DEFAULT FALSE,
  `meta_title`   VARCHAR(70),
  `meta_desc`    VARCHAR(160),
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX `idx_country_type_status` (`country_code`, `type`, `status`),
  INDEX `idx_geo`                 (`lat`, `lng`),
  INDEX `idx_featured`            (`featured`, `status`),
  FULLTEXT `ft_search`            (`city`, `meta_title`, `meta_desc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
