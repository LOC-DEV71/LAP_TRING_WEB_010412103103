<?php
// Comprehensive script to create all required tables if they do not exist.
// Run with: C:\xampp\php\php.exe scripts\create_all_tables.php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php'; // establishes $conn PDO instance via env()

$tables = [];

// users table (used by User model)
$tables[] = "CREATE TABLE IF NOT EXISTS `users` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `fullname` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NULL,
    `phone` VARCHAR(20) NULL,
    `reset_token` VARCHAR(255) NULL,
    `reset_token_expires` DATETIME NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// likes table (used by Like model)
$tables[] = "CREATE TABLE IF NOT EXISTS `likes` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `client_id` VARCHAR(50) NOT NULL,
    `product_id` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// products table (used by Product model)
$tables[] = "CREATE TABLE IF NOT EXISTS `products` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `category_id` VARCHAR(50) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// product_variants table
$tables[] = "CREATE TABLE IF NOT EXISTS `product_variants` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `product_id` VARCHAR(50) NOT NULL,
    `sku` VARCHAR(100) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `price` DECIMAL(10,2) NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// product_images table
$tables[] = "CREATE TABLE IF NOT EXISTS `product_images` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `product_id` VARCHAR(50) NOT NULL,
    `url` VARCHAR(255) NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// product_categories table
$tables[] = "CREATE TABLE IF NOT EXISTS `product_categories` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// orders table
$tables[] = "CREATE TABLE IF NOT EXISTS `orders` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `user_id` VARCHAR(50) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `total` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// order_items table
$tables[] = "CREATE TABLE IF NOT EXISTS `order_items` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `order_id` VARCHAR(50) NOT NULL,
    `product_id` VARCHAR(50) NOT NULL,
    `quantity` INT NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// roles table (if used by Role model)
$tables[] = "CREATE TABLE IF NOT EXISTS `roles` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// permissions table (if used by Permission model)
$tables[] = "CREATE TABLE IF NOT EXISTS `permissions` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `role_id` VARCHAR(50) NOT NULL,
    `resource` VARCHAR(255) NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

foreach ($tables as $sql) {
    try {
        $conn->exec($sql);
        if (preg_match('/CREATE TABLE IF NOT EXISTS `([^`]+)`/', $sql, $m)) {
            echo "Table `{$m[1]}` created or already exists.\n";
        }
    } catch (PDOException $e) {
        echo "Error creating table: " . $e->getMessage() . "\n";
    }
}
?>
