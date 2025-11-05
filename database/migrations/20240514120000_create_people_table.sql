-- Migration: Create the initial people table
-- This table will store all individuals in the system, including users, players, and officials.

CREATE TABLE IF NOT EXISTS `people` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `dob` DATE NOT NULL COMMENT 'Date of Birth',
    `phone` VARCHAR(20) NULL,
    `address_1` VARCHAR(255) NOT NULL,
    `address_2` VARCHAR(255) NULL,
    `address_3` VARCHAR(255) NULL,
    `city` VARCHAR(100) NOT NULL,
    `state` VARCHAR(50) NOT NULL,
    `zip_5` VARCHAR(10) NOT NULL,
    `zip_4` VARCHAR(10) NULL,
    `language_preference` VARCHAR(5) DEFAULT 'en' COMMENT 'User language preference (en, es)',
    `identity_verified_indicator` BOOLEAN DEFAULT FALSE,
    `status` VARCHAR(50) DEFAULT 'active' COMMENT 'Examples: active, suspended, guest, inactive',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL COMMENT 'For logical deletes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
