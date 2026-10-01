<?php

require_once __DIR__ . "/Create_users_table.php";
require_once __DIR__ . "/Create_authors_table.php";
require_once __DIR__ . "/Create_books_table.php";
require_once __DIR__ . "/Create_orders_table.php";
require_once __DIR__ . "/Create_order_items_table.php";
require_once __DIR__ . "/Create_api_tokens_table.php";


\Create_api_tokens_table::down();
\Create_order_items_table::down();
\Create_orders_table::down();
\Create_books_table::down();
\Create_authors_table::down();
\Create_users_table::down();