<?php
namespace Core;

class Controller
{
    // Hàm hỗ trợ gọi View và truyền dữ liệu
    public function view($view, $data = [])
    {
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
