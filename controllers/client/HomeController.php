<?php
namespace Controllers\Client;

use Core\Controller;
use Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Khởi tạo model và lấy tất cả sản phẩm đang hoạt động từ cơ sở dữ liệu
        $productModel = new Product();
        $products = $productModel->getAllActive();
        
        // Lấy 4 sản phẩm đầu tiên làm sản phẩm nổi bật trên trang chủ
        $featuredProducts = array_slice($products, 0, 4);

        // Gọi view 'pages/client/home/index.php'
        $this->view('pages/client/home/index', [
            'title' => 'Trang chủ - FASHION',
            'products' => $featuredProducts
        ]);
    }
}
