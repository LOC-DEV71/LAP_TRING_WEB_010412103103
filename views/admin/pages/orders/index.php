<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Quản Lý Đơn Hàng';
        $page_subtitle = 'Theo dõi, duyệt và xử lý các đơn đặt hàng của khách hàng.';
        require __DIR__ . '/../../layouts/page_header.php';
        ?>

        <!-- Recent Products Table Area -->
        <div class="flat-card" style="overflow: visible;">
            <div class="card-header">
                <div>
                    <h4>Danh Sách Đơn Hàng</h4>
                    <p>Danh sách lịch sử mua hàng của toàn hệ thống.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th class="col-expand">Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Hình Thức</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th style="text-align: right;">Cập Nhật Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có đơn hàng nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td style="font-weight: 700; font-family: monospace;"><?= htmlspecialchars($order['_id']) ?></td>
                                    <td>
                                        <div style="font-weight: 700;"><?= htmlspecialchars($order['customer_name'] ?? 'Ẩn danh') ?></div>
                                        <div style="font-size: 11px; color: #848484;"><?= htmlspecialchars($order['phone']) ?></div>
                                    </td>
                                    <td style="font-weight: 700;"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                                    <td><?= htmlspecialchars(strtoupper($order['payment_method'])) ?></td>
                                    <td>
                                        <?php 
                                        $statusClass = 'badge-secondary';
                                        $statusText = 'Chờ xử lý';
                                        if ($order['status'] === 'processing') { $statusClass = 'badge-secondary'; $statusText = 'Đang xử lý'; }
                                        elseif ($order['status'] === 'shipped') { $statusClass = 'badge-success'; $statusText = 'Đang giao'; }
                                        elseif ($order['status'] === 'delivered') { $statusClass = 'badge-success'; $statusText = 'Đã giao'; }
                                        elseif ($order['status'] === 'cancelled') { $statusClass = 'badge-danger'; $statusText = 'Đã hủy'; }
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($order['createdAt'])) ?></td>
                                    <td style="text-align: right;">
                                        <form action="<?= url('admin/orders/updateStatus/' . $order['_id']) ?>" method="POST" style="display: inline-flex; gap: 8px; align-items: center; text-align: left;">
                                            <div class="admin-custom-dropdown" style="width: 140px;">
                                                <button type="button" class="dropdown-trigger" style="height: 36px; padding: 0 10px; font-size: 12px; border-radius: 6px;">
                                                    <?php
                                                    $currText = 'Chờ xử lý';
                                                    if ($order['status'] === 'processing') $currText = 'Đang xử lý';
                                                    elseif ($order['status'] === 'shipped') $currText = 'Đang giao';
                                                    elseif ($order['status'] === 'delivered') $currText = 'Đã giao';
                                                    elseif ($order['status'] === 'cancelled') $currText = 'Đã hủy';
                                                    ?>
                                                    <span class="selected-value"><?= $currText ?></span>
                                                    <span class="material-symbols-outlined arrow-icon" style="font-size: 16px;">expand_more</span>
                                                </button>
                                                <ul class="dropdown-options" style="font-size: 12px; padding: 4px; border-radius: 6px;">
                                                    <li data-value="pending" class="<?= $order['status'] === 'pending' ? 'active' : '' ?>" style="padding: 6px 10px;">Chờ xử lý</li>
                                                    <li data-value="processing" class="<?= $order['status'] === 'processing' ? 'active' : '' ?>" style="padding: 6px 10px;">Đang xử lý</li>
                                                    <li data-value="shipped" class="<?= $order['status'] === 'shipped' ? 'active' : '' ?>" style="padding: 6px 10px;">Đang giao</li>
                                                    <li data-value="delivered" class="<?= $order['status'] === 'delivered' ? 'active' : '' ?>" style="padding: 6px 10px;">Đã giao</li>
                                                    <li data-value="cancelled" class="<?= $order['status'] === 'cancelled' ? 'active' : '' ?>" style="padding: 6px 10px;">Đã hủy</li>
                                                </ul>
                                                <input type="hidden" name="status" value="<?= htmlspecialchars($order['status']) ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="padding: 0 12px; font-size: 11px; height: 36px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">Cập nhật</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
