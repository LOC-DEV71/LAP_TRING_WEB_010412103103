<?php

class CartController {
    
    public function index() {
        // In thử dữ liệu Session ra màn hình để test
        echo '<pre style="margin-top:100px; padding:20px; background:#f4f4f4; border:1px solid #ddd;">';
        print_r($_SESSION['cart'] ?? 'Giỏ hàng đang trống');
        echo '</pre>';   

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
                header('Location: /?controller=cart');
                exit;
            }
        }
        die("Lỗi: Dữ liệu sản phẩm không hợp lệ.");
    }
    
}
?>