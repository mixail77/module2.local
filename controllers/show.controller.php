<?php

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

//Страница товара
$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

$arResult = $db->getById('products', 20);

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [
    'products' => $arResult,
];

echo $templates->render('show.view', $arParams);