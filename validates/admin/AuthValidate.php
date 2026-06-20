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
        }
        
        if (empty($data['password'])) {
            $errors['password'] = "Vui lòng nhập Mật khẩu.";
        }
        
        return $errors;
    }
}
