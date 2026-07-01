<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<!-- Main Content Area -->
<main class="admin-main">
    <div class="main-container">
        <!-- Top Nav Header (Search & Profile) -->
        <?php require __DIR__ . '/../../layouts/page_header.php'; ?>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 24px;">
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div>
                    <p style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Đang hoạt động</p>
                    <span style="font-size: 32px; font-weight: 800; color: var(--text-primary);"><?= $countActive ?? 0 ?></span>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #d1fae5; color: #059669; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
            </div>
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div>
                    <p style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Tạm ẩn</p>
                    <span style="font-size: 32px; font-weight: 800; color: var(--text-primary);"><?= $countInactive ?? 0 ?></span>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined">pause_circle</span>
                </div>
            </div>
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div>
                    <p style="font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Tổng sản phẩm</p>
                    <span style="font-size: 32px; font-weight: 800; color: var(--text-primary);"><?= count($products ?? []) ?></span>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined">inventory_2</span>
                </div>
            </div>
        </div>

        <!-- Bulk Action Bar (ẩn khi không có gì được chọn) -->
        <div id="bulkActionBar" style="display:none; background: #1e293b; border-radius: 12px; padding: 14px 24px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); align-items: center; gap: 16px; flex-wrap: wrap;">
            <span id="bulkSelectedCount" style="color: #94a3b8; font-size: 13px; font-weight: 600; white-space: nowrap;">0 đã chọn</span>
            <div style="flex: 1;"></div>
            <button onclick="bulkDo('active')"       class="bulk-btn" style="background:#22c55e;color:#fff;">✓ Active</button>
            <button onclick="bulkDo('inactive')"     class="bulk-btn" style="background:#6b7280;color:#fff;">✕ Inactive</button>
            <button onclick="bulkDo('featured_yes')" class="bulk-btn" style="background:#a855f7;color:#fff;">★ Nổi bật</button>
            <button onclick="bulkDo('featured_no')"  class="bulk-btn" style="background:#475569;color:#fff;">☆ Bỏ nổi bật</button>
            <div style="width:1px;height:28px;background:#334155;"></div>
            <button onclick="bulkDo('delete')"       class="bulk-btn" style="background:#ef4444;color:#fff;">🗑 Xóa</button>
            <button onclick="clearSelection()" style="background:none;border:none;color:#64748b;cursor:pointer;font-size:12px;padding:6px 12px;border-radius:6px;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#64748b'">Bỏ chọn</button>
        </div>
        <style>
        .bulk-btn { border:none; border-radius:8px; padding:7px 14px; font-size:12px; font-weight:700; cursor:pointer; transition:opacity .15s; }
        .bulk-btn:hover { opacity:.8; }
        </style>


        <!-- Filter Bar -->
        <form method="GET" action="<?= url('admin/products') ?>" id="filterForm" style="background: #ffffff; border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Trạng thái -->
            <select name="status" onchange="this.form.submit()" style="padding: 9px 14px; border-radius: 8px; border: 1px solid var(--panel-border); background: var(--panel-bg); color: var(--text-primary); outline: none; font-size: 13px; cursor:pointer;">
                <option value=""            <?= ($filterStatus??'')==''          ? 'selected':'' ?>>-- Tất cả Trạng thái --</option>
                <option value="active"      <?= ($filterStatus??'')=='active'    ? 'selected':'' ?>>✓ Active (<?= $countActive ?? 0 ?>)</option>
                <option value="inactive"    <?= ($filterStatus??'')=='inactive'  ? 'selected':'' ?>>✕ Inactive (<?= $countInactive ?? 0 ?>)</option>
                <option value="featured"    <?= ($filterStatus??'')=='featured'  ? 'selected':'' ?>>★ Featured (<?= $countFeatured ?? 0 ?>)</option>
            </select>

            <!-- Danh mục -->
            <select name="category" onchange="this.form.submit()" style="padding: 9px 14px; border-radius: 8px; border: 1px solid var(--panel-border); background: var(--panel-bg); color: var(--text-primary); outline: none; font-size: 13px; cursor:pointer;">
                <option value="">-- Tất cả Danh mục --</option>
                <?php foreach ($categories ?? [] as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['_id']) ?>" <?= ($filterCategory??'')===$cat['_id'] ? 'selected':'' ?>>
                        <?= htmlspecialchars($cat['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Sắp xếp -->
            <select name="sort" onchange="this.form.submit()" style="padding: 9px 14px; border-radius: 8px; border: 1px solid var(--panel-border); background: var(--panel-bg); color: var(--text-primary); outline: none; font-size: 13px; cursor:pointer;">
                <option value="newest"     <?= ($filterSort??'newest')==='newest'     ? 'selected':'' ?>>Mới nhất</option>
                <option value="oldest"     <?= ($filterSort??'newest')==='oldest'     ? 'selected':'' ?>>Cũ nhất</option>
                <option value="price_asc"  <?= ($filterSort??'newest')==='price_asc'  ? 'selected':'' ?>>Giá tăng dần</option>
                <option value="price_desc" <?= ($filterSort??'newest')==='price_desc' ? 'selected':'' ?>>Giá giảm dần</option>
            </select>

            <!-- Search -->
            <div style="flex: 1; min-width: 180px; position: relative;">
                <span class="material-symbols-outlined" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:18px;color:#9ca3af;pointer-events:none;">search</span>
                <input type="text" name="search" value="<?= htmlspecialchars($filterSearch ?? '') ?>" placeholder="Tìm tên sản phẩm..." style="width:100%;padding:9px 12px 9px 36px;border-radius:8px;border:1px solid var(--panel-border);background:var(--panel-bg);outline:none;font-size:13px;box-sizing:border-box;">
            </div>
            <button type="submit" style="padding:9px 18px;border-radius:8px;border:none;background:#2563eb;color:#fff;font-weight:700;font-size:13px;cursor:pointer;">Tìm kiếm</button>

            <?php if (!empty($filterStatus) || !empty($filterCategory) || !empty($filterSearch) || ($filterSort ?? 'newest') !== 'newest'): ?>
                <a href="<?= url('admin/products') ?>" style="padding:9px 14px;border-radius:8px;border:1px solid #fca5a5;color:#ef4444;font-size:12px;font-weight:600;text-decoration:none;white-space:nowrap;">✕ Xóa bộ lọc</a>
            <?php endif; ?>

            <div style="margin-left:auto;">
                <a href="<?= url('admin/products/create') ?>" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;border:none;background:#2563eb;color:#fff;font-weight:700;font-size:13px;text-decoration:none;">
                    <span class="material-symbols-outlined" style="font-size:18px;">add</span> Thêm mới
                </a>
            </div>
        </form>


        <!-- Products Table -->
        <div style="background: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
            <div class="table-responsive">
                <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 16px 20px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: left; width: 44px;">
                                <input type="checkbox" id="selectAllCb" style="width: 16px; height: 16px; cursor: pointer;">
                            </th>
                            <th style="padding: 16px 24px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: left; color: var(--text-secondary); font-size: 12px; font-weight: 700;">SẢN PHẨM</th>
                            <th style="padding: 16px 24px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: left; color: var(--text-secondary); font-size: 12px; font-weight: 700;">GIÁ BÁN</th>
                            <th style="padding: 16px 24px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: left; color: var(--text-secondary); font-size: 12px; font-weight: 700;">BIẾN THỂ</th>
                            <th style="padding: 16px 24px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: left; color: var(--text-secondary); font-size: 12px; font-weight: 700;">TRẠNG THÁI</th>
                            <th style="padding: 16px 24px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: left; color: var(--text-secondary); font-size: 12px; font-weight: 700;">NỔI BẬT</th>
                            <th style="padding: 16px 24px; background: #f9fafb; border-bottom: 1px solid var(--panel-border); text-align: right; color: var(--text-secondary); font-size: 12px; font-weight: 700;">HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted" style="padding: 40px;">
                                    Chưa có sản phẩm nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr class="product-row" style="border-bottom: 1px solid var(--panel-border);">
                                    <td class="cb-cell" style="padding: 16px 20px;">
                                        <input type="checkbox" class="row-checkbox" data-id="<?= htmlspecialchars($product['_id']) ?>" style="width: 16px; height: 16px; cursor: pointer;">
                                    </td>
                                    <!-- Ảnh + Tên sản phẩm -->
                                    <td style="padding: 16px 24px;">
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="width: 56px; height: 72px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: #f3f4f6; border: 1px solid var(--panel-border);">
                                                <?php if (!empty($product['thumbnail'])): ?>
                                                    <img src="<?= htmlspecialchars($product['thumbnail']) ?>" alt="<?= htmlspecialchars($product['title'] ?? '') ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                <?php else: ?>
                                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                        <span class="material-symbols-outlined" style="color: #d1d5db; font-size: 28px;">image</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div style="display: flex; flex-direction: column; gap: 2px;">
                                                <span style="font-weight: 700; color: var(--text-primary); font-size: 14px; line-height: 1.4;"><?= htmlspecialchars($product['title'] ?? '') ?></span>
                                                <span style="color: var(--text-secondary); font-size: 12px;"><?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?></span>
                                                <span style="color: #9ca3af; font-size: 11px;">#<?= substr($product['_id'] ?? '', -8) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Giá bán -->
                                    <td style="padding: 16px 24px;">
                                        <span style="font-weight: 700; color: var(--text-primary); font-size: 14px;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['price_sale']) && $product['price_sale'] > 0): ?>
                                            <br><span style="color: #ef4444; font-size: 12px; font-weight: 600;">Sale: <?= number_format($product['price_sale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Biến thể (Màu & Size) -->
                                    <td style="padding: 16px 24px;">
                                        <?php if (!empty($product['colors'])): ?>
                                            <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 160px;">
                                                <?php foreach (array_unique(explode(',', $product['colors'])) as $color): ?>
                                                    <span style="display: inline-block; padding: 2px 8px; background: #f3f4f6; color: #374151; border-radius: 4px; font-size: 11px; font-weight: 500;"><?= htmlspecialchars(trim($color)) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if (!empty($product['sizes'])): ?>
                                                <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 4px; max-width: 160px;">
                                                    <?php foreach (array_unique(explode(',', $product['sizes'])) as $size): ?>
                                                        <span style="display: inline-block; padding: 2px 6px; background: #eff6ff; color: #2563eb; border-radius: 4px; font-size: 11px; font-weight: 600; border: 1px solid #bfdbfe;"><?= htmlspecialchars(trim($size)) ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span style="color: #9ca3af; font-size: 12px;">Chưa có biến thể</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Trạng thái -->
                                    <td style="padding: 16px 24px;">
                                        <?php if (($product['status'] ?? 'active') === 'active'): ?>
                                            <span style="display: inline-block; padding: 4px 12px; background: #d1fae5; color: #059669; border-radius: 9999px; font-size: 12px; font-weight: 700;">Đang HĐ</span>
                                        <?php else: ?>
                                            <span style="display: inline-block; padding: 4px 12px; background: #f3f4f6; color: #6b7280; border-radius: 9999px; font-size: 12px; font-weight: 700;">Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Nổi bật -->
                                    <td style="padding: 16px 24px;">
                                        <?php if (($product['featured'] ?? 'no') === 'yes'): ?>
                                            <span style="display: inline-block; padding: 4px 12px; background: #f3e8ff; color: #9333ea; border-radius: 9999px; font-size: 12px; font-weight: 700;">Nổi bật</span>
                                        <?php else: ?>
                                            <span style="color: #9ca3af; font-size: 12px;">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Hành động -->
                                    <td style="padding: 16px 24px; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                                            <a href="<?= url('admin/products/edit/' . $product['_id']) ?>" title="Chỉnh sửa" style="color: #6b7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#6b7280'"><span class="material-symbols-outlined" style="font-size: 20px;">edit</span></a>
                                            <a href="javascript:void(0)" onclick="confirmDelete('<?= htmlspecialchars($product['_id']) ?>')" title="Xóa" style="color: #6b7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#6b7280'"><span class="material-symbols-outlined" style="font-size: 20px;">delete</span></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Pagination -->
        <?php
        require_once __DIR__ . '/../../../utils/pagination.php';
        $queryForPagination = array_filter([
            'status'   => $filterStatus   ?? '',
            'category' => $filterCategory ?? '',
            'sort'     => $filterSort     ?? '',
            'search'   => $filterSearch   ?? '',
        ]);
        echo render_pagination($pagination, url('admin/products'), $queryForPagination);
        ?>

        <?php require_once __DIR__ . '/../../layouts/csv_import_modal.php'; ?>
    </div>

</main>

<script>
(function() {
    const bar       = document.getElementById('bulkActionBar');
    const countEl   = document.getElementById('bulkSelectedCount');
    const selectAll = document.getElementById('selectAllCb');

    function getChecked() {
        return [...document.querySelectorAll('.row-checkbox:checked')];
    }

    function updateBar() {
        const checked = getChecked();
        if (checked.length > 0) {
            bar.style.display = 'flex';
            countEl.textContent = checked.length + ' sản phẩm đã chọn';
        } else {
            bar.style.display = 'none';
            if (selectAll) selectAll.checked = false;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(cb => { cb.checked = this.checked; });
            updateBar();
        });
    }

    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.addEventListener('change', updateBar);
    });

    window.clearSelection = function() {
        document.querySelectorAll('.row-checkbox').forEach(cb => { cb.checked = false; });
        if (selectAll) selectAll.checked = false;
        updateBar();
    };

    function executeBulk(ids, action) {
        fetch('<?= url('admin/products/bulkAction') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ids, action })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 700);
            } else {
                Swal.fire({ title: 'Lỗi!', text: data.message || 'Có lỗi xảy ra!', icon: 'error' });
            }
        })
        .catch(() => Swal.fire({ title: 'Lỗi kết nối!', icon: 'error' }));
    }

    window.bulkDo = function(action) {
        const ids = getChecked().map(cb => cb.dataset.id);
        if (!ids.length) return;

        if (action === 'delete') {
            Swal.fire({
                title: 'Xóa ' + ids.length + ' sản phẩm?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '🗑 Xóa',
                cancelButtonText: 'Hủy'
            }).then(result => {
                if (result.isConfirmed) executeBulk(ids, action);
            });
        } else {
            executeBulk(ids, action);
        }
    };

    window.confirmDelete = function(id) {
        Swal.fire({
            title: 'Xóa sản phẩm?',
            text: 'Sản phẩm sẽ bị xóa mềm. Bạn có thể khôi phục sau.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '🗑 Xóa',
            cancelButtonText: 'Hủy'
        }).then(result => {
            if (result.isConfirmed) {
                window.location.href = '<?= url('admin/products/delete/') ?>' + id;
            }
        });
    };

})();
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
