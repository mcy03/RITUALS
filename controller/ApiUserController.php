<?php
include_once "model/User.php";

class ApiUserController{    
    public function index(){
        echo "estas en la api user";
    }
    public function api(){
        $accion = isset($_POST["accion"]) ? $_POST["accion"] : '';
 
        if(trim($accion) == "get_user"){  
            
            $user = $_SESSION['user'];
            
            $array_user[] = array(
                "USUARIO_ID" => $userv->getId(),
                "EMAIL" => $userv->getEmail(),
                "SALUDO" => $userv->getSaludo(),
                "NOMBRE" => $userv->getName(),
                "APELLIDOS" => $userv->getApellidos(),
                "FECHA_NACIMIENTO" => $userv->getFechaNacimiento(),
                "PASSWORD" => $userv->getPass(),
                "TELEFONO" => $userv->getPhone(),
                "DIRECCION" => $userv->getDir(),
                "PERMISO" => $userv->getPermiso()
            );

            echo json_encode($array_user, JSON_UNESCAPED_UNICODE);
            return;
        }elseif (trim($accion) == "log_user") {
            $id = $_POST['user_id'];
            $user = User::getUserById($id);

        }
    }
}