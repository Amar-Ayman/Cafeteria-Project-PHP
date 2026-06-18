<?php

use Core\Router;
const BASE_PATH = __DIR__ . "/../";

require_once BASE_PATH . "Core/functions.php";

session_start();

spl_autoload_register(function ($class) {
    $class = str_replace("\\", "/", $class);
    require base_path("{$class}.php");
});

$router = new Router();

require base_path("routes.php");

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($url, $method);
