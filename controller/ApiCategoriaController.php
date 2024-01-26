<?php
include_once "model/Categoria.php";

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

        }else if($accion == 'get_products_category'){ 
            $PEDIDO_ID = json_decode(trim($_POST["PEDIDO_ID"]));
            $ASUNTO = json_decode(trim($_POST["ASUNTO"]));
            $COMENTARIO = json_decode(trim($_POST["COMENTARIO"]));
            $FECHA_RESENA = json_decode(trim($_POST["FECHA_RESENA"]));
            $VALORACION = json_decode(trim($_POST["VALORACION"]));

            $return = ResenaDAO::insertResena($PEDIDO_ID, $ASUNTO, $COMENTARIO, $FECHA_RESENA, $VALORACION);

            echo "insert correcto";
            return;
        }
    }
}