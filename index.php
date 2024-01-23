<?php

include_once 'controller/productoController.php';
include_once 'controller/ApiResenaController.php';
include_once 'controller/ApiUserController.php';
include_once 'config/parameters.php';

if (!isset($_GET['controller'])) {
    //Si no le pasamos nada se pasara pagina principal de productos
    header("location:" . url . '?controller=producto');
} else {
    $nombre_controller = $_GET['controller'] . 'Controller';

    if (class_exists($nombre_controller)) {
        //Miro si nos pasa una accion
        //En caso contrario mostramos una accion por defecto
        $controller = new $nombre_controller;

        if (isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'index';
        }
        $controller->$action();
    } else {
        header("location:" . url . '?controller=producto');
    }
}
?>