<?php require_once __DIR__ . '/../layouts/header/header.php'; ?>

<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap');

    .cart-page-wrapper {
        font-family: 'Hanken Grotesk', sans-serif;
        background-color: #f5f3f1;
        color: #111827;
        min-height: 100vh;
        padding: 60px 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        position: relative;
    }

    /* Background decorative element */
    .cart-page-wrapper::before {
        content: "";
        position: absolute;
        top: -10%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 94, 60, 0.08) 0%, rgba(255,255,255,0) 70%);
        z-index: 0;
        pointer-events: none;
    }

    .cart-container-glass {
        max-width: 1200px;
        width: 100%;
        background: rgba(255, 255, 255, 0.72);
        backdrop-filter: blur(24px) saturate(140%);
        -webkit-backdrop-filter: blur(24px) saturate(140%);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        z-index: 1;
        position: relative;
    }

    .cart-header-title {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 35px;
        text-transform: uppercase;
        position: relative;
        display: inline-block;
    }

    .cart-header-title::after {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 40px;
        height: 3px;
        background-color: #8b5e3c;
        border-radius: 2px;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 40px;
    }

    /* Cart Items Table */
    .cart-items-section {
        overflow-x: auto;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .cart-table th {
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6b7280;
        padding: 15px 20px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
    }

    .cart-table td {
        padding: 24px 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
    }

    .cart-item-row {
        transition: background-color 0.2s ease;
    }

    .cart-item-row:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }

    .product-cell {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-thumb {
        width: 90px;
        height: 110px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 8px 20px -8px rgba(0, 0, 0, 0.15);
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .product-meta .product-title-link {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        text-decoration: none;
        transition: color 0.2s;
        display: block;
        margin-bottom: 6px;
    }

    .product-meta .product-title-link:hover {
        color: #8b5e3c;
    }

    .product-meta .product-variant-info {
        font-size: 13px;
        color: #6b7280;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .variant-badge {
        background: rgba(0, 0, 0, 0.04);
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 600;
    }

    .price-text {
        font-weight: 700;
        font-size: 16px;
    }

    /* Quantity Controls */
    .qty-control-wrapper {
        display: inline-flex;
        align-items: center;
        background: rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        padding: 4px;
    }

    .btn-qty-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #111827;
        text-decoration: none;
        font-weight: 800;
        font-size: 16px;
        transition: all 0.2s;
    }

    .btn-qty-action:hover {
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        color: #8b5e3c;
    }

    .qty-display-input {
        width: 40px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 700;
        font-size: 15px;
        color: #111827;
        outline: none;
        -moz-appearance: textfield;
    }

    .qty-display-input::-webkit-outer-spin-button,
    .qty-display-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .subtotal-text {
        font-weight: 800;
        font-size: 16px;
        color: #8b5e3c;
    }

    .btn-delete-item {
        color: #9ca3af;
        transition: color 0.2s, transform 0.2s;
        background: none;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-delete-item:hover {
        color: #ef4444;
        transform: scale(1.15);
    }

    /* Cart Summary Section */
    .cart-summary-box {
        background: rgba(255, 255, 255, 0.50);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        height: fit-content;
    }

    .summary-heading {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: -0.3px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding-bottom: 15px;
    }

    .summary-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        font-size: 15px;
    }

    .summary-item-row .label-text {
        color: #6b7280;
        font-weight: 600;
    }

    .summary-item-row .value-text {
        font-weight: 700;
        color: #111827;
    }

    .summary-divider-line {
        border: none;
        border-top: 1px dashed rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    .summary-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .summary-total-row .total-label {
        font-size: 18px;
        font-weight: 800;
    }

    .summary-total-row .total-value {
        font-size: 24px;
        font-weight: 800;
        color: #8b5e3c;
    }

    .btn-checkout-action {
        width: 100%;
        padding: 16px;
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 14px;
        display: block;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.12);
    }

    .btn-checkout-action:hover {
        background: #8b5e3c;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(139, 94, 60, 0.2);
    }

    .btn-continue-action {
        width: 100%;
        padding: 14px;
        background: transparent;
        color: #4b5563;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: block;
        text-align: center;
        text-decoration: none;
    }

    .btn-continue-action:hover {
        background: rgba(0, 0, 0, 0.02);
        color: #111827;
        border-color: rgba(0, 0, 0, 0.2);
    }

    /* Empty Cart State */
    .empty-cart-container {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-cart-icon {
        font-size: 72px;
        color: #9ca3af;
        margin-bottom: 20px;
    }

    .empty-cart-heading {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .empty-cart-text {
        color: #6b7280;
        font-size: 15px;
        margin-bottom: 30px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .cart-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 767px) {
        .cart-container-glass {
            padding: 24px;
            border-radius: 16px;
        }

        .cart-header-title {
            font-size: 24px;
            margin-bottom: 25px;
        }

        /* Convert table to cards on mobile */
        .cart-table thead {
            display: none;
        }

        .cart-table tr {
            display: block;
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 16px;
            position: relative;
        }

        .cart-table td {
            display: block;
            padding: 8px 0;
            border: none;
        }

        .cart-table td.product-cell-col {
            padding-bottom: 12px;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.05);
        }

        .product-cell {
            gap: 15px;
        }

        .product-thumb {
            width: 75px;
            height: 90px;
        }

        .cart-table td.price-cell-col,
        .cart-table td.qty-cell-col,
        .cart-table td.subtotal-cell-col {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .cart-table td.price-cell-col::before {
            content: "Đơn giá:";
            font-weight: 700;
            color: #6b7280;
        }

        .cart-table td.qty-cell-col::before {
            content: "Số lượng:";
            font-weight: 700;
            color: #6b7280;
        }

        .cart-table td.subtotal-cell-col::before {
            content: "Thành tiền:";
            font-weight: 700;
            color: #6b7280;
        }

        .cart-table td.remove-cell-col {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 0;
        }
    }
</style>

<main class="cart-page-wrapper">
    <div class="cart-container-glass">
        <div class="cart-header">
            <h1 class="cart-header-title">Giỏ hàng của bạn</h1>
        </div>

        <?php if (!empty($cartData)): ?>
            <div class="cart-layout">
                <!-- Cart Items Section -->
                <div class="cart-items-section">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartData as $item): ?>
                                <tr class="cart-item-row">
                                    <td class="product-cell-col">
                                        <div class="product-cell">
                                            <img class="product-thumb" src="<?= strpos($item['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($item['thumbnail']) : asset(htmlspecialchars($item['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>">
                                            <div class="product-meta">
                                                <a href="<?= url('products/detail/' . ($item['product_id'] ?? '')) ?>" class="product-title-link"><?= htmlspecialchars($item['title']) ?></a>
                                                <div class="product-variant-info">
                                                    <span class="variant-badge">Size: <?= htmlspecialchars($item['size']) ?></span>
                                                    <span class="variant-badge">Màu: <?= htmlspecialchars($item['color']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price-cell-col">
                                        <span class="price-text"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                                    </td>
                                    <td class="qty-cell-col">
                                        <div class="qty-control-wrapper">
                                            <a href="<?= url('cart/decrease/' . $item['variant_id']) ?>" class="btn-qty-action minus-btn">-</a>
                                            <input type="number" class="qty-display-input" value="<?= $item['quantity'] ?>" min="1" readonly>
                                            <a href="<?= url('cart/increase/' . $item['variant_id']) ?>" class="btn-qty-action plus-btn">+</a>
                                        </div>
                                    </td>
                                    <td class="subtotal-cell-col">
                                        <span class="subtotal-text"><?= number_format($item['subtotal'], 0, ',', '.') ?>đ</span>
                                    </td>
                                    <td class="remove-cell-col">
                                        <a href="<?= url('cart/remove/' . $item['variant_id']) ?>" class="btn-delete-item" title="Xóa sản phẩm">
                                            <span class="material-symbols-outlined">delete</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Order Summary Section -->
                <div class="cart-summary-section">
                    <div class="cart-summary-box">
                        <h2 class="summary-heading">Tổng đơn hàng</h2>
                        
                        <div class="summary-item-row">
                            <span class="label-text">Tạm tính:</span>
                            <span class="value-text"><?= isset($totalPrice) ? number_format($totalPrice, 0, ',', '.') : '0' ?>đ</span>
                        </div>
                        <div class="summary-item-row">
                            <span class="label-text">Phí vận chuyển:</span>
                            <span class="value-text" style="color: #10b981; font-weight: 700;">Miễn phí</span>
                        </div>

                        <hr class="summary-divider-line">

                        <div class="summary-total-row">
                            <span class="total-label">Tổng cộng:</span>
                            <span class="total-value"><?= isset($totalPrice) ? number_format($totalPrice, 0, ',', '.') : '0' ?>đ</span>
                        </div>

                        <a href="<?= url('checkout') ?>" class="btn-checkout-action">TIẾN HÀNH THANH TOÁN</a>
                        <a href="<?= url('') ?>" class="btn-continue-action">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty Cart State -->
            <div class="empty-cart-container">
                <span class="material-symbols-outlined empty-cart-icon">shopping_bag</span>
                <h2 class="empty-cart-heading">Giỏ hàng trống</h2>
                <p class="empty-cart-text">Hiện tại bạn chưa thêm sản phẩm nào vào giỏ hàng của mình. Hãy quay lại cửa hàng để chọn những món đồ ưng ý nhé!</p>
                <a href="<?= url('') ?>" class="btn-checkout-action" style="max-width: 280px; margin: 0 auto;">MUA SẮM NGAY</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>