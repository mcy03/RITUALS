<?php
include_once "model/Categoria.php";
include_once "model/Producto.php";

class ApiCategoriaController{    

    public function api(){
        $accion = isset($_POST["accion"]) ? $_POST["accion"] : '';
 
        //print_r($_POST);
        if(trim($accion) == "get_categories"){  
            
            $categorias = Categoria::getCat();

            $array_categorias = [];
            foreach ($categorias as $categoria) {
                $array_categorias[] = array(
                    "CATEGORIA_ID" => $categoria->getCategoriaId(),
                    "NOMBRE_CATEGORIA" => $categoria->getName(),
                );
            }
            
            echo json_encode($array_categorias, JSON_UNESCAPED_UNICODE);
            return $array_categorias;
        }else if($accion == 'get_category'){
            $resena_id = json_decode($_POST["RESENA_ID"]); //se decodifican los datos JSON que se reciben desde JS
            
            $resena = ResenaDAO::getResenaById($resena_id);

            $array_resenas = array(
                "RESENA_ID" => $resena->getId(),
                "PEDIDO_ID" => $resena->getPedidoId(),
                "ASUNTO" => $resena->getAsunto(),
                "COMENTARIO" => $resena->getComentario(),
                "FECHA_RESENA" => $resena->getFechaResena(),
                "VALORACION" => $resena->getValoracion()
            );
                
            echo json_encode($array_resenas, JSON_UNESCAPED_UNICODE); 
            return $array_resenas; //return para salir de la funcion

        }else if($accion == 'get_all_products'){ 
            $productos = Producto::getProducts();

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
            return $array_productos; //return para salir de la funcion
        }else if($accion == 'get_products_category'){ 
            $categorias = json_decode($_POST["categoria"]); //se decodifican los datos JSON que se reciben desde JS

            foreach ($categorias as $categoria) {
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
            }
                
            echo json_encode($array_productos, JSON_UNESCAPED_UNICODE); 
            return $array_productos; //return para salir de la funcion
        }
    }
}