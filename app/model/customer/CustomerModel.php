<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class CustomerModel extends \Model
{
    public static function getBookStock(mixed $bookId)
    {
        $DB = \Database::getConnection();
        $stat = $DB->query("SELECT  stock
                             FROM books 
                             WHERE books.id='{$bookId}'");
        return $stat->fetch();
    }
    private static function getPendingOrderId(): false|int
    {
        $DB = \Database::getConnection();
        $customerId = auth("id");
        $stat = $DB->query("SELECT  id
                             FROM orders 
                             WHERE orders.customer_id='{$customerId}'AND status='pending'");
        return $stat->fetchColumn();
    }
    private static function getOrderItemId(string $orderId, string $bookId): false|int
    {
        $DB = \Database::getConnection();
        $stat = $DB->query("SELECT  id
                             FROM orders_items
                             WHERE orders_items.order_id='{$orderId}'AND orders_items.book_id='{$bookId}'");
        return $stat->fetchColumn();
    }

    private static function updateTotalPrice(string $orderId)
    {
        $DB = \Database::getConnection();
        $stat = $DB->query("SELECT SUM(subtotal) As Total
                    FROM
                    orders_items  
                    WHERE orders_items.order_id='{$orderId}';
                    ");
        $totalPrice = $stat->fetchColumn() ?? 0;
        $DB->exec("UPDATE orders
                    SET
                    total_price =$totalPrice
                    WHERE orders.id='{$orderId}';
                    ");
        return $totalPrice;
    }

    private static function updateStock(string $bookId, string $operator, string $quantity)
    {
        $DB = \Database::getConnection();
        $DB->exec("UPDATE books
                    SET
                    stock = stock {$operator} " . (int)$quantity . "
                    WHERE books.id='{$bookId}';
                    ");
    }

    public static function totalItemsIntoOrder(): int
    {
        $DB = \Database::getConnection();
        $orderId = self::getPendingOrderId();
        $stat = $DB->query("SELECT COUNT(*) As Total
                    FROM
                    orders_items  
                    WHERE orders_items.order_id='{$orderId}';
                    ");
        return $stat->fetchColumn();
    }

    public static function AddToCart()
    {
        $DB = \Database::getConnection();
        $pendingOrderId = self::getPendingOrderId();
        $customerId = auth("id");

        if ($pendingOrderId == false) {
            $DB->exec("INSERT INTO orders 
                       (customer_id)
                       VALUES
                       ('{$customerId}')");
            $pendingOrderId = $DB->lastInsertId();
        }

        $bookId = \Request::input("bookId");
        $unitPrice = $DB->query("SELECT price FROM books WHERE books.id='{$bookId}'")->fetchColumn();
        $quantity = \Request::input("quantity");
        $orderItemId = self::getOrderItemId($pendingOrderId, $bookId);

        if ($orderItemId == false) {
            $stat = $DB->prepare("INSERT INTO orders_items 
                       (order_id,book_id,quantity,unit_price,subtotal)
                       VALUES
                       (:order_id,:book_id,:quantity,:unit_price,:subtotal)");

            $stat->execute([
                "order_id" => $pendingOrderId,
                "book_id" => $bookId,
                "quantity" => \Request::input("quantity"),
                "unit_price" => $unitPrice,
                "subtotal" => (float)$unitPrice * (int)$quantity
            ]);
        } else {
            $newSubtotal = (float)$unitPrice * (int)$quantity;
            $DB->exec("UPDATE orders_items 
                        SET 
                        quantity=quantity+{$quantity},
                        subtotal=subtotal+{$newSubtotal}
                        WHERE orders_items.id={$orderItemId};
                       ");
        }
        self::updateTotalPrice($pendingOrderId);
        self::updateStock($bookId, "-", $quantity);
    }
    public static function getItemsInCart(?int $orderId = null)
    {
        if ($orderId == null) {
            $orderId =  $pendingOrderId = self::getPendingOrderId();
        }
        $DB = \Database::getConnection();
        $stat = $DB->query("SELECT 
                            books.id AS book_id,
                            books.title,
                            books.image,
                            books.description,
                            books.price,
                            authors.id AS author_id,
                            authors.name AS author_name,
                            orders_items.quantity,
                            orders_items.subtotal,
                            orders_items.id AS order_items_id,
                            orders.total_price,
                            orders.id AS order_id
                            FROM orders_items
                            LEFT JOIN orders ON orders.id=orders_items.order_id
                            LEFT JOIN books ON books.id=orders_items.book_id
                            LEFT JOIN authors ON authors.id=books.author_id
                            WHERE
                            orders.id='{$orderId}';");

        return $stat->fetchAll();
    }

    public static function updateQuantity()
    {
        $DB = \Database::getConnection();
        $pendingOrderId = self::getPendingOrderId();
        $orderItemId = \Request::input("orderItemId");
        $bookId = \Request::input("bookId");
        $unitPrice = $DB->query("SELECT price FROM books WHERE books.id='{$bookId}'")->fetchColumn();
        $quantity = \Request::input("quantity");
        $newSubtotal = (float)$unitPrice * (int)$quantity;
        $DB->exec("UPDATE orders_items 
                        SET 
                        quantity={$quantity},
                        subtotal={$newSubtotal}
                        WHERE orders_items.id={$orderItemId};
                       ");
        $returnTotalPrice = self::updateTotalPrice($pendingOrderId);
        $deferenceQuantity = \Request::input("deferenceQuantity");
        $operation = \Request::input("operation");
        self::updateStock($bookId, $operation, $deferenceQuantity);
        $returnSubtotal = $DB->query("SELECT subtotal FROM orders_items WHERE orders_items.id={$orderItemId}")->fetchColumn();
        $returnQuantity = $DB->query("SELECT quantity FROM orders_items WHERE orders_items.id={$orderItemId}")->fetchColumn();
        $returnStock = self::getBookStock($bookId);
        return [
            "returnSubtotal" => $returnSubtotal,
            "returnQuantity" => $returnQuantity,
            "returnTotalPrice" => $returnTotalPrice,
            "returnStock" => $returnStock["stock"]
        ];
    }

    public static function DeleteItem()
    {
        $DB = \Database::getConnection();
        $pendingOrderId = self::getPendingOrderId();
        $orderItemId = \Request::input("orderItemId");
        $bookId = \Request::input("bookId");
        $quantity = \Request::input("quantity");
        self::updateStock($bookId, '+', $quantity);
        $DB->exec("DELETE
                    FROM orders_items 
                    WHERE orders_items.id={$orderItemId};
                    ");
        $returnTotalPrice = self::updateTotalPrice($pendingOrderId);
        $returnStock = self::getBookStock($bookId);
        $totalItemsIntoOrder = self::totalItemsIntoOrder();
        return [
            "returnTotalPrice" => $returnTotalPrice,
            "returnStock" => $returnStock["stock"],
            "totalItemsIntoOrder" => $totalItemsIntoOrder,
            "orderItemId" => $orderItemId
        ];
    }
    public static function fireOrder()
    {
        $DB = \Database::getConnection();

        $pendingOrderId = self::getPendingOrderId();

        $DB->exec("UPDATE orders
                    SET status = 'ordered'
                    WHERE id = '{$pendingOrderId}'
                        ");

        $stat = $DB->query(" SELECT
                            orders.id AS order_id,
                            users.name AS customer_name,
                            orders.total_price,
                            orders.created_at
                        FROM orders
                        LEFT JOIN users
                            ON orders.customer_id = users.id
                        WHERE users.role = 'customer' AND orders.id ='{$pendingOrderId}'
                  ");

        return $stat->fetchAll();
    }
}
