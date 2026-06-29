<?php 
require_once __DIR__ . '/../../layouts/header/header.php'; 
?>
<link rel="stylesheet" href="<?= asset('css/client/Products/product.css') ?>?v=<?= time() ?>">

<?php include_once __DIR__ . '/parts/banner.php'; ?>

<!-- Catalog -->
<section class="catalog">

    <?php include_once __DIR__ . '/parts/sidebar.php'; ?>

    <?php include_once __DIR__ . '/parts/grid.php'; ?>

</section>

<script>
    // Định nghĩa các đường dẫn động từ PHP sang JS
    const APP_CONFIG = {
        toggleLikeUrl: '<?= url("products/toggleLike") ?>',
        loginUrl: '<?= url("auth/login") ?>',
        productsUrl: '<?= url("products") ?>'
    };
</script>
<script src="<?= asset('js/client/Products/product.js') ?>?v=<?= time() ?>"></script>

<?php require_once __DIR__ . '/../../layouts/cart_modal.php'; ?>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>