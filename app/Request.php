<?php

namespace App;

class Request
{

    private $arPost;
    private $arQuery;
    private $postValue;
    private $queryValue;

    public function __construct()
    {

        $this->arPost = $_POST;
        $this->arQuery = $_GET;

    }

    /**
     * Возвращает безопасное значение из POST массива по ключу
     * @param $key
     * @return string
     */
    public function getPost($key)
    {

        $this->postValue = trim(strip_tags($this->arPost[$key]));

        return $this->postValue;

    }

    /**
     * Возвращает безопасное значение из GET массива по ключу
     * @param $key
     * @return string
     */
    public function getQuery($key)
    {

        $this->queryValue = trim(strip_tags($this->arQuery[$key]));

        return $this->queryValue;

    }

}
