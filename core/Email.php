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
        $mail = new PHPMailer(true);

        try {
            // Cấu hình Server SMTP
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USER', 'trantrungnamm3@gmail.com');
            $mail->Password   = env('MAIL_PASS', 'your_app_password');
            $mail->SMTPSecure = env('MAIL_SECURE', 'ssl');
            $mail->Port       = env('MAIL_PORT', 465);
            $mail->CharSet    = 'UTF-8';

            // Thiết lập người gửi và người nhận
            $mail->setFrom(env('MAIL_FROM_EMAIL', 'trantrungnamm3@gmail.com'), env('MAIL_FROM_NAME', 'Fashion Store Support'));
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
