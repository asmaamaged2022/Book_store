<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../model/DB/DBModel.php";
require_once __DIR__ . "/../../../model/Book/BookModel.php";
require_once __DIR__ . "/../../../model/Orders/OrderModel.php";

class ProfileController extends \Controller
{
    public function index()
    {
        $data = null;
        if (isAuth("admin")) {
            $data = $this->getAdminData();
        } else if (isAuth("customer")) {
            $data = $this->getCustomerData();
        }
        //  pr($data, true);
        $this->view("profile/profile", $data);

        // $this->view("profile/profile");
    }

    private function getAdminData()
    {

        $total = [
            'books' => \DBModel::getTotalOfTable('books'),
            'authors' => \DBModel::getTotalOfTable('authors'),
            'customers' => \DBModel::getTotalOfTable('users', [['role', '=', 'customer']]),
            'admins' => \DBModel::getTotalOfTable('users', [['role', '=', 'admin']]),
            'orders' => [
                'ordered' => \DBModel::getTotalOfTable('orders', [['status', '=', 'ordered']]),
                'canceled' => \DBModel::getTotalOfTable('orders', [['status', '=', 'canceled']]),
                'done' => \DBModel::getTotalOfTable('orders', [['status', '=', 'done']])
            ]

        ];

        $admins = \DBModel::getDataOfTable(
            'users',
            [
                ['role', '=', 'admin'],
                ['id', '!=', auth('id')]
            ],
            \Request::input("admins-page", 1)
        );
        $customers = \DBModel::getDataOfTable(
            'users',
            [['role', '=', 'customer']],
            \Request::input("customers-page", 1)
        );
        $authors = \DBModel::getDataOfTable(
            'authors',
            [],
            \Request::input("authors-page", 1)
        );
        $books = \BookModel::getDataOfBooks(
            [],
            page: \Request::input("books-page", 1)
        );
        $orders = [
            'ordered' => \OrderModel::getDataOfOrders(
                [['status', '=', 'ordered']],
                \Request::input("ordered-page", 1)
            ),
            'canceled' => \OrderModel::getDataOfOrders(
                [['status', '=', 'canceled']],
                \Request::input("canceled-page", 1)
            ),
            'done' => \OrderModel::getDataOfOrders(
                [['status', '=', 'done']],
                \Request::input("done-page", 1)
            )
        ];


        return [
            'total' => $total,
            'admins' => $admins,
            'customers' => $customers,
            'authors' => $authors,
            'books' => $books,
            'orders' => $orders
        ];
    }
    private function getCustomerData()
    {

        $total = [
            'books' => \DBModel::getTotalOfTable('books'),
            'boughtBooks' => \DBModel::getTotalBoughtBooks(),
            'totalItemsIntoOrder' => \CustomerModel::totalItemsIntoOrder(),
            'orders' => [
                'ordered' => \DBModel::getTotalOfTable('orders', [
                    ['status', '=', 'ordered'],
                    ['customer_id', '=', auth("id")]
                ]),
                'canceled' => \DBModel::getTotalOfTable('orders', [
                    ['status', '=', 'canceled'],
                    ['customer_id', '=', auth("id")]
                ]),
                'done' => \DBModel::getTotalOfTable('orders', [
                    ['status', '=', 'done'],
                    ['customer_id', '=', auth("id")]
                ])
            ]

        ];

        $books = \BookModel::getDataOfBooks(
            [],
            page: \Request::input("books-page", 1)
        );
        $orders = [
            'ordered' => \OrderModel::getDataOfOrders(
                [
                    ['status', '=', 'ordered'],
                    ['customer_id', '=', auth("id")]
                ],
                \Request::input("ordered-page", 1)
            ),
            'canceled' => \OrderModel::getDataOfOrders(
                [
                    ['status', '=', 'canceled'],
                    ['customer_id', '=', auth("id")]
                ],
                \Request::input("canceled-page", 1)
            ),
            'done' => \OrderModel::getDataOfOrders(
                [
                    ['status', '=', 'done'],
                    ['customer_id', '=', auth("id")]
                ],
                \Request::input("done-page", 1)
            )
        ];


        return [
            'total' => $total,
            'books' => $books,
            'orders' => $orders
        ];
    }
}
/* 


*/