<?php

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

//Удаляем товар
$query = new QueryFactory('mysql');
$db = new QueryBuilder($query);

//$db->delete('products', 20);

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [];

echo $templates->render('delete.view', $arParams);