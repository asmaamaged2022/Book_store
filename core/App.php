<?php

class App
{
    public static function run()
    {
        session_start();
        // unset($_SESSION['user']);

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $type = str_starts_with($path, BASE_URL . "/api") ? 'api' : 'web';
        if ($type === "api") {
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }
        require_once __DIR__ . "/../router/{$type}.php";
        require_once __DIR__ . "/Route.php";
        require_once __DIR__ . "/../app/helpers/helpers.php";
        require_once __DIR__ . "/response.php";
        require_once __DIR__ . "/Request.php";
        require_once __DIR__ . "/validation.php";
        // $_SESSION['user']['role'] = 'admin';
        \Route::despatch();
    }
}
