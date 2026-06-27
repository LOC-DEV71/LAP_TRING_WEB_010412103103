<?php

$product = [
    '_id' => 'prod_001',
    'slug' => 'ao-polo-basic',
    'title' => 'Áo Polo Basic',
    'price' => 299000,
    'thumbnail' => 'https://picsum.photos/600/700',
    'description' => 'Áo polo được thiết kế với chất liệu cotton mềm mại, mang lại cảm giác thoải mái khi mặc hằng ngày.'
];

?>

<link rel="stylesheet" href="/LAP_TRING_WEB_010412103103/public/css/client/Products/detail.css">

<div class="product-detail-container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="/">Trang chủ</a>
        <span>/</span>
        <a href="/products">Sản phẩm</a>
        <span>/</span>
        <span><?= $product['title'] ?></span>
    </div>

    <?= $product['slug'] ?>

    <section class="product-detail">

        <!-- Gallery -->
        <div class="product-gallery">

            <div class="thumbnail-list">
                <img src="<?= $product['thumbnail'] ?>">
                <img src="<?= $product['thumbnail'] ?>">
                <img src="<?= $product['thumbnail'] ?>">
                <img src="<?= $product['thumbnail'] ?>">
            </div>

            <div class="main-image">
                <img src="<?= $product['thumbnail'] ?>">
            </div>

        </div>

        <!-- Product Info -->
        <div class="product-info">

            <span class="badge">
                BEST SELLER
            </span>

            <h1><?= $product['title'] ?></h1>

            <div class="rating">
                ★★★★★
                <span>(128 đánh giá)</span>
                <span>| Đã bán 532</span>
            </div>

            <div class="price">
                <?= number_format($product['price']) ?>đ
            </div>

            <div class="price-extra">
                <span class="old-price">399.000đ</span>
                <span class="discount">-25%</span>
            </div>

            <p class="description">
                <?= $product['description'] ?>
            </p>

            <!-- Colors -->
            <div class="option-group">
                <h4>Màu sắc</h4>

                <div class="colors">
                    <span class="color black"></span>
                    <span class="color white"></span>
                    <span class="color beige"></span>
                    <span class="color blue"></span>
                </div>
            </div>

            <!-- Sizes -->
            <div class="option-group">
                <h4>Kích thước</h4>

                <div class="sizes">
                    <button type="button">S</button>
                    <button type="button" class="active">M</button>
                    <button type="button">L</button>
                    <button type="button">XL</button>
                </div>
            </div>

            <!-- Add To Cart -->
            <form action="/cart/add" method="POST">
                <input
                    type="hidden"
                    name="product_variant_id"
                    value="var_001">

                <div class="cart-actions">
                    <input
                        type="number"
                        name="quantity"
                        value="1"
                        min="1">

                    <button
                        type="submit"
                        class="btn-cart">
                        THÊM VÀO GIỎ HÀNG
                    </button>

                    <button
                        type="button"
                        class="btn-buy">
                        MUA NGAY
                    </button>

                </div>

            </form>

            <!-- Features -->
            <div class="product-features">

            <div class="feature">
                <img src="/LAP_TRING_WEB_010412103103/public/assets/images/truck.png" alt="">
                <span>
                    Miễn phí vận chuyển<br>
                    cho đơn từ 499.000đ
                </span>
            </div>

            <div class="feature">
                <img src="/LAP_TRING_WEB_010412103103/public/assets/images/return.png" alt="">
                <span>
                    Đổi trả dễ dàng<br>
                    trong 7 ngày
                </span>
            </div>

            <div class="feature">
                <img src="/LAP_TRING_WEB_010412103103/public/assets/images/shield.png" alt="">
                <span>
                    Sản phẩm chính hãng<br>
                    100%
                </span>
            </div>
        </div>
    </div>

    </section>

    <!-- Tabs -->
    <section class="product-tabs">

        <div class="tabs-header">
            <button class="active">
                MÔ TẢ SẢN PHẨM
            </button>

            <button>
                CHI TIẾT
            </button>

            <button>
                BẢO QUẢN
            </button>

            <button>
                ĐÁNH GIÁ
            </button>
        </div>

        <div class="tabs-content">
            <p>
                <?= $product['description'] ?>
            </p>
        </div>

    </section>

</div>