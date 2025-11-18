-- URL Shortener Database Schema
-- This file contains all the SQL commands needed to set up your database

-- Create the database (optional - you might already have one from Hostinger)
-- CREATE DATABASE url_shortener CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE url_shortener;

-- Table to store shortened URLs
CREATE TABLE IF NOT EXISTS `urls` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `short_code` VARCHAR(10) UNIQUE NOT NULL,
  `original_url` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `clicks` INT DEFAULT 0,
  `last_accessed` TIMESTAMP NULL DEFAULT NULL,
  `custom` TINYINT(1) DEFAULT 0,
  `active` TINYINT(1) DEFAULT 1,
  INDEX `idx_short_code` (`short_code`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table to store click analytics (optional but useful)
CREATE TABLE IF NOT EXISTS `clicks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `url_id` INT NOT NULL,
  `ip_address` VARCHAR(45),
  `user_agent` TEXT,
  `referer` VARCHAR(255),
  `clicked_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`url_id`) REFERENCES `urls`(`id`) ON DELETE CASCADE,
  INDEX `idx_url_id` (`url_id`),
  INDEX `idx_clicked_at` (`clicked_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert some sample data (optional - remove if not needed)
-- INSERT INTO `urls` (`short_code`, `original_url`, `custom`) VALUES
-- ('github', 'https://github.com', 1),
-- ('google', 'https://google.com', 1);
