<!-- Sidebar -->
<aside class="sidebar glass-panel">
    <h3>Bộ lọc</h3>

    <!-- Danh mục -->
    <div class="filter-group">
        <h4>Danh mục</h4>
        <ul id="category-filter">
            <li data-category="">Tất cả</li>
            <?php if (!empty($dbCategories)): ?>
                <?php foreach ($dbCategories as $cat): ?>
                    <li data-category="<?= htmlspecialchars($cat['slug']) ?>">
                        <?= htmlspecialchars($cat['title']) ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Kích cỡ -->
    <div class="filter-group" id="size-filter">
        <h4>Kích cỡ</h4>
        <?php if (!empty($dbSizes)): ?>
            <?php foreach ($dbSizes as $size): ?>
                <label>
                    <input type="checkbox" value="<?= htmlspecialchars($size) ?>"> 
                    <?= htmlspecialchars($size) ?>
                </label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Màu sắc -->
    <div class="filter-group">
        <h4>Màu sắc</h4>
        <div class="color-list" id="color-filter">
            <?php if (!empty($dbColors)): ?>
                <?php foreach ($dbColors as $color): ?>
                    <span class="color <?= htmlspecialchars($color) ?>" data-color="<?= htmlspecialchars($color) ?>" title="<?= htmlspecialchars($color) ?>"></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Khoảng giá -->
    <div class="filter-group">
        <h4>Khoảng giá</h4>

        <input type="range" 
               min="<?= $minPrice ?>" 
               max="<?= $maxPrice ?>" 
               step="10000" 
               id="price-range" 
               value="<?= $maxPrice ?>">

        <div class="price-range">
            <span><?= number_format($minPrice, 0, ',', '.') ?>đ</span>
            <span id="price-value"><?= number_format($maxPrice, 0, ',', '.') ?>đ</span>
        </div>
    </div>

    <button class="clear-filter" id="btn-clear-filter">
        XÓA BỘ LỌC
    </button>
</aside>
