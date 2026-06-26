<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Fashion Store') ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@100..900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="<?= asset('css/client/Home/home.css') ?>">
</head>
<body>

    <!--header-->
    <header class="header">

        <div class="top-bar">
            <div class="top-item">
                <img src="<?= asset('assets/images/fast-delivery.png') ?>" alt="Delivery">
                <span>Miễn phí vận chuyển cho đơn hàng từ 499.000đ</span>
            </div>
            <div class="top-item">
                <img src="<?= asset('assets/images/viber.png') ?>" alt="Phone">
                <span>Hỗ trợ khách hàng: 1900 1234 567</span>
            </div>
        </div>

        <div class="navbar">
            <div class="logo">
                <a href="<?= url('') ?>" style="color: inherit; text-decoration: none;">FASHION</a>
            </div>
            <ul class="menu">
                <li><a href="<?= url('') ?>">Trang chủ</a></li>
                <li><a href="<?= url('product') ?>">Nam</a></li>
                <li><a href="<?= url('product') ?>">Nữ</a></li>
                <li><a href="<?= url('product') ?>">Phụ kiện</a></li>
                <li><a href="<?= url('product') ?>">Bộ sưu tập</a></li>
                <li><a href="<?= url('product') ?>">Sale</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>

            <div class="actions">
                <span class="material-symbols-outlined action-btn">search</span>
                <a href="<?= url('cart') ?>" style="color: inherit; text-decoration: none;">
                    <span class="material-symbols-outlined action-btn">shopping_cart</span>
                </a>
                <a href="<?= url('user/profile') ?>" style="color: inherit; text-decoration: none;">
                    <span class="material-symbols-outlined action-btn">person</span>
                </a>
            </div>

        </div>

    </header>
