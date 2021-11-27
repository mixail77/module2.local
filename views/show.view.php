<?php

$arParams = [
    'title' => 'Страница товара',
];

//Шаблон
$this->layout('template', $arParams);

?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-md-2">

            <div class="container">
                <div class="row">
                    <div class="col-8 offset-md-2">

                        <h1><?= $products['TITLE'] ?> - <?= $products['PRICE'] ?></h1>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>