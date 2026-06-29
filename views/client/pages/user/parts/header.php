<!-- Profile Header -->
<section class="glass-panel profile-header-section">
    <div class="profile-header-main">
        <div class="profile-header-flex-md">
            <div class="avatar-wrapper">
                <div class="avatar-circle">
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="<?= asset($user['avatar']) ?>" alt="Avatar" class="avatar-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <span class="material-symbols-outlined">person</span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($user['is_verified'])): ?>
                    <div class="badge-verified" title="Tài khoản đã xác thực">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h1 class="profile-fullname">
                    <?= htmlspecialchars($user['fullname']) ?>
                    <button class="btn-edit-icon" id="btn-edit-profile" title="Sửa hồ sơ">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                </h1>
                <div class="badge-container">
                    <span class="badge-membership">
                        <span class="material-symbols-outlined">workspace_premium</span>
                        Thành viên Bạc
                    </span>
                </div>
            </div>
            <div class="profile-action-right">
                <?php if (empty($user['is_verified'])): ?>
                    <a href="<?= url('user/sendVerification') ?>" class="btn-verify-email">
                        <span class="material-symbols-outlined">mail</span>
                        Xác thực thông tin
                    </a>
                <?php else: ?>
                    <span class="badge-verified-text">
                        <span class="material-symbols-outlined">verified</span>
                        Đã xác thực
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Detail Grid below border -->
    <div class="profile-details-grid-new">
        <div class="detail-item">
            <div class="detail-icon-wrapper">
                <span class="material-symbols-outlined">mail</span>
            </div>
            <div>
                <p class="detail-label">Email</p>
                <p class="detail-value"><?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-icon-wrapper">
                <span class="material-symbols-outlined">call</span>
            </div>
            <div>
                <p class="detail-label">Số điện thoại</p>
                <p class="detail-value"><?= htmlspecialchars(!empty($user['phone']) ? $user['phone'] : 'Chưa cập nhật') ?></p>
            </div>
        </div>
        <div class="detail-item detail-item-full">
            <div class="detail-icon-wrapper">
                <span class="material-symbols-outlined">location_on</span>
            </div>
            <div>
                <p class="detail-label">Địa chỉ</p>
                <p class="detail-value"><?= htmlspecialchars(!empty($user['address']) ? $user['address'] : 'Chưa cập nhật') ?></p>
            </div>
        </div>
    </div>
</section>
