<?php
namespace Controllers\Client;

use Core\Controller;
use Models\Product\Product;
use Models\Product\ProductCategory;

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

        // Lấy danh sách biến thể màu/size và category_slug cho sản phẩm nổi bật
        if (!empty($featuredProducts)) {
            $productIds = array_column($featuredProducts, '_id');
            $variantModel = new \Models\Product\ProductVariant();
            $variantsData = $variantModel->getColorsAndSizesByProductIds($productIds);
            
            $variantsMap = [];
            foreach ($variantsData as $vd) {
                $variantsMap[$vd['product_id']] = $vd;
            }
            
            foreach ($featuredProducts as &$product) {
                $product['colors'] = $variantsMap[$product['_id']]['colors'] ?? '';
                $product['sizes'] = $variantsMap[$product['_id']]['sizes'] ?? '';
                // Lấy thêm category_slug từ danh sách categories đã có
                foreach ($categories as $cat) {
                    if ($cat['_id'] === $product['product_category_id']) {
                        $product['category_slug'] = $cat['slug'];
                        break;
                    }
                }
            }
            unset($product);
        }

        // Lấy danh sách sản phẩm đã Like của User (nếu đã đăng nhập)
        $likedProducts = [];
        $token = $_COOKIE['jwt_token'] ?? '';
        if (empty($token)) {
            $token = $_COOKIE['admin_jwt_token'] ?? '';
        }
        
        if (!empty($token)) {
            $payload = \Core\JwtUtils::decode($token);
            if (is_array($payload)) {
                $userId = $payload['user_id'] ?? ($payload['account_id'] ?? null);
                if ($userId) {
                    $likeModel = new \Models\Like();
                    $likedProducts = $likeModel->getLikedProductsByClient($userId);
                }
            }
        }

        // Lấy cấu hình hệ thống/trang chủ
        $settingModel = new \Models\Setting();
        $settings = $settingModel->getAll();

        // Gọi view 'client/pages/home/index.php' và truyền dữ liệu ra
        $this->view('client/pages/home/index', [
            'title' => 'Trang chủ - FASHION',
            'products' => $featuredProducts,
            'categories' => $categories,
            'likedProducts' => $likedProducts,
            'settings' => $settings
        ]);
    }
}
