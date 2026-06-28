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

    // Lấy kết nối cơ sở dữ liệu PDO
    public function getDbConnection()
    {
        return $this->db;
    }
}
