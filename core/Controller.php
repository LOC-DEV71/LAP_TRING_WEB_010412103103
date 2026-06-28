<?php
namespace Core;

use Models\Product\ProductCategory;

class Controller
{
    // Hàm hỗ trợ gọi View và truyền dữ liệu
    public function view($view, $data = [])
    {
        // Tự động nạp danh mục cho Header ở mọi trang
        if (!isset($data['categories'])) {
            try {
                $categoryModel = new ProductCategory();
                $data['categories'] = $categoryModel->getAllActive();
            } catch (\Exception $e) {}
        }

        // Biến mảng $data thành các biến độc lập
        extract($data);

        $viewPath = 'views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Lỗi: Không tìm thấy giao diện (View) tại " . $viewPath);
        }
    }
}
