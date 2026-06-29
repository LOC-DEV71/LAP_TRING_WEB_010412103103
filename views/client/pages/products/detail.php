<?php 
require_once __DIR__ . '/../../layouts/header/header.php'; 

// Trích xuất danh sách Màu sắc và Kích thước duy nhất từ các biến thể
$colors = [];
$sizes = [];
if (!empty($variants)) {
    foreach ($variants as $variant) {
        if (!empty($variant['color']) && !in_array($variant['color'], $colors)) {
            $colors[] = $variant['color'];
        }
        if (!empty($variant['size']) && !in_array($variant['size'], $sizes)) {
            $sizes[] = $variant['size'];
        }
    }
}
?>

<link rel="stylesheet" href="<?= asset('css/client/Products/product.css') ?>?v=<?= time() ?>">

<div class="product-detail-container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?= url('') ?>">Trang chủ</a>
        <span>/</span>
        <a href="<?= url('products') ?>">Sản phẩm</a>
        <span>/</span>
        <span><?= htmlspecialchars($product['title'] ?? '') ?></span>
    </div>

    <section class="product-detail glass-panel">

        <!-- Gallery -->
        <div class="product-gallery">
            <div class="thumbnail-list">
                <!-- Thumbnail chính -->
                <img src="<?= strpos($product['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail']) : asset(htmlspecialchars($product['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" class="active">
                
                <!-- Các ảnh phụ từ database -->
                <?php if (!empty($productImages)): ?>
                    <?php foreach ($productImages as $img): ?>
                        <img src="<?= strpos($img['image_url'] ?? '', 'http') === 0 ? htmlspecialchars($img['image_url']) : asset(htmlspecialchars($img['image_url'] ?? 'assets/images/placeholder.jpg')) ?>">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="main-image">
                <img src="<?= strpos($product['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail']) : asset(htmlspecialchars($product['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>">
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">

            <span class="badge">
                BEST SELLER
            </span>

            <h1><?= htmlspecialchars($product['title'] ?? '') ?></h1>

            <div class="rating">
                ★★★★★
                <span>(128 đánh giá)</span>
                <span>| Đã bán 532</span>
            </div>

            <?php if (!empty($product['price_sale']) && $product['price_sale'] > 0): ?>
                <div class="price">
                    <?= number_format($product['price_sale'], 0, ',', '.') ?>đ
                </div>
                <div class="price-extra">
                    <span class="old-price"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                    <?php 
                        $discountPercent = round((($product['price'] - $product['price_sale']) / $product['price']) * 100);
                    ?>
                    <span class="discount">-<?= $discountPercent ?>%</span>
                </div>
            <?php else: ?>
                <div class="price">
                    <?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ
                </div>
            <?php endif; ?>

            <p class="description">
                <?= htmlspecialchars($product['description'] ?? 'Không có mô tả cho sản phẩm này.') ?>
            </p>

            <!-- Colors -->
            <?php if (!empty($colors)): ?>
                <div class="option-group">
                    <h4>Màu sắc</h4>
                    <div class="colors">
                        <?php foreach ($colors as $index => $color): ?>
                            <span class="color <?= $index === 0 ? 'active' : '' ?>" data-color="<?= htmlspecialchars($color) ?>" title="<?= htmlspecialchars($color) ?>">
                                <?= htmlspecialchars($color) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sizes -->
            <?php if (!empty($sizes)): ?>
                <div class="option-group">
                    <h4>Kích thước</h4>
                    <div class="sizes">
                        <?php foreach ($sizes as $index => $size): ?>
                            <button type="button" class="<?= $index === 0 ? 'active' : '' ?>" data-size="<?= htmlspecialchars($size) ?>">
                                <?= htmlspecialchars($size) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Add To Cart -->
            <form action="/cart/add" method="POST">
                <input
                    type="hidden"
                    name="product_variant_id"
                    id="hidden-variant-id"
                    value="<?= !empty($variants) ? htmlspecialchars($variants[0]['_id']) : '' ?>">

                <div class="cart-actions">
                    <input
                        type="number"
                        name="quantity"
                        value="1"
                        min="1">

                    <button
                        type="submit"
                        class="btn-cart"
                        id="btn-add-to-cart">
                        THÊM VÀO GIỎ HÀNG
                    </button>

                    <button
                        type="button"
                        class="btn-buy"
                        id="btn-buy-now">
                        MUA NGAY
                    </button>
                </div>
            </form>

            <!-- Features -->
            <div class="product-features">
                <div class="feature glass-panel">
                    <img src="<?= asset('assets/images/truck.png') ?>" alt="">
                    <span>
                        Miễn phí vận chuyển<br>
                        cho đơn từ 499.000đ
                    </span>
                </div>

                <div class="feature glass-panel">
                    <img src="<?= asset('assets/images/return.png') ?>" alt="">
                    <span>
                        Đổi trả dễ dàng<br>
                        trong 7 ngày
                    </span>
                </div>

                <div class="feature glass-panel">
                    <img src="<?= asset('assets/images/shield.png') ?>" alt="">
                    <span>
                        Sản phẩm chính hãng<br>
                        100%
                    </span>
                </div>
            </div>
        </div>

    </section>

    <!-- Tabs -->
    <section class="product-tabs glass-panel">
        <div class="tabs-header">
            <button class="active">MÔ TẢ SẢN PHẨM</button>
            <button>CHI TIẾT</button>
            <button>BẢO QUẢN</button>
            <button>ĐÁNH GIÁ</button>
        </div>

        <div class="tabs-content">
            <div class="tab-panel active">
                <p><?= htmlspecialchars($product['description'] ?? 'Không có mô tả cho sản phẩm này.') ?></p>
            </div>
            <div class="tab-panel">
                <p>Chi tiết thông số sản phẩm đang được cập nhật...</p>
            </div>
            <div class="tab-panel">
                <p>Giặt máy nhẹ nhàng ở nhiệt độ thường. Không sử dụng hóa chất tẩy có chứa clo.</p>
            </div>
            <div class="tab-panel">
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            </div>
        </div>
    </section>

</div>

<script>
    // Truyền dữ liệu biến thể từ PHP sang JS
    const PRODUCT_VARIANTS = <?= json_encode($variants ?? []) ?>;
</script>

<script src="<?= asset('js/client/Products/detail.js') ?>"></script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>