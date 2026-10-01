<?php

require_once __DIR__ . "/../core/Database.php";

class Create_authors_table
{
    public static function up()
    {
        \Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS authors (
            id BIGINT UNSIGNED AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            bio TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            PRIMARY KEY (id)
        );");
    }

    public static function down()
    {
        \Database::getConnection()->exec(
            "DROP TABLE IF EXISTS authors"
        );
    }
}