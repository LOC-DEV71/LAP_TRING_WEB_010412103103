<?php
namespace Controllers\Admin;

use Core\Controller;
use Core\JwtUtils;
use Models\User;
use Validates\Admin\AuthValidate;

class AuthController extends Controller
{
    // Xử lý hiển thị form và đăng nhập Admin
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = AuthValidate::login($_POST);

            if (empty($errors)) {
                $userModel = new User();
                $user = $userModel->getByEmail($email);

                // Kiểm tra User có tồn tại và đúng password
                if ($user && password_verify($password, $user['password'])) {
                    
                    // Tùy theo logic phân quyền của anh, anh có thể check role tại đây.
                    // Ví dụ: if ($user['role'] !== 'admin') { báo lỗi }

                    $payload = [
                        'user_id' => $user['_id'],
                        'fullname' => $user['fullname'],
                        'role' => $user['member']
                    ];
                    $token = JwtUtils::encode($payload);

                    // Lưu JWT vào Cookie riêng cho Admin (Tránh xung đột với cookie Client)
                    setcookie('admin_jwt_token', $token, time() + (86400 * 7), "/", "", false, true);
                    
                    // Reset lại số lần nhập sai khi đăng nhập thành công
                    unset($_SESSION['admin_login_attempts']);
                    
                    header('Location: ' . url('admin/dashboard'));
                    exit;
                } else {
                    // Đăng nhập thất bại, tăng số lần nhập sai lên 1
                    $_SESSION['admin_login_attempts'] = ($_SESSION['admin_login_attempts'] ?? 0) + 1;
                    $errors['auth'] = "Tài khoản hoặc mật khẩu Quản trị viên không chính xác.";
                }
            } else {
                // Nếu form có lỗi nhập liệu (như thiếu captcha khi đã kích hoạt)
                $_SESSION['admin_login_attempts'] = ($_SESSION['admin_login_attempts'] ?? 0) + 1;
            }

            return $this->view('pages/admin/auth/login', [
                'title' => 'Đăng Nhập Quản Trị Viên',
                'errors' => $errors,
                'old_email' => $email,
                'show_captcha' => ($_SESSION['admin_login_attempts'] ?? 0) >= 3
            ]);
        }

        $this->view('pages/admin/auth/login', [
            'title' => 'Đăng Nhập Quản Trị Viên',
            'errors' => [],
            'show_captcha' => ($_SESSION['admin_login_attempts'] ?? 0) >= 3
        ]);
    }

    // Xử lý đăng xuất và xóa Token Admin
    public function logout()
    {
        setcookie('admin_jwt_token', '', time() - 3600, "/");
        header('Location: ' . url('admin/auth/login'));
        exit;
    }
}
