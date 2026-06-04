<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function add($route, $controller, $action, $method = 'GET') {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }

    public function dispatch($url, $requestMethod) {
        $url = parse_url($url, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['route'] === $url && $route['method'] === $requestMethod) {
                $controllerName = "App\Controllers\\" . $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $action)) {
                        return $controller->$action();
                    }
                }
            }
        }

        // 404 Not Found
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
