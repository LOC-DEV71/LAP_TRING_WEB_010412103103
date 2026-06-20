<?php
namespace Core;

class JwtUtils
{
    private static $secret = 'GearX_SecretKey_2026!@#';

    // Sinh chuỗi JWT từ dữ liệu truyền vào
    public static function encode($payload)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload['exp'] = time() + (86400 * 7); // Hạn 7 ngày
        $payloadJson = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payloadJson));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    // Giải mã và kiểm tra tính hợp lệ của JWT
    public static function decode($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;

        // Kiểm tra chữ ký
        $validSignature = hash_hmac('sha256', $header . "." . $payload, self::$secret, true);
        $base64UrlValidSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($validSignature));

        if (!hash_equals($base64UrlValidSignature, $signature)) {
            return false; // Sai chữ ký
        }

        $payloadData = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);
        
        // Kiểm tra hạn sử dụng
        if (isset($payloadData['exp']) && $payloadData['exp'] < time()) {
            return false; // Đã hết hạn
        }

        return $payloadData;
    }
}
