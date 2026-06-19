<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'client'): void
    {
        // Giải nén các biến dữ liệu để sử dụng trong view
        extract($data);

        $viewsDir = dirname(__DIR__, 2) . '/views';

        // Đường dẫn đến layout và view
        $layoutPath = $viewsDir . "/layouts/{$layout}.php";
        // Cho phép định dạng view dạng 'admin/dashboard' hoặc 'client/home'
        $viewPath = $viewsDir . "/pages/{$view}.php";

        if (!file_exists($viewPath)) {
            echo "<h1>Không tìm thấy View: " . htmlspecialchars($view) . "</h1>";
            return;
        }

        if (file_exists($layoutPath)) {
            // Đọc nội dung view vào một bộ đệm
            ob_start();
            include $viewPath;
            $content = ob_get_clean();

            // Nhúng layout (layout sẽ hiển thị biến $content)
            include $layoutPath;
        } else {
            // Render trực tiếp nếu không tìm thấy layout
            include $viewPath;
        }
    }
}
