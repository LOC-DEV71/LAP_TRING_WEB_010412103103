<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Fashion Store') ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@100..900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="<?= asset('css/client/layouts/header.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/client/Home/home.css') ?>">
</head>
<body>

    <!--header-->
    <header class="header">

        <?php if (!isset($hideNotification) || !$hideNotification): ?>
            <?php require_once __DIR__ . '/notification.php'; ?>
        <?php endif; ?>

        <div class="navbar">
            <button class="hamburger-btn" id="btn-hamburger">
                <span class="material-symbols-outlined">menu</span>
            </button>

            <div class="logo">
                <a href="<?= url('') ?>" style="color: inherit; text-decoration: none;">FASHION</a>
            </div>
            <ul class="menu">
                <li>
                    <a href="<?= url('') ?>" class="menu-btn">
                        <span class="menu-text">Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('product') ?>" class="menu-btn">
                        <span class="menu-text">Nam</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('product') ?>" class="menu-btn">
                        <span class="menu-text">Nữ</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('product') ?>" class="menu-btn">
                        <span class="menu-text">Phụ kiện</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('product') ?>" class="menu-btn">
                        <span class="menu-text">Bộ sưu tập</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('product') ?>" class="menu-btn">
                        <span class="menu-text">Sale</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-btn">
                        <span class="menu-text">Blog</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-btn">
                        <span class="menu-text">Liên hệ</span>
                    </a>
                </li>
            </ul>


            <div class="actions">
                <span class="material-symbols-outlined action-btn">search</span>
                <a href="<?= url('/cart') ?>" style="color: inherit; text-decoration: none;">
                    <span class="material-symbols-outlined action-btn">shopping_cart</span>
                </a>
                <a href="<?= url('user/profile') ?>" style="color: inherit; text-decoration: none;">
                    <span class="material-symbols-outlined action-btn">person</span>
                </a>
            </div>

        </div>

    </header>

    <!-- Mobile Sidebar Drawer -->
    <div class="sidebar-drawer" id="mobile-drawer">
        <div class="drawer-overlay" id="drawer-overlay"></div>
        <div class="drawer-content">
            <div class="drawer-header">
                <div class="drawer-logo">FASHION</div>
                <button class="btn-close-drawer" id="btn-close-drawer">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <ul class="drawer-menu">
                <li><a href="<?= url('') ?>" class="drawer-link">Trang chủ</a></li>
                <li><a href="<?= url('product') ?>" class="drawer-link">Nam</a></li>
                <li><a href="<?= url('product') ?>" class="drawer-link">Nữ</a></li>
                <li><a href="<?= url('product') ?>" class="drawer-link">Phụ kiện</a></li>
                <li><a href="<?= url('product') ?>" class="drawer-link">Bộ sưu tập</a></li>
                <li><a href="<?= url('product') ?>" class="drawer-link">Sale</a></li>
                <li><a href="#" class="drawer-link">Blog</a></li>
                <li><a href="#" class="drawer-link">Liên hệ</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('btn-hamburger');
            const closeBtn = document.getElementById('btn-close-drawer');
            const overlay = document.getElementById('drawer-overlay');
            const drawer = document.getElementById('mobile-drawer');

            if (hamburgerBtn && drawer) {
                hamburgerBtn.addEventListener('click', function() {
                    drawer.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });

                const closeDrawer = function() {
                    drawer.classList.remove('active');
                    document.body.style.overflow = '';
                };

                if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
                if (overlay) overlay.addEventListener('click', closeDrawer);
            }
        });
    </script>
