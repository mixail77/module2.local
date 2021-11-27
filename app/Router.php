<?php

namespace App;

class Router
{

    private $rout;
    private $arRoutes;

    public function __construct()
    {

        $arConfig = self::getConfig();

        if (!empty($arConfig)) {

            $this->rout = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $this->arRoutes = $arConfig;

        }

    }

    public function getController()
    {

        if (array_key_exists($this->rout, $this->arRoutes)) {

            include $_SERVER['DOCUMENT_ROOT'] . $this->arRoutes[$this->rout];
            exit();

        }

        include $_SERVER['DOCUMENT_ROOT'] . '/controllers/404.controller.php';

    }

    public static function getConfig()
    {

        return [
            '/' => '/controllers/index.controller.php',
            '/show.php' => '/controllers/show.controller.php',
            '/create.php' => '/controllers/create.controller.php',
            '/edit.php' => '/controllers/edit.controller.php',
            '/delete.php' => '/controllers/delete.controller.php',
        ];

    }

}
