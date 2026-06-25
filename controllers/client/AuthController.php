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
            $loginKey = $_POST['login_key'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = AuthValidate::login($_POST);

            if (empty($errors)) {
                $userModel = new User();
                $user = $userModel->getByLoginKey($loginKey);

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
                    
                    header('Location: ' . url(''));
                    exit;
                } else {
                    $errors['auth'] = "Tài khoản hoặc mật khẩu không chính xác.";
                }
            }

            return $this->view('pages/client/auth/login', [
                'title' => 'Đăng Nhập Khách Hàng',
                'errors' => $errors,
                'old_login_key' => $loginKey,
                'active_tab' => 'login'
            ]);
        }

        $this->view('pages/client/auth/login', [
            'title' => 'Đăng Nhập Khách Hàng',
            'errors' => []
        ]);
    }

    // Xử lý đăng ký tài khoản Client
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = AuthValidate::register([
                'email' => $email,
                'password' => $password
            ]);

            if (empty($errors)) {
                $userModel = new User();
                if ($userModel->getByEmail($email)) {
                    $errors['email'] = "Email này đã được sử dụng.";
                } else {
                    $newId = 'usr_' . bin2hex(random_bytes(6));
                    $userData = [
                        '_id' => $newId,
                        'fullname' => $username,
                        'email' => $email,
                        'password' => $password,
                        'address' => '',
                        'phone' => ''
                    ];

                    if ($userModel->create($userData)) {
                        $_SESSION['register_success'] = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
                        header('Location: ' . url('auth/login'));
                        exit;
                    } else {
                        $errors['auth'] = "Đăng ký thất bại, vui lòng thử lại.";
                    }
                }
            }

            return $this->view('pages/client/auth/login', [
                'title' => 'Đăng Ký Khách Hàng',
                'errors' => $errors,
                'old_email' => $email,
                'old_username' => $username,
                'active_tab' => 'register'
            ]);
        }

        header('Location: ' . url('auth/login'));
        exit;
    }

    // Xử lý đăng xuất và xóa Token Client
    public function logout()
    {
        setcookie('jwt_token', '', time() - 3600, "/");
        header('Location: ' . url('auth/login'));
        exit;
    }
}
