<?php
include_once 'db.php';
include_once 'Producto.php';
include_once 'Pedido.php';
include_once 'PedidosBBDD.php';
// Clase Admin que hereda de Usuario
class Admin extends User {
    // Métodos específicos para el admin
    public function __construct() {

    }
/*
    public function suficientesPermisos($sujeto) {
        if (strpos($this->PERMISO, get_class($sujeto))) {
            return true;
        }
        return false;
        
    }
*/
    public static function insertUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $PASSWORD, $TELEFONO, $DIRECCION, $PERMISO = 0){
        parent::insertUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION);
        $result = Admin::registrarActividad("Insert", "User", $email);
    }

    public static function updateUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION){
        parent::updateUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION);
        $result = Admin::registrarActividad("Update", "User", $email);
    }
    public static function deleteUser($id){
        $conn = db::connect();

        // Consulta para eliminar el usuario basado en el email
        $sql = "DELETE FROM usuarios WHERE USUARIO_ID = ?";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular el parámetro
        $stmt->bind_param('s', $id);
        
        try {
            // Ejecutar la consulta
            $stmt->execute();

            $result = Admin::registrarActividad("Del", "User", $id);
            return true; // Éxito al eliminar el usuario
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            return false; // Error al eliminar el usuario
        }

        //ejecutamos consulta
        $stmt->execute();
        $conn->close();
    }

    public static function insertPedido($user, $array_id_product, $array_cantidades){
        $conn = db::connect();

        foreach ($arrayIdsProductos as $idProducto) {
            $consulta = "SELECT * FROM productos WHERE id = :id";
            $stmt = $conn->prepare($consulta);
            $stmt->bindParam(':id', $idProducto);
            $stmt->execute();
        
            if ($resultado = $stmt->fetch_object('Producto')) {
                $array_products[] = $resultado;
            }
        }

        $cantPedidos = 0;
        foreach ($array_products as $productos) {
            $pedidos[] = new Pedido($productos);
            $pedidos[$cantPedidos]->setCantidad($array_cantidades[$cantPedidos]);
            $cantPedidos++;
            
        }

        $result = PedidosBBDD::procesarPedido($user, $pedidos);
        $id_pedido = PedidosBBDD::getIdUltimoPedido();
        $result = Admin::registrarActividad("Insert", "Pedido", $id_pedido);
    }

    public static function updatePedido($pedido_id, $usuario_id, $estado, $fecha_pedido){
        $result = PedidosBBDD::updatePedido($pedido_id, $usuario_id, $estado, $fecha_pedido);
        $result = Admin::registrarActividad("Update", "Pedido", $pedido_id);
    }

    public static function deletePedido($pedido_id){
        $result = PedidosBBDD::deletePedido($pedido_id);
        $result = Admin::registrarActividad("Delete", "Pedido", $pedido_id);
    }

    public static function insertProduct($nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id){
        $result = Producto::insertProduct($nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id);
        $result = Admin::registrarActividad("Insert", "Product", $nombre_producto);
    }

    public static function updateProduct($producto_id, $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id){
        $result = Producto::updateProduct($producto_id, $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id);
        $result = Admin::registrarActividad("Update", "Product", $producto_id);
    }
    public static function deleteProduct($producto_id){
        $result = Producto::deleteProduct($producto_id);
        $result = Admin::registrarActividad("Delete", "Product", $producto_id);
    }

    public static function registrarActividad($actividad, $objeto, $valor_diferencial_objeto) {
        if (isset($_SESSION['user'])) {
            $id_user = $_SESSION['user']->getId();
        }else{
            $id_user = 1;
        }
        $conn = db::connect();
        $valor_diferencial_objeto .= "";
        // Consulta para insertar un nuevo producto
        $consulta = "INSERT INTO REGISTRO_CAMBIOS (USUARIO_ID, ACCION, TIPO_SUJETO, SUJETO, FECHA_CAMBIO) 
                    VALUES (?, ?, ?, ?, SYSDATE())";
            
        $stmt = $conn->prepare($consulta);
        $stmt->bind_Param('isss', $id_user, $actividad, $objeto, $valor_diferencial_objeto);
            
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}