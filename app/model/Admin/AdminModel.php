<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class AdminModel extends \Model
{
    public static function BanUser()
    {
        $DB = \Database::getConnection();

        $id = \Request::input("userId");

        $stat = $DB->query(
            "SELECT is_banned FROM users WHERE id = '{$id}'"
        );

        $oldBan = $stat->fetchColumn();

        $stat = $DB->prepare(
            "UPDATE users
         SET is_banned = :newBan
         WHERE id = :userId"
        );

        $stat->execute([
            "newBan" => !$oldBan,
            "userId" => $id
        ]);

        $states = ($oldBan) ? "unbanned" : "banned";
        \Response::json(
            [$id, $oldBan],
            "User {$states} successfully"
        );
    }
    public static function DoneOrder()
    {
        $DB = \Database::getConnection();
        $orderId = \Request::input("orderId");
        $DB->exec("UPDATE orders
                    SET
                    status='done'
                    WHERE orders.id='{$orderId}'");
        $id = \Request::input('orderId');
        $stat = $DB->query(" SELECT
                            orders.id AS order_id,
                            users.name AS customer_name,
                            orders.total_price,
                            orders.created_at
                        FROM orders
                        LEFT JOIN users
                            ON orders.customer_id = users.id
                        WHERE users.role = 'customer' AND orders.id ='{$id}'
    ");

        return $stat->fetchAll();
    }


    public static function CancelOrder()
    {
        $DB = \Database::getConnection();
        $orderId = \Request::input("orderId");
        $cancelReason = \Request::input("cancelReason");

        $stmt = $DB->prepare(" UPDATE orders
                                SET
                                status = 'canceled',
                                cancel_reason = :cancelReason
                                WHERE id = :orderId
                                ");

        $stmt->execute([
            "cancelReason" => $cancelReason,
            "orderId" => $orderId
        ]);
        $id = \Request::input('orderId');
        $stat = $DB->query(" SELECT
                            orders.id AS order_id,
                            users.name AS customer_name,
                            orders.total_price,
                            orders.created_at
                        FROM orders
                        LEFT JOIN users
                            ON orders.customer_id = users.id
                        WHERE users.role = 'customer' AND orders.id ='{$id}'
    ");
        $DB->exec("UPDATE books
                LEFT JOIN orders_items
                ON books.id=orders_items.book_id
                SET books.stock= books.stock+orders_items.quantity
                WHERE orders_items.order_id= '{$id}'");

        return $stat->fetchAll();
    }
}
