<?php
namespace Core;

class App
{
    protected $controller = 'HomeController';
    protected $action = 'index';
    protected $params = [];
    protected $namespace = 'Controllers\\Client\\';

    public function __construct()
    {
        $url = $this->parseUrl();

        // 1. Phân luồng Admin / Client
        $folder = 'client';
        if (isset($url[0]) && strtolower($url[0]) === 'admin') {
            $folder = 'admin';
            $this->namespace = 'Controllers\\Admin\\';
            $this->controller = 'DashboardController'; // Mặc định của Admin là Dashboard
            unset($url[0]);
            $url = array_values($url); // Reset index lại cho admin
        }

        // 2. Tìm Controller (Ví dụ: /auth/login -> AuthController)
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('controllers/' . $folder . '/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            } else {
                // Nếu URL sai thì về mặc định tương ứng của phân vùng
                $this->controller = ($folder === 'admin') ? 'DashboardController' : 'HomeController';
            }
            unset($url[0]);
        }

        // Khởi tạo Controller
        $controllerClass = $this->namespace . $this->controller;
        if (class_exists($controllerClass)) {
            $this->controller = new $controllerClass;
        } else {
            die("Lỗi 404: Không tìm thấy Controller " . $controllerClass);
        }

        // 3. Tìm Method (Action)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            }
            unset($url[1]);
        }

        // 4. Gắn các tham số còn lại
        $this->params = $url ? array_values($url) : [];
    }

    public function run()
    {
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    protected function parseUrl()
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

        // Lấy thư mục cơ sở (ví dụ: /LAP_TRING_WEB_010412103103)
        $baseDir = str_replace('\\', '/', dirname($scriptName));
        $baseDir = rtrim($baseDir, '/');

        // Loại bỏ baseDir khỏi requestUri nếu requestUri bắt đầu bằng baseDir
        if (!empty($baseDir) && strpos($requestUri, $baseDir) === 0) {
            $requestUri = substr($requestUri, strlen($baseDir));
        }

        // Loại bỏ index.php khỏi requestUri nếu có
        if (strpos($requestUri, '/index.php') === 0) {
            $requestUri = substr($requestUri, 10);
        }

        $url = trim($requestUri, '/');
        $url = strtok($url, '?');

        if (!empty($url)) {
            return explode('/', filter_var($url, FILTER_SANITIZE_URL));
        }
        return [];
    }
}
