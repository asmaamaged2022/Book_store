<?php
//? not extend from Controller  so Controller  just has a view
require_once __DIR__ . "/../../model/user/UserModel.php";
//* used in api route folder 
class UserController
{public function getData()
    {

    $userModel = new UserModel();
    //*   $users contains getUsers Data from model 
    $users = $userModel->getUsers();
    // Response::json(Request::all(), "successfully");
    Response::json($users, "successfully");
}}
