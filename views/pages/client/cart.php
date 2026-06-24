<link rel="stylesheet" href="public/css/client/Home/cart.css">
<link rel="stylesheet" href="public/css/client/Home/home.css">
<main class="cart-page">
    <div class="cart-container">
        <div class="cart-header">
            <h1>GIỎ HÀNG CỦA BẠN</h1>
        </div>
        
        <div class="cart-content">
            <div class="cart-items-section">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th colspan="2">Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="product-img-col">
                                <img src="public/assets/images/somi-nu.jpg" alt="Sơ Mi Nữ Tay Dài">
                            </td>
                            <td class="product-info-col">
                                <a href="#" class="product-name">Sơ Mi Nữ Tay Dài</a>
                                <p class="product-variant">Size: M | Màu: Be</p>
                            </td>
                            <td class="product-price">329.000đ</td>
                            <td class="product-quantity">
                                <div class="qty-wrapper">
                                    <button class="btn-qty-minus">-</button>
                                    <input type="number" class="qty-input" value="1" min="1">
                                    <button class="btn-qty-plus">+</button>
                                </div>
                            </td>
                            <td class="product-subtotal">329.000đ</td>
                            <td class="product-remove">
                                <button class="btn-remove">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cart-summary-section">
                <div class="summary-box">
                    <h2>TỔNG ĐƠN HÀNG</h2>
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>329.000đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-row total-row">
                        <span>Tổng cộng:</span>
                        <span class="total-price">329.000đ</span>
                    </div>
                    <button class="btn-checkout">MUA NGAY</button>
                    <a href="index.php" class="btn-continue-shopping">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</main>