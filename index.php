<?php
session_start(); // bộ nhớ tạm CART

// hàm nhận style
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $url)) {
        return false;
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die("Vui lòng chạy lệnh 'composer install' trước khi tiếp tục.");
}

// Khởi tạo Database và Helpers
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/helpers.php';

// Khởi tạo ứng dụng và Routing
//$app = new Core\App();
//$app->run();

require_once 'controllers/client/CartController.php';
$cart = new CartController();
$cart->index();
?>