<?php
namespace Core;

class App
{
    protected $controller = 'HomeController';
    protected $action = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // 1. Tìm Controller
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            }
            unset($url[0]);
        }

        // Khởi tạo Controller
        $controllerClass = 'Controllers\\' . $this->controller;
        $this->controller = new $controllerClass;

        // 2. Tìm Method (Action)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            }
            unset($url[1]);
        }

        // 3. Lấy Params
        $this->params = $url ? array_values($url) : [];
    }

    public function run()
    {
        // Gọi hàm của controller với các tham số tương ứng
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    protected function parseUrl()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        $url = trim($url, '/');
        
        // Cắt bỏ phần query string (ví dụ: ?id=1)
        $url = strtok($url, '?');

        if (!empty($url)) {
            return explode('/', filter_var($url, FILTER_SANITIZE_URL));
        }
        return [];
    }
}
