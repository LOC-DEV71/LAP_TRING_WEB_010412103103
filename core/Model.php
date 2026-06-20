<?php
namespace Core;

use PDO;

class Model
{
    protected $db;

    public function __construct()
    {
        // Sử dụng biến $conn đã được khởi tạo trong config/database.php
        global $conn;
        if (isset($conn) && $conn instanceof PDO) {
            $this->db = $conn;
        } else {
            die("Lỗi: Không tìm thấy kết nối cơ sở dữ liệu (PDO).");
        }
    }

    // Một số hàm tiện ích chung có thể thêm ở đây
}
