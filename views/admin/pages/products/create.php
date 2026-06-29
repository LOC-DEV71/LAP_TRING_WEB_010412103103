<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <div class="main-header">
            <div class="header-title">
                <h2>Thêm Sản Phẩm Mới</h2>
                <p>Tạo sản phẩm mới đi kèm hình ảnh và các biến thể tùy chọn.</p>
            </div>
            <div class="header-actions">
                <a href="<?= url('admin/products') ?>" class="btn btn-outline">Hủy bỏ</a>
            </div>
        </div>

        <!-- Form Container -->
        <div class="flat-card p-32">
            <form action="<?= url('admin/products/store') ?>" method="POST" enctype="multipart/form-data" novalidate>
                <div class="admin-form-layout">
                    
                    <!-- Cột trái: Thông tin cơ bản & Biến thể -->
                    <div class="admin-form-column">
                        
                        <!-- Thông tin cơ bản -->
                        <div>
                            <div class="admin-form-section-header">
                                <h3 class="admin-form-section-title">Thông Tin Cơ Bản</h3>
                            </div>
                            
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: Áo khoác Bomber GearX" required>
                            </div>

                            <div class="admin-form-row-2col" style="grid-template-columns: 1fr 1fr 1fr;">
                                <div class="form-group">
                                    <label for="price">Giá bán gốc (VNĐ)</label>
                                    <input type="text" id="price" name="price" class="form-control fw-bold" placeholder="Ví dụ: 350.000đ" required>
                                </div>
                                <div class="form-group">
                                    <label for="price_sale">Giá sale (VNĐ)</label>
                                    <input type="text" id="price_sale" name="price_sale" class="form-control fw-bold" placeholder="Ví dụ: 290.000đ (không bắt buộc)">
                                </div>
                                 <div class="form-group">
                                    <label for="category_id">Danh mục</label>
                                    <div class="admin-custom-dropdown" id="category-dropdown">
                                        <button type="button" class="dropdown-trigger">
                                            <span class="selected-value">-- Chọn danh mục --</span>
                                            <span class="material-symbols-outlined arrow-icon">expand_more</span>
                                        </button>
                                        <ul class="dropdown-options">
                                            <li data-value="">-- Chọn danh mục --</li>
                                            <?php foreach ($categories as $cat): ?>
                                                <li data-value="<?= htmlspecialchars($cat['_id']) ?>"><?= htmlspecialchars($cat['title']) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <input type="hidden" id="category_id" name="category_id" value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <textarea id="description" name="description" class="form-control" rows="6" placeholder="Mô tả chi tiết về sản phẩm, chất liệu, hướng dẫn bảo quản..."></textarea>
                            </div>
                        </div>

                        <!-- Cấu hình biến thể -->
                        <div>
                            <div class="admin-form-section-header">
                                <h3 class="admin-form-section-title">Biến Thể Sản Phẩm</h3>
                                <button type="button" class="btn btn-outline" onclick="addVariantRow()">
                                    <span class="material-symbols-outlined">add</span> Thêm biến thể
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="admin-table" id="variantsTable">
                                    <thead>
                                        <tr>
                                            <th class="p-10-16">Màu sắc</th>
                                            <th class="p-10-16">Kích thước</th>
                                            <th class="p-10-16">Mã SKU</th>
                                            <th class="p-10-16">Số lượng kho</th>
                                            <th class="p-10-16 text-right">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantsBody">
                                        <!-- Hàng mặc định đầu tiên -->
                                        <tr>
                                            <td class="p-12-16">
                                                <input type="text" name="variants[0][color]" class="form-control" placeholder="Đen, Trắng..." required>
                                            </td>
                                            <td class="p-12-16">
                                                <input type="text" name="variants[0][size]" class="form-control" placeholder="S, M, L..." required>
                                            </td>
                                            <td class="p-12-16">
                                                <input type="text" name="variants[0][sku]" class="form-control" placeholder="Mã SKU định danh" required>
                                            </td>
                                            <td class="p-12-16">
                                                <input type="number" name="variants[0][stock]" class="form-control" placeholder="0" min="0" required>
                                            </td>
                                            <td class="p-12-16 text-right">
                                                <button type="button" class="btn btn-danger btn-icon" onclick="removeVariantRow(this)">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Cột phải: Hình ảnh & Trạng thái -->
                        <!-- Trạng thái & Hình ảnh đại diện (Gộp chung 1 Card) -->
                        <div class="flat-card p-24" style="overflow: visible;">
                            <h4 class="mb-16">Thiết Lập & Hình Ảnh</h4>
                            
                            <div class="form-group">
                                <label for="status">Hiển thị</label>
                                <div class="admin-custom-dropdown" id="status-dropdown">
                                    <button type="button" class="dropdown-trigger">
                                        <span class="selected-value">Hiển thị công khai</span>
                                        <span class="material-symbols-outlined arrow-icon">expand_more</span>
                                    </button>
                                    <ul class="dropdown-options">
                                        <li data-value="active" class="active">Hiển thị công khai</li>
                                        <li data-value="inactive">Tạm ẩn</li>
                                    </ul>
                                    <input type="hidden" id="status" name="status" value="active">
                                </div>
                            </div>

                            <div class="form-group mb-24">
                                <label for="featured">Sản phẩm nổi bật</label>
                                <div class="admin-custom-dropdown" id="featured-dropdown">
                                    <button type="button" class="dropdown-trigger">
                                        <span class="selected-value">Không</span>
                                        <span class="material-symbols-outlined arrow-icon">expand_more</span>
                                    </button>
                                    <ul class="dropdown-options">
                                        <li data-value="no" class="active">Không</li>
                                        <li data-value="yes">Có</li>
                                    </ul>
                                    <input type="hidden" id="featured" name="featured" value="no">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh đại diện</label>
                                <div class="admin-upload-zone" onclick="document.getElementById('image').click()" style="cursor: pointer;">
                                    <input type="file" id="image" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)" required>
                                    <div id="uploadPlaceholder">
                                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 8px;">upload_file</span>
                                        <p class="fw-bold" style="font-size: 13px; color: var(--text-secondary);">Nhấp để tải ảnh lên</p>
                                        <p class="text-muted" style="font-size: 11px; margin-top: 4px;">Hỗ trợ định dạng JPG, PNG, WEBP</p>
                                    </div>
                                    <img id="imagePreview" src="#" alt="Xem trước ảnh" class="admin-image-preview" style="display: none;">
                                </div>
                            </div>
                        </div>

                </div>

                <!-- Nút Submit cố định ở chân Form -->
                <div class="admin-form-actions">
                    <button type="button" class="btn btn-outline btn-lg" onclick="window.history.back()">Hủy</button>
                    <button type="submit" class="btn btn-primary btn-lg">Tạo sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
