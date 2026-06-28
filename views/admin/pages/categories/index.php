<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <?php 
        $page_title = 'Quản Lý Danh Mục';
        $page_subtitle = 'Quản lý các nhóm danh mục phân loại sản phẩm của hệ thống.';
        $create_button_onclick = 'openCreateModal()';
        $create_button_text = 'Thêm Danh Mục Mới';
        require __DIR__ . '/../../layouts/page_header.php';
        ?>

        <!-- Recent Products Table Area -->
        <div class="flat-card">
            <div class="card-header">
                <div>
                    <h4>Danh Sách Danh Mục</h4>
                    <p>Quản lý phân loại sản phẩm.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên Danh Mục</th>
                            <th>Đường Dẫn (Slug)</th>
                            <th>Trạng Thế</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #848484; padding: 40px;">
                                    Chưa có danh mục nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td style="font-weight: 700; width: 80px;"><?= htmlspecialchars($cat['position'] ?? 0) ?></td>
                                    <td>
                                        <span style="font-weight: 700;"><?= htmlspecialchars($cat['title']) ?></span>
                                    </td>
                                    <td style="font-family: monospace; color: #5d5f5f;"><?= htmlspecialchars($cat['slug']) ?></td>
                                    <td>
                                        <?php if (($cat['status'] ?? 'active') === 'active'): ?>
                                            <span class="badge badge-success">Kích hoạt</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <button class="btn btn-outline btn-icon" onclick="openEditModal(<?= htmlspecialchars(json_encode($cat)) ?>)" title="Chỉnh sửa">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                        </button>
                                        <a href="<?= url('admin/categories/delete/' . $cat['_id']) ?>" class="btn btn-danger btn-icon" style="margin-left: 4px;" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?')" title="Xóa">
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

<!-- Modal Thêm Mới & Chỉnh Sửa Danh Mục -->
<div id="categoryModal" class="modal-overlay">
    <div class="modal-container">
        <form id="categoryForm" method="POST" action="">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm Danh Mục Mới</h3>
                <button type="button" class="btn-close-modal" onclick="closeModal('categoryModal')">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Tên Danh Mục</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Ví dụ: THỜI TRANG NAM" required>
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
                <button type="button" class="btn btn-outline" onclick="closeModal('categoryModal')">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu Lại</button>
            </div>
        </form>
    </div>
</div>

<script>
const categoryModal = document.getElementById('categoryModal');
const categoryForm = document.getElementById('categoryForm');
const modalTitle = document.getElementById('modalTitle');
const titleInput = document.getElementById('title');
const positionInput = document.getElementById('position');
const statusInput = document.getElementById('status');

function openCreateModal() {
    modalTitle.textContent = "Thêm Danh Mục Mới";
    categoryForm.action = "<?= url('admin/categories/store') ?>";
    titleInput.value = "";
    positionInput.value = "0";
    statusInput.value = "active";
    openModal('categoryModal');
}

function openEditModal(cat) {
    modalTitle.textContent = "Chỉnh Sửa Danh Mục";
    categoryForm.action = "<?= url('admin/categories/update/') ?>" + cat._id;
    titleInput.value = cat.title;
    positionInput.value = cat.position;
    statusInput.value = cat.status;
    openModal('categoryModal');
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
