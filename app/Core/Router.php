<?php
namespace App\Core;

/**
 * Router
 * RESTful routing with middleware support
 */
class Router
{
    private array $routes = [];
    private array $currentMiddleware = [];
    private string $currentPrefix = '';

    public function get(string $path, $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    public function put(string $path, $handler, array $middleware = []): void
    {
        $this->add('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, $handler, array $middleware = []): void
    {
        $this->add('DELETE', $path, $handler, $middleware);
    }

    public function group(array $attributes, callable $callback): void
    {
        $previousMiddleware = $this->currentMiddleware;
        $previousPrefix = $this->currentPrefix;

        if (isset($attributes['middleware'])) {
            $this->currentMiddleware = array_merge($this->currentMiddleware, (array) $attributes['middleware']);
        }
        if (isset($attributes['prefix'])) {
            $this->currentPrefix .= '/' . trim($attributes['prefix'], '/');
        }

        $callback($this);

        $this->currentMiddleware = $previousMiddleware;
        $this->currentPrefix = $previousPrefix;
    }

    private function add(string $method, string $path, $handler, array $middleware): void
    {
        $fullPath = $this->currentPrefix . '/' . trim($path, '/');
        $fullPath = '/' . trim($fullPath, '/');
        if ($fullPath === '') $fullPath = '/';
        
        $this->routes[] = [
            'method' => $method,
            'path' => $fullPath,
            'handler' => $handler,
            'middleware' => array_merge($this->currentMiddleware, $middleware),
            'pattern' => $this->pathToPattern($fullPath),
        ];
    }

    private function pathToPattern(string $path): string
    {
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        
        // Handle method spoofing for forms (_method)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;
            
            if (preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
                
                // Run middleware
                foreach ($route['middleware'] as $middlewareName) {
                    $middlewareClass = "App\\Http\\Middleware\\" . $middlewareName;
                    if (class_exists($middlewareClass)) {
                        $middleware = new $middlewareClass();
                        $result = $middleware->handle();
                        if ($result === false) return;
                    }
                }
                
                $this->callHandler($route['handler'], $params);
                return;
            }
        }

        // 404
        http_response_code(404);
        $view = new View();
        echo $view->render('errors.404', ['title' => '404 Not Found']);
    }

    private function callHandler($handler, array $params): void
    {
        if (is_callable($handler)) {
            echo call_user_func_array($handler, $params);
            return;
        }
        
        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$controller, $method] = explode('@', $handler);
            $controllerClass = "App\\Http\\Controllers\\" . $controller;
            $instance = new $controllerClass();
            echo call_user_func_array([$instance, $method], $params);
        }
    }
}
