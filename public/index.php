<?php

use App\Router;

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

$router = new Router();
$router->getController();

