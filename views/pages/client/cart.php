<link rel="stylesheet" href="public/css/client/Home/cart.css">
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
                        <?php if (!empty($cartData)): ?>
                            <?php foreach ($cartData as $item): ?>
                            <tr>
                                <td class="product-img-col">
                                    <img src="/public/assets/images/<?= $item['thumbnail'] ?>" alt="<?= $item['title'] ?>">
                                </td>
                                <td class="product-info-col">
                                    <a href="#" class="product-name"><?= $item['title'] ?></a>
                                    <p class="product-variant">Size: <?= $item['size'] ?> | Màu: <?= $item['color'] ?></p>
                                </td>
                                <td class="product-price"><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                <td class="product-quantity">
                                    <div class="qty-wrapper">
                                        <button class="btn-qty-minus">-</button>
                                        <input type="number" class="qty-input" value="<?= $item['quantity'] ?>" min="1">
                                        <button class="btn-qty-plus">+</button>
                                    </div>
                                </td>
                                <td class="product-subtotal"><?= number_format($item['subtotal'], 0, ',', '.') ?>đ</td>
                                <td class="product-remove">
                                    <button class="btn-remove">Xóa</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 50px 0;">Giỏ hàng của bạn đang trống!</td>
                            </tr>
                        <?php endif; ?>
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
                        <span class="total-price"><?= isset($totalPrice) ? number_format($totalPrice, 0, ',', '.') : '0' ?>đ</span>
                    </div>
                    <button class="btn-checkout">MUA NGAY</button>
                    <a href="index.php" class="btn-continue-shopping">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</main>