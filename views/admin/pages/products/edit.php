<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <div class="main-header">
            <div class="header-title">
                <h2>Chỉnh Sửa Sản Phẩm</h2>
                <p>Cập nhật thông tin chi tiết, hình ảnh và các biến thể sản phẩm.</p>
            </div>
            <div class="header-actions">
                <a href="<?= url('admin/products') ?>" class="btn btn-outline">Hủy bỏ</a>
            </div>
        </div>

        <!-- Form Container -->
        <div class="flat-card p-32">
            <form action="<?= url('admin/products/edit/' . $product['_id']) ?>" method="POST" enctype="multipart/form-data" novalidate>
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
                                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($product['name'] ?? '') ?>" placeholder="Ví dụ: Áo khoác Bomber GearX" required>
                            </div>

                            <div class="admin-form-row-2col" style="grid-template-columns: 1fr 1fr 1fr;">
                                <div class="form-group">
                                    <label for="price">Giá bán gốc (VNĐ)</label>
                                    <input type="text" id="price" name="price" class="form-control fw-bold" value="<?= htmlspecialchars($product['price'] ?? '') ?>" placeholder="Ví dụ: 350.000đ" required>
                                </div>
                                <div class="form-group">
                                    <label for="price_sale">Giá sale (VNĐ)</label>
                                    <input type="text" id="price_sale" name="price_sale" class="form-control fw-bold" value="<?= htmlspecialchars($product['price_sale'] ?? '') ?>" placeholder="Ví dụ: 290.000đ (không bắt buộc)">
                                </div>
                                 <div class="form-group">
                                    <label for="category_id">Danh mục</label>
                                    <div class="admin-custom-dropdown" id="category-dropdown">
                                        <?php
                                        $selectedCatTitle = '-- Chọn danh mục --';
                                        $selectedCatId = '';
                                        foreach ($categories as $cat) {
                                            if (($product['product_category_id'] ?? '') === $cat['_id']) {
                                                $selectedCatTitle = $cat['title'];
                                                $selectedCatId = $cat['_id'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <button type="button" class="dropdown-trigger">
                                            <span class="selected-value"><?= htmlspecialchars($selectedCatTitle) ?></span>
                                            <span class="material-symbols-outlined arrow-icon">expand_more</span>
                                        </button>
                                        <ul class="dropdown-options">
                                            <li data-value="" class="<?= empty($selectedCatId) ? 'active' : '' ?>">-- Chọn danh mục --</li>
                                            <?php foreach ($categories as $cat): ?>
                                                <li data-value="<?= htmlspecialchars($cat['_id']) ?>" class="<?= $selectedCatId === $cat['_id'] ? 'active' : '' ?>"><?= htmlspecialchars($cat['title']) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <input type="hidden" id="category_id" name="category_id" value="<?= htmlspecialchars($selectedCatId) ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <textarea id="description" name="description" class="form-control" rows="6" placeholder="Mô tả chi tiết về sản phẩm, chất liệu, hướng dẫn bảo quản..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
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
                                        <?php if (empty($variants)): ?>
                                            <!-- Hàng mặc định nếu sản phẩm chưa có biến thể -->
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
                                        <?php else: ?>
                                            <?php foreach ($variants as $index => $variant): ?>
                                                <tr>
                                                    <td class="p-12-16">
                                                        <input type="hidden" name="variants[<?= $index ?>][_id]" value="<?= htmlspecialchars($variant['_id']) ?>">
                                                        <input type="text" name="variants[<?= $index ?>][color]" class="form-control" value="<?= htmlspecialchars($variant['color'] ?? '') ?>" placeholder="Đen, Trắng..." required>
                                                    </td>
                                                    <td class="p-12-16">
                                                        <input type="text" name="variants[<?= $index ?>][size]" class="form-control" value="<?= htmlspecialchars($variant['size'] ?? '') ?>" placeholder="S, M, L..." required>
                                                    </td>
                                                    <td class="p-12-16">
                                                        <input type="text" name="variants[<?= $index ?>][sku]" class="form-control" value="<?= htmlspecialchars($variant['sku'] ?? '') ?>" placeholder="Mã SKU định danh" required>
                                                    </td>
                                                    <td class="p-12-16">
                                                        <input type="number" name="variants[<?= $index ?>][stock]" class="form-control" value="<?= htmlspecialchars($variant['stock'] ?? 0) ?>" placeholder="0" min="0" required>
                                                    </td>
                                                    <td class="p-12-16 text-right">
                                                        <button type="button" class="btn btn-danger btn-icon" onclick="removeVariantRow(this)">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Cột phải: Thiết lập & Hình ảnh (Gộp chung 1 Card) -->
                    <div class="admin-form-column">
                        <div class="flat-card p-24" style="overflow: visible;">
                            <h4 class="mb-16">Thiết Lập & Hình Ảnh</h4>
                            
                            <div class="form-group">
                                <label for="status">Trạng thái hiển thị</label>
                                <div class="admin-custom-dropdown" id="status-dropdown">
                                    <?php 
                                    $isInactive = ($product['status'] ?? 'active') === 'inactive';
                                    ?>
                                    <button type="button" class="dropdown-trigger">
                                        <span class="selected-value"><?= $isInactive ? 'Tạm ẩn (Inactive)' : 'Hiển thị ngay (Active)' ?></span>
                                        <span class="material-symbols-outlined arrow-icon">expand_more</span>
                                    </button>
                                    <ul class="dropdown-options">
                                        <li data-value="active" class="<?= !$isInactive ? 'active' : '' ?>">Hiển thị ngay (Active)</li>
                                        <li data-value="inactive" class="<?= $isInactive ? 'active' : '' ?>">Tạm ẩn (Inactive)</li>
                                    </ul>
                                    <input type="hidden" id="status" name="status" value="<?= $isInactive ? 'inactive' : 'active' ?>">
                                </div>
                            </div>

                            <div class="form-group mb-24">
                                <label for="featured">Sản phẩm nổi bật</label>
                                <div class="admin-custom-dropdown" id="featured-dropdown">
                                    <?php 
                                    $isFeatured = ($product['featured'] ?? 'no') === 'yes';
                                    ?>
                                    <button type="button" class="dropdown-trigger">
                                        <span class="selected-value"><?= $isFeatured ? 'Nổi bật (Hiển thị trang chủ)' : 'Không nổi bật' ?></span>
                                        <span class="material-symbols-outlined arrow-icon">expand_more</span>
                                    </button>
                                    <ul class="dropdown-options">
                                        <li data-value="no" class="<?= !$isFeatured ? 'active' : '' ?>">Không nổi bật</li>
                                        <li data-value="yes" class="<?= $isFeatured ? 'active' : '' ?>">Nổi bật (Hiển thị trang chủ)</li>
                                    </ul>
                                    <input type="hidden" id="featured" name="featured" value="<?= $isFeatured ? 'yes' : 'no' ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh đại diện</label>
                                <div class="admin-upload-zone" onclick="document.getElementById('image').click()" style="cursor: pointer;">
                                    <input type="file" id="image" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">
                                    
                                    <?php $hasImage = !empty($product['thumbnail']); ?>
                                    <div id="uploadPlaceholder" style="display: <?= $hasImage ? 'none' : 'block' ?>;">
                                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 8px;">upload_file</span>
                                        <p class="fw-bold" style="font-size: 13px; color: var(--text-secondary);">Nhấp để thay đổi ảnh</p>
                                        <p class="text-muted" style="font-size: 11px; margin-top: 4px;">Hỗ trợ định dạng JPG, PNG, WEBP</p>
                                    </div>
                                    <img id="imagePreview" src="<?= $hasImage ? htmlspecialchars($product['thumbnail']) : '#' ?>" alt="Xem trước ảnh" class="admin-image-preview" style="display: <?= $hasImage ? 'block' : 'none' ?>;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Nút Submit cố định ở chân Form -->
                <div class="admin-form-actions">
                    <a href="<?= url('admin/products') ?>" class="btn btn-outline">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
(function() {
    let variantCount = <?= count($variants ?? [1]) ?>;

    // Hàm thêm một hàng biến thể mới vào bảng
    window.addVariantRow = function() {
        const tbody = document.getElementById('variantsBody');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td class="p-12-16">
                <input type="text" name="variants[${variantCount}][color]" class="form-control" placeholder="Đen, Trắng..." required>
            </td>
            <td class="p-12-16">
                <input type="text" name="variants[${variantCount}][size]" class="form-control" placeholder="S, M, L..." required>
            </td>
            <td class="p-12-16">
                <input type="text" name="variants[${variantCount}][sku]" class="form-control" placeholder="Mã SKU định danh" required>
            </td>
            <td class="p-12-16">
                <input type="number" name="variants[${variantCount}][stock]" class="form-control" placeholder="0" min="0" required>
            </td>
            <td class="p-12-16 text-right">
                <button type="button" class="btn btn-danger btn-icon" onclick="removeVariantRow(this)">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        variantCount++;
    }

    // Hàm xóa hàng biến thể
    window.removeVariantRow = function(button) {
        const row = button.closest('tr');
        const tbody = document.getElementById('variantsBody');
        if (tbody.rows.length > 1) {
            row.remove();
        } else {
            showToast("Sản phẩm phải có ít nhất một biến thể!", "error");
        }
    }

    // Hàm xem trước hình ảnh đại diện khi tải lên
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

    // Tự động định dạng tiền tệ khi gõ (mặt nạ 350.000 đ)
    const priceInput = document.getElementById('price');
    const priceSaleInput = document.getElementById('price_sale');

    // Định dạng giá trị hiện tại có sẵn từ DB khi tải trang
    if (priceInput && priceInput.value) {
        let rawVal = priceInput.value.replace(/\D/g, '');
        if (rawVal) {
            priceInput.value = parseInt(rawVal).toLocaleString('vi-VN') + ' đ';
        }
    }
    if (priceSaleInput && priceSaleInput.value) {
        let rawVal = priceSaleInput.value.replace(/\D/g, '');
        if (rawVal) {
            priceSaleInput.value = parseInt(rawVal).toLocaleString('vi-VN') + ' đ';
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
