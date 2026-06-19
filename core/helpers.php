<?php

if (!function_exists('asset')) {
    function asset($path) {
        // Trả về đường dẫn tuyệt đối bắt đầu từ thư mục public
        return '/public/' . ltrim($path, '/');
    }
}
