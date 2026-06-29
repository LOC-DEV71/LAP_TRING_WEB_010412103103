<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <div class="main-header">
            <div class="header-title">
                <h2>Quản Lý Menu (Navbar)</h2>
                <p>Quản lý các liên kết trên thanh điều hướng đầu trang của khách hàng.</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="openCreateModal()">
                    <span class="material-symbols-outlined">add</span> Thêm Menu Mới
                </button>
            </div>
        </div>

        <!-- Recent Products Table Area -->
        <div class="flat-card">
            <div class="card-header">
                <div>
                    <h4>Thanh Điều Hướng Khách Hàng</h4>
                    <p>Các mục hiển thị ngoài trang chủ.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tiêu Đề</th>
                            <th>Liên Kết (Link)</th>
                            <th>Trạng Thái</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($menus)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có mục menu nào được tạo.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($menus as $menu): ?>
                                <tr>
                                    <td style="font-weight: 700; width: 80px;"><?= htmlspecialchars($menu['position']) ?></td>
                                    <td style="font-weight: 700;"><?= htmlspecialchars($menu['title']) ?></td>
                                    <td style="font-family: monospace; color: #5d5f5f;"><?= htmlspecialchars($menu['link']) ?></td>
                                    <td>
                                        <?php if ($menu['status'] === 'active'): ?>
                                            <span class="badge badge-success">Hiển thị</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <button class="btn btn-outline btn-icon" onclick="openEditModal(<?= htmlspecialchars(json_encode($menu)) ?>)" title="Chỉnh sửa">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                        <a href="<?= url('admin/navbar/delete/' . $menu['_id']) ?>" class="btn btn-danger btn-icon" style="margin-left: 4px;" onclick="return confirm('Bạn chắc chắn muốn xóa menu này?')" title="Xóa">
                                            <span class="material-symbols-outlined">delete</span>
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

<!-- Modal Thêm Mới & Chỉnh Sửa -->
<div id="menuModal" class="modal-overlay">
    <div class="modal-container">
        <form id="menuForm" method="POST" action="">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm Menu Mới</h3>
                <button type="button" class="btn-close-modal" onclick="closeModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Tiêu Đề Menu</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Ví dụ: KHUYẾN MÃI" required>
                </div>
                <div class="form-group">
                    <label for="link">Đường Dẫn (Link)</label>
                    <input type="text" id="link" name="link" class="form-control" placeholder="Ví dụ: products/sale" required>
                </div>
                <div class="form-group">
                    <label for="position">Thứ tự hiển thị</label>
                    <input type="number" id="position" name="position" class="form-control" value="0" min="0" required>
                </div>
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active">Hiển thị (Active)</option>
                        <option value="inactive">Ẩn (Inactive)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu Lại</button>
            </div>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('menuModal');
const menuForm = document.getElementById('menuForm');
const modalTitle = document.getElementById('modalTitle');
const titleInput = document.getElementById('title');
const linkInput = document.getElementById('link');
const positionInput = document.getElementById('position');
const statusInput = document.getElementById('status');

function openCreateModal() {
    modalTitle.textContent = "Thêm Menu Mới";
    menuForm.action = "<?= url('admin/navbar/store') ?>";
    titleInput.value = "";
    linkInput.value = "";
    positionInput.value = "0";
    statusInput.value = "active";
    modal.classList.add('open');
}

function openEditModal(menu) {
    modalTitle.textContent = "Chỉnh Sửa Menu";
    menuForm.action = "<?= url('admin/navbar/update/') ?>" + menu._id;
    titleInput.value = menu.title;
    linkInput.value = menu.link;
    positionInput.value = menu.position;
    statusInput.value = menu.status;
    modal.classList.add('open');
}

function closeModal() {
    modal.classList.remove('open');
}

// Đóng modal khi click ra ngoài
window.onclick = function(event) {
    if (event.target === modal) {
        closeModal();
    }
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
