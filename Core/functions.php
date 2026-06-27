<?php

use Core\Response;

function dd($value)
{
    if (is_array($value) || is_object($value)) {
        echo "<h2> <pre>";
        var_dump($value);
        echo "</h2> </pre>";
    } else {
        echo $value;
    }
    die();
}

function urlIS($url)
{
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $requestUri === $url;
}

function abort($code = Response::NOT_FOUND)
{
    http_response_code($code);
    require base_path("views/errors/{$code}.php");
    die();
}

function authorize($conditon, $status = Response::FORBIDDEN)
{
    if (!$conditon) {
        abort($status);
    }
}


function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);
    require base_path("views/{$path}");
}


function redirect($path)
{
    header("location: $path");
    exit();
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}
