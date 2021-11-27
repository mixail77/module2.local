<?php

use League\Plates\Engine;

//Ошибка 404
header('HTTP/1.0 404 Not Found');

//Представление
$templates = new Engine($_SERVER['DOCUMENT_ROOT'] . '/views');

$arParams = [];

echo $templates->render('404.view', $arParams);