<?php

class Router
{
    private $routes = [];

    public function get($path, $handler) {
        $this->add('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->add('POST', $path, $handler);
    }

    private function add($method, $path, $handler) {
        $pattern = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            function ($match) {
                return '(?P<' . $match[1] . '>[^/]+)';
            },
            $path
        );

        $this->routes[$method][] = [
            'pattern' => '#^' . $pattern . '$#',
            'handler' => $handler
        ];
    }

    public function dispatch($method, $path) {
        foreach (isset($this->routes[$method]) ? $this->routes[$method] : array() as $route) {
            if (preg_match($route['pattern'], $path, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                call_user_func($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        echo 'Page not found';
    }
}
