<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Quản Lý Tồn Kho';
        $page_subtitle = 'Theo dõi số lượng tồn kho và cập nhật trực tiếp các biến thể sản phẩm.';
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
                                            <button class="btn btn-primary" style="padding: 6px 12px; font-size: 11px;" onclick="saveStockInline('<?= htmlspecialchars($v['_id']) ?>')">Lưu</button>
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
    </div>
</main>

<script>
// Hàm cập nhật nhanh số lượng tồn kho bằng AJAX
function saveStockInline(variantId) {
    const stockInput = document.getElementById(`stock-${variantId}`);
    if (!stockInput) return;

    const newStock = parseInt(stockInput.value);
    if (isNaN(newStock) || newStock < 0) {
        showToast("Số lượng kho không hợp lệ!", "error");
        return;
    }

    // Gửi yêu cầu AJAX
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, "success");
        } else {
            showToast(data.message, "error");
        }
    })
    .catch(err => {
        console.error("Error updating stock:", err);
        showToast("Lỗi kết nối máy chủ!", "error");
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
