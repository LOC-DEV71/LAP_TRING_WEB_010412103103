<?php
$prodThumb = $product['thumbnail'] ?? '';
$prodThumbSrc = (strpos($prodThumb, 'http') === 0) ? $prodThumb : asset($prodThumb ?: 'assets/images/placeholder.jpg');
$isLiked = in_array($product['_id'], $likedProducts ?? []);
?>
<div class="product-card glass-panel" 
     data-category="<?= htmlspecialchars($product['category_slug'] ?? '') ?>" 
     data-price="<?= (int)((!empty($product['price_sale']) && $product['price_sale'] > 0) ? $product['price_sale'] : ($product['price'] ?? 0)) ?>" 
     data-sizes="<?= htmlspecialchars($product['sizes'] ?? '') ?>" 
     data-colors="<?= htmlspecialchars($product['colors'] ?? '') ?>">
    
    <button class="wishlist <?= $isLiked ? 'liked' : '' ?>" data-id="<?= $product['_id'] ?>">
        <span class="material-symbols-outlined" style="<?= $isLiked ? "font-variation-settings: 'FILL' 1;" : "" ?>">favorite</span>
    </button>
    
    <a href="<?= url('products/detail/' . $product['_id']) ?>" class="product-link" style="text-decoration: none; color: inherit; display: block;">
        <img src="<?= htmlspecialchars($prodThumbSrc) ?>" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">
    </a>

    <div class="product-info">
        <a href="<?= url('products/detail/' . $product['_id']) ?>" style="text-decoration: none; color: inherit;">
            <h3><?= htmlspecialchars($product['title'] ?? '') ?></h3>
        </a>
        <?php if (!empty($product['price_sale']) && $product['price_sale'] > 0): ?>
            <p class="price">
                <span class="sale-price" style="color: #d70018; font-weight: 700;"><?= number_format($product['price_sale'], 0, ',', '.') ?>đ</span>
                <span class="old-price" style="text-decoration: line-through; color: #888; font-size: 0.85em; margin-left: 6px; font-weight: normal;"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
            </p>
        <?php else: ?>
            <p class="price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>
        <?php endif; ?>

        <div class="product-colors" style="margin-bottom: 10px;">
            <?php 
            $cardColors = explode(',', $product['colors'] ?? '');
            foreach ($cardColors as $color): 
                $color = trim($color);
                if (!empty($color)):
            ?>
                <span class="<?= htmlspecialchars($color) ?>" title="<?= htmlspecialchars($color) ?>"></span>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>

        <div class="product-actions" style="margin: 0;">
            <button class="btn-buy-now" data-id="<?= $product['_id'] ?>">MUA NGAY</button>
            <button class="btn-add-cart" data-id="<?= $product['_id'] ?>"><span class="material-symbols-outlined">shopping_cart</span></button>
        </div>
    </div>
</div>
