<?php
require_once __DIR__ . "/../core/Route.php";
require_once __DIR__ . "/../app/controllers/web/homeController.php";
require_once __DIR__ . "/../app/controllers/web/profile/ProfileController.php";
require_once __DIR__ . "/../app/controllers/web/Auth/LoginController.php";
require_once __DIR__ . "/../app/controllers/web/Auth/registerController.php";
require_once __DIR__ . "/../app/controllers/web/user/UserController.php";
require_once __DIR__ . "/../app/controllers/web/user/AuthorController.php";
require_once __DIR__ . "/../app/controllers/web/Book/BooksController.php";
require_once __DIR__ . "/../app/controllers/web/Admin/AdminController.php";
require_once __DIR__ . "/../app/controllers/web/customer/CustomerController.php";
require_once __DIR__ . "/../app/middleware/AuthMiddleware.php";
require_once __DIR__ . "/../app/middleware/GuestMiddleware.php";
require_once __DIR__ . "/../app/middleware/RegisterMiddleware.php";

//* to make specific user
// Route::get("/home", HomeController::class, "index", ['AuthMiddleware:admin']);
//* Gust
// Route::get("/home", HomeController::class, "index", [GuestMiddleware::class]);
// \Route::get("/home", \HomeController::class, "index", [\AuthMiddleware::class]);
// \Route::get("/test", \HomeController::class, "test");
//* to pass data in url 
// Route::get("/product/{id}/items/{item_id}", HomeController::class, "test");


\Route::get("", \HomeController::class, "index");
\Route::get("/auth/Login", \LoginController::class, "index", [\GuestMiddleware::class]);
\Route::post("/auth/Login", \LoginController::class, "login");
\Route::get("/auth/register", \RegisterController::class, "index", [\RegisterMiddleware::class]);
\Route::post("/auth/register", \RegisterController::class, "register");
\Route::get("/auth/logout", \LoginController::class, "logout", [\AuthMiddleware::class]);
\Route::get("/Profile", \ProfileController::class, "index", [\AuthMiddleware::class]);

/* =============== USER =============== */
\Route::post("/Profile/editName", \UserController::class, "editName", [\AuthMiddleware::class]);
\Route::post("/Profile/editEmail", \UserController::class, "editEmail", [\AuthMiddleware::class]);
\Route::post("/Profile/editPhone", \UserController::class, "editPhone", [\AuthMiddleware::class]);
\Route::post("/Profile/editGender", \UserController::class, "editGender", [\AuthMiddleware::class]);
\Route::post("/Profile/editPassword", \UserController::class, "editPassword", [\AuthMiddleware::class]);
\Route::post("/Profile/FilterBooks", \BooksController::class, "filterBooks", [\AuthMiddleware::class]);
\Route::post("/Profile/GetCartData", \CustomerController::class, "GetCartData", [\AuthMiddleware::class]);


/* =============== Admin =============== */
\Route::post("/Profile/addAuthor", \AuthorController::class, "addAuthor", ['AuthMiddleware:admin']);
\Route::post("/Profile/AddBook", \BooksController::class, "addBook", ['AuthMiddleware:admin']);
\Route::post("/Profile/BanUser", \AdminController::class, "BanUser", ['AuthMiddleware:admin']);
\Route::post("/Profile/BanUser", \AdminController::class, "BanUser", ['AuthMiddleware:admin']);
\Route::post("/Profile/DoneOrder", \AdminController::class, "DoneOrder", ['AuthMiddleware:admin']);
\Route::post("/Profile/cancelOrder", \AdminController::class, "cancelOrder", ['AuthMiddleware:admin']);

/* =============== customer =============== */
\Route::post("/Profile/AddToCart", \CustomerController::class, "AddToCart", ['AuthMiddleware:customer']);
\Route::post("/Profile/updateQuantity", \CustomerController::class, "updateQuantity", ['AuthMiddleware:customer']);
\Route::post("/Profile/DeleteItem", \CustomerController::class, "DeleteItem", ['AuthMiddleware:customer']);
\Route::post("/Profile/fireOrder", \CustomerController::class, "fireOrder", ['AuthMiddleware:customer']);
