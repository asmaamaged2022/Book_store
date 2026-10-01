<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../../core/Request.php";
require_once __DIR__ . "/../../../model/user/UserModel.php";


class UserController extends \Controller
{
    public function editName()
    {
        $error = \Request::validate(
            [
                'name' => ['required'],
            ]
        );

        if (!empty($error)) {
            unset($_SESSION["_errors"]);
            back('editAlert', ['error', $error['name'][0]]);
        }
        \UserModel::editUser('name', \Request::input("name"));

        $_SESSION['user']['name'] = \Request::input("name");
        unset($_SESSION['_old']);

        back('editAlert', ['success', "Name updated Successfully"]);
    }


    public function editEmail()
    {
        $error = \Request::validate(
            [
                'email' => ['required', 'email', ['unique', 'users', auth('id')]],
            ]
        );

        if (!empty($error)) {
            unset($_SESSION["_errors"]);
            back('editAlert', ['error', $error['email'][0]]);
        }
        \UserModel::editUser('email', \Request::input("email"));

        $_SESSION['user']['email'] = \Request::input("email");
        unset($_SESSION['_old']);

        back('editAlert', ['success', "Email updated Successfully"]);
    }


    public function editPhone()
    {
        $error = \Request::validate(
            [
                'phone' => ['required', ['unique', 'users', auth('id')], 'EGPhone'],
            ]
        );

        if (!empty($error)) {
            unset($_SESSION["_errors"]);
            back('editAlert', ['error', $error['phone'][0]]);
        }
        \UserModel::editUser('phone', \Request::input("phone"));

        $_SESSION['user']['phone'] = \Request::input("phone");
        unset($_SESSION['_old']);

        back('editAlert', ['success', "Phone updated Successfully"]);
    }


    public function editGender()
    {
        $error = \Request::validate(
            [
                'gender' => ['required'],
            ]
        );

        if (!empty($error)) {
            unset($_SESSION["_errors"]);
            back('editAlert', ['error', $error['gender'][0]]);
        }
        \UserModel::editUser('gender', \Request::input("gender"));

        $_SESSION['user']['gender'] = \Request::input("gender");
        unset($_SESSION['_old']);

        back('editAlert', ['success', "Gender updated Successfully"]);
    }


    public function editPassword()
    {
        $error = \Request::validate(
            [
                "password" => ['required', ['min', 8]],
            ]
        );

        if (!empty($error)) {
            unset($_SESSION["_errors"]);
            back('editAlert', ['error', $error['password'][0]]);
        }
        \UserModel::editUser('password', \Request::input("password"));

        $_SESSION['user']['password'] = \Request::input("password");
        unset($_SESSION['_old']);

        back('editAlert', ['success', "Password updated Successfully"]);
    }

    
}
