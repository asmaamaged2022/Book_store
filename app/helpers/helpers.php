<?php
function pr(mixed $data, bool $die = false)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($die) {
        exit;
    }
}
function prJson(mixed $data, bool $die = false)
{
    echo "<pre>";
    print_r(json_encode($data));
    echo "</pre>";
    if ($die) {
        exit;
    }
}
function asset(string $path)
{
    return BASE_URL . "/assets/" . ltrim($path, "/");
}
function route(string $path)
{
    return BASE_URL . $path;
}
function session(string $key, mixed $value)
{
    //!Getter
    if (func_num_args() === 1) {
        return $_SESSION[$key] ?? null;
    }
    /** this explain for getter
    if (isset($_SESSION[$key])) {
    return $_SESSION[$key];
    } else {
    return null;
    }
     */
    //!setter
    return $_SESSION[$key] = $value;
}
function old(string $key, mixed $default = "")
{
    $old = $_SESSION['_old'][$key] ?? $default;
    unset($_SESSION['_old'][$key]);
    return $old;
}
function oldSelect(string $key, mixed $optionValue, bool $delete = false)
{
    $old = (isset($_SESSION['_old'][$key]) && ($_SESSION['_old'][$key] == $optionValue)) ? "selected" : "";

    if ($delete) {
        unset($_SESSION['_old'][$key]);
    }
    return  $old;
}
function isSelected(string $value, mixed $optionValue)
{
    $old = ($value== $optionValue) ? "selected" : "";
    return  $old;
}
function back(?string $key = null, mixed $msg = null)
{
    $path = $_SERVER['HTTP_REFERER'];
    if ($key !== null) {
        $_SESSION[$key] = $msg;
    }
    header("location: {$path}");
    exit;
}
function isAuth(?string $role = null): bool
{
    // $user = $_SESSION['user'] ?? null;
    if (!isset($_SESSION['user'])) {
        return false;
    }
    if ($role === null) {
        return true;
    }
    return ($_SESSION['user']['role'] ?? null) == $role;
}
function Auth(?string $key = null): mixed
{
    $user = $_SESSION['user'] ?? null;
    //* to return all user info
    if ($key == null) {
        return $user;
    }
    //* to return spacial info of user
    return $user[$key] ?? null;
}
function isGust(): bool
{
    return ! isAuth();
}
function redirect(string $path)
{
    $url = BASE_URL . $path;
    header("Location: {$url}");
    exit;
}
//*field errors
function getError(string $key)
{
    $htmlError = "";
    if (isset($_SESSION["_errors"][$key])) {
        $htmlError = "<p class='alert alert-danger text-start'>{$_SESSION["_errors"][$key][0]}</p>";
        unset($_SESSION["_errors"][$key]);
    }
    return $htmlError;
}
//* alert in system
function getSessionMsg(string $key, bool $isErr = true)
{
    $htmlSuccess = "";

    $color = ($isErr) ? "alert-danger" : "alert-success";
    if (isset($_SESSION[$key])) {
        $htmlSuccess = "<p class='alert {$color} text-start'>{$_SESSION[$key]}</p>";

        unset($_SESSION[$key]);
        unset($_SESSION["_old"]);
    }

    return $htmlSuccess;
}
