<?php 
require_once __DIR__ . '/../../layouts/header/header.php'; 

// Helper function to map product names to category slugs for JS filtering
if (!function_exists('getProductCategorySlug')) {
    function getProductCategorySlug($name) {
        $nameLower = mb_strtolower($name, 'UTF-8');
        if (strpos($nameLower, 'thun') !== false || strpos($nameLower, 'polo') !== false) return 'ao-thun';
        if (strpos($nameLower, 'sơ mi') !== false) return 'ao-so-mi';
        if (strpos($nameLower, 'khoác') !== false || strpos($nameLower, 'bomber') !== false) return 'ao-khoac';
        if (strpos($nameLower, 'short') !== false) return 'quan-short';
        if (strpos($nameLower, 'quần') !== false || strpos($nameLower, 'jeans') !== false || strpos($nameLower, 'kaki') !== false || strpos($nameLower, 'jogger') !== false) return 'quan';
        return 'ao-thun'; // default
    }
}

// Helper to assign mock/default sizes consistently based on product name
if (!function_exists('getProductSizes')) {
    function getProductSizes($name) {
        $nameLower = mb_strtolower($name, 'UTF-8');
        if (strpos($nameLower, 'nam') !== false || strpos($nameLower, 'oversize') !== false) {
            return 'M,L,XL,XXL';
        }
        return 'S,M,L,XL';
    }
}

// Helper to assign mock/default colors consistently based on product name
if (!function_exists('getProductColors')) {
    function getProductColors($name) {
        $nameLower = mb_strtolower($name, 'UTF-8');
        $colors = [];
        if (strpos($nameLower, 'basic') !== false) {
            $colors = ['black', 'white', 'gray'];
        } elseif (strpos($nameLower, 'sơ mi') !== false) {
            $colors = ['white', 'blue', 'beige'];
        } elseif (strpos($nameLower, 'khoác') !== false || strpos($nameLower, 'bomber') !== false) {
            $colors = ['green', 'black', 'gray'];
        } elseif (strpos($nameLower, 'quần') !== false) {
            $colors = ['blue', 'black', 'beige', 'gray'];
        } else {
            $colors = ['black', 'white', 'blue'];
        }
        return implode(',', $colors);
    }
}
?>
<link rel="stylesheet" href="<?= asset('css/client/Products/product.css') ?>">

<!-- Banner -->
<section class="product-banner">
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

<!-- Catalog -->
<section class="catalog">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h3>Bộ lọc</h3>

        <!-- Danh mục -->
        <div class="filter-group">
            <h4>Danh mục</h4>
            <ul id="category-filter">
                <li data-category="ao-thun">Áo thun</li>
                <li data-category="ao-so-mi">Áo sơ mi</li>
                <li data-category="ao-khoac">Áo khoác</li>
                <li data-category="quan">Quần</li>
                <li data-category="quan-short">Quần short</li>
            </ul>
        </div>

        <!-- Kích cỡ -->
        <div class="filter-group" id="size-filter">
            <h4>Kích cỡ</h4>

            <label><input type="checkbox" value="S"> S</label>
            <label><input type="checkbox" value="M"> M</label>
            <label><input type="checkbox" value="L"> L</label>
            <label><input type="checkbox" value="XL"> XL</label>
            <label><input type="checkbox" value="XXL"> XXL</label>
        </div>

        <!-- Màu sắc -->
        <div class="filter-group">
            <h4>Màu sắc</h4>

            <div class="color-list" id="color-filter">
                <span class="color black" data-color="black"></span>
                <span class="color white" data-color="white"></span>
                <span class="color gray" data-color="gray"></span>
                <span class="color beige" data-color="beige"></span>
                <span class="color blue" data-color="blue"></span>
                <span class="color green" data-color="green"></span>
            </div>
        </div>

        <!-- Khoảng giá -->
        <div class="filter-group">
            <h4>Khoảng giá</h4>

            <input type="range" min="199000" max="699000" id="price-range" value="699000">

            <div class="price-range">
                <span>199.000đ</span>
                <span id="price-value">699.000đ</span>
            </div>
        </div>

        <button class="clear-filter" id="btn-clear-filter">
            XÓA BỘ LỌC
        </button>
    </aside>

    <!-- Nội dung -->
    <div class="catalog-content">

        <!-- Thanh trên -->
        <div class="catalog-top">
            <p>Hiển thị <?= !empty($products) ? count($products) : 9 ?> sản phẩm</p>

            <select id="sort-selector">
                <option value="newest">Mới nhất</option>
                <option value="price-asc">Giá tăng dần</option>
                <option value="price-desc">Giá giảm dần</option>
            </select>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card" 
                         data-category="<?= getProductCategorySlug($product['title'] ?? '') ?>" 
                         data-price="<?= (int)($product['price'] ?? 0) ?>" 
                         data-sizes="<?= htmlspecialchars($product['sizes'] ?? '') ?>" 
                         data-colors="<?= htmlspecialchars($product['colors'] ?? '') ?>">
                        <?php $isLiked = in_array($product['_id'], $likedProducts ?? []); ?>
                        <button class="wishlist <?= $isLiked ? 'liked' : '' ?>" data-id="<?= $product['_id'] ?>">
                            <span class="material-symbols-outlined" style="<?= $isLiked ? "font-variation-settings: 'FILL' 1;" : "" ?>">favorite</span>
                        </button>
                        <a href="<?= url('products/detail/' . $product['_id']) ?>" class="product-link" style="text-decoration: none; color: inherit; display: block;">
                            <img src="<?= strpos($product['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail']) : asset(htmlspecialchars($product['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">
                        </a>

                        <div class="product-info">
                            <a href="<?= url('products/detail/' . $product['_id']) ?>" style="text-decoration: none; color: inherit;">
                                <h3><?= htmlspecialchars($product['title'] ?? '') ?></h3>
                            </a>
                            <p class="price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>

                            <div class="product-colors" style="margin-bottom: 10px;">
                                <span class="black"></span>
                                <span class="white"></span>
                                <span class="gray"></span>
                            </div>

                            <div class="product-actions" style="margin: 0;">
                                <button class="btn-buy-now" data-id="<?= $product['_id'] ?>">MUA NGAY</button>
                                <button class="btn-add-cart" data-id="<?= $product['_id'] ?>"><span class="material-symbols-outlined">shopping_cart</span></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Phân trang -->
        <div class="pagination">
            <a class="active" href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">&gt;</a>
        </div>

    </div>

</section>
<script>
    // Định nghĩa các đường dẫn động từ PHP sang JS
    const APP_CONFIG = {
        toggleLikeUrl: '<?= url("products/toggleLike") ?>',
        loginUrl: '<?= url("auth/login") ?>'
    };
</script>
<script src="<?= asset('js/client/Products/product.js') ?>"></script>



<?php require_once __DIR__ . '/../../layouts/cart_modal.php'; ?>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>