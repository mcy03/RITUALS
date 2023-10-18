<?php

class productosController{
    public function content(){
        //cabecera

        //include panel
        $conn = db::connect();
        $resultado = $conn->query("SELECT * FROM productos");
            while ($producto = $resultado->fetch_assoc()) {
                $prod[] = new Producto($producto['id']);
            }
        require_once("/views/viewProductos.phtml");
        //pie
    }
    public function compra(){
        echo "pagina principal compra";
    }
}