CREATE TABLE IF NOT EXISTS `home_product_sections` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `source_type` ENUM('latest', 'category', 'tag', 'custom') NOT NULL DEFAULT 'latest',
    `category_id` BIGINT UNSIGNED NULL,
    `tag_id` BIGINT UNSIGNED NULL,
    `product_ids` TEXT NULL,
    `products_limit` TINYINT UNSIGNED NOT NULL DEFAULT 10,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `home_product_sections_active_sort_index` (`is_active`, `sort_order`),
    KEY `home_product_sections_category_index` (`category_id`),
    KEY `home_product_sections_tag_index` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
