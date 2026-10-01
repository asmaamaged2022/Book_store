<?php

require_once __DIR__ . "/middleware.php";
class RegisterMiddleware implements \Middleware
{
    public function handle(string ...$roles): void
    {
        /*
         * admin=>Register
         * customer=>profile
         * guest=>register
         */

        if (isAuth('customer')) {
            redirect("/Profile");
        }
    }
}
