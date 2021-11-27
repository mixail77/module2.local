<?php

$arParams = [
    'title' => 'Добавить товар',
];

//Шаблон
$this->layout('template', $arParams);

?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-md-2">

            <form action="/create.php" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Название товара</label>
                    <input type="text" name="title" class="form-control" id="title" value="">
                    <label for="price" class="form-label">Стоимость товара</label>
                    <input type="text" name="price" class="form-control" id="price" value="">
                </div>
                <button type="submit" class="btn btn-success">Добавить</button>
            </form>

        </div>
    </div>
</div>