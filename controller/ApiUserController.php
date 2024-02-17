<?php
include_once "model/User.php";
include_once "model/Admin.php";
class ApiUserController{    
    public function index(){
        echo "estas en la api user";
    }
    public function api(){
        $accion = isset($_POST["accion"]) ? $_POST["accion"] : '';
 
        if(trim($accion) == "get_user"){  
            
            $id = $_POST['USUARIO_ID'];

            $user = User::getUserById($id);

            $array_user[] = array(
                "USUARIO_ID" => $user->getId(),
                "EMAIL" => $user->getEmail(),
                "PUNTOS" => $user->getPuntos(),
                "SALUDO" => $user->getSaludo(),
                "NOMBRE" => $user->getName(),
                "APELLIDOS" => $user->getApellidos(),
                "FECHA_NACIMIENTO" => $user->getFechaNacimiento(),
                "PASSWORD" => $user->getPass(),
                "TELEFONO" => $user->getPhone(),
                "DIRECCION" => $user->getDir(),
                "PERMISO" => $user->getPermiso()
            );

            echo json_encode($array_user, JSON_UNESCAPED_UNICODE);
            return;
        }elseif (trim($accion) == "log_user") {
            $id = $_POST['user_id'];
            $user = User::getUserById($id);

            

            echo json_encode($user, JSON_UNESCAPED_UNICODE);
            return;
        }elseif (trim($accion) == "get_points_user") {
            $id = $_POST['user_id'];

            $points = User::getPointsById($id);

            echo json_encode($points, JSON_UNESCAPED_UNICODE);
            return;
        }elseif ($accion == 'update_puntos') {
            $puntos = json_decode($_POST["puntos"]);
            $user = json_decode($_POST["user"]);


            $result = User::updatePuntos($user, $puntos);

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }
    }
}