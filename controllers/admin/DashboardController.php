<?php
namespace Controllers\Admin;

use Models\Product\Product;
use Models\Product\ProductVariant;
use Models\Order;

class DashboardController extends AdminBaseController
{
    public function index()
    {
        $productModel = new Product();
        $variantModel = new ProductVariant();
        
        $totalProducts = $productModel->getTotalCount();
        $lowStockAlerts = $variantModel->getLowStockCount(10);
        $topCategory = 'Thời trang Nam'; // Mặc định hiển thị danh mục chính bán chạy

        // Lấy danh sách sản phẩm mới nhất
        $recentProducts = $productModel->getRecentProducts(5);

        $this->view('admin/pages/dashboard/index', [
            'title' => 'Bảng điều khiển - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'totalProducts' => $totalProducts,
            'lowStockAlerts' => $lowStockAlerts,
            'topCategory' => $topCategory,
            'recentProducts' => $recentProducts
        ]);
    }
}
