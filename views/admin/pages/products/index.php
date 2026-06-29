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
                             <th class="text-right">Thao Tác</th>
                        </tr>
                    </thead>
                    <!-- Hàng thứ hai (nội dung bảng) -->
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted p-40">
                                    Chưa có sản phẩm nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td class="col-expand">
                                        <div class="product-cell">
                                            <div class="product-icon">
                                                <span class="material-symbols-outlined">checkroom</span>
                                            </div>
                                            <span class="product-name"><?= htmlspecialchars($product['title'] ?? '') ?></span>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?></td>
                                    <td class="fw-bold"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</td>
                                    <td>
                                        <?php if (($product['status'] ?? 'active') === 'active'): ?>
                                            <span class="badge badge-success">Hiển thị</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <!-- Nút chỉnh sửa -->
                                        <a href="<?= url('admin/products/edit/' . $product['_id']) ?>" class="btn btn-outline btn-icon" title="Chỉnh sửa"><span class="material-symbols-outlined" style="font-size: 18px;">edit</span></a>
                                        <!-- Nút xóa -->
                                        <a href="<?= url('admin/products/delete/' . $product['_id']) ?>" class="btn btn-danger btn-icon ml-4" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')" title="Xóa"><span class="material-symbols-outlined" style="font-size: 18px;">delete</span></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Nhập CSV Dùng Chung -->
        <?php require_once __DIR__ . '/../../layouts/csv_import_modal.php'; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
