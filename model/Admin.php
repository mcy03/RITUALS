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

    public static function insertUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $PASSWORD, $TELEFONO, $DIRECCION, $PERMISO = 0){
        // Intentar insertar el usuario en la base de datos
        if(parent::insertUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $PASSWORD, $TELEFONO, $DIRECCION)) {
            // Si la inserción tiene éxito, registrar la actividad del administrador
            $result = Admin::registrarActividad("Insert", "User", $EMAIL);
            return true; // Devolver true si la inserción y el registro fueron exitosos
        } else {
            return false; // Devolver false si la inserción falló
        }
    }    

    public static function updateUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION){
        // Intentar actualizar la información del usuario
        if(parent::updateUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION)) {
            // Si la actualización tiene éxito, registrar la actividad del administrador
            $result = Admin::registrarActividad("Update", "User", $EMAIL);
            return true; // Devolver true si la actualización y el registro fueron exitosos
        } else {
            return false; // Devolver false si la actualización falló
        }
    }
    
    public static function deleteUser($id){
        $conn = db::connect();
        $sql = "DELETE FROM usuarios WHERE USUARIO_ID = ?"; // Consulta para eliminar el usuario basado en el ID
    
        $stmt = $conn->prepare($sql); // Preparar la consulta
    
        
        $stmt->bind_param('i', $id);// Vincular el parámetro
        
        try {
            $stmt->execute();// Ejecutar la consulta
    
            // Registrar actividad relacionada con la eliminación del usuario
            $result = Admin::registrarActividad("Del", "User", $id);
            $conn->close(); // Cerrar la conexión
            return true; // Éxito al eliminar el usuario
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            $conn->close(); // Cerrar la conexión en caso de error
            return false; // Error al eliminar el usuario
        }
    }
    

    public static function insertPedido($user, $array_id_product, $array_cantidades){
        $conn = db::connect();

        foreach ($array_id_product as $idProducto) {
            $consulta = "SELECT * FROM productos WHERE  PRODUCTO_ID = ?";
            $stmt = $conn->prepare($consulta);
            $stmt->bind_param('i', $idProducto);
            $stmt->execute();
            $result=$stmt->get_result();

            $array_products[] = $result->fetch_object('Producto');
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
        $resultUpdate = PedidosBBDD::updatePedido($pedido_id, $usuario_id, $estado, $fecha_pedido); // Actualizar el pedido en la base de datos
    
        // Verificar si la actualización fue exitosa antes de registrar la actividad del administrador
        if ($resultUpdate) {
            // Si la actualización del pedido fue exitosa, registrar la actividad del administrador
            $resultActividad = Admin::registrarActividad("Update", "Pedido", $pedido_id);
            return true; // Devolver true si todo se ejecutó correctamente
        } else {
            return false; // Devolver false si hubo algún problema al actualizar el pedido
        }
    }
    
    public static function deletePedido($pedido_id){
        // Eliminar el pedido de la base de datos
        $resultDelete = PedidosBBDD::deletePedido($pedido_id);
    
        // Verificar si la eliminación fue exitosa antes de registrar la actividad del administrador
        if ($resultDelete) {
            // Si la eliminación del pedido fue exitosa, registrar la actividad del administrador
            $resultActividad = Admin::registrarActividad("Delete", "Pedido", $pedido_id);
            return true; // Devolver true si todo se ejecutó correctamente
        } else {
            return false; // Devolver false si hubo algún problema al eliminar el pedido
        }
    }
    

    public static function insertProduct($nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id){
        // Intentar insertar el producto en la base de datos
        $resultInsert = Producto::insertProduct($nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id);
    
        // Verificar si la inserción fue exitosa antes de registrar la actividad del administrador
        if ($resultInsert) {
            // Si la inserción del producto fue exitosa, registrar la actividad del administrador
            $resultActividad = Admin::registrarActividad("Insert", "Product", $nombre_producto);
            return true; // Devolver true si todo se ejecutó correctamente
        } else {
            return false; // Devolver false si hubo algún problema al insertar el producto
        }
    }
    

    public static function updateProduct($producto_id, $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id){
        // Intentar actualizar el producto en la base de datos
        $resultUpdate = Producto::updateProduct($producto_id, $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id);
    
        // Verificar si la actualización fue exitosa antes de registrar la actividad del administrador
        if ($resultUpdate) {
            // Si la actualización del producto fue exitosa, registrar la actividad del administrador
            $resultActividad = Admin::registrarActividad("Update", "Product", $producto_id);
            return true; // Devolver true si todo se ejecutó correctamente
        } else {
            return false; // Devolver false si hubo algún problema al actualizar el producto
        }
    }
    
    public static function deleteProduct($producto_id){
        // Eliminar el producto de la base de datos
        $resultDelete = Producto::deleteProduct($producto_id);
    
        // Verificar si la eliminación fue exitosa antes de registrar la actividad del administrador
        if ($resultDelete) {
            // Si la eliminación del producto fue exitosa, registrar la actividad del administrador
            $resultActividad = Admin::registrarActividad("Delete", "Product", $producto_id);
            return true; // Devolver true si todo se ejecutó correctamente
        } else {
            return false; // Devolver false si hubo algún problema al eliminar el producto
        }
    }
    
    public static function registrarActividad($actividad, $objeto, $valor_diferencial_objeto) {
        $id_user = isset($_SESSION['user']) ? $_SESSION['user']->getId() : 1;
    
        $conn = db::connect();
    
        // Consulta para insertar un nuevo registro de actividad
        $consulta = "INSERT INTO REGISTRO_CAMBIOS (USUARIO_ID, ACCION, TIPO_SUJETO, SUJETO, FECHA_CAMBIO) 
                    VALUES (?, ?, ?, ?, SYSDATE())"; // Usando NOW() para la fecha actual
    
        $stmt = $conn->prepare($consulta);
        $stmt->bind_Param('isss', $id_user, $actividad, $objeto, $valor_diferencial_objeto);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
}