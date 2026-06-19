<?php

namespace App\Core;

class Router
{
    protected array $routes = [];

    public function get(string $path, array|callable $handler): void
    {
        $this->routes['GET'][$this->normalizePath($path)] = $handler;
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->routes['POST'][$this->normalizePath($path)] = $handler;
    }

    protected function normalizePath(string $path): string
    {
        return '/' . trim($path, '/');
    }

    public function resolve(string $uri, string $method): void
    {
        $path = $this->normalizePath($uri);
        $method = strtoupper($method);

        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            http_response_code(404);
            echo "<h1>404 - Không tìm thấy trang</h1>";
            return;
        }

        if (is_callable($handler)) {
            call_user_func($handler);
            return;
        }

        if (is_array($handler)) {
            [$controllerClass, $methodName] = $handler;

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                    return;
                }
            }
        }

        http_response_code(500);
        echo "<h1>500 - Lỗi máy chủ nội bộ (Cấu hình Route không hợp lệ)</h1>";
    }
}
