<?php
require_once __DIR__ . "/middleware.php";

class GuestMiddleware implements \Middleware
{
    public function handle(string ...$roles): void
    {
        if (isset($_SESSION['user'])) {
            // \Response::error("Already Authenticated ", 403);
            redirect("/Profile");
        }
    }
}
