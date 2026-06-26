<?php
namespace Controllers\Client;

use Core\Controller;
use Models\Product;
use Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        // Khởi tạo model Product
        $productModel = new Product();
        $categoryModel = new ProductCategory();
        
        // Truy vấn danh sách Sản phẩm nổi bật (Featured Products)
        $featuredProducts = $productModel->getFeatured();
        $categories = $categoryModel->getAllActive();

        
        // Gọi view 'pages/client/home/index.php' và truyền dữ liệu ra
        $this->view('pages/client/home/index', [
            'title' => 'Trang chủ - FASHION',
            'products' => $featuredProducts,
            'categories' => $categories
        ]);
    }
}
