-- MySQL 8 / MariaDB
-- Run this script on the database shared by the storefront and admin panel.

CREATE TABLE IF NOT EXISTS `product_variants` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `sku` VARCHAR(255) NULL,
    `price` BIGINT UNSIGNED NULL,
    `stock` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_variants_sku_unique` (`sku`),
    KEY `product_variants_product_id_index` (`product_id`),
    CONSTRAINT `product_variants_product_id_foreign`
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `product_variant_attributes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_variant_id` BIGINT UNSIGNED NOT NULL,
    `attribute_id` BIGINT UNSIGNED NOT NULL,
    `attribute_value_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `variant_attribute_unique` (`product_variant_id`, `attribute_id`),
    UNIQUE KEY `variant_value_unique` (`product_variant_id`, `attribute_value_id`),
    KEY `pva_attribute_id_index` (`attribute_id`),
    KEY `pva_attribute_value_id_index` (`attribute_value_id`),
    CONSTRAINT `pva_variant_foreign`
        FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `pva_attribute_foreign`
        FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `pva_attribute_value_foreign`
        FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MariaDB 10.4 supports IF NOT EXISTS on ALTER operations, so no stored
-- procedure is required. This also works around outdated mysql.proc tables.
ALTER TABLE `product_variants`
    ADD COLUMN IF NOT EXISTS `is_active` TINYINT(1) NOT NULL DEFAULT 1 AFTER `stock`;

ALTER TABLE `order_items`
    ADD COLUMN IF NOT EXISTS `product_variant_id` BIGINT UNSIGNED NULL AFTER `product_id`;

-- Foreign-key columns must have the exact same type and both tables must use
-- InnoDB. Existing installations may have created this column as INT or SIGNED.
ALTER TABLE `product_variants` ENGINE=InnoDB;
ALTER TABLE `order_items` ENGINE=InnoDB;
ALTER TABLE `order_items`
    MODIFY COLUMN `product_variant_id` BIGINT UNSIGNED NULL;

-- Preserve historical order rows while clearing references to variants that
-- no longer exist, otherwise adding the foreign key would fail.
UPDATE `order_items` AS `oi`
LEFT JOIN `product_variants` AS `pv` ON `pv`.`id` = `oi`.`product_variant_id`
SET `oi`.`product_variant_id` = NULL
WHERE `oi`.`product_variant_id` IS NOT NULL
  AND `pv`.`id` IS NULL;

ALTER TABLE `order_items`
    ADD INDEX IF NOT EXISTS `order_items_product_variant_id_index` (`product_variant_id`);

ALTER TABLE `order_items`
    ADD FOREIGN KEY IF NOT EXISTS `order_items_product_variant_id_foreign`
    (`product_variant_id`) REFERENCES `product_variants` (`id`)
    ON DELETE SET NULL;
