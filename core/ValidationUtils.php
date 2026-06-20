<?php
namespace Core;

class ValidationUtils
{
    // Kiểm tra định dạng email
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Kiểm tra mật khẩu (8-16 ký tự, 1 chữ hoa, 1 ký tự đặc biệt)
    public static function isStrongPassword($password)
    {
        if (strlen($password) < 8 || strlen($password) > 16) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        if (!preg_match('/[@#$%^&*]/', $password)) {
            return false;
        }
        return true;
    }
}
