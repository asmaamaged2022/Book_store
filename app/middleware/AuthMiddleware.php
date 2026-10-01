<?php

require_once __DIR__ . "/middleware.php";
class AuthMiddleware implements \Middleware
{
    public function handle(string ...$roles): void
    {

        if (! $_SESSION['user']) {
            // \Response::error("unauthorized", 401);
            redirect("/auth/Login");
        }
        if (empty($roles)) {
            return;
        }
        $currentRoleAuth = $_SESSION['user']['role'];
        if (! in_array($currentRoleAuth, $roles)) {
            \Response::error("forbidden", 403);
        }
    }
}
