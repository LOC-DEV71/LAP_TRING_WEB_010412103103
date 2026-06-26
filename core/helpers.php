<?php

if (!function_exists('asset')) {
    function asset($path) {
        // Tự động nhận diện thư mục gốc của dự án (ví dụ: /LAP_TRING_WEB_010412103103)
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = rtrim($basePath, '/');
        return $basePath . '/public/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    function url($path) {
        // Tự động nhận diện thư mục gốc của dự án cho các link định tuyến
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = rtrim($basePath, '/');
        return $basePath . '/' . ltrim($path, '/');
    }
}

if (!function_exists('loadEnv')) {
    function loadEnv($path) {
        if (!file_exists($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            // Bỏ qua dòng trống hoặc dòng bình luận
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            // Chỉ phân tách ở dấu bằng đầu tiên
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                // Loại bỏ dấu ngoặc kép hoặc ngoặc đơn ở hai đầu giá trị
                if (preg_match('/^([\'"])(.*)\1$/', $value, $matches)) {
                    $value = $matches[2];
                }
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }
        return $value;
    }
}
