<?php 
$extra_css = [
    asset('css/client/Home/home.css'),
    asset('css/client/Products/product.css')
];
require_once __DIR__ . '/../../layouts/header/header.php'; 
?>
    <!--hero-->
    <section class="hero">
        <div class="hero-left">
            <span>
                <?= htmlspecialchars($settings['home_hero_subtitle'] ?? 'BỘ SƯU TẬP MÙA HÈ 2026') ?>
            </span>

            <h1>
                <?= nl2br(htmlspecialchars($settings['home_hero_title'] ?? "NEW SEASON\nNEW STYLE")) ?>
            </h1>

            <p>
                <?= htmlspecialchars($settings['home_hero_sale'] ?? 'Giảm đến 50% cho tất cả sản phẩm') ?>
            </p>

            <a href="<?= url($settings['home_hero_button_link'] ?? 'products') ?>" class="btn">
                <?= htmlspecialchars($settings['home_hero_button_text'] ?? 'MUA NGAY') ?>
            </a>

        </div>
        <div class="hero-right">
            <?php 
            $heroImg = $settings['home_hero_image'] ?? '';
            $heroImgSrc = (strpos($heroImg, 'http') === 0) ? $heroImg : asset($heroImg ?: 'assets/images/banner1.jpg');
            ?>
            <img src="<?= htmlspecialchars($heroImgSrc) ?>" alt="Banner mùa hè">
        </div>

    </section>

    <!--danh mục-->
    <section class="categories">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <?php 
                $catThumb = $category['thumbnail'] ?? '';
                $catThumbSrc = (strpos($catThumb, 'http') === 0) ? $catThumb : asset($catThumb ?: 'assets/images/placeholder.jpg');
                ?>
                <a href="<?= url('products?category=' . $category['slug']) ?>" class="category-card" style="text-decoration: none; color: inherit;">
                    <img src="<?= htmlspecialchars($catThumbSrc) ?>" alt="<?= htmlspecialchars($category['title'] ?? '') ?>">
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
        <h2><?= htmlspecialchars($settings['home_sale_banner_title'] ?? 'SALE UP TO 70%') ?></h2>
        <a href="<?= url($settings['home_sale_banner_button_link'] ?? 'products') ?>" style="text-decoration: none;">
            <button><?= htmlspecialchars($settings['home_sale_banner_button_text'] ?? 'MUA NGAY') ?></button>
        </a>
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
                    <?php include __DIR__ . '/../products/product_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </section>

    <!--bộ sưu tập-->
    <?php 
    // Tìm các danh mục phục vụ cho phần Collection
    $mainCollection = null;
    $miniCollections = [];
    
    foreach ($categories as $cat) {
        if ($cat['slug'] === 'bo-suu-tap') {
            $mainCollection = $cat;
        } elseif (in_array($cat['slug'], ['do-the-thao', 'cong-so', 'phu-kien'])) {
            $miniCollections[$cat['slug']] = $cat;
        }
    }
    
    // Fallback dự phòng nếu không tìm thấy trong DB
    $mainCollection = $mainCollection ?: [
        'title' => 'COLLECTION 2026',
        'description' => 'SUMMER',
        'thumbnail' => 'https://images.unsplash.com/photo-1509319117193-57bab727e09d?w=800',
        'slug' => 'bo-suu-tap'
    ];
    ?>
    <section class="collection">
        <div class="collection-left">
            <img src="<?= htmlspecialchars($mainCollection['thumbnail'] ?? '') ?>" alt="<?= htmlspecialchars($mainCollection['title'] ?? '') ?>">
            <div class="collection-text">
                <span><?= htmlspecialchars($mainCollection['description'] ?? '') ?></span>
                <h2>COLLECTION<br>2026</h2>
                <a href="<?= url('products?category=' . $mainCollection['slug']) ?>" style="text-decoration: none; color: inherit;">
                    <p>Khám phá ngay</p>
                </a>
            </div>
        </div>

        <div class="collection-right">
            <?php 
            $orderedSlugs = ['do-the-thao', 'cong-so', 'phu-kien'];
            foreach ($orderedSlugs as $slug):
                if (isset($miniCollections[$slug])):
                    $mCol = $miniCollections[$slug];
                    $isFullWidth = ($slug === 'phu-kien') ? 'full-width' : '';
            ?>
                <div class="mini-card <?= $isFullWidth ?>">
                    <div class="mini-content">
                        <h3><?= htmlspecialchars($mCol['title'] ?? '') ?></h3>
                        <p class="mini-desc"><?= htmlspecialchars($mCol['description'] ?? '') ?></p>
                        <a href="<?= url('products?category=' . $mCol['slug']) ?>" style="text-decoration: none; color: inherit;">
                            <span class="mini-link">Khám phá</span>
                        </a>
                    </div>
                    <img src="<?= htmlspecialchars($mCol['thumbnail'] ?? '') ?>" alt="<?= htmlspecialchars($mCol['title'] ?? '') ?>">
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </section>

    <!-- Form testing -->
    <div style="max-width: 1200px; margin: 40px auto; padding: 30px; border: 2px dashed #d70018; background-color: #fff; border-radius: 8px;">
        <h3 style="color: #d70018; margin-bottom: 15px;">🛠 KHU VỰC TEST LOGIC GIỎ HÀNG</h3>
        <p style="margin-bottom: 20px; color: #666;">Form này giả lập việc khách hàng bấm Mua sản phẩm từ trang Chi tiết.</p>
        
        <form action="<?= url('cart/add') ?>" method="POST" style="display: flex; gap: 20px; align-items: center;">
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
    // Định nghĩa các đường dẫn động từ PHP sang JS
    const APP_CONFIG = {
        toggleLikeUrl: '<?= url("products/toggleLike") ?>',
        loginUrl: '<?= url("auth/login") ?>'
    };
</script>
<script src="<?= asset('js/client/Home/home.js') ?>"></script>

<?php require_once __DIR__ . '/../../layouts/cart_modal.php'; ?>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>