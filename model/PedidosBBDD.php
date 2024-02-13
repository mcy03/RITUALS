<?php
// Incluir las clases Producto y Pedido
include_once("model/Producto.php");
include_once("model/Pedido.php");
/*      
=========================================================================
|                           CLASE PedidosBBDD                           |
=========================================================================
| Inicializamos la clase PedidosBBDD la cual conectara a la base de     |
| datos para obtener registros de pedidos y trabajara con ellos         |
=========================================================================
*/
class PedidosBBDD{
    protected $PEDIDO_ID; // Identificador único del pedido en la tabla de pedidos

    protected $USUARIO_ID; // Identificador del usuario asociado con este pedido

    protected $ESTADO; // Estado actual del pedido: pendiente, en proceso, completado, etc.

    protected $FECHA_PEDIDO; // Fecha en la que se realizó el pedido
    
    protected $PROPINA;

    public function __construct(){

    }

    /**
     * Obtiene todos los pedidos de la base de datos.
     * @return array|false Retorna un array de objetos PedidosBBDD si hay resultados,
     * o 'false' si no se obtienen resultados o hay un error en la consulta.
     */
    public static function getPedidosBBDD(){
        $conn = db::connect(); // Establece la conexión a la base de datos
        
        // Consulta SQL para obtener todos los pedidos
        $consulta = "SELECT * FROM pedidos";

        if ($resultado = $conn->query($consulta)) {
            $arrayPedidosBBDD = []; // Inicializa un array para almacenar los objetos PedidosBBDD
            
            /* Obtener el array de objetos */
            while ($obj = $resultado->fetch_object('PedidosBBDD')) {
                $arrayPedidosBBDD[] = $obj; // Agrega cada objeto a la lista de pedidos
            }
        
            $resultado->close(); // Cierra el conjunto de resultados
            return $arrayPedidosBBDD; // Retorna el array de pedidos
        }else{
            return false; // Retorna 'false' si la consulta falla o no se obtienen resultados
        }
    }

    /**
     * Obtiene el identificador único del pedido.
     * @return int El ID del pedido
     */
    public function getId(){
        return $this->PEDIDO_ID;
    }

    /**
     * Establece el identificador único del pedido.
     * @param int $pedido_id El ID del pedido a asignar.
     */
    public function setId($pedido_id){
        $this->PEDIDO_ID = $pedido_id;
    }

    /**
     * Obtiene el ID del usuario asociado al pedido.
     * @return int El ID del usuario asociado al pedido.
     */
    public function getUserId(){
        return $this->USUARIO_ID;
    }

    /**
     * Establece el ID del usuario asociado al pedido.
     * @param int $usuario_id El ID del usuario a asignar al pedido.
     */
    public function setUserId($usuario_id){
        $this->USUARIO_ID = $usuario_id;
    }

    /**
     * Obtiene el estado actual del pedido.
     * @return string El estado actual del pedido.
     */
    public function getEstado(){
        return $this->ESTADO;
    }

    /**
     * Establece el estado del pedido.
     * @param string $estado El estado a asignar al pedido.
     */
    public function setEstado($estado){
        $this->ESTADO = $estado;
    }

    /**
     * Obtiene la fecha en la que se realizó el pedido.
     * @return string|null La fecha del pedido o null si no está asignada.
     */
    public function getFechaPedido(){
        return $this->FECHA_PEDIDO;
    }

    /**
     * Establece la fecha en la que se realizó el pedido.
     * @param string $fechaPedido La fecha del pedido a asignar.
     */
    public function setFechaPedido($fechaPedido){
        $this->FECHA_PEDIDO = $fechaPedido;
    }

