<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class BookModel extends \Model
{


    public static function getDataOfBooks(array $wheres = [], string $sort = 'DESC', int $page = 1)
    {
        $DB = \Database::getConnection();
        $whereQuery = \Model::prepareWhereQuery($wheres);
        $offset = ($page * 10) - 10;

        $stat = $DB->query("SELECT  books.*, authors.name AS author_name ,authors.id AS author_id
                             FROM books 
                             LEFT JOIN authors ON authors.id=books.author_id
                             {$whereQuery}
                             ORDER BY id {$sort}
                             LIMIT 10 OFFSET {$offset}");
        $data = $stat->fetchAll();



        $stat = $DB->query("SELECT COUNT(*) AS total
                             FROM books
                             LEFT JOIN authors ON authors.id=books.author_id
                             $whereQuery");
        $total = $stat->fetch()['total'];
        return [
            'data' => $data,
            'total' => $total,
            'currentPage' => $page

        ];
    }
    public static function AddBook()
    {
        $DB = \Database::getConnection();

        $stat = $DB->prepare("
                INSERT INTO books 
                (author_id, title, image, description, price, stock) 
                VALUES 
                (:bookAuthorId, :bookTitle, :bookImage, :bookDescription, :bookPrice, :bookStock)
                ");

        $stat->execute([
            "bookAuthorId"    => \Request::input("bookAuthorId"),
            "bookTitle"       => \Request::input("bookTitle"),
            "bookImage"           => self::uploadImage("bookImage"),
            "bookDescription" => \Request::input("bookDescription"),
            "bookPrice"       => \Request::input("bookPrice"),
            "bookStock"       => \Request::input("bookStock")
        ]);
        $newBookId = $DB->lastInsertId();
        $newBook = self::getDataOfBooks(
            [
                ['books.id', '=', $newBookId]
            ]
        )['data'][0];
        return $newBook;
        
    }
    private static function uploadImage(string $fileName): ?string
    {
        if (\Request::hasFile($fileName)) {
            $file = \Request::file($fileName);
            $fileName = $file['name'];
            $fileOriginalName = pathinfo($fileName, PATHINFO_FILENAME);
            $fileOriginalExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $fileTemp = $file["tmp_name"];
            $allowedExtension = ['png', 'jpg', 'jpeg'];
            if (!in_array($fileOriginalExtension, $allowedExtension)) {
                \Response::error("File Extension Not Allowed", 403);
            }
            $newFileName = $fileOriginalName . "_" . time() . "." . $fileOriginalExtension;
            $uploadDir = __DIR__ . "/../../../public/assets/upload";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir);
            }
            $uploadPath = $uploadDir . "/" . $newFileName;
            if (! move_uploaded_file($fileTemp, $uploadPath)) {
                \Response::error("Error in upload image", 403);
            }
            return $newFileName;
        } else {
            return null;
        }
    }
}
