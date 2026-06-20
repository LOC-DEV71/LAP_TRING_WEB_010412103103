<?php
namespace Controllers\Client;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $products = [
            [
                'name' => 'Product 1',
                'price' => 10000,
            ],
            [
                'name' => 'Product 2',
                'price' => 20000,
            ],
            [
                'name' => 'Product 3',
                'price' => 30000,
            ],
        ];
        // Gọi view 'pages/client/home/index.php'
        $this->view('pages/client/home/index', [
            'title' => 'Trang chủ GearX',
            'products' => $products
        ]);
    }
}