    /**
     * Obtiene un pedido específico de la base de datos por su ID.
     * @param int $id El ID del pedido que se quiere recuperar.
     * @return array|false Retorna un array de objetos PedidosBBDD si se encuentra el pedido,
     * o 'false' si no se obtienen resultados o hay un error en la consulta.
     */
    public static function getPedidoById($id){
        $conn = db::connect(); // Establece la conexión a la base de datos
        $consulta = "SELECT * FROM pedidos WHERE PEDIDO_ID = $id"; // Consulta SQL para obtener el pedido por su ID

        if ($resultado = $conn->query($consulta)) {
            $arrayPedidosBBDD = []; // Inicializa un array para almacenar los objetos PedidosBBDD

            /* Obtener el array de objetos */
            if($obj = $resultado->fetch_object('PedidosBBDD')) {
                $arrayPedidosBBDD = $obj; // Agrega cada objeto a la lista de pedidos
            }
        
            $resultado->close(); // Cierra el conjunto de resultados
            return $arrayPedidosBBDD; // Retorna el array de pedidos encontrados por el ID
        } else {
            // Retorna 'false' si la consulta falla o no se obtienen resultados
            return false;
        }
    }

    /**
     * Obtiene los pedidos de un usuario específico desde la base de datos por su ID, utilizando bind_param para seguridad.
     * @param int $id_user El ID del usuario cuyos pedidos se quieren recuperar.
     * @return array|false Retorna un array de objetos PedidosBBDD si se encuentran pedidos para el usuario,
     * o 'false' si no se obtienen resultados o hay un error en la consulta.
     */
    public static function getPedidosBBDD_ByIdUser($id_user){
        $conn = db::connect(); // Establece la conexión a la base de datos
        $consulta = "SELECT * FROM pedidos WHERE USUARIO_ID = ?"; // Consulta SQL para obtener los pedidos por el ID de usuario
        
        if ($stmt = $conn->prepare($consulta)) {
            $stmt->bind_param("i", $id_user); // Vincula el parámetro $id_user a la consulta SQL
            $stmt->execute(); // Ejecuta la consulta
            
            $resultado = $stmt->get_result(); // Obtiene el conjunto de resultados
            $arrayPedidosBBDD = []; // Inicializa un array para almacenar los objetos PedidosBBDD
            
            // Recorre los resultados y los agrega al array de pedidos
            while ($obj = $resultado->fetch_object('PedidosBBDD')) {
                $arrayPedidosBBDD[] = $obj;
            }
            
            $stmt->close(); // Cierra la sentencia preparada
            return $arrayPedidosBBDD; // Retorna el array de pedidos encontrados para el usuario
        } else {
            return false; // Retorna 'false' si la consulta falla
        }
    }



