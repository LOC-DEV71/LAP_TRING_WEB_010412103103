<?php require_once __DIR__ . '/../../../layouts/client/header/header.php'; ?>
<link rel="stylesheet" href="<?= asset('css/client/User/profile.css') ?>">

<div class="profile-page-wrapper" style="position: relative; min-height: 100vh; overflow: hidden;">

    <!-- Banner Strip Background -->
    <div class="banner-strip">
        <img alt="Banner background" class="banner-img" src="https://images.unsplash.com/photo-1600091166886-c7a68d63d5cb?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
        <div class="banner-overlay"></div>
    </div>

    <!-- Main Container -->
    <main class="main-content">
        <!-- Profile Header -->
        <section class="glass-panel profile-header-section">
            <div class="avatar-wrapper">
                <div class="avatar-circle">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div class="badge-verified">
                    <span class="material-symbols-outlined">verified</span>
                </div>
            </div>
            <div class="profile-info">
                <h1 class="profile-fullname"><?= htmlspecialchars($user['fullname']) ?></h1>
                <div class="badge-container">
                    <span class="badge-membership">
                        <span class="material-symbols-outlined">workspace_premium</span>
                        Thành viên Bạc
                    </span>
                    <span class="registration-date">Tài khoản hoạt động</span>
                </div>
                <div class="profile-details-grid">
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars(!empty($user['phone']) ? $user['phone'] : 'Chưa cập nhật') ?></p>
                    <p style="grid-column: span 2;"><strong>Địa chỉ:</strong> <?= htmlspecialchars(!empty($user['address']) ? $user['address'] : 'Chưa cập nhật') ?></p>
                </div>
            </div>
            <div class="action-button-group">
                <button class="btn-action btn-primary">
                    <span class="material-symbols-outlined">edit</span>
                    Sửa hồ sơ
                </button>
                <a href="<?= url('auth/logout') ?>" class="btn-action btn-outline-danger">
                    <span class="material-symbols-outlined">logout</span>
                    Đăng xuất
                </a>
            </div>
        </section>

        <!-- Dashboard Thống kê -->
        <section class="dashboard-stats">
            <div class="glass-panel stat-box">
                <div class="stat-icon-wrapper">
                    <span class="material-symbols-outlined">local_shipping</span>
                </div>
                <div>
                    <p class="stat-label-title">Đơn hàng</p>
                    <p class="stat-numeric-value"><?= count($orders) ?></p>
                </div>
            </div>
            <div class="glass-panel stat-box">
                <div class="stat-icon-wrapper">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <div>
                    <p class="stat-label-title">Yêu thích</p>
                    <p class="stat-numeric-value">2</p>
                </div>
            </div>
            <div class="glass-panel stat-box">
                <div class="stat-icon-wrapper">
                    <span class="material-symbols-outlined">confirmation_number</span>
                </div>
                <div>
                    <p class="stat-label-title">Voucher</p>
                    <p class="stat-numeric-value">0</p>
                </div>
            </div>
        </section>

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
                                <tr>
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
                                    <td class="order-total-price"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
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

        <!-- Danh sách yêu thích -->
        <section class="favorites-section">
            <div class="section-header">
                <h2 class="section-heading-title">Sản phẩm yêu thích</h2>
                <button class="link-discover">
                    Khám phá thêm <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
            <div class="favorites-row-grid">
                <!-- Product 1 -->
                <div class="product-item-card">
                    <div class="product-img-wrapper">
                        <img alt="Silk Evening Blazer" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAb_K8V2C2tj8UJrSJHoiuj5_qb3Su6zNZghJDxu2JXwpjfXRGS79-bBob5IH1TzSFY4L8fSo0zEnXzm3yes8i6LdJY4qbKX4DMF31fuJVFPbuWydwKywAe5uzyGjvVkZW4TNczpU-YNZx-OVDrY7387ffD2L9DJpbVG0kEIjM4nszx9lloAVYgUSwRFd2mzkE5nUWXcJeA_mrRsFwMHoEtCnpstGwSCdvFXNdHM8AkZ48MjSi8-48mOsWS8VH2zDaJlGu1vg5GsTvG"/>
                        <button class="btn-heart-remove">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <h3 class="product-card-title">Silk Evening Blazer</h3>
                    <p class="product-card-price">4.250.000đ</p>
                </div>
                <!-- Product 2 -->
                <div class="product-item-card">
                    <div class="product-img-wrapper">
                        <img alt="Cashmere Essential" src="https://lh3.googleusercontent.com/aida-public/AB6AXuByZILhUr2_IJzhlL6_jK721_F06TBMxl3Bayn0wx_88kgoTxaVWal3bURRKcf8cR96yEukm5Ptf6IDv4HN89ChfEjZ6-VA51OTPHvBDkCVWw272l2klnbmuKFTnAOK-rrbX55AgGhok54TsfxX5Xtvx6oeS1BlqcmEEZU3umL1If-81STLPcrpz6WsHOcfR_3SBszBM9KavmErV_LIUMAGK2d-1OLf1yXRPmTWpErrjIbzznMAbphSNn59JZacudM_xXjlJsswkLJ6"/>
                        <button class="btn-heart-remove">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <h3 class="product-card-title">Cashmere Essential</h3>
                    <p class="product-card-price">3.100.000đ</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Mobile Bottom Nav -->
    <nav class="bottom-nav-mobile">
        <a href="<?= url('') ?>">
            <span class="material-symbols-outlined">storefront</span>
            <span class="nav-text">Shop</span>
        </a>
        <a href="<?= url('cart') ?>">
            <span class="material-symbols-outlined">local_mall</span>
            <span class="nav-text">Giỏ hàng</span>
        </a>
        <a href="<?= url('user/profile') ?>" class="active">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
            <span class="nav-text">Tôi</span>
        </a>
    </nav>
</div>
<?php require_once __DIR__ . '/../../../layouts/client/footer.php'; ?>
