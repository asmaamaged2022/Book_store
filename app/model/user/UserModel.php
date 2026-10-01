<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class UserModel extends \Model
{
    public function getUsers()
    {
        $stat = $this->DB->query("SELECT * FROM customers;");
        $res  = $stat->fetchAll();
        return $res;
    }
    public static function CreateUser()
    {
        //* static can nt use protected
        $DB = \Database::getConnection();
        $Data = \Request::all();
        $hashPass = password_hash($Data['password'], PASSWORD_DEFAULT);
        $DB->exec("INSERT INTO users
         (role,name,email,password,phone,gender)
         VALUES
         ('{$Data['role']}','{$Data['name']}','{$Data['email']}',
         '{$hashPass}','{$Data['phone']}','{$Data['gender']}');");
    }
    public static function editUser(string $col, string $value)
    {
        $DB = \Database::getConnection();
        $id = auth("id");
        if ($col == "password") {
            $value = password_hash($value, PASSWORD_DEFAULT);
        }
        $DB->exec("UPDATE users 
                    SET {$col} ='$value'
                    WHERE id='{$id}'");
        unset($_SESSION['_old']);            
    }
}
