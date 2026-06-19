<?php

namespace App\Controllers;

use App\Core\Controller;

class ProductController extends Controller
{
    public function index(): void
    {
        echo "<h1>Danh sách sản phẩm (Products)</h1>";
    }
}
