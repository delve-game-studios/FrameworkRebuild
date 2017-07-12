<?php
use \System\Route;

Route::$_route = array(
    "/:controller/:action" => array("App::Dynamic"),
    "/:controller/:action/:id" => array("App::Dynamic"),

    "/" => array("\Application\Controllers\cms::Index"),
    "/login" => array("\Application\Controllers\cms::Login"),
);

?>