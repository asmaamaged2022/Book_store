<?php
require_once __DIR__ . "/../../controller.php";
require_once __DIR__ . "/../../../../core/Request.php";
require_once __DIR__ . "/../../../model/Author/AuthorModel.php";


class AuthorController extends \Controller
{
    public function addAuthor()
    {
        $error = \Request::validate([
            'authorBio' => ['required'],
            'authorName' => ['required'],

        ]);
        if (!empty($error)) {
            \Response::json($error, "UnProcessable Entity", 422);
        };
        $newAuthor = \AuthorModel::addAuthor();

        \Response::json($newAuthor, 'New Author has been Add Successfully', 200);
    }
}
