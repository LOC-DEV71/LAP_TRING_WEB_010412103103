<?php
namespace Controllers\Client;

use Core\Controller;
use Core\JwtUtils;
use Models\User;
use Validates\Client\AuthValidate;

class AuthController extends Controller
{
    // Xử lý hiển thị form và đăng nhập Client
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = AuthValidate::login($_POST);

            if (empty($errors)) {
                $userModel = new User();
                $user = $userModel->getByEmail($email);

                // Sử dụng password_verify để so sánh hash Bcrypt
                if ($user && password_verify($password, $user['password'])) {
                    
                    // Tạo payload và sinh chuỗi JWT
                    $payload = [
                        'user_id' => $user['_id'],
                        'fullname' => $user['fullname'],
                        'role' => $user['member']
                    ];
                    $token = JwtUtils::encode($payload);

                    // Lưu JWT vào Cookie, thiết lập HttpOnly = true để chống XSS
                    setcookie('jwt_token', $token, time() + (86400 * 7), "/", "", false, true);
                    
                    header('Location: /');
                    exit;
                } else {
                    $errors['auth'] = "Email hoặc mật khẩu không chính xác.";
                }
            }

            return $this->view('pages/client/auth/login', [
                'title' => 'Đăng Nhập Khách Hàng',
                'errors' => $errors,
                'old_email' => $email
            ]);
        }

        $this->view('pages/client/auth/login', [
            'title' => 'Đăng Nhập Khách Hàng',
            'errors' => []
        ]);
    }

    // Xử lý đăng xuất và xóa Token Client
    public function logout()
    {
        setcookie('jwt_token', '', time() - 3600, "/");
        header('Location: /login');
        exit;
    }
}
