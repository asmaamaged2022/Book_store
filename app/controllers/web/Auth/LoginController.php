<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../model/Auth/Auth.php";

class LoginController extends \Controller
{
    public function index()
    {
        $this->view("Auth/Login");
    }
    public function login()
    {
        $error = \Request::validate([

            "email"  => ['required', 'email'],
            "password" => ['required']
        ]);
        if (!empty($error)) {
            back();
        }
        if (\Auth::isBanned() ==1) {
            back("invalid", 'Banned Account');
        }


        if (\Auth::login()) {
            unset($_SESSION['_old']);

            session_regenerate_id(true);
            redirect('/Profile');
        }
        back("invalid", 'invalid Account');
    }
    public static function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['_old']);
        session_regenerate_id(true);
        redirect('/auth/Login');
    }
}
