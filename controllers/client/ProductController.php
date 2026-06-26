<?php
namespace Controllers\Client;

use Core\Controller;
use Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // 1. Khởi tạo Product Model và truy vấn danh sách sản phẩm hoạt động
        $productModel = new Product();
        $products = $productModel->getAllActive();

        // 2. Trả về view danh sách sản phẩm cùng tiêu đề và dữ liệu sản phẩm
        $this->view('pages/client/products/index', [
            'title' => 'Thời trang Nam - FASHION',
            'products' => $products,
            'categoryName' => 'Nam',
            'bannerTitle' => 'THỜI TRANG NAM',
            'bannerDesc' => 'Khám phá các thiết kế mới nhất dành cho phái mạnh'
        ]);
    }
}
