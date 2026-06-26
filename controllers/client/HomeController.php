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

        // Gọi view 'pages/client/home/index.php' và truyền dữ liệu ra
        $this->view('pages/client/home/index', [
            'title' => 'Trang chủ - FASHION',
            'products' => $featuredProducts,
            'categories' => $categories,
            'likedProducts' => $likedProducts
        ]);
    }
}
