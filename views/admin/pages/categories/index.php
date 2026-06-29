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
    <?php require_once __DIR__ . '/category_modal.php'; ?>

    <script>
    (function() {
        window.openCreateModal = function() {
            const modalTitle = document.getElementById('modalTitle');
            const categoryForm = document.getElementById('categoryForm');
            const titleInput = document.getElementById('title');
            const positionInput = document.getElementById('position');
            const statusInput = document.getElementById('status');

            if (modalTitle) modalTitle.textContent = "Thêm Danh Mục Mới";
            if (categoryForm) categoryForm.action = "<?= url('admin/categories/store') ?>";
            if (titleInput) titleInput.value = "";
            if (positionInput) positionInput.value = "0";
            
            // Cập nhật giá trị và giao diện cho Custom Dropdown
            if (statusInput) statusInput.value = "active";
            const statusDropdown = document.getElementById('status-dropdown');
            if (statusDropdown) {
                const selectedVal = statusDropdown.querySelector('.selected-value');
                if (selectedVal) selectedVal.textContent = "Hiển thị (Active)";
                statusDropdown.querySelectorAll('.dropdown-options li').forEach(li => {
                    if (li.getAttribute('data-value') === 'active') {
                        li.classList.add('active');
                    } else {
                        li.classList.remove('active');
                    }
                });
            }
            
            openModal('categoryModal');
        }

        window.openEditModal = function(cat) {
            const modalTitle = document.getElementById('modalTitle');
            const categoryForm = document.getElementById('categoryForm');
            const titleInput = document.getElementById('title');
            const positionInput = document.getElementById('position');
            const statusInput = document.getElementById('status');

            if (modalTitle) modalTitle.textContent = "Chỉnh Sửa Danh Mục";
            if (categoryForm) categoryForm.action = "<?= url('admin/categories/update/') ?>" + cat._id;
            if (titleInput) titleInput.value = cat.title || "";
            if (positionInput) positionInput.value = cat.position !== undefined ? cat.position : "0";
            
            // Cập nhật giá trị và giao diện cho Custom Dropdown
            const currentStatus = cat.status || "active";
            if (statusInput) statusInput.value = currentStatus;
            
            const statusDropdown = document.getElementById('status-dropdown');
            if (statusDropdown) {
                const text = currentStatus === 'active' ? "Hiển thị (Active)" : "Ẩn (Inactive)";
                const selectedVal = statusDropdown.querySelector('.selected-value');
                if (selectedVal) selectedVal.textContent = text;
                
                statusDropdown.querySelectorAll('.dropdown-options li').forEach(li => {
                    if (li.getAttribute('data-value') === currentStatus) {
                        li.classList.add('active');
                    } else {
                        li.classList.remove('active');
                    }
                });
            }
            
            openModal('categoryModal');
        }

        window.stepUp = function() {
            const input = document.getElementById('position');
            if (input) {
                input.value = parseInt(input.value || 0) + 1;
            }
        }

        window.stepDown = function() {
            const input = document.getElementById('position');
            if (input) {
                const val = parseInt(input.value || 0);
                if (val > 0) {
                    input.value = val - 1;
                }
            }
        }
    })();
    </script>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
