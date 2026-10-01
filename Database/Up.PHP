<?php

require_once __DIR__ . "/Create_users_table.php";
require_once __DIR__ . "/Create_authors_table.php";
require_once __DIR__ . "/Create_books_table.php";
require_once __DIR__ . "/Create_orders_table.php";
require_once __DIR__ . "/Create_order_items_table.php";
require_once __DIR__ . "/Create_api_tokens_table.php";


Create_users_table::up();
Create_authors_table::up();
Create_books_table::up();
Create_orders_table::up();
Create_order_items_table::up();
Create_api_tokens_table::up();