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
        <form action="<?= url('user/update') ?>" method="POST" enctype="multipart/form-data" class="modal-form">
            <div class="form-group">
                <label for="avatar">Ảnh đại diện</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
            </div>
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
