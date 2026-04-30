-- Migration: 002_create_leads_table.sql

CREATE TABLE IF NOT EXISTS `leads` (
  `id`          BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `property_id` BIGINT UNSIGNED REFERENCES `properties`(`id`) ON DELETE SET NULL,
  `name`        VARCHAR(100),
  `email`       VARCHAR(254),
  `phone`       VARCHAR(20),
  `country_code` CHAR(2),
  `source_page` VARCHAR(50) COMMENT 'home|venta|renta|desarrollos|contacto',
  `score`       TINYINT DEFAULT 0 COMMENT 'Lead scoring automático 0-100',
  `ip_hash`     CHAR(64)  COMMENT 'SHA-256 anonimizado',
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX `idx_property`        (`property_id`),
  INDEX `idx_country_created` (`country_code`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
