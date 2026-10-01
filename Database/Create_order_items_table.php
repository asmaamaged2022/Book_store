<?php

require_once __DIR__ . "/../core/Database.php";

class Create_order_items_table
{
    public static function up()
    {
        \Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS orders_items (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            order_id BIGINT UNSIGNED NOT NULL,
            book_id BIGINT UNSIGNED NOT NULL,
            quantity INT UNSIGNED NOT NULL,
            unit_price DECIMAL(10,2) ,
            subtotal DECIMAL(10,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            CONSTRAINT fk_order_id
                FOREIGN KEY (order_id)
                REFERENCES orders(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,

            CONSTRAINT fk_book_id
                FOREIGN KEY (book_id)
                REFERENCES books(id)
                ON DELETE RESTRICT
                ON UPDATE CASCADE
        );");
    }

    public static function down()
    {
        \Database::getConnection()->exec(
            "DROP TABLE IF EXISTS order_items"
        );
    }
}