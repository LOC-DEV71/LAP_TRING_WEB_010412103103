<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Quản Lý Sản Phẩm';
        $page_subtitle = 'Thêm mới, sửa đổi hoặc cấu hình danh sách sản phẩm cửa hàng.';
        $show_import_csv = true;
        $create_button_url = url('admin/products/create');
        $create_button_text = 'Thêm Sản Phẩm';
        require __DIR__ . '/../../layouts/page_header.php';
        ?>

        <!-- Recent Products Table Area -->
        <div class="flat-card">
            <div class="card-header">
                <div>
                    <h4>Tất Cả Sản Phẩm</h4>
                    <p>Danh sách tất cả các mặt hàng hiện có.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <!-- Hàng đầu -->
                        <tr>
                            <th class="col-expand">Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Giá Cả</th>
                            <th>Trạng Thái</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <!-- Hàng thứ hai (nội dung bảng) -->
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có sản phẩm nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            <div class="product-icon">
                                                <span class="material-symbols-outlined">checkroom</span>
                                            </div>
                                            <span class="product-name"><?= htmlspecialchars($product['title'] ?? '') ?></span>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?></td>
                                    <td style="font-weight: 700;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</td>
                                    <td>
                                        <?php if (($product['status'] ?? 'active') === 'active'): ?>
                                            <span class="badge badge-success">Hiển thị</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <!-- Nút chỉnh sửa -->
                                        <a href="<?= url('admin/products/edit/' . $product['_id']) ?>" class="btn btn-outline btn-icon" title="Chỉnh sửa"><span class="material-symbols-outlined" style="font-size: 18px;">edit</span></a>
                                        <!-- Nút xóa -->
                                        <a href="<?= url('admin/products/delete/' . $product['_id']) ?>" class="btn btn-danger btn-icon" style="margin-left: 4px;" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')" title="Xóa"><span class="material-symbols-outlined" style="font-size: 18px;">delete</span></a>
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

<!-- Modal Nhập CSV -->
<div id="csvImportModal" class="modal-overlay">
    <div class="modal-container">
        <form action="<?= url('admin/products/import-csv') ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h3>Nhập sản phẩm từ file CSV</h3>
                <button type="button" class="btn-close-modal" onclick="closeModal('csvImportModal')">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="csv_file">Chọn tệp CSV</label>
                    <input type="file" id="csv_file" name="csv_file" class="form-control" accept=".csv" required>
                </div>
                <p style="font-size: 12px; color: #848484; margin-top: 8px;">
                    Tải về tệp mẫu CSV: <a href="<?= asset('templates/products_import_template.csv') ?>" style="color: #000; font-weight: 700; text-decoration: underline;">Tải xuống tại đây</a>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('csvImportModal')">Hủy</button>
                <button type="submit" class="btn btn-primary">Tải lên & Nhập</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
