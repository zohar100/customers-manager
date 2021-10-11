<?php

namespace app;

class Router
{
    public array $getRoutes = [];


    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
    public function resolve()
    {
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        if (strpos($currentUrl, '?') !== false) {
            $currentUrl = substr($currentUrl, 0, strpos($currentUrl, '?'));
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }
        if ($fn) {
            $controller = new $fn[0];
            call_user_func(array($controller, $fn[1]), $this);
        } else {
            echo "Page not found!";
        }
    }
    public function renderView($view)
    {
        ob_start();
        include_once __DIR__ . "/public/src/views/$view.html";
        $content = ob_get_clean();
        include_once __DIR__ . '/public/src/views/_layout.php';
    }
}
