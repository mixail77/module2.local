<?php

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

//Добавляем товар
$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

$db->create('products', [
    'TITLE' => 'Название товара',
    'PRICE' => rand(100, 10000),
]);

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [];

echo $templates->render('create.view', $arParams);
