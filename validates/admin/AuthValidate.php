<?php
namespace Validates\Admin;

class AuthValidate
{
    // Xác thực dữ liệu form đăng nhập Admin
    public static function login($data)
    {
        $errors = [];
        
        if (empty($data['email'])) {
            $errors['email'] = "Vui lòng nhập Email Quản trị viên.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Định dạng email Quản trị viên không hợp lệ.";
        }
        
        if (empty($data['password'])) {
            $errors['password'] = "Vui lòng nhập Mật khẩu.";
        }

        // Kích hoạt CAPTCHA chống spam cho Admin khi nhập sai từ 3 lần trở lên
        if (($_SESSION['admin_login_attempts'] ?? 0) >= 3) {
            if (empty($data['captcha'])) {
                $errors['captcha'] = "Mã xác thực không được để trống.";
            } elseif (empty($_SESSION['captcha']) || strtolower($data['captcha']) !== $_SESSION['captcha']) {
                $errors['captcha'] = "Mã xác thực CAPTCHA không chính xác.";
            }
        }
        
        return $errors;
    }
}
