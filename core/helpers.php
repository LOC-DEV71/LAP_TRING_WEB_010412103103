<?php

if (!function_exists('asset')) {
    function asset($path) {
        // Tự động nhận diện thư mục gốc của dự án (ví dụ: /LAP_TRING_WEB_010412103103)
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = rtrim($basePath, '/');
        return $basePath . '/public/' . ltrim($path, '/');
    }
}
