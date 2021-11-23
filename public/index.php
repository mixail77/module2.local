<?php

use Aura\SqlQuery\QueryFactory;

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
}

$queryFactory = new QueryFactory('mysql');
$select = $queryFactory->newSelect();
$select->cols(['*']);
$select->from('products');

print_r($select->getStatement());

$pdo = new PDO('mysql:host=localhost;dbname=module1;charset=utf8', 'admin', 'root');
$sth = $pdo->prepare($select->getStatement());
$sth->execute($select->getBindValues());
$result = $sth->FetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($result);
echo '</pre>';