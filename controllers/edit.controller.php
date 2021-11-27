<?php

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

//Редактируем товар
$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

$arFields = [
    'TITLE' => 'Название товара',
    'PRICE' => rand(100, 10000),
];
//$db->update('products', 20, $arFields);

$arResult = $db->getById('products', 20);

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [
    'products' => $arResult,
];

echo $templates->render('edit.view', $arParams);