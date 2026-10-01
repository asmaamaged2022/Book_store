<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class AuthorModel extends \Model
{
    public static function addAuthor()
    {
        $DB = \Database::getConnection();
        $Data = \Request::all();

        /* 
            * make error
             $DB->exec("
            INSERT INTO authors (name, bio)
            VALUES ('{$Data['authorName']}', '{$Data['authorBio']}')
        "); */
        $stmt = $DB->prepare("INSERT INTO authors 
        (name, bio)
        VALUES 
        (:name, :bio)
       ");

        $stmt->execute([
            ":name" => $Data["authorName"],
            ":bio" => $Data["authorBio"]
        ]);
        $authorId = $DB->lastInsertId();
        $stat = $DB->query("SELECT * FROM authors WHERE id='{$authorId}'");
        return $stat->fetch();
    }
}
