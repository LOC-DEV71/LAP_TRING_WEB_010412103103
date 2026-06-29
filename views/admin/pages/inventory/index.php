<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Quản Lý Tồn Kho';
        $page_subtitle = 'Theo dõi số lượng tồn kho và cập nhật trực tiếp các biến thể sản phẩm.';
        $show_import_csv = true; // Kích hoạt nút Nhập CSV trên thanh tiêu đề
        require __DIR__ . '/../../layouts/page_header.php';
        ?>

        <!-- Recent Products Table Area -->
        <div class="flat-card">
            <div class="card-header">
                <div>
                    <h4>Trạng Thái Kho Hàng</h4>
                    <p>Thay đổi số lượng kho trực tiếp và nhấn Lưu để đồng bộ.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã SKU</th>
                            <th class="col-expand">Tên Sản Phẩm</th>
                            <th>Màu sắc</th>
                            <th>Kích cỡ</th>
                            <th style="width: 200px;">Số lượng kho</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($variants)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có biến thể sản phẩm nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($variants as $v): ?>
                                <tr>
                                    <td style="font-weight: 700; font-family: monospace;"><?= htmlspecialchars($v['sku'] ?? 'N/A') ?></td>
                                    <td style="font-weight: 700;"><?= htmlspecialchars($v['product_title']) ?></td>
                                    <td><?= htmlspecialchars($v['color']) ?></td>
                                    <td><?= htmlspecialchars($v['size']) ?></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <input type="number" id="stock-<?= htmlspecialchars($v['_id']) ?>" class="form-control" value="<?= htmlspecialchars($v['stock']) ?>" min="0" style="width: 90px; padding: 6px 10px;">
                                            <button type="button" class="btn btn-primary btn-sm" data-variant-id="<?= htmlspecialchars($v['_id']) ?>" style="padding: 6px 12px; font-size: 11px;" onclick="saveStockInline(this.dataset.variantId)">Lưu</button>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="<?= url('admin/inventory/delete/' . $v['_id']) ?>" class="btn btn-danger btn-icon" onclick="return confirm('Bạn chắc chắn muốn xóa biến thể này?')" title="Xóa">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Nhật Ký Biến Động Kho Hàng -->
        <div class="flat-card mt-24">
            <div class="card-header">
                <div>
                    <h4>Nhật Ký Biến Động Kho Hàng</h4>
                    <p>Lịch sử thay đổi số lượng tồn kho (Tối đa 100 giao dịch gần nhất).</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã SKU</th>
                            <th class="col-expand">Sản Phẩm</th>
                            <th>Thay đổi</th>
                            <th>Loại giao dịch</th>
                            <th class="col-expand">Lý do điều chỉnh</th>
                            <th>Người thực hiện</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có lịch sử biến động kho nào được ghi nhận.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td style="font-weight: 700; font-family: monospace;"><?= htmlspecialchars($t['sku'] ?? 'N/A') ?></td>
                                    <td class="col-expand">
                                        <span style="font-weight: 600;"><?= htmlspecialchars($t['product_title'] ?? 'Biến thể đã xóa') ?></span>
                                        <?php if (!empty($t['color']) || !empty($t['size'])): ?>
                                            <small style="display: block; color: var(--text-secondary); margin-top: 2px;">
                                                (Màu: <?= htmlspecialchars($t['color'] ?? '-') ?>, Size: <?= htmlspecialchars($t['size'] ?? '-') ?>)
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-weight: 700; color: <?= $t['change_qty'] > 0 ? '#10b981' : ($t['change_qty'] < 0 ? '#ef4444' : 'var(--text-primary)') ?>;">
                                        <?= $t['change_qty'] > 0 ? '+' . $t['change_qty'] : $t['change_qty'] ?>
                                    </td>
                                    <td>
                                        <?php if ($t['type'] === 'import'): ?>
                                            <span class="badge badge-success">Nhập kho</span>
                                        <?php elseif ($t['type'] === 'export'): ?>
                                            <span class="badge badge-danger">Xuất kho</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Điều chỉnh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="col-expand"><?= htmlspecialchars($t['reason'] ?? 'N/A') ?></td>
                                    <td style="font-weight: 600;"><?= htmlspecialchars($t['created_by'] ?? 'Hệ thống') ?></td>
                                    <td style="color: var(--text-secondary);"><?= date('H:i d/m/Y', strtotime($t['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Nhập CSV dùng chung -->
        <?php require_once __DIR__ . '/../../layouts/csv_import_modal.php'; ?>

    </div>
</main>

<script>
// Hàm cập nhật nhanh số lượng tồn kho bằng AJAX
function saveStockInline(variantId) {
    const stockInput = document.getElementById(`stock-${variantId}`);
    if (!stockInput) return;

    const btn = document.querySelector(`button[data-variant-id="${variantId}"]`);
    if (btn) btn.disabled = true;

    const newStock = parseInt(stockInput.value);
    if (isNaN(newStock) || newStock < 0) {
        showToast("Số lượng kho không hợp lệ!", "error");
        if (btn) btn.disabled = false;
        return;
    }

    fetch("<?= url('admin/inventory/updateStock') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            variant_id: variantId,
            stock: newStock
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || "Cập nhật thành công!", "success");
            // Refresh the inventory table via SPA fetch
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMain = doc.querySelector('.admin-main');
                    const currentMain = document.querySelector('.admin-main');
                    if (newMain && currentMain) {
                        currentMain.innerHTML = newMain.innerHTML;
                        if (window.initCustomDropdowns) window.initCustomDropdowns();
                    }
                })
                .catch(err => console.error('Refresh error:', err));
        } else {
            showToast(data.message || "Cập nhật thất bại!", "error");
        }
    })
    .catch(err => {
        console.error(err);
        showToast("Lỗi kết nối máy chủ!", "error");
    })
    .finally(() => {
        if (btn) btn.disabled = false;
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
