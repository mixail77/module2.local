<?php

namespace App;

use App\Request;
use App\Validator;
use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class Controller
{

    private $db;
    private $query;
    private $template;
    private $flash;
    private $request;
    private $validator;

    public function __construct()
    {

        $this->request = new Request();
        $this->validator = new Validator();
        $this->query = new QueryFactory('mysql');
        $this->db = new QueryBuilder($this->query);
        $this->flash = new Flash();
        $this->template = new Engine($_SERVER['DOCUMENT_ROOT'] . '/app/views');

    }

    /**
     * Выводит все товары
     * @param $vars
     */
    public function index($vars)
    {

        echo $this->template->render('index.view', [
            'products' => $this->db->getAll('products')]
        );

    }

    /**
     * Выводит товар по ID
     * @param $vars
     */
    public function show($vars)
    {

        echo $this->template->render('show.view', [
            'products' => $this->db->getById('products', $vars['id'])]
        );

    }

    /**
     * Выводит форму добавления товара
     * @param $vars
     */
    public function create($vars)
    {

        echo $this->template->render('create.view', []);

    }

    /**
     * Добавляет новый товар
     * @param $vars
     */
    public function addProduct($vars)
    {

        $title = $this->request->getPost('title');
        $price = $this->request->getPost('price');

        $arFields = [
            'TITLE' => $title,
            'PRICE' => $price,
        ];

        if ($this->validator->isNotEmpty($title) && $this->validator->isNumeric($price)) {

            $this->db->create('products', $arFields);
            $this->redirectTo('/');

        }

        Flash::message('Неверно заполнены поля товара!', 'error');

        echo $this->template->render('create.view', [
            'products' => $arFields,
        ]);

    }

    /**
     * Выводит форму редактирования товара
     * @param $vars
     */
    public function edit($vars)
    {

        echo $this->template->render('edit.view', [
            'products' => $this->db->getById('products', $vars['id'])]
        );

    }

    /**
     * Редактирует товар
     * @param $vars
     */
    public function editProduct($vars)
    {

        $title = $this->request->getPost('title');
        $price = $this->request->getPost('price');

        $arFields = [
            'TITLE' => $title,
            'PRICE' => $price,
        ];

        if ($this->validator->isNotEmpty($title) && $this->validator->isNumeric($price)) {

            $this->db->update('products', $vars['id'], $arFields);
            $this->redirectTo('/');

        }

        Flash::message('Неверно заполнены поля товара!', 'error');

        echo $this->template->render('edit.view', [
            'products' => $arFields,
        ]);

    }

    /**
     * Удаляет товар по ID
     * @param $vars
     */
    public function delete($vars)
    {

        $this->db->delete('products', $vars['id']);
        $this->redirectTo('/');

    }

    /**
     * Выводит ошибку 404
     */
    public function error404()
    {

        echo $this->template->render('404.view', []);

    }

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