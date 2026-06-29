<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Header Title Row -->
        <div class="main-header">
            <div class="header-title">
                <h2>Cấu Hình Trang Chủ</h2>
                <p>Cập nhật nội dung các banner, tiêu đề và ảnh bìa hiển thị tại trang chủ khách hàng.</p>
            </div>
        </div>



        <!-- Form Container -->
        <div class="flat-card p-32">
            <form action="<?= url('admin/homepage/update') ?>" method="POST" enctype="multipart/form-data" novalidate>
                <div class="admin-form-layout">
                    
                    <!-- Cột trái: Nội dung chữ các Section -->
                    <div class="admin-form-column">
                        
                        <!-- Hero Section -->
                        <div>
                            <div class="admin-form-section-header">
                                <h3 class="admin-form-section-title">Khu vực Hero Banner (Đầu trang)</h3>
                            </div>
                            
                            <div class="form-group">
                                <label for="home_hero_subtitle">Dòng chữ nhỏ phụ (Subtitle)</label>
                                <input type="text" id="home_hero_subtitle" name="home_hero_subtitle" class="form-control" 
                                       value="<?= htmlspecialchars($settings['home_hero_subtitle'] ?? '') ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="home_hero_title">Tiêu đề lớn (Nhấn Enter để xuống dòng)</label>
                                <textarea id="home_hero_title" name="home_hero_title" class="form-control" rows="2" required><?= htmlspecialchars($settings['home_hero_title'] ?? '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="home_hero_sale">Dòng chữ khuyến mãi (Sale Text)</label>
                                <input type="text" id="home_hero_sale" name="home_hero_sale" class="form-control" 
                                       value="<?= htmlspecialchars($settings['home_hero_sale'] ?? '') ?>" required>
                            </div>

                            <div class="admin-form-row-2col">
                                <div class="form-group">
                                    <label for="home_hero_button_text">Chữ trên nút bấm</label>
                                    <input type="text" id="home_hero_button_text" name="home_hero_button_text" class="form-control" 
                                           value="<?= htmlspecialchars($settings['home_hero_button_text'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="home_hero_button_link">Đường dẫn nút bấm</label>
                                    <input type="text" id="home_hero_button_link" name="home_hero_button_link" class="form-control" 
                                           value="<?= htmlspecialchars($settings['home_hero_button_link'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Banner Section -->
                        <div>
                            <div class="admin-form-section-header">
                                <h3 class="admin-form-section-title">Khung Khuyến Mãi Ngang (Sale Banner)</h3>
                            </div>
                            
                            <div class="form-group">
                                <label for="home_sale_banner_title">Tiêu đề khuyến mãi (Sale Banner Title)</label>
                                <input type="text" id="home_sale_banner_title" name="home_sale_banner_title" class="form-control" 
                                       value="<?= htmlspecialchars($settings['home_sale_banner_title'] ?? '') ?>" required>
                            </div>

                            <div class="admin-form-row-2col">
                                <div class="form-group">
                                    <label for="home_sale_banner_button_text">Chữ trên nút bấm</label>
                                    <input type="text" id="home_sale_banner_button_text" name="home_sale_banner_button_text" class="form-control" 
                                           value="<?= htmlspecialchars($settings['home_sale_banner_button_text'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="home_sale_banner_button_link">Đường dẫn nút bấm</label>
                                    <input type="text" id="home_sale_banner_button_link" name="home_sale_banner_button_link" class="form-control" 
                                           value="<?= htmlspecialchars($settings['home_sale_banner_button_link'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Cột phải: Hình ảnh & Thiết lập khác -->
                    <div class="admin-form-column">
                        
                        <!-- Hero Banner Image -->
                        <div>
                            <div class="admin-form-section-header">
                                <h3 class="admin-form-section-title">Hình Ảnh Hero Banner</h3>
                            </div>
                            
                            <!-- Khung Upload & Preview -->
                            <div class="admin-upload-zone" onclick="document.getElementById('home_hero_image_file').click()">
                                <input type="file" id="home_hero_image_file" name="home_hero_image" style="display: none;" accept="image/*" onchange="previewHeroImage(event)">
                                <div id="uploadPlaceholder" style="<?= !empty($settings['home_hero_image']) ? 'display: none;' : '' ?>">
                                    <span class="material-symbols-outlined" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 8px;">upload_file</span>
                                    <p class="fw-bold" style="font-size: 13px; color: var(--text-secondary);">Nhấp để thay đổi ảnh</p>
                                    <p class="text-muted" style="font-size: 11px; margin-top: 4px;">Hỗ trợ định dạng JPG, PNG, WEBP</p>
                                </div>
                                <?php 
                                $heroImg = $settings['home_hero_image'] ?? '';
                                $heroImgSrc = (strpos($heroImg, 'http') === 0) ? $heroImg : asset($heroImg ?: 'assets/images/placeholder.jpg');
                                ?>
                                <img id="heroImagePreview" src="<?= htmlspecialchars($heroImgSrc) ?>" alt="Xem trước ảnh banner" class="admin-image-preview" style="<?= !empty($settings['home_hero_image']) ? 'display: block;' : 'display: none;' ?>">
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Nút Submit cố định ở chân Form -->
                <div class="admin-form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">Lưu cấu hình trang chủ</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
function previewHeroImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('heroImagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        output.src = reader.result;
        output.style.display = 'block';
        if (placeholder) {
            placeholder.style.display = 'none';
        }
    };
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
