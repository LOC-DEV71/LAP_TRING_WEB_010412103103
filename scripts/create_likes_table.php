<?php
// Script to create the `likes` table if it does not exist.
// Run with: C:\xampp\php\php.exe scripts\create_likes_table.php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php'; // establishes $conn PDO instance via env()

$sql = "CREATE TABLE IF NOT EXISTS `likes` (
    `_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `client_id` VARCHAR(50) NOT NULL,
    `product_id` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $conn->exec($sql);
    echo "Table `likes` created or already exists.\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
    exit(1);
}
?>
