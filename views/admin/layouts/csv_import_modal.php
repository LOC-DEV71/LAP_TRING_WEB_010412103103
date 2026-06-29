<?php
// Cấu hình các biến động từ trang cha truyền xuống (hoặc dùng giá trị mặc định)
$modal_id = $csv_import_id ?? 'csvImportModal';
$action_url = $csv_import_action ?? url('admin/inventory/importCsv');
$title = $csv_import_title ?? 'Nhập Kho Bằng Tệp CSV';
$template_url = $csv_import_template_url ?? url('scratch/inventory_import_fake.csv');
$description = $csv_import_desc ?? 'Chọn hoặc kéo thả tệp CSV chứa danh sách biến thể cần cập nhật số lượng tồn kho.';
?>
<!-- Modal Nhập CSV Dùng Chung -->
<div id="<?= htmlspecialchars($modal_id) ?>" class="modal-overlay">
    <div class="modal-container" style="max-width: 550px;">
        <div class="modal-header">
            <h3 class="modal-title"><?= htmlspecialchars($title) ?></h3>
            <button type="button" class="close-btn">&times;</button>
        </div>
        <form action="<?= $action_url ?>" method="POST" enctype="multipart/form-data" class="no-spa">
            <div class="modal-body">
                <p class="text-muted mb-16" style="font-size: 13px; line-height: 1.5;">
                    <?= htmlspecialchars($description) ?> 
                    Tải tệp mẫu <a href="<?= $template_url ?>" download style="color: var(--primary-color); font-weight: 600; text-decoration: underline;">tại đây</a> để làm mẫu.
                </p>
                
                <div class="form-group">
                    <div class="admin-upload-zone" id="csv-drag-zone" style="cursor: pointer; border: 2px dashed var(--border-color); padding: 32px 16px; text-align: center; border-radius: 8px; transition: all 0.2s ease;">
                        <input type="file" id="csv_file" name="csv_file" style="display: none;" accept=".csv" required>
                        <div id="csv-placeholder">
                            <span class="material-symbols-outlined" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 8px;">upload_file</span>
                            <p class="fw-bold" style="font-size: 14px; color: var(--text-primary);">Kéo thả tệp .csv vào đây hoặc nhấp để chọn</p>
                            <p class="text-muted" style="font-size: 11px; margin-top: 4px;">Hỗ trợ tệp định dạng CSV</p>
                        </div>
                        <div id="csv-file-info" style="display: none;">
                            <span class="material-symbols-outlined" style="font-size: 48px; color: var(--primary-color); margin-bottom: 8px;">description</span>
                            <p class="fw-bold" id="csv-file-name" style="font-size: 14px; color: var(--primary-color);"></p>
                            <p class="text-muted" id="csv-file-size" style="font-size: 11px; margin-top: 4px;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 8px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Tải Lên & Cập Nhật</button>
            </div>
        </form>
    </div>
</div>
