<?php
namespace Controllers\Client;

use Core\Controller;
use Core\JwtUtils;
use Models\User;

class UserController extends Controller
{
    public function profile()
    {
        // 1. Kiểm tra JWT Token trong Cookie
        $token = $_COOKIE['jwt_token'] ?? '';
        $payload = null;

        if (!empty($token)) {
            $payload = JwtUtils::decode($token);
        }

        // Nếu chưa đăng nhập hoặc token không hợp lệ
        if (!$payload) {
            $_SESSION['login_error'] = "Vui lòng đăng nhập để truy cập trang cá nhân.";
            header('Location: ' . url('auth/login'));
            exit;
        }

        // 2. Lấy thông tin chi tiết của người dùng từ database
        $userModel = new User();
        $user = $userModel->getById($payload['user_id']);

        if (!$user) {
            $_SESSION['login_error'] = "Tài khoản không tồn tại trên hệ thống.";
            header('Location: ' . url('auth/login'));
            exit;
        }

        // 3. Lấy lịch sử đơn hàng thực tế của người dùng
        $orderModel = new \Models\Order();
        $orders = $orderModel->getAllByUserId($user['_id']);

        // 4. Hiển thị trang cá nhân cùng với dữ liệu người dùng và đơn hàng
        $this->view('pages/client/user/profile', [
            'title' => 'Trang cá nhân - ' . $user['fullname'],
            'user' => $user,
            'orders' => $orders
        ]);
    }

    // Mặc định chuyển hướng về trang cá nhân
    public function index()
    {
        $this->profile();
    }
}
