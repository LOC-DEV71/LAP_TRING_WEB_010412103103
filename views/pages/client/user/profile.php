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
                    <button class="btn-edit-profile-compact" id="btn-edit-profile" title="Sửa hồ sơ">
                        <span class="material-symbols-outlined">edit</span>
                        Sửa hồ sơ
                    </button>
                </div>
                <div class="profile-details-grid">
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars(!empty($user['phone']) ? $user['phone'] : 'Chưa cập nhật') ?></p>
                    <p style="grid-column: span 2;"><strong>Địa chỉ:</strong> <?= htmlspecialchars(!empty($user['address']) ? $user['address'] : 'Chưa cập nhật') ?></p>
                </div>
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
                    <p class="stat-numeric-value" id="favorite-count"><?= count($likedProducts ?? []) ?></p>
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
                <?php if (!empty($likedProducts)): ?>
                    <?php foreach ($likedProducts as $product): ?>
                        <div class="product-item-card">
                            <div class="product-img-wrapper">
                                <a href="<?= url('products/detail/' . ($product['slug'] ?? '')) ?>">
                                    <img alt="<?= htmlspecialchars($product['title'] ?? $product['name'] ?? '') ?>" src="<?= strpos($product['thumbnail'] ?? $product['image'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail'] ?? $product['image'] ?? '') : asset(htmlspecialchars($product['thumbnail'] ?? $product['image'] ?? 'assets/images/placeholder.jpg')) ?>"/>
                                </a>
                                <button class="btn-heart-remove wishlist liked" data-id="<?= $product['_id'] ?>">
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; color: #d70018;">favorite</span>
                                </button>
                            </div>
                            <h3 class="product-card-title"><?= htmlspecialchars($product['title'] ?? $product['name'] ?? '') ?></h3>
                            <p class="product-card-price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px 20px;">Bạn chưa có sản phẩm yêu thích nào.</p>
                <?php endif; ?>
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
    <!-- Edit Profile Modal -->
    <div id="edit-profile-modal" class="modal-wrapper" style="display: none;">
        <div class="modal-overlay"></div>
        <div class="glass-panel modal-container">
            <div class="modal-header">
                <h3>Chỉnh sửa hồ sơ</h3>
                <button class="btn-close-modal">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="<?= url('user/update') ?>" method="POST" class="modal-form">
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <textarea id="address" name="address" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-outline btn-cancel">Hủy</button>
                    <button type="submit" class="btn-action btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('btn-edit-profile');
            const modal = document.getElementById('edit-profile-modal');
            const closeBtns = modal ? modal.querySelectorAll('.btn-close-modal, .btn-cancel') : [];
            const overlay = modal ? modal.querySelector('.modal-overlay') : null;

            if (editBtn && modal) {
                editBtn.addEventListener('click', function() {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });

                const closeModal = function() {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                };

                closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
                if (overlay) {
                    overlay.addEventListener('click', closeModal);
                }
            }

            // Trigger toasts from PHP Session
            <?php if (isset($_SESSION['profile_success'])): ?>
                showToast("<?= addslashes($_SESSION['profile_success']) ?>", 'success');
                <?php unset($_SESSION['profile_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['profile_error'])): ?>
                showToast("<?= addslashes($_SESSION['profile_error']) ?>", 'error');
                <?php unset($_SESSION['profile_error']); ?>
            <?php endif; ?>

            // Handle unliking from profile page
            const wishlistButtons = document.querySelectorAll('.wishlist');
            wishlistButtons.forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const productId = btn.getAttribute('data-id');
                    
                    try {
                        const apiUrl = '<?= url("products/toggleLike") ?>';
                        const response = await fetch(apiUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ product_id: productId })
                        });

                        if (response.status === 401) {
                            showToast("Vui lòng đăng nhập để thao tác.", 'error');
                            return;
                        }

                        const textResponse = await response.text();
                        let result;
                        try { result = JSON.parse(textResponse); } catch (e) { return; }

                        if (result.success) {
                            if (!result.liked) {
                                // Xóa thẻ sản phẩm khỏi giao diện
                                const card = btn.closest('.product-item-card');
                                if (card) card.remove();
                                
                                // Cập nhật số lượng
                                const countEl = document.getElementById('favorite-count');
                                if (countEl) {
                                    countEl.textContent = Math.max(0, parseInt(countEl.textContent) - 1);
                                }
                                showToast("Đã xóa khỏi danh sách yêu thích.", 'success');
                            }
                        } else {
                            showToast(result.message || "Lỗi xử lý", 'error');
                        }
                    } catch (err) {
                        console.error(err);
                        showToast("Có lỗi xảy ra", 'error');
                    }
                });
            });
        });
    </script>
</div>
<?php require_once __DIR__ . '/../../../layouts/client/footer.php'; ?>
