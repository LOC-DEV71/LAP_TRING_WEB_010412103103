<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Tổng Quan Hệ Thống';
        $page_subtitle = 'Số liệu thống kê chi tiết hoạt động kinh doanh cửa hàng.';
        $create_button_url = url('admin/products/create');
        $create_button_text = 'Thêm Sản Phẩm';
        require __DIR__ . '/../../layouts/page_header.php';
        ?>
        
        <!-- Product Statistics Row -->
        <div class="stats-grid">
            <!-- Stat 1: Total Sales -->
            <div class="stat-card">
                <div class="stat-details">
                    <p class="stat-label">Tổng Doanh Thu</p>
                    <div class="stat-value-wrapper">
                        <h3 class="stat-value"><?= number_format($totalSales ?? 0, 0, ',', '.') ?>đ</h3>
                    </div>
                    <div>
                        <span class="meta-tag success">Thực tế nhận</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper success" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71;">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>
            <!-- Stat 2: Total Orders -->
            <div class="stat-card">
                <div class="stat-details">
                    <p class="stat-label">Tổng Đơn Hàng</p>
                    <div class="stat-value-wrapper">
                        <h3 class="stat-value"><?= number_format($totalOrders ?? 0) ?></h3>
                    </div>
                    <div>
                        <span class="meta-tag info">Đã phát sinh</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper info" style="background: rgba(52, 152, 219, 0.15); color: #3498db;">
                    <span class="material-symbols-outlined">shopping_bag</span>
                </div>
            </div>
            <!-- Stat 3: Total Products -->
            <div class="stat-card">
                <div class="stat-details">
                    <p class="stat-label">Tổng Sản Phẩm</p>
                    <div class="stat-value-wrapper">
                        <h3 class="stat-value"><?= number_format($totalProducts ?? 0) ?></h3>
                    </div>
                    <div>
                        <span class="meta-tag">Hoạt động</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <span class="material-symbols-outlined">inventory_2</span>
                </div>
            </div>
            <!-- Stat 4: Low Stock Alerts -->
            <div class="stat-card border-alert">
                <div class="stat-details">
                    <p class="stat-label">Cảnh Báo Hết Hàng</p>
                    <div class="stat-value-wrapper">
                        <h3 class="stat-value"><?= number_format($lowStockAlerts ?? 0) ?></h3>
                    </div>
                    <div>
                        <span class="meta-tag danger">Cần nhập kho</span>
                    </div>
                </div>
                <div class="stat-icon-wrapper danger">
                    <span class="material-symbols-outlined">warning</span>
                </div>
            </div>
        </div>
        
        <!-- Recent Products Table Area -->
        <div class="flat-card">
            <div class="card-header">
                <div>
                    <h4>Sản Phẩm Gần Đây</h4>
                    <p>Danh sách sản phẩm được thêm hoặc cập nhật gần đây nhất.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Giá Cả</th>
                            <th>Trạng Thái</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentProducts)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có sản phẩm nào trong cơ sở dữ liệu.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentProducts as $product): ?>
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            <div class="product-icon">
                                                <span class="material-symbols-outlined">checkroom</span>
                                            </div>
                                            <span class="product-name"><?= htmlspecialchars($product['name'] ?? '') ?></span>
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
                                        <a href="<?= url('admin/products/edit/' . $product['_id']) ?>" class="btn btn-outline btn-icon" title="Chỉnh sửa"><span class="material-symbols-outlined" style="font-size: 18px;">edit</span></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer" style="justify-content: flex-end;">
                <a href="<?= url('admin/products') ?>" class="btn btn-primary btn-lg">
                    Xem tất cả sản phẩm <span class="material-symbols-outlined" style="vertical-align: middle; margin-left: 4px;">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