    /**
     * Procesa un pedido para un usuario específico, agregando los productos del pedido a la tabla 'pedidos_productos'.
     * @param int $user El ID del usuario que realiza el pedido.
     * @param array $pedidos Un array de objetos Pedido que contiene los productos a procesar en el pedido.
     */
    public static function procesarPedido($user, $pedidos){
        // Genera el pedido en la tabla 'pedidos'
        $result = PedidosBBDD::generarPedido($user);
        
        // Obtiene el ID del último pedido generado
        $id_pedido = PedidosBBDD::getIdUltimoPedido();
        
        // Recorre cada producto en el pedido para agregarlo a 'pedidos_productos'
        foreach ($pedidos as $producto) {
            // Obtiene información del producto
            $id_producto = $producto->getIdProduct();
            $precio_unidad = $producto->getPriceProduct();
            $cantidad = $producto->getCantidad();

            $conn = db::connect(); // Establece la conexión a la base de datos
            
            // Prepara la consulta SQL para insertar el producto en 'pedidos_productos'
            $stmt = $conn->prepare("INSERT INTO `pedidos_productos`(`PEDIDO_ID`, `PRODUCTO_ID`, `CANTIDAD`, `PRECIO_UNIDAD`) VALUES (?, ?, ?, ?)");
            
            // Vincula los parámetros a la consulta SQL de manera segura
            $stmt->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio_unidad);
            
            // Ejecuta la consulta
            $stmt->execute();
            
            // Cierra la conexión a la base de datos
            $conn->close();
        }
    }

    /**
     * Genera un nuevo pedido para un usuario específico en la tabla 'pedidos'.
     * @param int $user El ID del usuario para el cual se genera el pedido.
     * @return mixed Retorna el resultado de la ejecución de la consulta o false si hay un error.
     */
    public static function generarPedido($user){
        $id_user = $user->getId(); // Obtiene el ID del usuario
        
        $conn = db::connect(); // Establece la conexión a la base de datos
            
        // Prepara la consulta SQL para insertar un nuevo pedido
        $stmt = $conn->prepare("INSERT INTO `pedidos`(`USUARIO_ID`, `ESTADO`, `FECHA_PEDIDO`) VALUES (?, 'EN PREPARACIÓN', SYSDATE())");
        
        // Vincula el ID del usuario a la consulta SQL de manera segura
        $stmt->bind_param("i", $id_user);
        
        // Ejecuta la consulta
        $stmt->execute();
        $result = $stmt->get_result(); // Obtiene el resultado de la ejecución de la consulta
        
        $conn->close(); // Cierra la conexión a la base de datos
        
        return $result; // Retorna el resultado de la ejecución de la consulta
    }


    /**
     * Obtiene el ID del último pedido registrado en la tabla 'pedidos'.
     * @return int|null Retorna el ID del último pedido o null si no hay pedidos registrados.
     */
    public static function getIdUltimoPedido(){
        $conn = db::connect(); // Establece la conexión a la base de datos
        
        // Prepara la consulta SQL para obtener el máximo ID de pedido
        $stmt = $conn->prepare("SELECT max(PEDIDO_ID) as pedido FROM PEDIDOS");
        
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result(); // Obtiene el conjunto de resultados
        
        $conn->close(); // Cierra la conexión a la base de datos
        
        $id = $result->fetch_assoc(); // Obtiene el ID del último pedido
        
        return $id['pedido']; // Retorna el ID del último pedido o null si no hay pedidos registrados
    }


    public static function getPrecioUnidad($pedidos){
        foreach ($pedidos as $productos) {
            $precio_unidad = $productos->producto->getPrice();
        }
        return $precio_unidad;
    }

    /**
     * Obtiene los pedidos asociados a un usuario específico desde la base de datos.
     * @param int $id_user El ID del usuario del cual se quieren recuperar los pedidos.
     * @return array Retorna un array de objetos PedidosBBDD que pertenecen al usuario especificado.
     * En caso de no encontrar pedidos o error en la consulta, retorna un array vacío.
     */
    public static function getPedidosByUser($id_user){
        $conn = db::connect(); // Establece la conexión a la base de datos
        $stmt = $conn->prepare("SELECT * FROM pedidos WHERE USUARIO_ID = ?");
        
        if ($stmt) {
            $stmt->bind_param("i", $id_user); // Vincula el parámetro $id_user a la consulta SQL de manera segura
            $stmt->execute(); // Ejecuta la consulta
            
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            $pedidos = []; // Inicializa un array para almacenar los pedidos
            
            // Recorre los resultados y los agrega al array de pedidos
            while ($pedido = $result->fetch_object('PedidosBBDD')) {
                $pedidos[] = $pedido;
            }
            
            $stmt->close(); // Cierra la sentencia preparada
            $conn->close(); // Cierra la conexión a la base de datos
            
            return $pedidos; // Retorna el array de pedidos asociados al usuario
        } else {
            // En caso de fallo en la preparación de la consulta, se cierra la conexión y retorna un array vacío
            $conn->close();
            return [];
        }
    }

    /**
     * Cuenta la cantidad de pedidos asociados a un usuario específico en la base de datos.
     * @param int $id_user El ID del usuario del cual se quiere contar la cantidad de pedidos.
     * @return int Retorna la cantidad de pedidos asociados al usuario especificado.
     * En caso de no encontrar pedidos o error en la consulta, retorna 0.
     */
    public static function countPedidosByUser($id_user){
        $conn = db::connect(); // Establece la conexión a la base de datos
        $stmt = $conn->prepare("SELECT count(PEDIDO_ID) as pedido FROM PEDIDOS WHERE USUARIO_ID = ?");
        
        if ($stmt) {
            $stmt->bind_param("i", $id_user); // Vincula el parámetro $id_user a la consulta SQL de manera segura
            $stmt->execute(); // Ejecuta la consulta
            
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            $cantidad = $result->fetch_assoc(); // Obtiene la cantidad de pedidos
            
            $stmt->close(); // Cierra la sentencia preparada
            $conn->close(); // Cierra la conexión a la base de datos
            
            return $cantidad['pedido']; // Retorna la cantidad de pedidos asociados al usuario
        } else {
            // En caso de fallo en la preparación de la consulta, se cierra la conexión y se retorna false
            $conn->close();
            return 0;
        }
    }
    

    /**
     * Verifica si un usuario tiene pedidos asociados en la base de datos.
     * @param int $id_user El ID del usuario para verificar sus pedidos.
     * @return bool Retorna true si el usuario tiene pedidos, de lo contrario, retorna false.
     */
    public static function tienePedidosUser($id_user){
        $conn = db::connect(); // Establece la conexión a la base de datos
        $stmt = $conn->prepare("SELECT count(PEDIDO_ID) as pedido FROM PEDIDOS WHERE USUARIO_ID = ?");
        
        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            $stmt->bind_param("i", $id_user); // Vincula el parámetro $id_user a la consulta SQL de manera segura
            $stmt->execute(); // Ejecuta la consulta
            
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            $cantidad = $result->fetch_assoc(); // Obtiene la cantidad de pedidos
            
            $stmt->close(); // Cierra la sentencia preparada
            $conn->close(); // Cierra la conexión a la base de datos
            
            return $cantidad['pedido'] > 0; // Retorna true si el usuario tiene pedidos, de lo contrario, retorna false
        } else {
            // En caso de fallo en la preparación de la consulta, se cierra la conexión y se retorna false
            $conn->close();
            return false;
        }
    }

    public static function updatePedido($pedido_id, $user_id, $estado, $fecha_pedido){
        $conn = db::connect();
    
        // Consulta para actualizar un pedido con nueva información
        $consulta = "UPDATE pedidos SET USUARIO_ID = ?, ESTADO = ?, FECHA_PEDIDO = ? WHERE pedido_id = ?";
        
        // Preparar la consulta para la actualización
        $stmt = $conn->prepare($consulta);
        $stmt->bind_param('issi', $user_id, $estado, $fecha_pedido, $pedido_id);
    
        // Ejecutar la consulta de actualización
        if ($stmt->execute()) {
            return true;// Si la ejecución es exitosa, se devuelve verdadero
        } else {
            return false;// Si hay algún problema al ejecutar la consulta, se devuelve falso
        }
    }
    

    public static function deletePedido($pedido_id){
        $conn = db::connect();
    
        // Consulta para eliminar los registros asociados al pedido en la tabla pedidos_productos
        $consultaPedidoProductos = "DELETE FROM pedidos_productos WHERE pedido_id = ?";
        $stmt = $conn->prepare($consultaPedidoProductos);
        $stmt->bind_param("i", $pedido_id);
    
        // Ejecutar la consulta para eliminar registros asociados al pedido en la tabla pedidos_productos
        if ($stmt->execute()) {
            // Si se ejecuta correctamente, se establece el resultado como verdadero
            $result = true;
        }
    
        // Consulta para eliminar el pedido en la tabla pedidos
        $consultaPedido = "DELETE FROM pedidos WHERE pedido_id = ?";
        $stmt = $conn->prepare($consultaPedido);
        $stmt->bind_param("i", $pedido_id);
        
        // Ejecutar la consulta para eliminar el pedido en la tabla pedidos
        if ($stmt->execute()) {
            // Si se ejecuta correctamente, se devuelve verdadero
            return true;
        } else {
            // Si hay algún problema al ejecutar la consulta, se devuelve falso
            return false;
        }
    }    

    public static function updatePropina($pedido, $propina){
        $conn = db::connect();
    
        // Consulta para actualizar un pedido con nueva información
        $consulta = "UPDATE pedidos SET PROPINA = ? WHERE pedido_id = ?";
        $propina = 4.50;
        $pedido = 65;
        // Preparar la consulta para la actualización
        $stmt = $conn->prepare($consulta);
        $stmt->bind_param('id', $pedido, $propina);

        // Ejecutar la consulta de actualización
        if ($stmt->execute()) {
            return true;// Si la ejecución es exitosa, se devuelve verdadero
        } else {
            return false;// Si hay algún problema al ejecutar la consulta, se devuelve falso
        }
    }
}