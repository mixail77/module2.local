<?php

namespace App;

class Redirect
{

    /**
     * Выполняет редирект на страницу
     * @param $url
     */
    public function redirectTo($url)
    {

        header('Location: ' . $url);
        exit();

    }

}