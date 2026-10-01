<?php
// * print data with good structure
class Response
{
    public static function error(string $message, int $status = 200): void
    {
        http_response_code($status);
        header("Content-Type: application/json");

        echo json_encode([
            "status" => $status,
            "message" => $message
        ]);

        exit;
    }
    public static function json(array $data, string $message = "", int $status = 200)
    {

        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($status);
        echo json_encode([
            "message" => $message,
            "data"    => $data,
        ]);
        exit;
    }
}
