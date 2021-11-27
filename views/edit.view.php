<?php

$arParams = [
    'title' => 'Редактировать товар',
];

//Шаблон
$this->layout('template', $arParams);

?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-md-2">

            <form action="/edit.php" method="POST">
                <input type="hidden" value="<?= $products['ID'] ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Название товара</label>
                    <input type="text" name="title" class="form-control" id="title" value="<?= $products['TITLE'] ?>">
                    <label for="price" class="form-label">Стоимость товара</label>
                    <input type="text" name="price" class="form-control" id="price" value="<?= $products['PRICE'] ?>">
                </div>
                <button type="submit" class="btn btn-success">Редактировать</button>
            </form>

        </div>
    </div>
</div>
