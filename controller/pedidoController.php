<?php
include_once("model/Producto.php");
include_once 'config/parameters.php';
class pedidoController{
    public function index(){
        $productos = Producto::getProducts();
        //cabecera
        require_once("views/header.php");
        //include panel
        require_once("views/panelPedido.php");
        //pie
    }

    public static function eliminar(){
        echo "eliminar producto ";
        $id_product = 1;  //$_POST['id']
        Producto::deleteProduct($id_product);
        header("Location:".url.'?controller=producto');
    }
    public static function editar($id){
        echo "editar producto ";
        $id = 1;  //$_POST['id']
        $conn = db::connect();


        $stmt = $conn->prepare("DELETE FROM productos WHERE ID=?");
        $stmt->bind_param("i", $id);

        //ejecutamos consulta
        $stmt->execute();
        $result=$stmt->get_result();

        $conn->close();
        return $result;
    }
}