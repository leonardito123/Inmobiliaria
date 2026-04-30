-- Migration: 003_create_agents_table.sql

CREATE TABLE IF NOT EXISTS `agents` (
  `id`           TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name`         VARCHAR(100) NOT NULL,
  `email`        VARCHAR(254),
  `phone`        VARCHAR(20),
  `bio`          TEXT,
  `photo_url`    VARCHAR(500),
  `country_code` CHAR(2),
  `languages`    JSON COMMENT '["es","en","pt"]',
  `specialties`  JSON COMMENT '["venta","renta"]',
  `active`       BOOLEAN DEFAULT TRUE,
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX `idx_country_active` (`country_code`, `active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
