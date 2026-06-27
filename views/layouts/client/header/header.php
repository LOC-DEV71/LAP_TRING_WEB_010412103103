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
            </ul>
        </div>
    </div>

    <script>
        function showToast(message, type = 'success') {
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }

            const maxToasts = 5;
            const currentToasts = container.querySelectorAll('.toast');
            if (currentToasts.length >= maxToasts) {
                currentToasts[0].remove();
            }

            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const iconName = type === 'success' ? 'check_circle' : 'error';
            toast.innerHTML = `
                <span class="material-symbols-outlined toast-icon">${iconName}</span>
                <span class="toast-message">${message}</span>
                <button class="btn-toast-close" onclick="this.parentElement.remove()">
                    <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                </button>
            `;

            container.appendChild(toast);

            // Trigger animation
            setTimeout(() => toast.classList.add('show'), 10);

            // Remove after 4 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

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

            // Global trigger for toasts from PHP Sessions
            <?php if (isset($_SESSION['register_success'])): ?>
                showToast("<?= addslashes($_SESSION['register_success']) ?>", 'success');
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['login_success'])): ?>
                showToast("<?= addslashes($_SESSION['login_success']) ?>", 'success');
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['profile_success'])): ?>
                showToast("<?= addslashes($_SESSION['profile_success']) ?>", 'success');
                <?php unset($_SESSION['profile_success']); ?>
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
            </ul>
        </div>
    </div>

    <script>
        function showToast(message, type = 'success') {
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }

            const maxToasts = 5;
            const currentToasts = container.querySelectorAll('.toast');
            if (currentToasts.length >= maxToasts) {
                currentToasts[0].remove();
            }

            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const iconName = type === 'success' ? 'check_circle' : 'error';
            toast.innerHTML = `
                <span class="material-symbols-outlined toast-icon">${iconName}</span>
                <span class="toast-message">${message}</span>
                <button class="btn-toast-close" onclick="this.parentElement.remove()">
                    <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                </button>
            `;

            container.appendChild(toast);

            // Trigger animation
            setTimeout(() => toast.classList.add('show'), 10);

            // Remove after 4 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

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

            // Global trigger for toasts from PHP Sessions
            <?php if (isset($_SESSION['register_success'])): ?>
                showToast("<?= addslashes($_SESSION['register_success']) ?>", 'success');
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['login_success'])): ?>
                showToast("<?= addslashes($_SESSION['login_success']) ?>", 'success');
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['profile_success'])): ?>
                showToast("<?= addslashes($_SESSION['profile_success']) ?>", 'success');
                <?php unset($_SESSION['profile_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['profile_error'])): ?>
                showToast("<?= addslashes($_SESSION['profile_error']) ?>", 'error');
                <?php unset($_SESSION['profile_error']); ?>
            <?php endif; ?>
        });
    </script>
