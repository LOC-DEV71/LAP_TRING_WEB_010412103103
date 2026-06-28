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
        <div class="flat-card" style="padding: 32px;">
            <form action="<?= url('admin/products/store') ?>" method="POST" enctype="multipart/form-data" novalidate>
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
                    
                    <!-- Cột trái: Thông tin cơ bản & Biến thể -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        
                        <!-- Thông tin cơ bản -->
                        <div>
                            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 8px;">Thông Tin Cơ Bản</h3>
                            
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: Áo khoác Bomber GearX" required>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="form-group">
                                    <label for="price">Giá bán (VNĐ)</label>
                                    <input type="text" id="price" name="price" class="form-control" placeholder="Ví dụ: 350.000đ" required style="font-weight: 700;">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Danh mục</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= htmlspecialchars($cat['_id']) ?>"><?= htmlspecialchars($cat['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <textarea id="description" name="description" class="form-control" rows="6" placeholder="Mô tả chi tiết về sản phẩm, chất liệu, hướng dẫn bảo quản..."></textarea>
                            </div>
                        </div>

                        <!-- Cấu hình biến thể -->
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 8px;">
                                <h3 style="font-size: 16px; font-weight: 700;">Biến Thể Sản Phẩm</h3>
                                <button type="button" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;" onclick="addVariantRow()">
                                    <span class="material-symbols-outlined" style="font-size: 16px; vertical-align: middle;">add</span> Thêm biến thể
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="admin-table" id="variantsTable">
                                    <thead>
                                        <tr>
                                            <th style="padding: 10px 16px;">Màu sắc</th>
                                            <th style="padding: 10px 16px;">Kích thước</th>
                                            <th style="padding: 10px 16px;">Mã SKU</th>
                                            <th style="padding: 10px 16px;">Số lượng kho</th>
                                            <th style="padding: 10px 16px; text-align: right;">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantsBody">
                                        <!-- Hàng mặc định đầu tiên -->
                                        <tr>
                                            <td style="padding: 12px 16px;">
                                                <input type="text" name="variants[0][color]" class="form-control" placeholder="Đen, Trắng..." required>
                                            </td>
                                            <td style="padding: 12px 16px;">
                                                <input type="text" name="variants[0][size]" class="form-control" placeholder="S, M, L..." required>
                                            </td>
                                            <td style="padding: 12px 16px;">
                                                <input type="text" name="variants[0][sku]" class="form-control" placeholder="Mã SKU định danh" required>
                                            </td>
                                            <td style="padding: 12px 16px;">
                                                <input type="number" name="variants[0][stock]" class="form-control" placeholder="0" min="0" required>
                                            </td>
                                            <td style="padding: 12px 16px; text-align: right;">
                                                <button type="button" class="btn btn-danger" style="padding: 6px 10px;" onclick="removeVariantRow(this)">
                                                    <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Cột phải: Hình ảnh sản phẩm -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div>
                            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 8px;">Hình Ảnh Đại Diện</h3>
                            
                            <!-- Khung Upload & Preview -->
                            <div style="border: 2px dashed rgba(0,0,0,0.1); border-radius: 12px; padding: 20px; text-align: center; background-color: #fafafa; cursor: pointer; position: relative;" onclick="document.getElementById('image').click()">
                                <input type="file" id="image" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">
                                <div id="uploadPlaceholder">
                                    <span class="material-symbols-outlined" style="font-size: 48px; color: #848484; margin-bottom: 8px;">upload_file</span>
                                    <p style="font-size: 13px; font-weight: 600; color: #5d5f5f;">Nhấp để tải ảnh lên</p>
                                    <p style="font-size: 11px; color: #848484; margin-top: 4px;">Hỗ trợ định dạng JPG, PNG, WEBP</p>
                                </div>
                                <img id="imagePreview" src="#" alt="Xem trước ảnh" style="max-width: 100%; max-height: 250px; border-radius: 8px; display: none; margin: 0 auto;">
                            </div>
                        </div>

                        <!-- Trạng thái hiển thị -->
                        <div>
                            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 8px;">Thiết Lập</h3>
                            
                            <div class="form-group">
                                <label for="status">Trạng thái hiển thị</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="active">Hiển thị ngay (Active)</option>
                                    <option value="inactive">Tạm ẩn (Inactive)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="featured">Sản phẩm nổi bật</label>
                                <select id="featured" name="featured" class="form-control">
                                    <option value="no">Không nổi bật</option>
                                    <option value="yes">Nổi bật (Hiển thị trang chủ)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Nút Submit cố định ở chân Form -->
                <div style="margin-top: 40px; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 24px; display: flex; justify-content: flex-end; gap: 16px;">
                    <a href="<?= url('admin/products') ?>" class="btn btn-outline" style="padding: 12px 24px;">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Lưu Sản Phẩm</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
let variantCount = 1;

// Hàm thêm một hàng biến thể mới vào bảng
function addVariantRow() {
    const tbody = document.getElementById('variantsBody');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td style="padding: 12px 16px;">
            <input type="text" name="variants[${variantCount}][color]" class="form-control" placeholder="Đen, Trắng..." required>
        </td>
        <td style="padding: 12px 16px;">
            <input type="text" name="variants[${variantCount}][size]" class="form-control" placeholder="S, M, L..." required>
        </td>
        <td style="padding: 12px 16px;">
            <input type="text" name="variants[${variantCount}][sku]" class="form-control" placeholder="Mã SKU định danh" required>
        </td>
        <td style="padding: 12px 16px;">
            <input type="number" name="variants[${variantCount}][stock]" class="form-control" placeholder="0" min="0" required>
        </td>
        <td style="padding: 12px 16px; text-align: right;">
            <button type="button" class="btn btn-danger" style="padding: 6px 10px;" onclick="removeVariantRow(this)">
                <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
            </button>
        </td>
    `;
    
    tbody.appendChild(newRow);
    variantCount++;
}

// Hàm xóa hàng biến thể
function removeVariantRow(button) {
    const row = button.closest('tr');
    const tbody = document.getElementById('variantsBody');
    if (tbody.rows.length > 1) {
        row.remove();
    } else {
        showToast("Sản phẩm phải có ít nhất một biến thể!", "error");
    }
}

// Hàm xem trước hình ảnh đại diện khi tải lên
function previewImage(event) {
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

// Tự động định dạng tiền tệ khi nhập 
const priceInput = document.getElementById('price');
priceInput.addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    
    // Nếu là hành động nhấn Backspace để xóa
    if (e.inputType === 'deleteContentBackward') {
        // Trình duyệt mới chỉ xóa ký tự 'đ' hoặc khoảng trắng, ta chủ động xóa đi chữ số cuối cùng
        value = value.slice(0, -1);
    }
    
    if (value) {
        this.value = parseInt(value).toLocaleString('vi-VN') + ' đ';
    } else {
        this.value = '';
    }
});

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

    const rawPrice = priceInput.value.replace(/\D/g, '');
    priceInput.value = rawPrice;
});

// Xóa hiệu ứng viền đỏ khi người dùng bắt đầu nhập liệu
document.getElementById('name').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
