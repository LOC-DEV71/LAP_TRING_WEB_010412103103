<?php
namespace Validates\Client;

use Core\ValidationUtils;

class AuthValidate
{
    // Xác thực form đăng nhập (Email, SĐT hoặc Tên đăng nhập)
    public static function login($data)
    {
        $errors = [];

        if (empty($data['login_key'])) {
            $errors['login_key'] = "Tài khoản đăng nhập không được để trống.";
        }

        if (empty($data['password'])) {
            $errors['password'] = "Mật khẩu không được để trống.";
        }


        return $errors;
    }

    // Xác thực form đăng ký
    public static function register($data)
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = "Tên người dùng không được để trống.";
        }

        if (empty($data['email'])) {
            $errors['email'] = "Email không được để trống.";
        } elseif (!\Core\ValidationUtils::isValidEmail($data['email'])) {
            $errors['email'] = "Email không đúng định dạng.";
        }

        if (empty($data['password'])) {
            $errors['password'] = "Mật khẩu không được để trống.";
        } elseif (!\Core\ValidationUtils::isStrongPassword($data['password'])) {
            $errors['password'] = "Mật khẩu phải từ 8-16 ký tự, có 1 chữ hoa và 1 ký tự đặc biệt (@#$%^&*).";
        }


        return $errors;
    }
}
