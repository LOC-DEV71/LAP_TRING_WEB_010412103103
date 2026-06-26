<?php
namespace Controllers\Client;

use Core\Controller;
use Core\JwtUtils;
use Models\User;
use Validates\Client\AuthValidate;
use Core\Email;

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
                    
                    // Đăng nhập thành công, reset lại số lần nhập sai
                    unset($_SESSION['login_attempts']);
                    
                    header('Location: ' . url(''));
                    exit;
                } else {
                    // Chống Spam
                    // Đăng nhập thất bại, tăng số lần nhập sai lên 1
                    $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                    $errors['auth'] = "Tài khoản hoặc mật khẩu không chính xác.";
                }
            } else {
                // Nếu form có lỗi nhập liệu (như thiếu captcha khi đã kích hoạt)
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
            }

            return $this->view('pages/client/auth/login', [
                'title' => 'Đăng Nhập Khách Hàng',
                'errors' => $errors,
                'old_login_key' => $loginKey,
                'active_tab' => 'login',
                'show_captcha' => ($_SESSION['login_attempts'] ?? 0) >= 3
            ]);
        }

        $this->view('pages/client/auth/login', [
            'title' => 'Đăng Nhập Khách Hàng',
            'errors' => [],
            'show_captcha' => ($_SESSION['login_attempts'] ?? 0) >= 3
        ]);
    }

    // Xử lý đăng ký tài khoản Client
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = AuthValidate::register($_POST);

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

    // Hiển thị form và xử lý yêu cầu Quên mật khẩu
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $errors = [];

            if (empty($email)) {
                $errors['email'] = "Vui lòng nhập địa chỉ Email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Định dạng Email không hợp lệ.";
            }

            if (empty($errors)) {
                $userModel = new User();
                $user = $userModel->getByEmail($email);

                if ($user) {
                    // Tạo token khôi phục ngẫu nhiên và bảo mật
                    $token = bin2hex(random_bytes(32));
                    // Token có hiệu lực trong 15 phút (900 giây)
                    $expiresAt = date('Y-m-d H:i:s', time() + 900);

                    if ($userModel->updateResetToken($email, $token, $expiresAt)) {
                        $resetLink = url('auth/resetPassword/' . $token);
                        $subject = "[DEMO LOCALHOST] Khôi phục mật khẩu tài khoản Fashion Store";
                        $body = "
                            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;'>
                                <div style='text-align: right; margin-bottom: 10px;'>
                                    <span style='background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; border: 1px solid #fca5a5;'>LOCALHOST DEMO</span>
                                </div>
                                <h2 style='color: #1a1a1a; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; text-transform: uppercase; margin-top: 0;'>Khôi phục mật khẩu</h2>
                                <p>Xin chào <strong>" . htmlspecialchars($user['fullname']) . "</strong>,</p>
                                <p>Chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản Fashion Store liên kết với địa chỉ email này.</p>
                                <p>Vui lòng click vào liên kết bên dưới để đặt lại mật khẩu mới cho tài khoản của bạn (liên kết này có hiệu lực trong vòng <strong>15 phút</strong>):</p>
                                <div style='text-align: center; margin: 30px 0;'>
                                    <a href='{$resetLink}' style='background: #1a1a1a; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; display: inline-block;'>Đặt lại mật khẩu</a>
                                </div>
                                <p style='color: #4a5568; font-size: 0.9rem;'>Hoặc bạn có thể sao chép liên kết dưới đây và dán vào thanh địa chỉ của trình duyệt:</p>
                                <p style='word-break: break-all;'><a href='{$resetLink}'>{$resetLink}</a></p>
                                <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;'/>
                                <p style='color: #718096; font-size: 0.8rem;'>Nếu bạn không gửi yêu cầu này, bạn có thể bỏ qua email này một cách an toàn. Mật khẩu của bạn sẽ vẫn giữ nguyên.</p>
                                <p style='color: #718096; font-size: 0.8rem; font-weight: bold;'>Fashion Store Support Team.</p>
                            </div>
                        ";

                        if (Email::send($email, $subject, $body)) {
                            $_SESSION['forgot_success'] = "Đã gửi liên kết đặt lại mật khẩu đến email của bạn! Vui lòng kiểm tra hộp thư.";
                        } else {
                            $errors['auth'] = "Không thể gửi email khôi phục lúc này. Vui lòng thử lại sau.";
                        }
                    } else {
                        $errors['auth'] = "Có lỗi xảy ra trên hệ thống. Vui lòng thử lại.";
                    }
                } else {
                    // Để bảo mật thông tin, không tiết lộ email tồn tại hay không, 
                    // tuy nhiên vì mục đích làm bài tập học viên dễ test, chúng ta thông báo trực tiếp:
                    $errors['email'] = "Địa chỉ email này không tồn tại trong hệ thống.";
                }
            }

            return $this->view('pages/client/auth/forgot_password', [
                'title' => 'Quên Mật Khẩu',
                'errors' => $errors,
                'old_email' => $email
            ]);
        }

        return $this->view('pages/client/auth/forgot_password', [
            'title' => 'Quên Mật Khẩu',
            'errors' => []
        ]);
    }

    // Hiển thị form và xử lý đặt lại mật khẩu mới
    public function resetPassword($token = null)
    {
        if (empty($token)) {
            $_SESSION['login_error'] = "Đường dẫn khôi phục mật khẩu không hợp lệ.";
            header('Location: ' . url('auth/forgotPassword'));
            exit;
        }

        $userModel = new User();
        $user = $userModel->getByResetToken($token);

        if (!$user || strtotime($user['reset_token_expires']) < time()) {
            // Token không hợp lệ hoặc đã hết hạn
            return $this->view('pages/client/auth/forgot_password', [
                'title' => 'Quên Mật Khẩu',
                'errors' => ['auth' => 'Đường dẫn khôi phục mật khẩu không hợp lệ hoặc đã hết hạn. Vui lòng gửi yêu cầu mới.']
            ]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $errors = [];

            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu mới.";
            } elseif (strlen($password) < 6) {
                $errors['password'] = "Mật khẩu phải có độ dài tối thiểu từ 6 ký tự.";
            }

            if ($password !== $confirmPassword) {
                $errors['confirm_password'] = "Mật khẩu xác nhận không khớp.";
            }

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                if ($userModel->updatePasswordAndClearToken($user['_id'], $hashedPassword)) {
                    $_SESSION['register_success'] = "Đặt lại mật khẩu thành công! Vui lòng đăng nhập bằng mật khẩu mới.";
                    header('Location: ' . url('auth/login'));
                    exit;
                } else {
                    $errors['auth'] = "Đặt lại mật khẩu thất bại. Vui lòng thử lại.";
                }
            }

            return $this->view('pages/client/auth/reset_password', [
                'title' => 'Đặt Lại Mật Khẩu',
                'token' => $token,
                'errors' => $errors
            ]);
        }

        return $this->view('pages/client/auth/reset_password', [
            'title' => 'Đặt Lại Mật Khẩu',
            'token' => $token,
            'errors' => []
        ]);
    }
}
