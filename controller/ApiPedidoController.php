<?php
include_once "model/Pedido.php";
include_once "model/Producto.php";
include_once "model/PedidosBBDD.php";
include_once "model/ProductosPedidosDAO.php";

class ApiPedidoController{    

    public function api(){
        $accion = isset($_POST["accion"]) ? $_POST["accion"] : '';
 
        if(trim($accion) == "get_pedidos"){  
            $pedidos = PedidosBBDD::getPedidosBBDD();

            $array_pedidos = [];
            foreach ($pedidos as $pedido) {
                $array_pedidos[] = array(
                    "PEDIDO_ID" => $pedido->getId(),
                    "USUARIO_ID" => $pedido->getUserId(),
                    "ESTADO" => $pedido->getEstado(),
                    "FECHA_PEDIDO" => $pedido->getFechaPedido()
                );
            }
            
            echo json_encode($array_pedidos, JSON_UNESCAPED_UNICODE);
            return;

        }else if(trim($accion) == "get_last_command"){  
            $pedido_id = PedidosBBDD::getIdUltimoPedido();
            $pedido = PedidosBBDD::getPedidoById($pedido_id);
            $array_pedido = [];
            $array_pedido[] = array(
                "PEDIDO_ID" => $pedido->getId(),
                "USUARIO_ID" => $pedido->getUserId(),
                "ESTADO" => $pedido->getEstado(),
                "FECHA_PEDIDO" => $pedido->getFechaPedido(),
                "COSTE_PEDIDO" => $pedido->getCostePedido(),
                "PROPINA" => $pedido->getPropina(),
                "PUNTOS_APLICADOS" => $pedido->getPuntos()
            );
            echo json_encode($array_pedido, JSON_UNESCAPED_UNICODE);
            return;

        }else if($accion == 'get_pedidos_user'){
            $usuario_id = json_decode($_POST["USUARIO_ID"]); //se decodifican los datos JSON que se reciben desde JS
            
            $pedidos_user = PedidosBBDD::getPedidosBBDD_ByIdUser($usuario_id);

            $array_pedidos = [];
            foreach ($pedidos_user as $pedido) {
                $array_pedidos[] = array(
                    "PEDIDO_ID" => $pedido->getId(),
                    "USUARIO_ID" => $pedido->getUserId(),
                    "ESTADO" => $pedido->getEstado(),
                    "FECHA_PEDIDO" => $pedido->getFechaPedido()
                );
            }
                
            echo json_encode($array_pedidos, JSON_UNESCAPED_UNICODE); 
            return $array_pedidos; //return para salir de la funcion

        }else if($accion == 'get_products_pedido'){
            $pedido = json_decode($_POST["PEDIDO_ID"]);
            $productos = ProductosPedidosDAO::getPedidosBBDD_ByIdPedido($pedido);

            $array_productos = [];
            foreach ($productos as $producto) {
                $array_productos[] = array(
                    "ARTICULO_ID" => $producto->getId(),
                    "PEDIDO_ID" => $producto->getPedidoId(),
                    "PRODUCTO_ID" => $producto->getProductoId(),
                    "CANTIDAD" => $producto->getCantidad(),
                    "PRECIO_UNIDAD" => $producto->getPrecioUnidad()
                );
            }
                
            echo json_encode($array_productos, JSON_UNESCAPED_UNICODE); 
            return; //return para salir de la funcion

        }else if($accion == 'get_products_category'){ 
            $categoria = json_decode($_POST["categoria"]); //se decodifican los datos JSON que se reciben desde JS
            
            $id_cat = Categoria::getCatIdByName($categoria);
            $productos = Producto::getProductByCat($id_cat);

            $array_productos = [];
            foreach ($productos as $producto) {
                $array_productos[] = array(
                    "PRODUCTO_ID" => $producto->getId(),
                    "NOMBRE_PRODUCTO" => $producto->getName(),
                    "IMG" => $producto->getImg(),
                    "DESCRIPCION" => $producto->getDesc(),
                    "PRECIO_UNIDAD" => $producto->getPrice(),
                    "CATEGORIA_ID" => $producto->getCat()
                );
            }
                
            echo json_encode($array_productos, JSON_UNESCAPED_UNICODE); 
            return; //return para salir de la funcion

        }elseif ($accion == 'add_propina') {
            $propina = json_decode($_POST["propina"]);

            $pedido = PedidosBBDD::getIdUltimoPedido();

            $result = PedidosBBDD::updatePropina($pedido, $propina);

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }elseif ($accion == 'add_puntos') {
            $puntos = json_decode($_POST["puntos"]);

            $pedido = PedidosBBDD::getIdUltimoPedido();

            $result = PedidosBBDD::updatePuntos($pedido, $puntos);

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }elseif ($accion == 'generate_qr') {
            $url = 'https://api.qrserver.com/v1/create-qr-code/?data=HelloWorld&size=100x100';
        }



        
    }
}