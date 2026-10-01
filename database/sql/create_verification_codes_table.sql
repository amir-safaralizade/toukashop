CREATE TABLE IF NOT EXISTS `verification_codes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `phone` VARCHAR(20) NOT NULL,
    `code` VARCHAR(6) NOT NULL,
    `channel` VARCHAR(20) NOT NULL DEFAULT 'sms',
    `verified` TINYINT(1) NOT NULL DEFAULT 0,
    `attempts` INT UNSIGNED NOT NULL DEFAULT 0,
    `expires_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `verification_codes_phone_index` (`phone`),
    KEY `verification_codes_lookup_index` (`phone`, `channel`, `verified`, `id`),
    KEY `verification_codes_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
