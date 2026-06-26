<?php
namespace Controllers\Client;

use Core\Controller;
use Models\Product;
use Models\ProductCategory;

class ProductsController extends Controller
{
    public function index()
    {
        $productModel = new Product();
        $categoryModel = new ProductCategory();
        
        $categorySlug = $_GET['category'] ?? null;
        $categoryInfo = null;
        
        if ($categorySlug) {
            // Lấy products theo danh mục
            $products = $productModel->getByCategorySlug($categorySlug);
            
            // Lấy tên danh mục để hiển thị
            $categoryInfo = $categoryModel->getBySlug($categorySlug);
        } else {
            // Lấy tất cả products nếu ko có slug
            $products = $productModel->getAllActive();
        }

        $categoryName = $categoryInfo ? mb_convert_case($categoryInfo['title'], MB_CASE_TITLE, 'UTF-8') : 'Tất cả sản phẩm';
        $bannerTitle = $categoryInfo ? mb_convert_case($categoryInfo['title'], MB_CASE_UPPER, 'UTF-8') : 'THỜI TRANG';

        $this->view('pages/client/products/index', [
            'title' => $categoryName . ' - FASHION',
            'products' => $products,
            'categoryName' => $categoryName,
            'bannerTitle' => $bannerTitle,
            'bannerDesc' => 'Khám phá các thiết kế mới nhất'
        ]);
    }
}
