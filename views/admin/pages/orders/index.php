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
        <div class="flat-card">
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
                                        <form action="<?= url('admin/orders/updateStatus/' . $order['_id']) ?>" method="POST" style="display: inline-flex; gap: 6px; align-items: center;">
                                            <select name="status" class="form-control" style="padding: 4px 8px; font-size: 12px; width: 130px;">
                                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Đang giao</option>
                                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px;">Cập nhật</button>
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
