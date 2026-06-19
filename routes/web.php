<?php

/** @var \App\Core\Router $router */

// Đường dẫn HomePage
$router->get('/', [App\Controllers\HomeController::class, 'index']);
// Đường dẫn AuthPage
$router->get('/auth', [App\Controllers\AuthController::class, 'index']);
// Đường dẫn CartPage
$router->get('/cart', [App\Controllers\CartController::class, 'index']);
// Đường dẫn ProductPage
$router->get('/products', [App\Controllers\ProductController::class, 'index']);
