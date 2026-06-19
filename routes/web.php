<?php

/** @var \App\Core\Router $router */

$router->get('/', function() {
    echo "<h1>Chào mừng đến với dự án GearX theo chuẩn PSR-4!</h1>";
    echo "<p>Cấu trúc thư mục mới đã hoạt động thành công.</p>";
    echo "<ul>";
    echo "<li>Xem sản phẩm tại: <a href='products'>/products</a></li>";
    echo "<li>Xem giỏ hàng tại: <a href='cart'>/cart</a></li>";
    echo "<li>Trang xác thực tại: <a href='auth'>/auth</a></li>";
    echo "</ul>";
});

$router->get('/auth', [App\Controllers\AuthController::class, 'index']);
$router->get('/cart', [App\Controllers\CartController::class, 'index']);
$router->get('/products', [App\Controllers\ProductController::class, 'index']);
