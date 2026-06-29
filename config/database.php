<?php
/**
 * Database connection configuration.
 * Uses environment variables (loaded from .env) for credentials.
 */
// Load environment variables if not already loaded
if (!function_exists('env')) {
    /** Simple fallback env() implementation */
    function env(string $key, $default = null) {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}

// Optional: load .env file using the helper that exists in the project
if (file_exists(__DIR__ . '/../core/helpers.php')) {
    require_once __DIR__ . '/../core/helpers.php'; // provides loadEnv()
    loadEnv(__DIR__ . '/../.env');
}

$host = env('DB_HOST');
$port = env('DB_PORT');               
$dbname = env('DB_NAME');            
$username = env('DB_USER');           
$password = env('DB_PASS');

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}

?>