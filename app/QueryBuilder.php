<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{

    private $pdo;
    private $query;

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {

        $this->pdo = $pdo;
        $this->query = $queryFactory;

    }

    /**
     * Получает все записи из таблицы
     * @param $table
     * @return array|false
     */
    public function getAll($table)
    {

        if (empty($table)) {
            return false;
        }

        //Sql запрос
        $select = $this->query->newSelect();
        $select->cols(['*']);
        $select->from($table);

        //Подготавливаем запрос
        $sql = $select->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Получает запись из таблицы по ID
     * @param $table
     * @param $id
     * @return false|mixed
     */
    public function getById($table, $id)
    {

        if (empty($table) || empty($id)) {
            return false;
        }

        //Sql запрос
        $select = $this->query->newSelect();
        $select->cols(['*']);
        $select->from($table);
        $select->where('ID = :ID');
        $select->bindValue('ID', $id);

        //Подготавливаем запрос
        $sql = $select->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $select->getBindValues();
        $statement->execute($bind);

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    /**
     * Добавляет новую запись в таблицу
     * @param $table
     * @param $arFields
     * @return false|string
     */
    public function create($table, $arFields)
    {

        if (empty($table) || !is_array($arFields)) {
            return false;
        }

        $arKeys = array_keys($arFields);

        //Sql запрос
        $insert = $this->query->newInsert();
        $insert->into($table);
        $insert->cols($arKeys);
        $insert->bindValues($arFields);

        //Подготавливаем запрос
        $sql = $insert->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $insert->getBindValues();
        $statement->execute($bind);

        return $this->pdo->lastInsertId();

    }

    /**
     * Обновляет запись в таблице по ID
     * @param $table
     * @param $id
     * @param $arFields
     * @return false|int
     */
    public function update($table, $id, $arFields)
    {

        if (empty($table) || empty($id) || !is_array($arFields)) {
            return false;
        }

        $arKeys = array_keys($arFields);

        //Sql запрос
        $update = $this->query->newUpdate();
        $update->table($table);
        $update->cols($arKeys);
        $update->where('ID = :ID');
        $update->bindValues(array_merge($arFields, ['ID' => $id]));

        //Подготавливаем запрос
        $sql = $update->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $update->getBindValues();
        $statement->execute($bind);

        return $statement->rowCount();

    }

    /**
     * Удаляет запись из таблицы по ID
     * @param $table
     * @param $id
     * @return false|int
     */
    public function delete($table, $id)
    {

        if (empty($table) || empty($id)) {
            return false;
        }

        //Sql запрос
        $delete = $this->query->newDelete();
        $delete->from($table);
        $delete->where('ID = :ID');
        $delete->bindValue('ID', $id);

        //Подготавливаем запрос
        $sql = $delete->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $delete->getBindValues();
        $statement->execute($bind);

        return $statement->rowCount();

    }

}
