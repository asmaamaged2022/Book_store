<?php
class Database
{ //! change dbname if you change it
    private const DSN      = "mysql:host=localhost;dbname=book_store";
    private const USERNAME = "root";
    private const PASSWORD = "";
/* 
*private static ?PDO $connection = null;
*may be null so that write it in this way 
*/
    private static ?PDO $connection = null;
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {

            try {
                self::$connection = new PDO(self::DSN, self::USERNAME, self::PASSWORD);
                //* to throw error when it exist
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //* to make it return as associative array  direct  when i fetchAll
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die(" connection failed");
            }
        }
        return self::$connection;
    }

}
