<?php
require_once(__DIR__ . "/vendor/autoload.php");

use AdminTwig\Router\Route;
use AdminTwig\Application;


$router = new Router($_SERVER['REQUEST_URI'] ?? '/');
require(__DIR__ . "src/routes.php");

$app = new Application();
$app->run();