<?php require_once __DIR__ . '/../../layouts/header/header.php'; ?>
<link rel="stylesheet" href="<?= asset('css/client/User/profile.css') ?>?v=<?= time() ?>">

<div class="profile-page-wrapper">

    <!-- Banner Strip Background -->
    <div class="banner-strip">
        <img alt="Banner background" class="banner-img" src="https://images.unsplash.com/photo-1600091166886-c7a68d63d5cb?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
        <div class="banner-overlay"></div>
    </div>

    <!-- Main Container -->
    <main class="main-content">

        <!-- Thông báo từ Session -->
        <?php if (isset($_SESSION['profile_success'])): ?>
            <div class="alert alert-success">
                <span class="material-symbols-outlined">check_circle</span>
                <span><?= htmlspecialchars($_SESSION['profile_success']) ?></span>
            </div>
            <?php unset($_SESSION['profile_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['profile_error'])): ?>
            <div class="alert alert-danger">
                <span class="material-symbols-outlined">error</span>
                <span><?= htmlspecialchars($_SESSION['profile_error']) ?></span>
            </div>
            <?php unset($_SESSION['profile_error']); ?>
        <?php endif; ?>

        <!-- 1. Profile Header Part -->
        <?php require_once __DIR__ . '/parts/header.php'; ?>

        <!-- 2. Dashboard Stats Part -->
        <?php require_once __DIR__ . '/parts/stats.php'; ?>

        <!-- 3. Recent Orders Part -->
        <?php require_once __DIR__ . '/parts/orders.php'; ?>

        <!-- 4. Favorites Part -->
        <?php require_once __DIR__ . '/parts/favorites.php'; ?>

        <!-- 5. Account Settings Part -->
        <?php require_once __DIR__ . '/parts/settings.php'; ?>

    </main>

    <!-- Mobile Bottom Nav -->
    <nav class="bottom-nav-mobile">
        <a href="<?= url('') ?>">
            <span class="material-symbols-outlined">storefront</span>
            <span class="nav-text">Shop</span>
        </a>
        <a href="<?= url('cart') ?>">
            <span class="material-symbols-outlined">local_mall</span>
            <span class="nav-text">Giỏ hàng</span>
        </a>
        <a href="<?= url('user/profile') ?>" class="active">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
            <span class="nav-text">Tôi</span>
        </a>
    </nav>

    <!-- 6. Edit Profile Modal Part -->
    <?php require_once __DIR__ . '/parts/edit_modal.php'; ?>

    <!-- Client-side Configuration & JS -->
    <script>
        window.PROFILE_CONFIG = {
            toggleLikeUrl: '<?= url("products/toggleLike") ?>'
        };

        // Kích hoạt Toast từ Session của PHP sau khi reload trang
        <?php if (isset($_SESSION['profile_success'])): ?>
            showToast("<?= addslashes($_SESSION['profile_success']) ?>", 'success');
            <?php unset($_SESSION['profile_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['profile_error'])): ?>
            showToast("<?= addslashes($_SESSION['profile_error']) ?>", 'error');
            <?php unset($_SESSION['profile_error']); ?>
        <?php endif; ?>
    </script>
    <script src="<?= asset('js/client/User/profile.js') ?>?v=<?= time() ?>"></script>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
