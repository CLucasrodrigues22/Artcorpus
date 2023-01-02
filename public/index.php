<?php

    // require autoload.php for class
    require_once "../vendor/autoload.php";

    // use routes
    use App\Route;

    //echo '<pre>';
    //print_r(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    //print_r($_SERVER);
    $routes = new Route();



    