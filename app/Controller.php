<?php

namespace App;

use App\Request;
use App\Validator;
use App\QueryBuilder;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;
use App\Redirect;
use App\exception\ExceptionAddProduct;
use App\exception\ExceptionEditProduct;

class Controller
{

    private $db;
    private $template;
    private $flash;
    private $request;
    private $validator;
    private $redirect;

    public function __construct(
        Request      $request,
        Validator    $validator,
        QueryBuilder $queryBuilder,
        Engine       $engine,
        Flash        $flash,
        Redirect     $redirect
    )
    {

        $this->request = $request;
        $this->validator = $validator;
        $this->db = $queryBuilder;
        $this->template = $engine;
        $this->flash = $flash;
        $this->redirect = $redirect;

    }

    /**
     * Выводит все товары
     */
    public function index()
    {

        echo $this->template->render('index.view', [
            'products' => $this->db->getAll('products'),
        ]);

    }

    /**
     * Выводит товар по ID
     * @param $vars
     */
    public function show($vars)
    {

        echo $this->template->render('show.view', [
            'products' => $this->db->getById('products', $vars['id']),
        ]);

    }

    /**
     * Выводит форму добавления товара
     */
    public function create()
    {

        echo $this->template->render('create.view', []);

    }

    /**
     * Добавляет новый товар
     */
    public function addProduct()
    {

        $title = $this->request->getPost('title');
        $price = $this->request->getPost('price');

        $arFields = [
            'TITLE' => $title,
            'PRICE' => $price,
        ];

        try {

            if ($this->validator->isNotEmpty($title) && $this->validator->isNumeric($price)) {

                $this->db->create('products', $arFields);
                $this->redirect->redirectTo('/');

            }

            throw new ExceptionAddProduct('Product fields are filled in incorrect!');

        } catch (ExceptionAddProduct $exception) {

            $this->flash->error($exception->getMessage());

        }

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
            'products' => $this->db->getById('products', $vars['id']),
        ]);

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

        try {

            if ($this->validator->isNotEmpty($title) && $this->validator->isNumeric($price)) {

                $this->db->update('products', $vars['id'], $arFields);
                $this->redirect->redirectTo('/');

            }

            throw new ExceptionEditProduct('Product fields are filled in incorrect!');

        } catch (ExceptionEditProduct $exception) {

            $this->flash->error($exception->getMessage());

        }

        $arFields['ID'] = $vars['id'];

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
        $this->redirect->redirectTo('/');

    }

    /**
     * Выводит ошибку 404
     */
    public function error404()
    {

        echo $this->template->render('404.view', []);

    }

}