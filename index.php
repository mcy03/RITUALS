<?php
    include_once 'controller/pedidoController.php';
    include_once 'config/parameters.php';
    if (!isset($_GET['controller'])) {
        //si no pasamos nada, se mostrara paginaPedidos principal
        header("Location:".url.'?controller=pedido');
    }else{
        $nombre_controller = $_GET['controller'].'Controller';
        if (class_exists($nombre_controller)) {
            $controller = new $nombre_controller();
            if (isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
                $action = $_GET['action'];
            }else{
                $action = action_default;
            }
            $controller->$action();
        }else{
            header("Location:".url.'?controller=pedido');
        }
    }
?>