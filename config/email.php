<?php
return [
    'host' => env('MAIL_HOST'),
    'auth' => true,
    'username' => env('MAIL_USER'),
    'password' => env('MAIL_PASS'),
    'secure' => env('MAIL_SECURE'),
    'port' => env('MAIL_PORT'),
    'from_email' => env('MAIL_FROM_EMAIL'),
    'from_name' => env('MAIL_FROM_NAME')
];
