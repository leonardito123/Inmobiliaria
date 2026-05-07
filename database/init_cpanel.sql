-- HAVRE ESTATES - Inicializacion para cPanel
-- Importar este archivo seleccionando previamente la base de datos en phpMyAdmin.

-- Tabla de propiedades
CREATE TABLE IF NOT EXISTS `properties` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `slug` VARCHAR(200) UNIQUE NOT NULL,
  `type` ENUM('venta', 'renta', 'desarrollo') NOT NULL,
  `country_code` CHAR(2) NOT NULL COMMENT 'MX, CO, CL',
  `city` VARCHAR(100),
  `price` DECIMAL(18, 2),
  `currency` CHAR(3) COMMENT 'MXN, COP, CLP',
  `bedrooms` TINYINT UNSIGNED,
  `bathrooms` TINYINT UNSIGNED,
  `sqm` DECIMAL(10, 2),
  `lat` DECIMAL(10, 8),
  `lng` DECIMAL(11, 8),
  `status` ENUM('available', 'reserved', 'sold') DEFAULT 'available',
  `featured` BOOLEAN DEFAULT FALSE,
  `meta_title` VARCHAR(70),
  `meta_desc` VARCHAR(160),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX `idx_country_type_status` (`country_code`, `type`, `status`),
  INDEX `idx_geo` (`lat`, `lng`),
  INDEX `idx_featured` (`featured`, `status`),
  FULLTEXT `ft_search` (`city`, `meta_title`, `meta_desc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de leads
CREATE TABLE IF NOT EXISTS `leads` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `property_id` BIGINT UNSIGNED REFERENCES `properties`(`id`) ON DELETE SET NULL,
  `name` VARCHAR(100),
  `email` VARCHAR(254),
  `phone` VARCHAR(20),
  `country_code` CHAR(2),
  `source_page` VARCHAR(50) COMMENT 'home, venta, renta, etc.',
  `score` TINYINT DEFAULT 0 COMMENT 'Lead scoring automatico',
  `ip_hash` CHAR(64) COMMENT 'SHA-256 anonimizado',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX `idx_property` (`property_id`),
  INDEX `idx_country_created` (`country_code`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de agentes
CREATE TABLE IF NOT EXISTS `agents` (
  `id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(254),
  `phone` VARCHAR(20),
  `bio` TEXT,
  `languages` JSON COMMENT 'Array de codigos de idioma',
  `specialties` JSON COMMENT 'Array de especialidades',
  `avatar_url` VARCHAR(255),
  `country_code` CHAR(2),
  `active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX `idx_country` (`country_code`),
  INDEX `idx_active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de testimonios
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `author_name` VARCHAR(100),
  `author_title` VARCHAR(100),
  `content` TEXT,
  `rating` TINYINT UNSIGNED,
  `property_id` BIGINT UNSIGNED REFERENCES `properties`(`id`),
  `country_code` CHAR(2),
  `featured` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX `idx_featured` (`featured`),
  INDEX `idx_country` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de sesiones
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(128) PRIMARY KEY,
  `data` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` VARCHAR(255) PRIMARY KEY,
  `value` LONGTEXT,
  `expiry` TIMESTAMP NULL,

  INDEX `idx_expiry` (`expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;