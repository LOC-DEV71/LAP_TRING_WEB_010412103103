<?php
namespace Controllers\Client;

use Models\ProductVariant;
use Models\Product;
use Core\Controller;

class CartController {
    
    public function index() {
        $cartData = [];
        $totalPrice = 0;

        //check item in cart
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $variantModel = new ProductVariant();
            $productModel = new Product();

            foreach ($_SESSION['cart'] as $variantId => $quantity) {
                $variant = $variantModel->getById($variantId);
                if ($variant) {
                    $product = $productModel->getById($variant['product_id']);
                    if ($product) {
                        $subtotal = $product['price'] * $quantity;
                        $totalPrice += $subtotal;

                        $cartData[] = [
                            'variant_id' => $variantId,
                            'title' => $product['title'],
                            'color' => $variant['color'],
                            'size' => $variant['size'],
                            'price' => $product['price'],
                            'thumbnail' => $product['thumbnail'],
                            'quantity' => $quantity,
                            'subtotal' => $subtotal
                        ];
                    }
                }
            }
        }
        // 1. Header 
        if (file_exists('views/layouts/client/header.php')) {
            require_once 'views/layouts/client/header.php';
        }

        // 2. Nội dung chính của Giỏ hàng
        require_once 'views/pages/client/cart.php';

        // 3. Footer 
        if (file_exists('views/layouts/client/footer.php')) {
            require_once 'views/layouts/client/footer.php';
        }
    }

    // Hàm xử lý logic Thêm vào giỏ hàng
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu payload từ form gửi lên
            $variantId = $_POST['product_variant_id'] ?? null;
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($variantId && $quantity > 0) {
                // Khởi tạo mảng giỏ hàng nếu khách chưa có
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // Kiểm tra xem sản phẩm đã tồn tại trong giỏ chưa
                if (isset($_SESSION['cart'][$variantId])) {
                    // Nếu có rồi thì cộng dồn số lượng
                    $_SESSION['cart'][$variantId] += $quantity;
                } else {
                    // Nếu chưa có thì thêm mới
                    $_SESSION['cart'][$variantId] = $quantity;
                }

                // Chuyển hướng người dùng về trang giỏ hàng để xem thành quả
                header('Location: /cart');
                exit;
            }
        }
        die("Lỗi: Dữ liệu sản phẩm không hợp lệ.");
    }
    
    // Hàm xử lý Xóa 1 sản phẩm khỏi giỏ
    public function remove($variantId = null) {
        // Kiểm tra xem mã sản phẩm có được gửi lên và có tồn tại trong giỏ không
        if ($variantId && isset($_SESSION['cart'][$variantId])) {
            // Rút sản phẩm đó khỏi bộ nhớ Session
            unset($_SESSION['cart'][$variantId]);
        }
        
        // Xóa xong thì điều hướng quay lại đúng trang Giỏ hàng
        header('Location: /cart');
        exit;
    }
}
?>