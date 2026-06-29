<!-- Sản phẩm yêu thích -->
<section class="favorites-section">
    <div class="section-header">
        <h2 class="section-heading-title">Sản phẩm yêu thích</h2>
        <button class="link-discover">
            Khám phá thêm <span class="material-symbols-outlined">arrow_forward</span>
        </button>
    </div>
    <div class="favorites-row-grid">
        <?php if (!empty($likedProducts)): ?>
            <?php foreach ($likedProducts as $product): ?>
                <div class="product-item-card">
                    <div class="product-img-wrapper">
                        <a href="<?= url('products/detail/' . ($product['slug'] ?? '')) ?>">
                            <img alt="<?= htmlspecialchars($product['title'] ?? $product['name'] ?? '') ?>" src="<?= strpos($product['thumbnail'] ?? $product['image'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail'] ?? $product['image'] ?? '') : asset(htmlspecialchars($product['thumbnail'] ?? $product['image'] ?? 'assets/images/placeholder.jpg')) ?>"/>
                        </a>
                        <button class="btn-heart-remove wishlist liked" data-id="<?= $product['_id'] ?>">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; color: #d70018;">favorite</span>
                        </button>
                    </div>
                    <h3 class="product-card-title"><?= htmlspecialchars($product['title'] ?? $product['name'] ?? '') ?></h3>
                    <?php if (!empty($product['price_sale']) && $product['price_sale'] > 0): ?>
                        <p class="product-card-price">
                            <span class="sale-price" style="color: #d70018; font-weight: 700;"><?= number_format($product['price_sale'], 0, ',', '.') ?>đ</span>
                            <span class="old-price" style="text-decoration: line-through; color: #888; font-size: 0.85em; margin-left: 6px; font-weight: normal;"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                        </p>
                    <?php else: ?>
                        <p class="product-card-price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px 20px;">Bạn chưa có sản phẩm yêu thích nào.</p>
        <?php endif; ?>
    </div>
</section>
