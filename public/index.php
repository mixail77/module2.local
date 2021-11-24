<?php

use Aura\SqlQuery\QueryFactory;
use App\QueryBuilder;

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

//Все товары
//$arResult = $db->getAll('products');

//Один товар
//$arResult = $db->getById('products', 20);

//Удаление товара
//$arResult = $db->delete('products', 25);

//Добавление товара
$arCreate = [
    'TITLE' => 'NEW_PRODUCT',
    'PRICE' => rand(100, 10000),
];
//$arResult = $db->create('products', $arCreate);

//Обновление товара
$arUpdate = [
    'TITLE' => 'NEW_UPDATE',
    'PRICE' => rand(100, 10000),
];
//$arResult = $db->update('products', 90, $arUpdate);
