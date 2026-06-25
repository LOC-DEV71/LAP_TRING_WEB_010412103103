<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Fashion Store') ?></title>
    <link rel="stylesheet" href="/public/css/client/Home/home.css">
</head>
<body>

    <!--header-->
    <header class="header">

        <div class="top-bar">
            <div class="top-item">
                <img src="/public/assets/images/fast-delivery.png" alt="Delivery">
                <span>Miễn phí vận chuyển cho đơn hàng từ 499.000đ</span>
            </div>
            <div class="top-item">
                <img src="/public/assets/images/viber.png" alt="Phone">
                <span>Hỗ trợ khách hàng: 1900 1234 567</span>
            </div>
        </div>

        <div class="navbar">
            <div class="logo">
                FASHION
            </div>
            <ul class="menu">
                <li><a href="/">Trang chủ</a></li>
                <li><a href="#">Nam</a></li>
                <li><a href="#">Nữ</a></li>
                <li><a href="#">Phụ kiện</a></li>
                <li><a href="#">Bộ sưu tập</a></li>
                <li><a href="#">Sale</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>

            <div class="actions">
                <img src="/public/assets/images/search.png" alt="Search">
                <img src="/public/assets/images/cart.png" alt="Cart">
                <img src="/public/assets/images/user.png" alt="User">
            </div>

        </div>

    </header>
