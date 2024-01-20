<?php
include_once "model/ResenaDAO.php";

class ApiResenaController{    
    public function index(){
        echo "estas en la api";
    }
    public function api(){
        $accion = isset($_POST["accion"]) ? $_POST["accion"] : '';
 
       //print_r($_POST);
        if(trim($accion) == "buscar_todo"){  

           //header('Content-Type: application/json; charset=UTF-8');
            
            $resenas = ResenaDAO::getResenas();
           
            $array_resenas = [];
            foreach ($resenas as $resena) {
                $array_resenas[] = array(
                    "RESENA_ID" => $resena->getId(),
                    "PEDIDO_ID" => $resena->getPedidoId(),
                    "ASUNTO" => $resena->getAsunto(),
                    "COMENTARIO" => $resena->getComentario(),
                    "FECHA_RESENA" => $resena->getFechaResena(),
                    "VALORACION" => $resena->getValoracion()
                );
            }
            echo trim($accion) == "buscar_todo";
            echo json_encode($array_resenas, JSON_UNESCAPED_UNICODE);
            return;
        }else if($accion == 'buscar_resena'){
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
            $PEDIDO_ID = json_decode($_POST["PEDIDO_ID"]);
            $ASUNTO = json_decode($_POST["ASUNTO"]);
            $COMENTARIO = json_decode($_POST["COMENTARIO"]);
            $FECHA_RESENA = json_decode($_POST["FECHA_RESENA"]);
            $VALORACION = json_decode($_POST["VALORACION"]);

            //ResenaDAO::insertResena(52, "asunto", "comentario", "2023/03/02", 3);
            $return = ResenaDAO::insertResena($PEDIDO_ID, $ASUNTO, $COMENTARIO, $FECHA_RESENA, $VALORACION);
            echo "insert correcto";
            return;
        }
    }
}