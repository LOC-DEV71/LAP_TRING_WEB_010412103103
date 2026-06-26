<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Trang cá nhân') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;family=Raleway:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <style>
        /* CSS Reset & Variable Tokens */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Raleway', sans-serif;
        }

        :root {
            --primary: #000000;
            --background: #fdf8f8;
            --on-background: #1c1b1b;
            --on-surface-variant: #444748;
            --secondary-fixed: #e1e0ff;
            --on-secondary-fixed: #06006c;
            --success-indigo: #4648d4;
            --error-red: #ba1a1a;
            --error-container: #ffdad6;
            --glass-surface: rgba(255, 255, 255, 0.35);
            --glass-border-light: rgba(255, 255, 255, 0.5);
            --glass-border-dark: rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--background);
            color: var(--on-background);
            background-image: 
                radial-gradient(at 0% 0%, rgba(70, 72, 212, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(186, 26, 26, 0.02) 0px, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* Fixed Navigation Header */
        .header-nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 50;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-bottom: 1px solid var(--glass-border-dark);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease-in-out;
        }

        .nav-container {
            max-width: 1000px;
            margin: 0 auto;
            height: 64px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
        }

        .brand-logo {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
        }

        .brand-logo a {
            color: var(--primary);
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            gap: 24px;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            color: var(--on-surface-variant);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary);
            font-weight: 600;
        }

        /* Ethereal Banner Strip */
        .banner-strip {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 600px;
            z-index: 0;
            overflow: hidden;
        }

        .banner-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            brightness: 0.9;
            opacity: 0.7;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 70%, rgba(0,0,0,0.6) 85%, rgba(0,0,0,0) 100%);
            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 70%, rgba(0,0,0,0.6) 85%, rgba(0,0,0,0) 100%);
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, rgba(253, 248, 248, 0.2) 60%, rgba(253, 248, 248, 0.9) 100%);
        }

        /* Main Content Grid Wrapper */
        .main-content {
            padding-top: 112px;
            padding-left: 16px;
            padding-right: 16px;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        /* Premium Glass Panel */
        .glass-panel {
            background: var(--glass-surface);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border-light);
            border-bottom: 1px solid var(--glass-border-dark);
            border-right: 1px solid var(--glass-border-dark);
            border-radius: 24px;
            box-shadow: inset 1px 1px 0px rgba(255, 255, 255, 0.6);
            transition: box-shadow 0.3s ease;
        }

        .glass-panel:hover {
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.12), inset 1px 1px 0px rgba(255, 255, 255, 0.6);
        }

        /* Profile Header Card Layout */
        .profile-header-section {
            padding: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 32px;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.08), inset 1px 1px 0px rgba(255, 255, 255, 0.6);
        }

        .avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .avatar-circle {
            width: 128px;
            height: 128px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #ffffff;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle span {
            font-size: 72px;
            color: #d1d5db;
        }

        .badge-verified {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: var(--primary);
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
        }

        .badge-verified span {
            font-size: 18px;
            font-variation-settings: 'FILL' 1;
        }

        .profile-info {
            flex-grow: 1;
            text-align: center;
        }

        .profile-fullname {
            font-family: 'Inter', sans-serif;
            font-size: 32px;
            line-height: 1.2;
            letter-spacing: -0.02em;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .badge-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .badge-membership {
            background-color: var(--secondary-fixed);
            color: var(--on-secondary-fixed);
            padding: 4px 12px;
            border-radius: 9999px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 400;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-membership span {
            font-size: 14px;
            font-variation-settings: 'FILL' 1;
        }

        .registration-date {
            color: var(--on-surface-variant);
            font-size: 16px;
            font-weight: 400;
        }

        /* Profile Details Grid */
        .profile-details-grid {
            margin-top: 16px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            text-align: left;
            border-top: 1px solid var(--glass-border-dark);
            padding-top: 16px;
            font-size: 14px;
            color: var(--on-surface-variant);
        }

        .profile-details-grid p strong {
            color: var(--on-background);
            font-weight: 600;
        }

        .action-button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .btn-action {
            width: 100%;
            padding: 12px 24px;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.8;
        }

        .btn-outline-danger {
            background: var(--glass-surface);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border-dark);
            color: var(--error-red);
        }

        .btn-outline-danger:hover {
            background-color: rgba(186, 26, 26, 0.1);
        }

        /* Stats Grid Layout */
        .dashboard-stats {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .stat-box {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.08), inset 1px 1px 0px rgba(255, 255, 255, 0.6);
        }

        .stat-box:hover {
            transform: scale(1.02);
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .stat-icon-wrapper span {
            font-size: 24px;
        }

        .stat-label-title {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: var(--on-surface-variant);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 4px;
        }

        .stat-numeric-value {
            font-family: 'Inter', sans-serif;
            font-size: 24px;
            font-weight: 500;
            color: var(--primary);
            line-height: 1;
        }

        /* Section Typography & Links */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-heading-title {
            font-family: 'Inter', sans-serif;
            font-size: 24px;
            font-weight: 500;
            color: var(--primary);
        }

        .link-discover {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            outline: none;
            color: var(--on-surface-variant);
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.3s;
        }

        .link-discover:hover {
            color: var(--primary);
        }

        .link-discover span {
            font-size: 16px;
        }

        /* Table Design */
        .orders-table-wrapper {
            overflow-x: auto;
            border-radius: 24px;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.08), inset 1px 1px 0px rgba(255, 255, 255, 0.6);
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .orders-table th {
            padding: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: var(--on-surface-variant);
            border-bottom: 1px solid var(--glass-border-dark);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .orders-table td {
            padding: 20px;
            font-size: 16px;
            font-weight: 300;
            border-bottom: 1px solid var(--glass-border-dark);
        }

        .orders-table tr {
            transition: background-color 0.3s;
        }

        .orders-table tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .order-id-cell {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 500;
            color: var(--primary);
        }

        .order-status-badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 400;
            display: inline-block;
        }

        .status-shipping {
            background-color: rgba(70, 72, 212, 0.1);
            color: var(--success-indigo);
        }

        .status-completed {
            background-color: rgba(0, 0, 0, 0.05);
            color: var(--primary);
        }

        .order-total-price {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            text-align: right;
            color: var(--primary);
        }

        .empty-orders {
            padding: 40px;
            text-align: center;
            color: var(--on-surface-variant);
            font-weight: 300;
        }

        /* Favorites Grid System */
        .favorites-row-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .product-item-card {
            cursor: pointer;
        }

        .product-img-wrapper {
            position: relative;
            aspect-ratio: 3/4;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 12px;
            box-shadow: inset 1px 1px 0px rgba(255, 255, 255, 0.6);
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .product-item-card:hover .product-img-wrapper img {
            transform: scale(1.1);
        }

        .btn-heart-remove {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--error-red);
            border: none;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .btn-heart-remove:hover {
            transform: scale(1.1);
        }

        .btn-heart-remove span {
            font-size: 20px;
            font-variation-settings: 'FILL' 1;
        }

        .product-card-title {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: var(--primary);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card-price {
            font-size: 12px;
            color: var(--on-surface-variant);
        }

        /* Mobile Responsive Bottom Nav */
        .bottom-nav-mobile {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 440px;
            z-index: 50;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 72px;
            background: var(--glass-surface);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-top: 1px solid var(--glass-border-light);
            box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
        }

        .bottom-nav-mobile a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--on-surface-variant);
            padding-top: 8px;
            transition: color 0.2s;
        }

        .bottom-nav-mobile a:hover,
        .bottom-nav-mobile a.active {
            color: var(--primary);
            font-weight: 700;
        }

        .bottom-nav-mobile a.active {
            border-top: 2px solid var(--primary);
        }

        .bottom-nav-mobile span {
            font-size: 24px;
        }

        .bottom-nav-mobile .nav-text {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 400;
            margin-top: 2px;
        }

        /* Media Queries for Desktop layout changes */
        @media (min-width: 640px) {
            .profile-header-section {
                flex-direction: row;
                padding: 48px;
            }

            .profile-info {
                text-align: left;
            }

            .badge-container {
                justify-content: flex-start;
            }

            .profile-details-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px 24px;
            }

            .action-button-group {
                width: auto;
            }

            .dashboard-stats {
                grid-template-columns: repeat(3, 1fr);
            }

            .favorites-row-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 768px) {
            .avatar-circle {
                width: 160px;
                height: 160px;
            }

            .bottom-nav-mobile {
                display: none;
            }
        }
    </style>
</head>
<body class="pb-24">
    <!-- TopNavBar -->
    <header class="header-nav">
        <div class="nav-container">
            <div class="brand-logo">
                <a href="<?= url('') ?>">FASHION</a>
            </div>
            <ul class="nav-menu">
                <li><a href="<?= url('') ?>">Trang chủ</a></li>
                <li><a href="<?= url('cart') ?>">Giỏ hàng</a></li>
                <li><a href="<?= url('user/profile') ?>" class="active">Tôi</a></li>
            </ul>
        </div>
    </header>

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
</body>
</html>