(function() {
    // Tự động định dạng tiền tệ khi nhập 
    const priceInput = document.getElementById('price');
    const priceSaleInput = document.getElementById('price_sale');

    window.previewImage = function(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function formatCurrencyInput(input, event) {
        let value = input.value.replace(/\D/g, '');
        if (event.inputType === 'deleteContentBackward') {
            value = value.slice(0, -1);
        }
        if (value) {
            input.value = parseInt(value).toLocaleString('vi-VN') + ' đ';
        } else {
            input.value = '';
        }
    }

    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            formatCurrencyInput(this, e);
        });
    }

    if (priceSaleInput) {
        priceSaleInput.addEventListener('input', function(e) {
            formatCurrencyInput(this, e);
        });
    }

    // Nút thêm dòng variant
    let variantIndex = 1;
    window.addVariantRow = function() {
        const tbody = document.getElementById('variantsBody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="p-12-16">
                <input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Đen, Trắng..." required>
            </td>
            <td class="p-12-16">
                <input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="S, M, L..." required>
            </td>
            <td class="p-12-16">
                <input type="text" name="variants[${variantIndex}][sku]" class="form-control" placeholder="Mã SKU định danh" required>
            </td>
            <td class="p-12-16">
                <input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="0" min="0" required>
            </td>
            <td class="p-12-16 text-right">
                <button type="button" class="btn btn-danger btn-icon" onclick="removeVariantRow(this)">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
        variantIndex++;
    }

    window.removeVariantRow = function(button) {
        const tbody = document.getElementById('variantsBody');
        const rows = tbody.querySelectorAll('tr');
        
        if (rows.length > 1) {
            const row = button.closest('tr');
            row.remove();
        } else {
            showToast("Sản phẩm phải có ít nhất một biến thể!", "error");
        }
    }

    // Loại bỏ các ký tự phi số trước khi submit form để gửi số nguyên thuần túy lên server
    document.querySelector('form').addEventListener('submit', function(e) {
        const nameInput = document.getElementById('name');
        if (!nameInput.value.trim()) {
            e.preventDefault();
            showToast("Vui lòng nhập tên sản phẩm!", "error");
            nameInput.classList.add('is-invalid');
            nameInput.focus();
            return;
        }

        const catInput = document.getElementById('category_id');
        if (!catInput || !catInput.value) {
            e.preventDefault();
            showToast("Vui lòng chọn danh mục sản phẩm!", "error");
            return;
        }

        if (priceInput) {
            const rawPrice = priceInput.value.replace(/\D/g, '');
            priceInput.value = rawPrice;
        }
        
        if (priceSaleInput) {
            const rawPriceSale = priceSaleInput.value.replace(/\D/g, '');
            priceSaleInput.value = rawPriceSale;
        }
    });

    // Xóa hiệu ứng viền đỏ khi người dùng bắt đầu nhập liệu
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    }
})();
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
