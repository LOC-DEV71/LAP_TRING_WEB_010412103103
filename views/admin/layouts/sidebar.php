<?php
// Hàm hỗ trợ kiểm tra xem URL hiện tại có khớp với menu item hay không
function isMenuCategoryActive($path) {
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

    // Loại bỏ baseDir khỏi requestUri (ví dụ: /LAP_TRING_WEB_010412103103)
    $baseDir = str_replace('\\', '/', dirname($scriptName));
    $baseDir = rtrim($baseDir, '/');
    if (!empty($baseDir) && strpos($requestUri, $baseDir) === 0) {
        $requestUri = substr($requestUri, strlen($baseDir));
    }

    // Loại bỏ index.php nếu có
    if (strpos($requestUri, '/index.php') === 0) {
        $requestUri = substr($requestUri, 10);
    }

    $currentPath = trim(strtok($requestUri, '?'), '/');
    $targetPath = trim($path, '/');

    // Trang tổng quan (Dashboard) active khi khớp chính xác hoặc chỉ có 'admin'
    if ($targetPath === 'admin/dashboard') {
        return $currentPath === $targetPath || $currentPath === 'admin' || empty($currentPath);
    }

    // Các trang khác active khi đường dẫn hiện tại bắt đầu bằng đường dẫn đích (ví dụ: admin/products/create vẫn active mục admin/products)
    return strpos($currentPath, $targetPath) === 0;
}
?>
<!-- SideNavBar Component -->
<aside class="admin-sidebar">
    <!-- Brand Logo -->
    <div class="sidebar-logo" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>GearX Admin</h1>
            <p>Catalog Control</p>
        </div>
        <button id="theme-toggle" onclick="toggleTheme()" style="background: rgba(0,0,0,0.04); border: none; cursor: pointer; color: var(--text-primary); display: flex; align-items: center; justify-content: center; padding: 8px; border-radius: 50%; transition: all 0.2s; width: 36px; height: 36px;">
            <span class="material-symbols-outlined" id="theme-toggle-icon" style="font-size: 20px;">dark_mode</span>
        </button>
    </div>
    <!-- Navigation Groups -->
    <div class="sidebar-menu">
        <!-- Overview -->
        <div class="menu-group">
            <p class="menu-title">Overview</p>
            <a class="menu-item <?= isMenuCategoryActive('admin/dashboard') ? 'active' : '' ?>" href="<?= url('admin/dashboard') ?>">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
        </div>
        <!-- Catalog -->
        <div class="menu-group">
            <p class="menu-title">Catalog</p>
            <a class="menu-item <?= isMenuCategoryActive('admin/categories') ? 'active' : '' ?>" href="<?= url('admin/categories') ?>">
                <span class="material-symbols-outlined">category</span>
                <span>Categories</span>
            </a>
            <a class="menu-item <?= isMenuCategoryActive('admin/products') ? 'active' : '' ?>" href="<?= url('admin/products') ?>">
                <span class="material-symbols-outlined">inventory</span>
                <span>Products</span>
            </a>
            <a class="menu-item <?= isMenuCategoryActive('admin/inventory') ? 'active' : '' ?>" href="<?= url('admin/inventory') ?>">
                <span class="material-symbols-outlined">warehouse</span>
                <span>Inventory</span>
            </a>
        </div>
        <!-- Sales -->
        <div class="menu-group">
            <p class="menu-title">Sales</p>
            <a class="menu-item <?= isMenuCategoryActive('admin/orders') ? 'active' : '' ?>" href="<?= url('admin/orders') ?>">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span>Orders</span>
            </a>
            <a class="menu-item <?= isMenuCategoryActive('admin/customers') ? 'active' : '' ?>" href="<?= url('admin/customers') ?>">
                <span class="material-symbols-outlined">person</span>
                <span>Customers</span>
            </a>
        </div>
        <!-- System -->
        <div class="menu-group">
            <p class="menu-title">System</p>
            <a class="menu-item <?= isMenuCategoryActive('admin/navbar') ? 'active' : '' ?>" href="<?= url('admin/navbar') ?>">
                <span class="material-symbols-outlined">menu</span>
                <span>Navbar</span>
            </a>
        </div>
    </div>
    
    <!-- User Account Info & Footer -->
    <div class="sidebar-profile">
        <div class="profile-info">
            <img alt="Admin Profile" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCg81GCOqczKzk2gAAR6-UR4ZH7VRPAH98qPPExWhjjoI5KiScZIWOaADyaNjmxr4zwrql6g3iFlLdlvde0vqixqcHWZHPjk0Fom1jK-Ml9LVY3pE7phAd4XqR7FB09U6N2BQ8-VqJiF3DdFhmzlx3uF6vRfmehJqNTjuunT-drEsqTT943p5rxSj37DwQ6BD_N0QtLLs0V7K987e0cyUy6ZiBPnOmVHWJ2r25128r8JL0O4d6K7TSNEf74POMUl7FIYuE0PR3mR4G5"/>
            <div class="profile-details">
                <p><?= htmlspecialchars($adminUser['fullname'] ?? 'Quản trị viên') ?></p>
                <span><?= htmlspecialchars($adminUser['role_slug'] ?? 'Admin') ?></span>
            </div>
        </div>
        <a class="btn-logout" href="<?= url('admin/auth/logout') ?>">
            <span class="material-symbols-outlined">logout</span>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>
