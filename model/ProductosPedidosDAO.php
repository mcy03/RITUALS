<?php
include_once("model/Producto.php");
include_once("model/Pedido.php");
class ProductosPedidosDAO{
    /**
     * Atributos de la clase ArticuloPedido que representan la información de un artículo en un pedido.
     */
    protected $ARTICULO_ID;   // Identificador único del artículo en un pedido
    protected $PEDIDO_ID;     // Identificador del pedido al que pertenece el artículo
    protected $PRODUCTO_ID;   // Identificador del producto asociado al artículo
    protected $CANTIDAD;      // Cantidad de unidades del producto en el artículo
    protected $PRECIO_UNIDAD; // Precio unitario del producto en el artículo


    public function __construct(){

    }

    public function getId(){
        return $this->ARTICULO_ID;
    }
    public function setId($articulo_id){
        $this->ARTICULO_ID = $articulo_id;
    }

    public function getPedidoId(){
        return $this->PEDIDO_ID;
    }
    public function setPedidoId($pedido_id){
        $this->PEDIDO_ID = $pedido_id;
    }

    public function getProductoId(){
        return $this->PRODUCTO_ID;
    }
    public function setProductoId($producto_id){
        $this->PRODUCTO_ID = $producto_id;
    }

    public function getCantidad(){
        return $this->CANTIDAD;
    }
    public function setCantidad($cantidad){
        $this->CANTIDAD = $cantidad;
    }

    public function getPrecioUnidad(){
        return $this->PRECIO_UNIDAD;
    }
    public function setPrecioUnidad($precioUnidad){
        $this->PRECIO_UNIDAD = $precioUnidad;
    }

    /**
     * Obtiene todos los registros de la tabla 'pedidos_productos' como objetos de la clase 'ProductosPedidosDAO'.
     * @return array|null Retorna un array de objetos 'ProductosPedidosDAO' si hay registros,
     *                     de lo contrario retorna null.
     */
    public static function getProductosPedidos(){
        $conn = db::connect(); // Establece la conexión a la base de datos
        
        $consulta = "SELECT * FROM pedidos_productos"; // Consulta para seleccionar todos los registros de la tabla
        
        if ($resultado = $conn->query($consulta)) {
            $productosPedidos = []; // Inicializa un array para almacenar los objetos
            
            // Obtiene el array de objetos 'ProductosPedidosDAO' de la tabla
            while ($obj = $resultado->fetch_object('ProductosPedidosDAO')) {
                $productosPedidos[] = $obj;
            }
            
            $resultado->close(); // Libera el conjunto de resultados
            $conn->close(); // Cierra la conexión a la base de datos
            
            return  $productosPedidos; // Retorna el array de objetos 'ProductosPedidosDAO'
        } else {
            return null; // Retorna null si no hay registros o hay un error en la consulta
        }
    }


    public static function getPedidosBBDD_ByIdPedido($id_pedido){
        $conn = db::connect();
        $consulta = "SELECT * FROM pedidos_productos WHERE PEDIDO_ID = $id_pedido";
        if ($resultado = $conn->query($consulta)) {

            /* obtener el array de objetos */
            while ($obj = $resultado->fetch_object('ProductosPedidosDAO')) {
                $ProductosPedidos [] = $obj;
            }
        
            /* liberar el conjunto de resultados */
            $resultado->close();
            return $ProductosPedidos;
        }
    }

    public static function calcPricePedidoById($id_pedido){
        $productos = ProductosPedidosDAO::getPedidosBBDD_ByIdPedido($id_pedido);
        $total = 0;
        foreach ($productos as $producto) {
            $total += $producto->getCantidad() * $producto->getPrecioUnidad();
        }

        return $total;
    }

    public function calcPrice(){
        return $this->PRECIO_UNIDAD * $this->CANTIDAD;
    }

    public static function estaProductoPedido($id_producto){
        $conn = db::connect(); // Establece la conexión a la base de datos
        $stmt = $conn->prepare("SELECT count(ARTICULO_ID) as registro FROM PEDIDOS_PRODUCTOS WHERE PRODUCTO_ID = ?");
        
        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            $stmt->bind_param("i", $id_producto); // Vincula el parámetro $id_producto a la consulta SQL de manera segura
            $stmt->execute(); // Ejecuta la consulta
            
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            $cantidad = $result->fetch_assoc(); // Obtiene la cantidad de pedidos
            
            $stmt->close(); // Cierra la sentencia preparada
            $conn->close(); // Cierra la conexión a la base de datos
            
            return $cantidad['registro'] > 0; // Retorna true si el producto esta en pedidos, de lo contrario, retorna false
        } else {
            // En caso de fallo en la preparación de la consulta, se cierra la conexión y se retorna false
            $conn->close();
            return false;
        }
    }

}