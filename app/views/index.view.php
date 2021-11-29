<?php

$arParams = [
    'title' => 'Каталог товаров',
];

//Шаблон
$this->layout('template', $arParams);

?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-md-2">

            <a href="/create/" class="btn btn-success">Добавить товар</a>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Управление</th>
                </tr>
                </thead>
                <tbody>

                    <? foreach ($products as $product): ?>
                        <tr>
                            <th scope="row"><?= $product['ID'] ?></th>
                            <td>
                                <a href="show/<?= $product['ID'] ?>/"><?= $product['TITLE'] ?></a> - <?= $product['PRICE'] ?>
                            </td>
                            <td>
                                <a href="edit/<?= $product['ID'] ?>/" class="btn btn-warning">Редактировать</a>
                                <a href="delete/<?= $product['ID'] ?>/" class="btn btn-danger">Удалить</a>
                            </td>
                        </tr>
                    <? endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>