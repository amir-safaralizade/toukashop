ALTER TABLE `orders`
    MODIFY COLUMN `status` ENUM(
        'pending',
        'ready_to_pay',
        'need_admin_approval',
        'paid',
        'shipped',
        'completed',
        'canceled',
        'expired'
    ) NOT NULL DEFAULT 'pending';

UPDATE `orders` AS `old_cart`
LEFT JOIN (
    SELECT `user_id`, MAX(`id`) AS `latest_cart_id`
    FROM `orders`
    WHERE `status` = 'pending'
    GROUP BY `user_id`
) AS `latest_cart`
    ON `latest_cart`.`user_id` = `old_cart`.`user_id`
SET `old_cart`.`status` = 'expired'
WHERE `old_cart`.`status` = 'pending'
  AND `old_cart`.`id` <> `latest_cart`.`latest_cart_id`;
