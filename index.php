<?php
use AdminTwig\Router\Route;
use AdminTwig\App;

// Composer autoloader && view path config
require_once(__DIR__ . "/vendor/autoload.php");
const VIEWPATH = __DIR__ . '/pages';
const ROOT = __DIR__;


// Here we go
$route = App::getInstance()->getRouter()->run();
if (!is_null($route)) {
    return call_user_func_array($route->getController(), $route->getMatches());
}

// Not found handler :)
http_response_code(404);
echo "404 Not Found";
exit();
