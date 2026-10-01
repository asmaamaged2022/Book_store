<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../model/user/UserModel.php";

class RegisterController extends \Controller
{
    public function index()
    {
        $this->view("Auth/Register");
    }
    public function register()
    {

        $error = \Request::validate([
            "role"  => ['required'],
            "name"  => ['required'],
            "email"  => ['required', 'email', ['unique', 'users','id']],
            "password" => ['required', ['min', 8]],
            "phone"  => ['required', ['unique', 'users','id'],'EGPhone'],
            "gender"  => ['required'],

        ]);
        if (!empty($error)) {
            back();
        }
        if (\Request::input('role') == 'admin' && !isAuth('admin')) {
            unset($_SESSION["_old"]);
            back('invalid','You mast Login As Admin');
        }
        \UserModel::CreateUser();

        back("correct", "Account created Successfully");
    }
}
