<?php
$clientUser = null;
$token = $_COOKIE['jwt_token'] ?? '';
if (!empty($token)) {
    $payload = \Core\JwtUtils::decode($token);
    if (is_array($payload) && isset($payload['user_id'])) {
        $clientUser = $payload;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Fashion Store') ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@100..900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="<?= asset('css/client/layouts/header.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/client/Home/home.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/toast.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/client/modal.css') ?>">
    <script src="<?= asset('js/toast.js') ?>"></script>
    <script src="<?= asset('js/header.js') ?>"></script>
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
                <?php if (isset($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?= url('products?category=' . $cat['slug']) ?>" class="menu-btn">
                                <span class="menu-text"><?= htmlspecialchars(mb_convert_case($cat['title'], MB_CASE_UPPER, 'UTF-8')) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback if categories are not passed -->
                    <li><a href="<?= url('products?category=nam') ?>" class="menu-btn"><span class="menu-text">NAM</span></a></li>
                    <li><a href="<?= url('products?category=nu') ?>" class="menu-btn"><span class="menu-text">NỮ</span></a></li>
                    <li><a href="<?= url('products?category=phu-kien') ?>" class="menu-btn"><span class="menu-text">PHỤ KIỆN</span></a></li>
                    <li><a href="<?= url('products?category=bo-suu-tap') ?>" class="menu-btn"><span class="menu-text">BỘ SƯU TẬP</span></a></li>
                    <li><a href="<?= url('products?category=sale') ?>" class="menu-btn"><span class="menu-text">SALE</span></a></li>
                <?php endif; ?>
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
                <div class="profile-dropdown">
                    <a href="<?= $clientUser ? url('user/profile') : url('auth/login') ?>" class="profile-btn" style="color: inherit; text-decoration: none;">
                        <span class="material-symbols-outlined action-btn">person</span>
                    </a>
                    <div class="dropdown-menu">
                        <?php if ($clientUser): ?>
                            <div class="dropdown-header">
                                <span>Xin chào,</span>
                                <strong><?= htmlspecialchars($clientUser['fullname'] ?? 'Khách') ?></strong>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="<?= url('user/profile') ?>" class="dropdown-item">
                                <span class="material-symbols-outlined">account_circle</span>
                                Trang cá nhân
                            </a>
                            <a href="<?= url('auth/logout') ?>" class="dropdown-item logout">
                                <span class="material-symbols-outlined">logout</span>
                                Đăng xuất
                            </a>
                        <?php else: ?>
                            <a href="<?= url('auth/login') ?>" class="dropdown-item">
                                <span class="material-symbols-outlined">login</span>
                                Đăng nhập
                            </a>
                            <a href="<?= url('auth/login?tab=register') ?>" class="dropdown-item">
                                <span class="material-symbols-outlined">person_add</span>
                                Đăng ký
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
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
                <?php if (isset($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="<?= url('products?category=' . $cat['slug']) ?>" class="drawer-link"><?= htmlspecialchars(mb_convert_case($cat['title'], MB_CASE_TITLE, 'UTF-8')) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="<?= url('products?category=nam') ?>" class="drawer-link">Nam</a></li>
                    <li><a href="<?= url('products?category=nu') ?>" class="drawer-link">Nữ</a></li>
                    <li><a href="<?= url('products?category=phu-kien') ?>" class="drawer-link">Phụ kiện</a></li>
                    <li><a href="<?= url('products?category=bo-suu-tap') ?>" class="drawer-link">Bộ sưu tập</a></li>
                    <li><a href="<?= url('products?category=sale') ?>" class="drawer-link">Sale</a></li>
                <?php endif; ?>
                <li><a href="#" class="drawer-link">Blog</a></li>
                <li><a href="#" class="drawer-link">Liên hệ</a></li>
                <li class="drawer-divider"></li>
                <?php if ($clientUser): ?>
                    <li><a href="<?= url('user/profile') ?>" class="drawer-link drawer-profile-link"><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">person</span><?= htmlspecialchars($clientUser['fullname']) ?></a></li>
                    <li><a href="<?= url('auth/logout') ?>" class="drawer-link logout-link"><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">logout</span>Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="<?= url('auth/login') ?>" class="drawer-link"><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">login</span>Đăng nhập</a></li>
                    <li><a href="<?= url('auth/login?tab=register') ?>" class="drawer-link"><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">person_add</span>Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- PHP Session Toast Triggers -->
    <?php if (isset($_SESSION['register_success'])): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['register_success']) ?>", 'success'));</script>
        <?php unset($_SESSION['register_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['login_success'])): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['login_success']) ?>", 'success'));</script>
        <?php unset($_SESSION['login_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['profile_success'])): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['profile_success']) ?>", 'success'));</script>
        <?php unset($_SESSION['profile_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['profile_error'])): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['profile_error']) ?>", 'error'));</script>
        <?php unset($_SESSION['profile_error']); ?>
    <?php endif; ?>
