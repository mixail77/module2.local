<?php

use App\Controller;

session_start();
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [Controller::class, 'index']);
    $r->addRoute('GET', '/show/{id:[0-9]+}/', [Controller::class, 'show']);
    $r->addRoute('GET', '/create/', [Controller::class, 'create']);
    $r->addRoute('POST', '/create/', [Controller::class, 'addProduct']);
    $r->addRoute('GET', '/edit/{id:[0-9]+}/', [Controller::class, 'edit']);
    $r->addRoute('POST', '/edit/{id:[0-9]+}/', [Controller::class, 'editProduct']);
    $r->addRoute('GET', '/delete/{id:[0-9]+}/', [Controller::class, 'delete']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:

        //Ошибка404
        $controller = new Controller();
        $controller->error404();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];

        //Ошибка404
        $controller = new Controller();
        $controller->error404();
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        //Подключаем класс контроллера
        $controller = new $handler[0];
        call_user_func([$controller, $handler[1]], $vars);
        break;
}

