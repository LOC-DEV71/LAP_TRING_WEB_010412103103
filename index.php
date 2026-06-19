<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die("Vui lòng chạy lệnh 'composer install' trước khi tiếp tục.");
}

echo "<h1>Chào mừng đến với dự án GearX!</h1>";
echo "<p>File index.php đã hoạt động thành công.</p>";

// 4. (Tương lai) Khởi tạo ứng dụng và Routing sẽ nằm ở đây
// Ví dụ:
// require_once __DIR__ . '/config/database.php';
// $app = new Core\App();
// $app->run();
?>