<?php

use App\Router;

session_start();
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

$router = new Router();
$router->getController();

