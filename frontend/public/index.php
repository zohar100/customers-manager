<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Router;
use app\Navigation;

$router = new Router();

$router->get('/', [Navigation::class, 'form']);
$router->get('/form', [Navigation::class, 'form']);
$router->get('/index', [Navigation::class, 'form']);
$router->get('/index', [Navigation::class, 'form']);
$router->get('/customers', [Navigation::class, 'customers']);
$router->get('/dashboard', [Navigation::class, 'dashboard']);


$router->resolve();
