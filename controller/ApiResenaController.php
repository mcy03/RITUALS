<?php
include_once "model/ResenaDAO.php";

class ApiResenaController{    

    public function api(){
        $accion = isset($_POST["accion"]) ? $_POST["accion"] : '';
 
        //print_r($_POST);
        if(trim($accion) == "get_reviews"){  

           //header('Content-Type: application/json; charset=UTF-8');
            if (isset($_POST['orden'])) {
                $orden = $_POST['orden'];

                $resenas = ResenaDAO::getResenas($orden);
            }else if(isset($_POST['filtro'])){
                $filtro = $_POST['filtro'];

                $resenas = ResenaDAO::getResenas($orden = "", $filtro);
            }else{
                $resenas = ResenaDAO::getResenas();
            }

            $array_resenas = [];
            foreach ($resenas as $resena) {
                $array_resenas[] = array(
                    "RESENA_ID" => $resena->getId(),
                    "PEDIDO_ID" => $resena->getPedidoId(),
                    "ASUNTO" => $resena->getAsunto(),
                    "COMENTARIO" => $resena->getComentario(),
                    "FECHA_RESENA" => $resena->getFechaResena(),
                    "VALORACION" => $resena->getValoracion(),
                    "EMAIL" => $resena->getEmail($resena->getUser())
                );
            }
            
            echo json_encode($array_resenas, JSON_UNESCAPED_UNICODE);
            return;
        }else if($accion == 'get_review'){
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

        }else if($accion == 'add_review'){ 
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