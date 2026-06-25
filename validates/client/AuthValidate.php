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

        // Xác thực CAPTCHA chống spam (chỉ khi đăng nhập sai từ 3 lần trở lên)
        if (($_SESSION['login_attempts'] ?? 0) >= 3) {
            if (empty($data['captcha'])) {
                $errors['captcha'] = "Mã xác thực không được để trống.";
            } elseif (empty($_SESSION['captcha']) || strtolower($data['captcha']) !== $_SESSION['captcha']) {
                $errors['captcha'] = "Mã xác thực CAPTCHA không chính xác.";
            }
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

        // Xác thực CAPTCHA chống spam cho đăng ký
        if (empty($data['captcha'])) {
            $errors['captcha'] = "Mã xác thực không được để trống.";
        } elseif (empty($_SESSION['captcha']) || strtolower($data['captcha']) !== $_SESSION['captcha']) {
            $errors['captcha'] = "Mã xác thực CAPTCHA không chính xác.";
        }

        return $errors;
    }
}
