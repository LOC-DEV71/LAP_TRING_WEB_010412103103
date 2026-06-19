<?php

namespace App\Controllers;

use App\Core\Controller;

class CartController extends Controller
{
    public function index(): void
    {
        echo "<h1>Giỏ hàng (Cart)</h1>";
    }
}
