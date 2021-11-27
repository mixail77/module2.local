<?php

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

//Добавляем товар
$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

$arFields = [
    'TITLE' => 'Название товара',
    'PRICE' => rand(100, 10000),
];
//$db->create('products', $arFields);

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [];

echo $templates->render('create.view', $arParams);
