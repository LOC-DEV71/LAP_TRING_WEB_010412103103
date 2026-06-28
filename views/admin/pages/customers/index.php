<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Quản Lý Khách Hàng';
        $page_subtitle = 'Xem và quản lý thông tin tài khoản khách hàng đăng ký mua sắm trên hệ thống.';
        require __DIR__ . '/../../layouts/page_header.php';
        ?>

        <!-- Recent Products Table Area -->
        <div class="flat-card">
            <div class="card-header">
                <div>
                    <h4>Danh Sách Khách Hàng</h4>
                    <p>Quản lý cơ sở dữ liệu khách hàng.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-expand">Họ và Tên</th>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Địa Chỉ</th>
                            <th>Xác Minh</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($customers)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có khách hàng nào đăng ký.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($customers as $c): ?>
                                <tr>
                                    <td style="font-weight: 700;"><?= htmlspecialchars($c['fullname']) ?></td>
                                    <td><?= htmlspecialchars($c['email']) ?></td>
                                    <td><?= htmlspecialchars($c['phone'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($c['address'] ?? 'Chưa cập nhật') ?></td>
                                    <td>
                                        <?php if ($c['is_verified']): ?>
                                            <span class="badge badge-success">Đã xác minh</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Chưa xác minh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <!-- Khóa/Mở khóa tài khoản -->
                                        <a href="<?= url('admin/customers/toggle/' . $c['_id']) ?>" class="btn btn-outline btn-icon" title="<?= $c['is_verified'] ? 'Khóa tài khoản' : 'Mở khóa tài khoản' ?>">
                                            <span class="material-symbols-outlined" style="font-size: 18px;"><?= $c['is_verified'] ? 'block' : 'check_circle' ?></span>
                                        </a>
                                        <!-- Xóa tài khoản -->
                                        <a href="<?= url('admin/customers/delete/' . $c['_id']) ?>" class="btn btn-danger btn-icon" style="margin-left: 4px;" onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản khách hàng này?')" title="Xóa">
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

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
