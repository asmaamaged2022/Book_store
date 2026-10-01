<?php

class Route
{
    private static array $routes = [];
    /* 
    *each route call a controller and func in this controller 
    *so that pass controller and func and url that i want (if i write it go to this controller)
    *and middleware
    */
    public static function get(string $url, string $controller, string $action, array $middlewares = []): void
    {
        /* 
        *self to static data fields or static methods
        * this to normal data fields and normal methods
        */

        self::$routes[] = [
            'url'         => $url,
            'method'      => 'GET',
            'controller'  => $controller,
            'action'      => $action,
            'middlewares' => $middlewares,
        ];
    }
    public static function post(string $url, string $controller, string $action, array $middlewares = []): void
    {
        self::$routes[] = [
            'url'         => $url,
            'method'      => 'POST',
            'controller'  => $controller,
            'action'      => $action,
            'middlewares' => $middlewares,
        ];
    }

    public static function routes(): array
    {
        return self::$routes;
    }
    //*despatch loop on routes
    public static function despatch()
    {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $url    = rtrim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];
        $flag = false;
        foreach (self::$routes as $route) {
            $args = self::matchRoute(BASE_URL . $route["url"], $url);

            if ($args !== false) {
                if (BASE_URL . $route["url"] === $url) {
                    if ($method !== $route["method"]) {
                        $flag = true;
                        continue;
                    }

                    self::handleMiddleware($route['middlewares']);
                    //* create obj from controller
                    $obj = new $route["controller"]();
                    // $obj->{$route["action"]}();
                    //if data exist 
                    $obj->{$route["action"]}(...$args);
                    return;
                }
            }
        }
        if ($flag) {
            \Response::error("405 method error", 405);
        }
        \Response::error(" error 404", 404);
    }
    private static function matchRoute(string $route, string $url): false | array
    {
        $regex   = "/\{[A-Za-z_][A-Za-z_]*\}/";
        $pattern = preg_replace($regex, "([^/]+)", $route);
        $pattern = "#^{$pattern}$#";
        //* matches --> declared in func preg_matches
        if (! preg_match($pattern, $url, $matches)) {
            return false;
        }
        //* to delete url in index 1
        unset($matches[0]);
        return $matches;
    }
    // * loop on all middlewares and fire it
    private static function handleMiddleware(array $middlewares): void
    {

        foreach ($middlewares as $middleware) {
            $args = [];
            if (str_contains($middleware, ":")) {
                //*["AuthMiddleware:admin,customer"]
                $arr = explode(":", $middleware);
                //* "AuthMiddleware", "admin,customer"
                $middleware = $arr[0];
                $args       = explode(",", $arr[1]);
                //* "admin","customer"

            }
            (new $middleware())->handle(...$args);
        }
    }
}
