<?php

namespace App\Core;

class App
{
    protected Router $router;

    public function __construct()
    {
        $this->router = new Router();
        
        // Load web routes
        $routesPath = dirname(__DIR__, 2) . '/routes/web.php';
        if (file_exists($routesPath)) {
            $router = $this->router;
            require_once $routesPath;
        }
    }

    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Normalize URI when running in a subdirectory
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        // Normalize backslashes to forward slashes
        $scriptDir = str_replace('\\', '/', $scriptDir);
        
        if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }
        
        // Ensure uri starts with / and is clean
        $uri = '/' . trim($uri, '/');

        $this->router->resolve($uri, $method);
    }
}
