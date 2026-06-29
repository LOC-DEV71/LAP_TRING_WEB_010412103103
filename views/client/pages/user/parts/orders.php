<!-- Đơn hàng gần đây -->
<section class="recent-orders-section">
    <div class="section-header">
        <h2 class="section-heading-title">Đơn hàng gần đây</h2>
        <button class="link-discover">
            Xem tất cả <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </div>
    <?php if (!empty($orders)): ?>
        <div class="glass-panel orders-table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày mua</th>
                        <th>Trạng thái</th>
                        <th style="text-align: right;">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="order-row" data-order-id="<?= htmlspecialchars($order['_id']) ?>" style="cursor: pointer;">
                            <td class="order-id-cell">#<?= htmlspecialchars($order['_id']) ?></td>
                            <td><?= date('d/m/Y', strtotime($order['createdAt'])) ?></td>
                            <td>
                                <?php
                                $status = $order['status'] ?? 'pending';
                                $statusText = 'Chờ xử lý';
                                $statusClass = 'status-shipping';
                                if ($status === 'completed') {
                                    $statusText = 'Hoàn thành';
                                    $statusClass = 'status-completed';
                                } elseif ($status === 'shipping') {
                                    $statusText = 'Đang giao';
                                    $statusClass = 'status-shipping';
                                } elseif ($status === 'cancelled') {
                                    $statusText = 'Đã hủy';
                                    $statusClass = 'status-completed';
                                }
                                ?>
                                <span class="order-status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                            </td>
                            <td class="order-total-price" style="text-align: right;"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="glass-panel">
            <div class="empty-orders">
                Bạn chưa thực hiện đơn đặt hàng nào gần đây.
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- Order Details Modal -->
<div id="order-details-modal" class="modal-wrapper" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="glass-panel modal-container" style="max-width: 600px; max-height: 85vh; overflow-y: auto;">
        <div class="modal-header">
            <h3>Chi tiết đơn hàng <span id="detail-order-id" style="font-family: monospace; opacity: 0.8;"></span></h3>
            <button class="btn-close-modal" id="btn-close-order-modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="modal-body" style="padding-top: 10px;">
            <!-- Info Summary -->
            <div class="order-info-summary" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; font-size: 0.9rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">
                <div>
                    <p style="margin-bottom: 6px;"><strong>Ngày đặt:</strong> <span id="detail-order-date"></span></p>
                    <p style="margin-bottom: 6px;"><strong>Phương thức:</strong> <span id="detail-order-payment"></span></p>
                    <p style="margin-bottom: 6px;"><strong>Trạng thái:</strong> <span id="detail-order-status" class="order-status-badge"></span></p>
                </div>
                <div>
                    <p style="margin-bottom: 6px;"><strong>Điện thoại:</strong> <span id="detail-order-phone"></span></p>
                    <p style="margin-bottom: 6px;"><strong>Địa chỉ giao:</strong> <span id="detail-order-address"></span></p>
                </div>
            </div>
            
            <!-- Products List -->
            <h4 style="margin-bottom: 12px; font-weight: 500;">Sản phẩm đã mua</h4>
            <div id="detail-order-items-list" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; max-height: 240px; overflow-y: auto; padding-right: 4px;">
                <!-- Dynamically populated -->
            </div>

            <!-- Note -->
            <div id="detail-order-note-container" style="margin-bottom: 20px; font-size: 0.9rem; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); display: none;">
                <strong>Ghi chú:</strong> <span id="detail-order-note" style="opacity: 0.8;"></span>
            </div>

            <!-- Total -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                <span style="font-size: 1rem; font-weight: 500;">Tổng tiền thanh toán:</span>
                <span id="detail-order-total" style="font-size: 1.25rem; font-weight: 700; color: #10b981;"></span>
            </div>
        </div>
    </div>
</div>
