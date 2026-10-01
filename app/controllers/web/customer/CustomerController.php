<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../model/customer/CustomerModel.php";
require_once __DIR__ . "/../../../model/DB/DBModel.php";


class CustomerController extends \Controller
{

    public  function AddToCart()
    {
        $errors = \Request::validate([
            "bookId" => ['required', ['exists', 'books', 'id']],
            "quantity" => ['required']
        ]);
        if (!empty($errors)) {
            \Response::json($errors, 'Enter the quantity you want.', 422);
        }
        $stock = \CustomerModel::getBookStock(\Request::input("bookId"));
        if ($stock["stock"] < 1) {
            \Response::json([], 'Book Is Out Of Stock', 422);
        } else if ($stock["stock"] < \Request::input("quantity")) {
            \Response::json([], 'your order bigger than  stock of this Book', 422);
        }
        \CustomerModel::AddToCart();
        $totalItemsIntoOrder = \CustomerModel::totalItemsIntoOrder();
        $stock = \CustomerModel::getBookStock(\Request::input("bookId"));
        \Response::json([
            ["totalItemsIntoOrder" => $totalItemsIntoOrder],
            $stock["stock"]
        ], "Itim Added in Your cart successfully");
    }
    public function GetCartData()
    {
        if (\Request::input("orderid") != null) {
            $errors = \Request::validate([
                "orderid" => ['required', ['exists', 'orders', 'id']]
            ]);
            if (!empty($errors)) {
                \Response::json($errors, 'Wrong Request in GetCartData', 422);
            }
        }
        $CartData = \CustomerModel::getItemsInCart(\Request::input("orderid"));
        \Response::json($CartData);
    }

    public  function  updateQuantity()
    {
        $errors = \Request::validate([
            "bookId" => ['required', ['exists', 'books', 'id']],
            "quantity" => ['required'],
            "orderItemId" => ['required', ['exists', 'orders_items', 'id']]
        ]);
        if (!empty($errors)) {
            \Response::json($errors, 'Wrong Request in updateQuantity', 422);
        }
        $stock = \CustomerModel::getBookStock(\Request::input("bookId"));
        if ($stock["stock"] < 1) {
            \Response::json([], 'Book Is Out Of Stock', 422);
        } else if ($stock["stock"] < \Request::input("deferenceQuantity") && (\Request::input("operation")) == "-") {
            \Response::json([], 'your order bigger than  stock of this Book', 422);
        }
        $updated = \CustomerModel::updateQuantity();
        \Response::json($updated, "update done");
    }

    public function DeleteItem()
    {
        $errors = \Request::validate([
            "bookId" => ['required', ['exists', 'books', 'id']],
            "quantity" => ['required'],
            "orderItemId" => ['required', ['exists', 'orders_items', 'id']]
        ]);
        if (!empty($errors)) {
            \Response::json($errors, 'Wrong Request in Delete Item', 422);
        }
        $updated = \CustomerModel::DeleteItem();
        \Response::json($updated, "Delete done");
    }

    public static function fireOrder()
    {
        $data = \CustomerModel::fireOrder();
        // $totalItemsIntoOrder=\CustomerModel::totalItemsIntoOrder();
        // $send=array_merge($data, [$totalItemsIntoOrder]);
        \Response::json($data, "Order ordered");
    }
}
