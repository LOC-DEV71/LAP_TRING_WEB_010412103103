<?php
require_once __DIR__ . '/../core/helpers.php';
loadEnv(__DIR__ . '/../.env');
require_once __DIR__ . '/../config/database.php';

try {
    // Check if is_verified and verification_token exist
    $stmt = $conn->query("SHOW COLUMNS FROM users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Current columns: " . implode(', ', $columns) . "\n";

    if (!in_array('is_verified', $columns)) {
        $conn->exec("ALTER TABLE users ADD COLUMN is_verified TINYINT(1) DEFAULT 0");
        echo "Added column 'is_verified'.\n";
    } else {
        echo "Column 'is_verified' already exists.\n";
    }

    if (!in_array('verification_token', $columns)) {
        $conn->exec("ALTER TABLE users ADD COLUMN verification_token VARCHAR(255) NULL");
        echo "Added column 'verification_token'.\n";
    } else {
        echo "Column 'verification_token' already exists.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
