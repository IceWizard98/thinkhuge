SET FOREIGN_KEY_CHECKS=OFF;

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`username`, `password`)
SELECT 'admin@admin.com', '$2y$10$0SDLzgnTfk1eWBKvOjrXIeqZ7IkG2K.V3Jv6bRU4Rr0EL/NcOpVae'
WHERE NOT EXISTS (
    SELECT 1 FROM `user` WHERE `username` = 'admin@admin.com'
);

CREATE TABLE IF NOT EXISTS `product` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `ram` INT NOT NULL,
    `cpu` INT NOT NULL,
    `memory_type` VARCHAR(10) NOT NULL DEFAULT 'SSD',
    `disk` INT NOT NULL,
    `os` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `discount` INT NULL,
    `is_dedicated_ip` BOOLEAN NOT NULL DEFAULT FALSE,
    `is_suggested` BOOLEAN NOT NULL DEFAULT FALSE,
    `icon` VARCHAR(128) NOT NULL DEFAULT 'empty',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product` (`name`, `ram`, `cpu`, `disk`, `memory_type`, `os`, `price`, `discount`, `is_dedicated_ip`, `is_suggested`, `icon`)
SELECT 'basic', 2048, 1, 60, 'SSD', 'windows 2012', 39, 30, true, false, 'empty'
WHERE NOT EXISTS (
    SELECT 1 FROM `product` WHERE `name` = 'basic'
);

INSERT INTO `product` (`name`, `ram`, `cpu`, `disk`, `memory_type`, `os`, `price`, `discount`, `is_dedicated_ip`, `is_suggested`, `icon`)
SELECT 'basic+', 2560, 2, 80, 'SSD', 'windows 2012/16/19/22', 43, 30, true, true, 'plus'
WHERE NOT EXISTS (
    SELECT 1 FROM `product` WHERE `name` = 'basic+'
);

INSERT INTO `product` (`name`, `ram`, `cpu`, `disk`, `memory_type`, `os`, `price`, `discount`, `is_dedicated_ip`, `is_suggested`, `icon`)
SELECT 'standard', 4096, 2, 90, 'SSD', 'windows 2012/16/19/22', 59, 30, true, false, 'double'
WHERE NOT EXISTS (
    SELECT 1 FROM `product` WHERE `name` = 'standard'
);

SET FOREIGN_KEY_CHECKS=ON;
