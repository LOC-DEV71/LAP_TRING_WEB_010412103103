<?php require_once __DIR__ . '/../../../layouts/client/header/header.php'; ?>
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
        <div class="category-card">
            <img src="<?= asset('assets/images/cat-nam.jpg') ?>" alt="">
            <div>
                <h3>Nam</h3>
                <span>Xem ngay</span>
            </div>
        </div>

        <div class="category-card">
            <img src="<?= asset('assets/images/cat-nu.jpg') ?>" alt="">
            <div>
                <h3>Nữ</h3>
                <span>Xem ngay</span>
            </div>
        </div>

        <div class="category-card">
            <img src="<?= asset('assets/images/cat-phukien.jpg') ?>" alt="">
            <div>
                <h3>Phụ kiện</h3>
                <span>Xem ngay</span>
            </div>
        </div>

        <div class="category-card">
            <img src="<?= asset('assets/images/cat-sale.jpg') ?>" alt="">
            <div>
                <h3>Sale</h3>
                <span>Xem ngay</span>
            </div>
        </div>

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
                        <img src="<?= strpos($product['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail']) : asset(htmlspecialchars($product['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">
                        <h3><?= htmlspecialchars($product['title'] ?? '') ?></h3>
                        <p class="price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>
                        <button>MUA NGAY</button>
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
<?php require_once __DIR__ . '/../../../layouts/client/footer.php'; ?>