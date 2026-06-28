<?php
namespace Controllers\Admin;

use Core\Controller;
use Core\JwtUtils;

class AdminBaseController extends Controller
{
    public function __construct()
    {
        // Kiểm tra Token Admin đăng nhập
        $token = $_COOKIE['admin_jwt_token'] ?? '';
        if (empty($token)) {
            header('Location: ' . url('admin/auth/login'));
            exit;
        }

        $payload = JwtUtils::decode($token);
        if (!is_array($payload) || empty($payload['account_id'])) {
            // Token không hợp lệ -> xóa cookie và yêu cầu đăng nhập lại
            setcookie('admin_jwt_token', '', time() - 3600, "/");
            header('Location: ' . url('admin/auth/login'));
            exit;
        }

        // Lưu thông tin admin vào session hoặc biến toàn cục nếu cần thiết dùng ở các trang con
        $_SESSION['admin_user'] = $payload;
    }
}
