<?php require_once __DIR__ . '/../../../layouts/client/header.php'; ?>

<!-- Banner -->
<section class="product-banner">
    <div class="product-banner-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="#">Trang chủ</a>
            <span>&gt;</span>
            <span>Nam</span>
        </div>

        <h1>THỜI TRANG NAM</h1>
        <p>Khám phá các thiết kế mới nhất dành cho phái mạnh</p>
    </div>

    <div class="product-banner-image">
        <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/banner1.jpg" alt="">
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
            <ul>
                <li>Áo thun</li>
                <li>Áo sơ mi</li>
                <li>Áo khoác</li>
                <li>Quần</li>
                <li>Quần short</li>
            </ul>
        </div>

        <!-- Kích cỡ -->
        <div class="filter-group">
            <h4>Kích cỡ</h4>

            <label><input type="checkbox"> S</label>
            <label><input type="checkbox"> M</label>
            <label><input type="checkbox"> L</label>
            <label><input type="checkbox"> XL</label>
            <label><input type="checkbox"> XXL</label>
        </div>

        <!-- Màu sắc -->
        <div class="filter-group">
            <h4>Màu sắc</h4>

            <div class="color-list">
                <span class="color black"></span>
                <span class="color white"></span>
                <span class="color gray"></span>
                <span class="color beige"></span>
                <span class="color blue"></span>
                <span class="color green"></span>
            </div>
        </div>

        <!-- Khoảng giá -->
        <div class="filter-group">
            <h4>Khoảng giá</h4>

            <input type="range" min="199000" max="699000">

            <div class="price-range">
                <span>199.000đ</span>
                <span>699.000đ</span>
            </div>
        </div>

        <button class="clear-filter">
            XÓA BỘ LỌC
        </button>
    </aside>

    <!-- Nội dung -->
    <div class="catalog-content">

        <!-- Thanh trên -->
        <div class="catalog-top">
            <p>Hiển thị 1–12 của 48 sản phẩm</p>

            <select>
                <option>Mới nhất</option>
                <option>Giá tăng dần</option>
                <option>Giá giảm dần</option>
            </select>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="product-grid">

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/polo-basic.jpg" alt="">

                <div class="product-info">
                    <h3>Áo Polo Basic</h3>
                    <p class="price">299.000đ</p>

                    <div class="product-colors">
                        <span class="black"></span>
                        <span class="white"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/thun-nam.jpg" alt="">

                <div class="product-info">
                    <h3>Áo Thun Nam Basic</h3>
                    <p class="price">269.000đ</p>

                    <div class="product-colors">
                        <span class="black"></span>
                        <span class="gray"></span>
                        <span class="white"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/polo-basic.jpg" alt="">

                <div class="product-info">
                    <h3>Áo Sơ Mi Nam Regular</h3>
                    <p class="price">329.000đ</p>

                    <div class="product-colors">
                        <span class="white"></span>
                        <span class="blue"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/thun-nam.jpg" alt="">

                <div class="product-info">
                    <h3>Áo Sơ Mi Ngắn Tay</h3>
                    <p class="price">299.000đ</p>

                    <div class="product-colors">
                        <span class="white"></span>
                        <span class="beige"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/banner1.jpg" alt="">

                <div class="product-info">
                    <h3>Áo Khoác Bomber</h3>
                    <p class="price">599.000đ</p>

                    <div class="product-colors">
                        <span class="green"></span>
                        <span class="black"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/banner1.jpg" alt="">

                <div class="product-info">
                    <h3>Quần Kaki Ống Suông</h3>
                    <p class="price">349.000đ</p>

                    <div class="product-colors">
                        <span class="beige"></span>
                        <span class="black"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/thun-nam.jpg" alt="">

                <div class="product-info">
                    <h3>Quần Short Basic</h3>
                    <p class="price">199.000đ</p>

                    <div class="product-colors">
                        <span class="blue"></span>
                        <span class="gray"></span>
                        <span class="white"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/polo-basic.jpg" alt="">

                <div class="product-info">
                    <h3>Quần Jeans Slim Fit</h3>
                    <p class="price">499.000đ</p>

                    <div class="product-colors">
                        <span class="blue"></span>
                        <span class="black"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <button class="wishlist">♡</button>

                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/thun-nam.jpg" alt="">

                <div class="product-info">
                    <h3>Quần Jogger Nam</h3>
                    <p class="price">339.000đ</p>

                    <div class="product-colors">
                        <span class="green"></span>
                        <span class="black"></span>
                        <span class="gray"></span>
                    </div>
                </div>
            </div>

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

<?php require_once __DIR__ . '/../../../layouts/client/footer.php'; ?>