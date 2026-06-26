<?php
return [
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'auth' => true,
    'username' => env('MAIL_USER', 'trantrungnamm3@gmail.com'),
    'password' => env('MAIL_PASS', 'your_app_password'),
    'secure' => env('MAIL_SECURE', 'ssl'),
    'port' => env('MAIL_PORT', 465),
    'from_email' => env('MAIL_FROM_EMAIL', 'trantrungnamm3@gmail.com'),
    'from_name' => env('MAIL_FROM_NAME', 'Fashion Store Support')
];
