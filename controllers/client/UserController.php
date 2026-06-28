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
        $this->view('client/pages/user/profile', [
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

        $userModel = new User();
        $existingUser = $userModel->getByUsername($fullname);
        if ($existingUser && $existingUser['_id'] !== $payload['user_id']) {
            $_SESSION['profile_error'] = "Tên người dùng này đã được sử dụng bởi một tài khoản khác.";
            header('Location: ' . url('user/profile'));
            exit;
        }

        // 4. Cập nhật vào DB
        $success = $userModel->updateProfile($payload['user_id'], $fullname, $phone, $address);

        if ($success) {
            $_SESSION['profile_success'] = "Cập nhật thông tin cá nhân thành công.";
        } else {
            $_SESSION['profile_error'] = "Không thể cập nhật thông tin. Vui lòng thử lại.";
        }

        header('Location: ' . url('user/profile'));
        exit;
    }

    // Gửi email xác thực tài khoản
    public function sendVerification()
    {
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

        $userModel = new User();
        $user = $userModel->getById($payload['user_id']);

        if (!$user) {
            $_SESSION['profile_error'] = "Tài khoản không tồn tại.";
            header('Location: ' . url('user/profile'));
            exit;
        }

        if ($user['is_verified']) {
            $_SESSION['profile_success'] = "Tài khoản của bạn đã được xác thực trước đó.";
            header('Location: ' . url('user/profile'));
            exit;
        }

        // Tạo token xác thực ngẫu nhiên
        $verificationToken = bin2hex(random_bytes(32));
        $userModel->updateVerificationToken($user['_id'], $verificationToken);

        // Chuẩn bị nội dung email
        $domain = $_SERVER['HTTP_HOST'];
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        
        // Tạo link xác thực đầy đủ bao gồm base path
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));
        $baseDir = rtrim($baseDir, '/');
        $verifyLink = $protocol . $domain . $baseDir . "/user/verify?token=" . $verificationToken;

        $subject = "Xác thực tài khoản của bạn - Fashion Store";
        $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                <h2 style='color: #333; text-align: center;'>Xác Thực Tài Khoản</h2>
                <p>Xin chào <strong>" . htmlspecialchars($user['fullname']) . "</strong>,</p>
                <p>Cảm ơn bạn đã đăng ký tài khoản tại cửa hàng của chúng tôi. Vui lòng bấm vào nút bên dưới để xác thực địa chỉ email của bạn:</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$verifyLink}' style='background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>Xác Thực Ngay</a>
                </div>
                <p style='color: #777; font-size: 12px;'>Nếu nút trên không hoạt động, bạn có thể sao chép và dán liên kết sau vào trình duyệt:</p>
                <p style='color: #007bff; font-size: 12px; word-break: break-all;'>{$verifyLink}</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='color: #999; font-size: 12px; text-align: center;'>Đây là email tự động, vui lòng không phản hồi email này.</p>
            </div>
        ";

        if (\Core\Email::send($user['email'], $subject, $body)) {
            $_SESSION['profile_success'] = "Đã gửi email xác thực đến địa chỉ " . htmlspecialchars($user['email']) . ". Vui lòng kiểm tra hộp thư của bạn!";
        } else {
            $_SESSION['profile_error'] = "Không thể gửi email xác thực. Vui lòng thử lại sau.";
        }

        header('Location: ' . url('user/profile'));
        exit;
    }

    // Xử lý xác thực tài khoản khi click vào link
    public function verify()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $_SESSION['profile_error'] = "Liên kết xác thực không hợp lệ.";
            header('Location: ' . url('user/profile'));
            exit;
        }

        $userModel = new User();
        $user = $userModel->getByVerificationToken($token);

        if (!$user) {
            $_SESSION['profile_error'] = "Liên kết xác thực không hợp lệ hoặc đã hết hạn.";
            header('Location: ' . url('user/profile'));
            exit;
        }

        // Đánh dấu tài khoản đã xác thực
        $userModel->verifyUser($user['_id']);

        $_SESSION['profile_success'] = "Tài khoản của bạn đã được xác thực thành công!";
        header('Location: ' . url('user/profile'));
        exit;
    }

    // Mặc định chuyển hướng về trang cá nhân
    public function index()
    {

        $this->profile();
    }
}
