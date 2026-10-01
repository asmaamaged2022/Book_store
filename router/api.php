<?php
require_once __DIR__ . "/../core/Route.php";
require_once __DIR__ . "/../app/controllers/api/UserController.php";

//*start with api (not important just to know it)
//* v1 means version 1
//* if you want to test it  BASE_URL./api/v1/getUsers
\Route::get("/api/v1/getUsers", \UserController::class, "getData");
