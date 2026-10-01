<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class DBModel extends \Model
{
    public static function getTotalOfTable(string $tableName, array $wheres = [])
    {

        $whereQuery = \Model::prepareWhereQuery($wheres);
        $DB = \Database::getConnection();
        $stat = $DB->query("SELECT COUNT(*) AS total
                             FROM {$tableName} 
                             $whereQuery");
        $result = $stat->fetch();
        return $result['total'];
    }
    public static function getDataOfTable(string $tableName, array $wheres = [], int $page = 1)
    {
        $DB = \Database::getConnection();
        $whereQuery = \Model::prepareWhereQuery($wheres);
        $offset = ($page * 10) - 10;
        $stat = $DB->query("SELECT *
                             FROM {$tableName} 
                             {$whereQuery}
                             ORDER BY id DESC
                             LIMIT 10 OFFSET {$offset}");
        $data = $stat->fetchAll();


        $stat = $DB->query("SELECT COUNT(*) AS total
                             FROM {$tableName} 
                             $whereQuery");
        $total = $stat->fetch()['total'];

        return [
            'data' => $data,
            'total' => $total,
            'currentPage' => $page
        ];
    }
    public static function getTotalBoughtBooks()
    {
        $DB = \Database::getConnection();

        $customerId = auth("id");

        $stat = $DB->prepare(" SELECT COALESCE(SUM(orders_items.quantity), 0) AS total
                                FROM orders_items
                                LEFT JOIN orders
                                    ON orders.id = orders_items.order_id
                                WHERE orders.customer_id = :customerId
                                AND orders.status = 'done'
                            ");

        $stat->execute([
            "customerId" => $customerId
        ]);

        return $stat->fetchColumn();
    }
    public static function getRoleOfUser(string $userId)
    {
        $DB = \Database::getConnection();



        $stat = $DB->query(" SELECT role FROM users
                             WHERE users.id={$userId}
                            ");



        return $stat->fetchColumn();
    }
}
