<?php

namespace App;

use PDO;

class QueryBuilder
{

    private $pdo;

    /**
     * В конструкторе получаем настройки для подключения и подключаемся к MySQL
     */
    public function __construct()
    {

        $arConfig = self::getConfig();

        if (!empty($arConfig)) {

            $this->pdo = new PDO("mysql:host={$arConfig['HOST']};dbname={$arConfig['NAME']};charset={$arConfig['CHARSET']}",
                $arConfig['USER'],
                $arConfig['PASSWORD']
            );

        }

    }

    public function getAll($table)
    {

        if (empty($table)) {
            return false;
        }

        $sql = "SELECT * FROM {$table}";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById($table, $id)
    {

        if (empty($table) || empty($id)) {
            return false;
        }

        $sql = "SELECT * FROM {$table} WHERE id=:id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    public function create($table, $arFields)
    {

        if (empty($table) || !is_array($arFields)) {
            return false;
        }

        //Строка с ключами
        $key = implode(',', array_keys($arFields));

        //Строка со значениями
        $value = ':' . implode(',:', array_keys($arFields));

        $sql = "INSERT INTO {$table} ({$key}) VALUE ({$value})";

        //Подготавливаем запрос
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $statement->execute($arFields);

        return $this->pdo->lastInsertId();

    }

    public function update($table, $arFields)
    {

        if (empty($table) || !is_array($arFields)) {
            return false;
        }

        $arKeys = array_keys($arFields);

        $setStr = '';
        foreach ($arKeys as $key) {

            //Поле ID не обновляем, пропускаем в цикле
            //При выполнении запроса, значение поля ID нам понадобится
            if ($key == 'ID') {
                continue;
            }

            $setStr .= $key . '=:' . $key . ',';

        }
        $setStr = rtrim($setStr, ',');

        $sql = "UPDATE {$table} SET {$setStr} WHERE ID=:ID";

        $statement = $this->pdo->prepare($sql);
        $statement->execute($arFields);

        return $statement->rowCount();

    }

    public function delete($table, $id)
    {

        if (empty($table) || empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$table} WHERE id=:id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->rowCount();

    }

    public static function getConfig()
    {

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/database.php')) {
            return false;
        }

        return include $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

    }

}
