<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $configPath = dirname(__DIR__, 2) . '/config/database.php';
            $config = [];
            if (file_exists($configPath)) {
                $config = require $configPath;
            }

            $host = $config['host'] ?? '127.0.0.1';
            $db   = $config['database'] ?? '';
            $user = $config['username'] ?? 'root';
            $pass = $config['password'] ?? '';
            $port = $config['port'] ?? '3306';
            $charset = $config['charset'] ?? 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
