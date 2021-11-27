<?php

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

//Выводим все товары
$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

$arResult = $db->getAll('products');

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [
    'products' => $arResult,
];

echo $templates->render('index.view', $arParams);
