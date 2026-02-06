<?php

require __DIR__ . "/../vendor/autoload.php" ;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require "../helpers.php";

use Framework\Router;
use Framework\Session;

Session::start();

$router = new Router();

require basePath("routes/web.php");

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// inspect($uri);

$router->route($uri);

// echo <<<NOWDOCS
// <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Document</title>
// </head>
// <body>
//     Hello world! It is us
// </body>
// </html>
// NOWDOCS;