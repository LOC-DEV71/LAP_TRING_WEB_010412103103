<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Fashion Store') ?></title>
    <link rel="stylesheet" href="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/css/client/Home/home.css">
</head>
<body>

    <!--header-->
    <header class="header">

        <div class="top-bar">
            <div class="top-item">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/fast-delivery.png" alt="Delivery">
                <span>Miễn phí vận chuyển cho đơn hàng từ 499.000đ</span>
            </div>
            <div class="top-item">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/viber.png" alt="Phone">
                <span>Hỗ trợ khách hàng: 1900 1234 567</span>
            </div>
        </div>

        <div class="navbar">
            <div class="logo">
                FASHION
            </div>
            <ul class="menu">
                <li><a href="/">Trang chủ</a></li>
                <li><a href="#">Nam</a></li>
                <li><a href="#">Nữ</a></li>
                <li><a href="#">Phụ kiện</a></li>
                <li><a href="#">Bộ sưu tập</a></li>
                <li><a href="#">Sale</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>

            <div class="actions">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/search.png" alt="Search">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/cart.png" alt="Cart">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/user.png" alt="User">
            </div>

        </div>

    </header>

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
            <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/banner1.jpg" alt="Banner mùa hè">

        </div>

    </section>

    <!--danh mục-->
    <section class="categories">
        <div class="category-card">
            <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/cat-nam.jpg" alt="">
            <div>
                <h3>Nam</h3>
                <span>Xem ngay</span>
            </div>
        </div>

        <div class="category-card">
            <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/cat-nu.jpg" alt="">
            <div>
                <h3>Nữ</h3>
                <span>Xem ngay</span>
            </div>
        </div>

        <div class="category-card">
            <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/cat-phukien.jpg" alt="">
            <div>
                <h3>Phụ kiện</h3>
                <span>Xem ngay</span>
            </div>
        </div>

        <div class="category-card">
            <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/cat-sale.jpg" alt="">
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

            <div class="product-card">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/polo-basic.jpg" alt="">
                <h3>Áo Polo Basic</h3>
                <p class="price">299.000đ</p>
                <button>MUA NGAY</button>
            </div>

            <div class="product-card">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/thun-oversize.jpg" alt="">
                <h3>Áo Thun Nữ Oversize</h3>
                <p class="price">259.000đ</p>
                <button>MUA NGAY</button>
            </div>

            <div class="product-card">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/thun-nam.jpg" alt="">
                <h3>Áo Thun Nam Basic</h3>
                <p class="price">269.000đ</p>
                <button>MUA NGAY</button>
            </div>

            <div class="product-card">
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/somi-nu.jpg" alt="">
                <h3>Sơ Mi Nữ Tay Dài</h3>
                <p class="price">329.000đ</p>
                <button>MUA NGAY</button>
            </div>

        </div>

    </section>

    <!--bộ sưu tập-->
    <section class="collection">
        <div class="collection-left">
            <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/summer-collection.jpg" alt="">
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
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/nang-dong.jpg" alt="">

            </div>
            <div class="mini-card">
                <div class="mini-content">
                    <h3>PHONG CÁCH</h3>
                    <p class="mini-desc">Lịch lãm, hiện đại</p>
                    <span class="mini-link">Khám phá</span>
                </div>
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/phongcach.jpg" alt="">

            </div>

            <div class="mini-card full-width">
                <div class="mini-content">
                    <h3>PHỤ KIỆN</h3>
                    <p class="mini-desc">Hoàn thiện phong cách</p>
                    <span class="mini-link">Khám phá</span>
                </div>
                <img src="/Web_CLOTHES/LAP_TRING_WEB_010412103103/public/assets/images/phukien.jpg" alt="">

            </div>

        </div>

    </section>

    <!--footer-->
    <footer class="footer">
        <div class="footer-grid">

            <div>
                <h3>FASHION</h3>
                <p>Thương hiệu thời trang dành cho giới trẻ hiện đại.</p>
            </div>

            <div>
                <h3>Thông tin</h3>
                <p>Về chúng tôi</p>
                <p>Chính sách bảo mật</p>
                <p>Điều khoản sử dụng</p>
            </div>

            <div>
                <h3>Hỗ trợ khách hàng</h3>
                <p>Liên hệ</p>
                <p>Câu hỏi thường gặp</p>
                <p>Đổi trả & hoàn tiền</p>
            </div>

            <div>
                <h3>Đăng ký nhận tin</h3>
                <input type="email" placeholder="Nhập email của bạn">
            </div>

        </div>

        <div class="copyright">
            © 2026 FASHION. All Rights Reserved.
        </div>

    </footer>

</body>
</html>
```
