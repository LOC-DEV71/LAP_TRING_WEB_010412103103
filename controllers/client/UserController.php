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

        // 4. Lấy danh sách sản phẩm yêu thích
        $likeModel = new \Models\Like();
        $likedProductIds = $likeModel->getLikedProductsByClient($user['_id']);
        
        $likedProducts = [];
        if (!empty($likedProductIds)) {
            $productModel = new \Models\Product();
            $likedProducts = $productModel->getByIds($likedProductIds);
        }

        // 5. Hiển thị trang cá nhân cùng với dữ liệu người dùng, đơn hàng và sản phẩm yêu thích
        $this->view('pages/client/user/profile', [
            'title' => 'Trang cá nhân - ' . $user['fullname'],
            'user' => $user,
            'orders' => $orders,
            'likedProducts' => $likedProducts
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('user/profile'));
            exit;
        }

        // 1. Kiểm tra JWT Token
        $token = $_COOKIE['jwt_token'] ?? '';
        $payload = null;
        if (!empty($token)) {
            $payload = JwtUtils::decode($token);
        }

        if (!$payload) {
            $_SESSION['login_error'] = "Vui lòng đăng nhập.";
            header('Location: ' . url('auth/login'));
            exit;
        }

        // 2. Nhận dữ liệu POST
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        // 3. Validation
        if (empty($fullname)) {
            $_SESSION['profile_error'] = "Họ tên không được để trống.";
            header('Location: ' . url('user/profile'));
            exit;
        }

        // 4. Cập nhật vào DB
        $userModel = new User();
        $success = $userModel->updateProfile($payload['user_id'], $fullname, $phone, $address);

        if ($success) {
            $_SESSION['profile_success'] = "Cập nhật thông tin cá nhân thành công.";
        } else {
            $_SESSION['profile_error'] = "Không thể cập nhật thông tin. Vui lòng thử lại.";
        }

        header('Location: ' . url('user/profile'));
        exit;
    }

    // Mặc định chuyển hướng về trang cá nhân
    public function index()
    {
        $this->profile();
    }
}
