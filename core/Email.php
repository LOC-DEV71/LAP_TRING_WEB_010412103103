<?php
namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    /**
     * Gửi email sử dụng SMTP và PHPMailer
     * 
     * @param string $to Địa chỉ email người nhận
     * @param string $subject Tiêu đề email
     * @param string $body Nội dung email (hỗ trợ HTML)
     * @return bool Trả về true nếu gửi thành công, ngược lại là false
     */
    public static function send($to, $subject, $body)
    {
        $configPath = 'config/email.php';
        if (!file_exists($configPath)) {
            error_log("PHPMailer Error: Config file config/email.php not found.");
            return false;
        }

        $config = require $configPath;
        $mail = new PHPMailer(true);

        try {
            // Cấu hình Server SMTP
            $mail->isSMTP();
            $mail->Host       = $config['host'];
            $mail->SMTPAuth   = $config['auth'];
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = $config['secure'];
            $mail->Port       = $config['port'];
            $mail->CharSet    = 'UTF-8';

            // Thiết lập người gửi và người nhận
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($to);

            // Cấu hình Nội dung Email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("PHPMailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
