<?php

class CartController {
    
    public function index() {
        
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
    
}
?>