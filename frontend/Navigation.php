<?php

namespace app;

use app\Router;


class Navigation
{
    public function form(Router $router)
    {
        $router->renderView('form/form');
    }

    public function customers(Router $router)
    {
        $router->renderView('customers/table');
    }

    public function dashboard(Router $router)
    {
        $router->renderView('dashboard/dashboard');
    }
}
