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

        
        return $errors;
    }
}
