<?php

use App\Controller;
use DI\Container;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;

session_start();
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

//php-di
$container = new Container();
$containerBuilder = new ContainerBuilder();

//Добавляем исключения для классов
$containerBuilder->addDefinitions([
    PDO::class => function () {
        return new PDO('mysql:host=localhost;dbname=module1;charset=utf8', 'admin', 'root');
    },
    QueryFactory::class => function () {
        return new QueryFactory('mysql');
    },
    Engine::class => function () {
        return new Engine($_SERVER['DOCUMENT_ROOT'] . '/app/views');
    },
]);
$container = $containerBuilder->build();

//route
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
        echo 'Error404';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'Error404';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        //php-di
        $container->call($handler, [$vars]);
        break;
}
