<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../../core/Request.php";
require_once __DIR__ . "/../../../model/Book/BookModel.php";


class BooksController extends \Controller
{
    public function filterBooks()
    {

        // \Response::json(\Request::all());
        $minPrice = \Request::input('minPrice', '') == '' ? 0 : \Request::input('minPrice', '');
        $maxPrice = \Request::input('maxPrice', '') == '' ? null : \Request::input('maxPrice', '');
        $stock = \Request::input('stock', '') == '' ? null : \Request::input('stock', '');
        $wheres = [
            ['authors.name', 'LIKE', '%' . \Request::input('author', '') . '%'],
            ['books.title', 'LIKE', '%' . \Request::input('title', '') . '%'],
            ['books.price', '>', $minPrice],
        ];
        if ($stock != null) {
            array_push($wheres, ['books.stock', '=',  \Request::input('stock')]);
        }
        if ($maxPrice != null) {
            array_push($wheres, ['books.price', '<', $maxPrice]);
        }
        $books = \BookModel::getDataOfBooks($wheres, \Request::input('sort', 'DESC'), \Request::input('page', 1));
        \Response::json($books);
    }
    public function addBook()
    {
        $errors = \Request::validate([
            'bookAuthorId' => ['required', ['exists', 'authors', 'id']],
            'bookDescription' => ['required'],
            'bookPrice' => ['required'],
            'bookStock' => ['required'],
            'bookTitle' => ['required'],
        ]);
        if (!empty($errors)) {
            \Response::json($errors, '', 422);
        }
        $newBook = \BookModel::AddBook();
        \Response::json($newBook, "Book Added Successful");
    }
}
