<?php
session_start();

// php.ini -> ;extension=gd -> extension=gd để ảnh hoạt động

// Sinh mã ngẫu nhiên gồm 5 ký tự (chữ và số)
$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$captcha_code = '';
for ($i = 0; $i < 5; $i++) {
    $captcha_code .= $chars[rand(0, strlen($chars) - 1)];
}

// Lưu mã đã chuyển thành chữ thường vào Session để so sánh không phân biệt hoa thường
$_SESSION['captcha'] = strtolower($captcha_code);

// Tạo ảnh bằng GD Library
$width = 130;
$height = 45;
$image = imagecreate($width, $height);

// Thiết lập màu sắc (Màu đầu tiên được allocate sẽ làm màu nền)
$bg_color = imagecolorallocate($image, 240, 242, 245); // Nền xám sáng sạch sẽ
$text_color = imagecolorallocate($image, 70, 72, 212); // Chữ màu xanh Indigo đồng bộ tông màu chủ đạo

// Vẽ một số đường kẻ nhiễu màu ngẫu nhiên để chống bot OCR tự động quét
for ($i = 0; $i < 4; $i++) {
    $line_color = imagecolorallocate($image, rand(160, 220), rand(160, 220), rand(160, 220));
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Vẽ các chấm nhiễu ngẫu nhiên
for ($i = 0; $i < 60; $i++) {
    $dot_color = imagecolorallocate($image, rand(130, 200), rand(130, 200), rand(130, 200));
    imagesetpixel($image, rand(0, $width), rand(0, $height), $dot_color);
}

// Viết mã CAPTCHA lên ảnh
$font_width = imagefontwidth(5);
$font_height = imagefontheight(5);
$total_width = $font_width * strlen($captcha_code);
$x = ($width - $total_width) / 2;
$y = ($height - $font_height) / 2;

// Viết từng ký tự và làm méo nhẹ bằng cách thay đổi tọa độ Y ngẫu nhiên
for ($i = 0; $i < strlen($captcha_code); $i++) {
    $char_x = $x + ($i * $font_width);
    $char_y = $y + rand(-4, 4);
    imagestring($image, 5, $char_x, $char_y, $captcha_code[$i], $text_color);
}

// Xuất ảnh dưới dạng PNG chất lượng cao
header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

imagepng($image);
imagedestroy($image);
