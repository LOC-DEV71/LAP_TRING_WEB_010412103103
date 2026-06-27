<?php
$host = env('DB_HOST', 'localhost');
$port = env('DB_PORT', '3307');               
$dbname = env('DB_NAME', 'GearX');            
$username = env('DB_USER', 'root');           
$password = env('DB_PASS', '');

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}

?>