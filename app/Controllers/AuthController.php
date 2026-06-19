<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function index(): void
    {
        echo "<h1>Trang xác thực (Auth)</h1>";
    }
}
