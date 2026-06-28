<div class="main-header">
    <div class="header-title">
        <h2><?= htmlspecialchars($page_title ?? 'GearX Admin') ?></h2>
        <p><?= htmlspecialchars($page_subtitle ?? '') ?></p>
    </div>
    <div class="header-actions">
        <!-- Nút Làm mới luôn luôn xuất hiện đồng bộ -->
        <button class="btn btn-outline" onclick="location.reload();">
            <span class="material-symbols-outlined">refresh</span> Làm mới
        </button>

        <!-- Nút Nhập CSV xuất hiện khi trang yêu cầu -->
        <?php if (isset($show_import_csv) && $show_import_csv): ?>
            <button class="btn btn-outline" onclick="openModal('csvImportModal')">
                <span class="material-symbols-outlined">upload_file</span> Nhập CSV
            </button>
        <?php endif; ?>

        <!-- Nút Thêm mới dạng liên kết URL -->
        <?php if (isset($create_button_url) && $create_button_url): ?>
            <a href="<?= $create_button_url ?>" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span> <?= htmlspecialchars($create_button_text ?? 'Thêm Mới') ?>
            </a>
        <?php endif; ?>

        <!-- Nút Thêm mới dạng kích hoạt Modal JS -->
        <?php if (isset($create_button_onclick) && $create_button_onclick): ?>
            <button class="btn btn-primary" onclick="<?= $create_button_onclick ?>">
                <span class="material-symbols-outlined">add</span> <?= htmlspecialchars($create_button_text ?? 'Thêm Mới') ?>
            </button>
        <?php endif; ?>
    </div>
</div>
