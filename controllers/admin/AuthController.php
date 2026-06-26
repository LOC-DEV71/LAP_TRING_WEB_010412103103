<?php
namespace Controllers\Admin;

use Core\Controller;
use Core\JwtUtils;
use Models\Account;
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
                $accountModel = new Account();
                $user = $accountModel->getByEmail($email);

                // Kiểm tra Account có tồn tại và đúng password
                if ($user && password_verify($password, $user['password'])) {
                    
                    // Kiểm tra status nếu cần
                    if ($user['status'] === 'inactive') {
                        $errors['auth'] = "Tài khoản của bạn đã bị khóa.";
                    } else {
                        $payload = [
                            'account_id' => $user['_id'],
                            'fullname' => $user['fullname'],
                            'role_slug' => $user['role_slug']
                        ];
                        $token = JwtUtils::encode($payload);

                        // Lưu JWT vào Cookie riêng cho Admin (Tránh xung đột với cookie Client)
                        setcookie('admin_jwt_token', $token, time() + (86400 * 7), "/", "", false, true);
                        
                        // Reset lại số lần nhập sai khi đăng nhập thành công
                        unset($_SESSION['admin_login_attempts']);
                        
                        header('Location: ' . url('admin/dashboard'));
                        exit;
                    }
                } else {
                    $errors['auth'] = "Tài khoản hoặc mật khẩu Quản trị viên không chính xác.";
                }
            }

            return $this->view('pages/admin/auth/login', [
                'title' => 'Đăng Nhập Quản Trị Viên',
                'errors' => $errors,
                'old_email' => $email
            ]);
        }

        $this->view('pages/admin/auth/login', [
            'title' => 'Đăng Nhập Quản Trị Viên',
            'errors' => []
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
