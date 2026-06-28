<?php
namespace Controllers\Client;

use Core\Controller;
use Core\JwtUtils;
use Models\Product;
use Models\ProductCategory;
use Models\Like;

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

        // Lấy danh sách biến thể màu/size cho từng sản phẩm
        if (!empty($products)) {
            $productIds = array_column($products, '_id');
            $variantModel = new \Models\ProductVariant();
            $variantsData = $variantModel->getColorsAndSizesByProductIds($productIds);
            
            // Map lại vào mảng products
            $variantsMap = [];
            foreach ($variantsData as $vd) {
                $variantsMap[$vd['product_id']] = $vd;
            }
            
            foreach ($products as &$product) {
                $product['colors'] = $variantsMap[$product['_id']]['colors'] ?? '';
                $product['sizes'] = $variantsMap[$product['_id']]['sizes'] ?? '';
            }
        }

        $categoryName = $categoryInfo ? mb_convert_case($categoryInfo['title'], MB_CASE_TITLE, 'UTF-8') : 'Tất cả sản phẩm';
        $bannerTitle = $categoryInfo ? mb_convert_case($categoryInfo['title'], MB_CASE_UPPER, 'UTF-8') : 'THỜI TRANG';

        // Lấy danh sách sản phẩm đã Like của User (nếu đã đăng nhập)
        $likedProducts = [];
        $token = $_COOKIE['jwt_token'] ?? '';
        if (empty($token)) {
            $token = $_COOKIE['admin_jwt_token'] ?? '';
        }
        
        if (!empty($token)) {
            $payload = JwtUtils::decode($token);
            if (is_array($payload)) {
                $userId = $payload['user_id'] ?? ($payload['account_id'] ?? null);
                if ($userId) {
                    $likeModel = new Like();
                    $likedProducts = $likeModel->getLikedProductsByClient($userId);
                }
            }
        }

        $this->view('client/pages/products/index', [
            'title' => $categoryName . ' - FASHION',
            'products' => $products,
            'categoryName' => $categoryName,
            'bannerTitle' => $bannerTitle,
            'bannerDesc' => 'Khám phá các thiết kế mới nhất',
            'likedProducts' => $likedProducts
        ]);
    }

    // Chi tiết sản phẩm
    public function detail($id = null)
    {
        if (!$id) {
            header('Location: ' . url('products'));
            exit;
        }

        $productModel = new Product();
        $product = $productModel->getById($id);

        if (!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại.";
            header('Location: ' . url('products'));
            exit;
        }

        // Lấy danh sách biến thể của sản phẩm
        $variantModel = new \Models\ProductVariant();
        $variants = $variantModel->getByProductId($product['_id']);

        // Lấy danh sách ảnh phụ của sản phẩm
        $imageModel = new \Models\ProductImage();
        $productImages = $imageModel->getByProductId($product['_id']);

        $this->view('client/pages/products/detail', [
            'title' => $product['title'] . ' - FASHION',
            'product' => $product,
            'variants' => $variants,
            'productImages' => $productImages
        ]);
    }

    // API Toggle Like
    public function toggleLike()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }

        // Kiểm tra đăng nhập (Hỗ trợ cả Client và Admin)
        $token = $_COOKIE['jwt_token'] ?? '';
        if (empty($token)) {
            $token = $_COOKIE['admin_jwt_token'] ?? '';
        }

        // DUMP LOG TO DEBUG:
        file_put_contents(__DIR__ . '/debug_like.txt', "Cookies: " . print_r($_COOKIE, true) . "\nToken selected: " . $token . "\n", FILE_APPEND);

        $payload = !empty($token) ? JwtUtils::decode($token) : null;
        file_put_contents(__DIR__ . '/debug_like.txt', "Payload: " . print_r($payload, true) . "\n", FILE_APPEND);

        // Nếu token không hợp lệ hoặc decode ra false, ngắt và trả về 401
        if (!is_array($payload)) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Phiên đăng nhập đã hết hạn. Cookie: ' . json_encode($_COOKIE)]);
            exit;
        }

        // payload có thể chứa user_id (client) hoặc account_id (admin)
        $userId = $payload['user_id'] ?? ($payload['account_id'] ?? null);

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Tài khoản không hợp lệ.']);
            exit;
        }

        // Đọc dữ liệu JSON từ request body
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? ($_POST['product_id'] ?? '');

        if (empty($productId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Mã sản phẩm không hợp lệ.']);
            exit;
        }

        $likeModel = new Like();

        $check = $likeModel->checkLiked($userId, $productId);
        if ($check) {
            // Đã like -> Xóa like
            $likeModel->remove($userId, $productId);
            echo json_encode(['success' => true, 'liked' => false, 'message' => 'Đã bỏ thích sản phẩm.']);
        } else {
            // Chưa like -> Thêm like
            $likeModel->add($userId, $productId);
            echo json_encode(['success' => true, 'liked' => true, 'message' => 'Đã thêm vào danh sách yêu thích.']);
        }
    }

    // API Get Product Details (for Modal)
    public function apiGetDetails()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }

        $productId = $_GET['id'] ?? null;
        if (!$productId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing product ID']);
            exit;
        }

        $productModel = new Product();
        $product = $productModel->getById($productId);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        $variantModel = new \Models\ProductVariant();
        $variants = $variantModel->getByProductId($productId);

        echo json_encode([
            'success' => true,
            'product' => [
                '_id' => $product['_id'],
                'title' => $product['title'],
                'price' => $product['price'],
                'thumbnail' => $product['thumbnail']
            ],
            'variants' => $variants
        ]);
        exit;
    }
}
