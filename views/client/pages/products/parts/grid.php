<!-- Nội dung -->
<div class="catalog-content">

    <!-- Thanh trên -->
    <div class="catalog-top">
        <p>Hiển thị <?= !empty($products) ? count($products) : 9 ?> sản phẩm</p>

        <!-- Bộ chọn sắp xếp tùy chỉnh (Custom Glassmorphism Dropdown) -->
        <div class="custom-dropdown" id="sort-dropdown">
            <button class="dropdown-trigger glass-panel">
                <span class="selected-value">Mới nhất</span>
                <span class="material-symbols-outlined arrow-icon">expand_more</span>
            </button>
            <ul class="dropdown-options glass-panel">
                <li data-value="newest" class="active">Mới nhất</li>
                <li data-value="price-asc">Giá tăng dần</li>
                <li data-value="price-desc">Giá giảm dần</li>
            </ul>
            <input type="hidden" id="sort-selector" value="newest">
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="product-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php include __DIR__ . '/../product_card.php'; ?>
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
