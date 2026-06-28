<?php require_once __DIR__ . '/../../layouts/header/header.php'; ?>
    <!--hero-->
    <section class="hero">
        <div class="hero-left">
            <span class="hero-subtitle">
                BỘ SƯU TẬP MÙA HÈ 2026
            </span>

            <h1>
                NEW SEASON <br>
                NEW STYLE
            </h1>

            <p>
                Giảm đến <span class="sale-percent">50%</span> cho tất cả sản phẩm
            </p>

            <a href="#" class="btn">
                MUA NGAY
            </a>

        </div>
        <div class="hero-right">
            <img src="<?= asset('assets/images/banner1.jpg') ?>" alt="Banner mùa hè">

        </div>

    </section>

    <!--danh mục-->
    <section class="categories">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <a href="<?= url('products?category=' . $category['slug']) ?>" class="category-card" style="text-decoration: none; color: inherit;">
                    <img src="<?= strpos($category['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($category['thumbnail']) : asset(htmlspecialchars($category['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" alt="<?= htmlspecialchars($category['title'] ?? '') ?>">
                    <div>
                        <h3><?= mb_convert_case(htmlspecialchars($category['title'] ?? ''), MB_CASE_TITLE, 'UTF-8') ?></h3>
                        <span>Xem ngay</span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!--sale banner-->
    <section class="sale-banner">
        <h2>SALE UP TO 70%</h2>
        <button>MUA NGAY</button>
    </section>

    <!--sản phẩm nổi bật-->
    <section class="featured-products">

        <div class="section-header">
            <h2>SẢN PHẨM NỔI BẬT</h2>
            <a href="#">Xem tất cả</a>
        </div>


        <div class="product-grid"> 
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <?php $isLiked = in_array($product['_id'], $likedProducts ?? []); ?>
                        <button class="wishlist <?= $isLiked ? 'liked' : '' ?>" data-id="<?= $product['_id'] ?>">
                            <span class="material-symbols-outlined" style="<?= $isLiked ? "font-variation-settings: 'FILL' 1;" : "" ?>">favorite</span>
                        </button>
                        <a href="<?= url('products/detail/' . $product['_id']) ?>" style="text-decoration: none; color: inherit; display: block;">
                            <img src="<?= strpos($product['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail']) : asset(htmlspecialchars($product['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">
                        </a>
                        <a href="<?= url('products/detail/' . $product['_id']) ?>" style="text-decoration: none; color: inherit;">
                            <h3><?= htmlspecialchars($product['title'] ?? '') ?></h3>
                        </a>
                        <p class="price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>
                        <div class="product-actions">
                            <button class="btn-buy-now" data-id="<?= $product['_id'] ?>">MUA NGAY</button>
                            <button class="btn-add-cart" data-id="<?= $product['_id'] ?>"><span class="material-symbols-outlined">shopping_cart</span></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </section>

    <!--bộ sưu tập-->
    <section class="collection">
        <div class="collection-left">
            <img src="<?= asset('assets/images/summer-collection.jpg') ?>" alt="">
            <div class="collection-text">
                <span>SUMMER</span>
                <h2>COLLECTION<br>2026</h2>
                <p>Khám phá ngay</p>
            </div>

        </div>

        <div class="collection-right">
            <div class="mini-card">
                <div class="mini-content">
                    <h3>NĂNG ĐỘNG</h3>
                    <p class="mini-desc">Trẻ trung, cá tính</p>
                    <span class="mini-link">Khám phá</span>
                </div>
                <img src="<?= asset('assets/images/nang-dong.jpg') ?>" alt="">

            </div>
            <div class="mini-card">
                <div class="mini-content">
                    <h3>PHONG CÁCH</h3>
                    <p class="mini-desc">Lịch lãm, hiện đại</p>
                    <span class="mini-link">Khám phá</span>
                </div>
                <img src="<?= asset('assets/images/phongcach.jpg') ?>" alt="">

            </div>

            <div class="mini-card full-width">
                <div class="mini-content">
                    <h3>PHỤ KIỆN</h3>
                    <p class="mini-desc">Hoàn thiện phong cách</p>
                    <span class="mini-link">Khám phá</span>
                </div>
                <img src="<?= asset('assets/images/phukien.jpg') ?>" alt="">

            </div>

        </div>

    </section>
    <div style="max-width: 1200px; margin: 40px auto; padding: 30px; border: 2px dashed #d70018; background-color: #fff; border-radius: 8px;">
        <h3 style="color: #d70018; margin-bottom: 15px;">🛠 KHU VỰC TEST LOGIC GIỎ HÀNG</h3>
        <p style="margin-bottom: 20px; color: #666;">Form này giả lập việc khách hàng bấm Mua sản phẩm từ trang Chi tiết.</p>
        
        <form action="/cart/add" method="POST" style="display: flex; gap: 20px; align-items: center;">
            <input type="hidden" name="product_variant_id" value="var_001">
            
            <div>
                <label style="font-weight: bold; margin-right: 10px;">Áo Polo Đen - Size M | Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1" style="width: 60px; padding: 8px; text-align: center; border: 1px solid #ccc;">
            </div>
            
            <button type="submit" style="padding: 10px 25px; background: #111; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                THÊM VÀO GIỎ HÀNG
            </button>
        </form>
    </div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const wishlistButtons = document.querySelectorAll('.wishlist');
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            const icon = btn.querySelector('.material-symbols-outlined');

            try {
                const apiUrl = '<?= url("products/toggleLike") ?>';
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                });

                if (response.status === 401) {
                    if (typeof showToast === 'function') showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", 'error');
                    setTimeout(() => { window.location.href = '<?= url("auth/login") ?>'; }, 1500);
                    return;
                }

                const textResponse = await response.text();
                let result;
                try {
                    result = JSON.parse(textResponse);
                } catch (e) {
                    console.error("Non-JSON response:", textResponse);
                    if (typeof showToast === 'function') showToast("Vui lòng đăng nhập để thao tác.", 'error');
                    setTimeout(() => { window.location.href = '<?= url("auth/login") ?>'; }, 1500);
                    return;
                }

                if (result.success) {
                    if (result.liked) {
                        btn.classList.add('liked');
                        icon.style.fontVariationSettings = "'FILL' 1";
                    } else {
                        btn.classList.remove('liked');
                        icon.style.fontVariationSettings = "'FILL' 0";
                    }
                    if (typeof showToast === 'function') showToast(result.message, 'success');
                } else {
                    if (typeof showToast === 'function') showToast(result.message || "Đã có lỗi xảy ra", 'error');
                }
            } catch (err) {
                console.error('Error toggling like:', err);
                if (typeof showToast === 'function') showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", 'error');
                setTimeout(() => { window.location.href = '<?= url("auth/login") ?>'; }, 1500);
            }
        });
    });

    // Add to cart API Integration -> Now opens Modal
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            if (typeof window.openCartModal === 'function') {
                window.openCartModal(productId);
            }
        });
    });

});
</script>

<?php require_once __DIR__ . '/../../layouts/cart_modal.php'; ?>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>