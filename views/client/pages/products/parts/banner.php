<!-- Banner -->
<section class="product-banner glass-panel">
    <div class="product-banner-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?= url('') ?>">Trang chủ</a>
            <span>&gt;</span>
            <span><?= htmlspecialchars($categoryName ?? 'Nam') ?></span>
        </div>

        <h1><?= htmlspecialchars($bannerTitle ?? 'THỜI TRANG NAM') ?></h1>
        <p><?= htmlspecialchars($bannerDesc ?? 'Khám phá các thiết kế mới nhất dành cho phái mạnh') ?></p>
    </div>

    <div class="product-banner-image">
        <img src="<?= asset('assets/images/banner1.jpg') ?>" alt="">
    </div>
</section>
