<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class OrderModel extends \Model
{


    public static function getDataOfOrders(array $wheres = [], int $page = 1)
    {
        $DB = \Database::getConnection();
        $whereQuery = \Model::prepareWhereQuery($wheres);
        $offset = ($page * 10) - 10;
        $stat = $DB->query("SELECT  orders.*, users.name AS customer_name ,users.id AS user_id
                             FROM orders 
                             LEFT JOIN users ON users.id=orders.customer_id
                             {$whereQuery}
                             ORDER BY id DESC
                             LIMIT 10 OFFSET {$offset}");
        $data = $stat->fetchAll();



        $stat = $DB->query("SELECT COUNT(*) AS total
                             FROM orders
                             LEFT JOIN users ON users.id=orders.customer_id
                             $whereQuery");
        $total = $stat->fetch()['total'];
        return [
            'data' => $data,
            'total' => $total,
            'currentPage' => $page

        ];
    }
}
