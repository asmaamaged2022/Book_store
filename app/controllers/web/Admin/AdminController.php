<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../model/Admin/AdminModel.php";
require_once __DIR__ . "/../../../model/DB/DBModel.php";


class AdminController extends \Controller
{
    public function BanUser()
    {

        $errors = \Request::validate([
            'userId' => ['required', ['exists', 'users', 'id']],

        ]);
        if (!empty($errors)) {
            \Response::json($errors, 'is not exist', 422);
        }
        $idOfBanUser = \Request::input('userId');
        $roleOfBanUser = \DBModel::getRoleOfUser($idOfBanUser);

        if ($roleOfBanUser == 'admin' && auth("id") > $idOfBanUser) {
            \Response::json([], "You Cannot Ban This Admin", 403);
        }
        \AdminModel::BanUser();
    }

    function DoneOrder()
    {
        $data = \AdminModel::DoneOrder();
        \Response::json($data, "order Is Done");
    }
    function cancelOrder()
    {
        $errors = \Request::validate([
            'orderId' => ['required', ['exists', 'orders', 'id']],
            'cancelReason' => ['required']

        ]);
        if (!empty($errors)) {
            \Response::json($errors, 'is not exist', 422);
        }
        $data = \AdminModel::CancelOrder();
        \Response::json($data, "order canceled successfully");
    }
}
