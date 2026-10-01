<?php
require_once __DIR__ . "/../model.php";
require_once __DIR__ . "/../../../core/Database.php";

class Auth extends \Model
{

    public static function login()
    {
        //* static can nt use protected
        $DB = \Database::getConnection();
        $email = \Request::input('email');
        $password = \Request::input('password');
        $stat = $DB->query("SELECT * FROM  users WHERE email ='{$email}';");
        $result = $stat->fetch();
        if (!empty($result) && password_verify($password, $result['password'])) {
            $_SESSION['user'] = $result;
            return true;
        }
        return false;
    }
    public static function isBanned()
    {
        $DB = \Database::getConnection();
        $email = \Request::input('email');
        $stat = $DB->query("SELECT is_banned FROM  users WHERE users.email ='{$email}';");
        $result = $stat->fetchColumn();
        return $result;
    }
}
