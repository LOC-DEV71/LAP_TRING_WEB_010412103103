<?php

// Controller này sẽ xử lý logic cho trang chủ (lấy dữ liệu sản phẩm, banner...) rồi render view tương ứng.


namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        // Truyền tên view (client/homePage) và layout tương ứng (client/layout)
        $this->render('client/homePage', [
            'title' => 'Trang chủ GearX'
        ], 'client/layout');
    }
}
