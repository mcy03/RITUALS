<?php
    include_once 'db.php';
    class Producto {
        protected $PRODUCTO_ID;     // ID único del producto
        protected $NOMBRE_PRODUCTO; // Nombre del producto
        protected $IMG;             // Ruta o nombre del archivo de imagen
        protected $DESCRIPCION;     // Descripción del producto
        protected $PRECIO_UNIDAD;   // Precio unitario del producto
        protected $CATEGORIA_ID;    // ID de la categoría del producto

        public function __construct(){
            
        }
        /**
         * Obtiene todos los productos de la base de datos.
         * @return array|null Retorna un array de objetos Producto si hay productos en la base de datos,
         * de lo contrario retorna null.
         */
        public static function getProducts(){
            $conn = db::connect(); // Establece la conexión a la base de datos
            $consulta = "SELECT * FROM productos"; // Consulta para seleccionar todos los productos
            
            if ($resultado = $conn->query($consulta)) {
                $arrayProducts = []; // Inicializa un array para almacenar los productos
                
                // Obtiene el array de objetos Producto
                while ($obj = $resultado->fetch_object('Producto')) {
                    $arrayProducts[] = $obj;
                }
                
                $resultado->close(); // Libera el conjunto de resultados
                $conn->close(); // Cierra la conexión a la base de datos
                
                return $arrayProducts; // Retorna el array de productos si hay productos en la base de datos
            } else {
                // Retorna null si no se encuentran productos o hay un error en la consulta
                return null;
            }
        }

        /**
         * Obtiene un producto específico de la base de datos mediante su ID.
         * @param int $id El ID del producto que se quiere obtener.
         * @return object|null Retorna un objeto Producto si se encuentra el producto con el ID proporcionado,
         *                     de lo contrario retorna null.
         */
        public static function getProductById($id){
            $conn = db::connect(); // Establece la conexión a la base de datos
            
            // Prepara la consulta SQL para seleccionar un producto por su ID
            $stmt = $conn->prepare("SELECT * FROM productos WHERE PRODUCTO_ID = ?");
            $stmt->bind_param("i", $id); // Vincula el parámetro $id a la consulta SQL
            
            $stmt->execute(); // Ejecuta la consulta
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            
            $conn->close(); // Cierra la conexión a la base de datos
            
            $producto = $result->fetch_object('Producto'); // Obtiene el objeto Producto
            
            // Retorna el objeto Producto si se encuentra el producto con el ID proporcionado, de lo contrario retorna null
            return $producto;
        }

        /**
         * Obtiene hasta 3 productos de una categoría específica de la base de datos.
         * @param int $id_cat El ID de la categoría de la cual se quieren obtener los productos.
         * @return array|null Retorna un array de hasta 3 objetos Producto si hay productos en la categoría especificada,
         *                     de lo contrario retorna null.
         */
        public static function getProductByIdCat($id_cat){
            $conn = db::connect(); // Establece la conexión a la base de datos
            
            // Prepara la consulta SQL con un marcador de posición para el ID de categoría
            $stmt = $conn->prepare("SELECT * FROM productos WHERE CATEGORIA_ID = ? ORDER BY PRODUCTO_ID LIMIT 3");
            $stmt->bind_param("i", $id_cat); // Vincula el parámetro $id_cat a la consulta SQL
            
            $stmt->execute(); // Ejecuta la consulta
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            
            $arrayProducts = []; // Inicializa un array para almacenar los productos
            
            // Obtiene el array de hasta 3 objetos Producto de la categoría especificada
            while ($obj = $result->fetch_object('Producto')) {
                $arrayProducts[] = $obj;
            }
            
            $stmt->close(); // Cierra la sentencia preparada
            $conn->close(); // Cierra la conexión a la base de datos
            
            // Retorna el array de hasta 3 productos de la categoría especificada
            return $arrayProducts;
        }

        /**
         * Obtiene el ID del producto.
         * @return int El ID del producto.
         */
        public function getId(){
            return $this->PRODUCTO_ID; // Retorna el ID del producto
        }

        /**
         * Obtiene el nombre del producto.
         * @return string El nombre del producto.
         */
        public function getName(){
            return $this->NOMBRE_PRODUCTO; // Retorna el nombre del producto
        }

        /**
         * Obtiene la ruta o nombre del archivo de imagen asociado al producto.
         * @return string La ruta o nombre del archivo de imagen.
         */
        public function getImg(){
            return $this->IMG; // Retorna la ruta o nombre del archivo de imagen asociado al producto
        }

        /**
         * Obtiene la descripción del producto.
         * @return string La descripción del producto.
         */
        public function getDesc(){
            return $this->DESCRIPCION; // Retorna la descripción del producto
        }

        /**
         * Obtiene el precio unitario del producto.
         * @return float El precio unitario del producto.
         */
        public function getPrice(){
            return $this->PRECIO_UNIDAD; // Retorna el precio unitario del producto
        }

        /**
         * Obtiene el ID de la categoría a la que pertenece el producto.
         * @return int El ID de la categoría del producto.
         */
        public function getCat(){
            return $this->CATEGORIA_ID; // Retorna el ID de la categoría del producto
        }

        /**
         * Elimina un producto de la base de datos según su ID.
         * @param int $producto_id El ID del producto que se desea eliminar.
         * @return bool|null Retorna true si se eliminó correctamente, false si no se pudo eliminar o null en caso de error.
         */
        public static function deleteProduct($producto_id){
            $conn = db::connect(); // Establece la conexión a la base de datos

            // Prepara la consulta SQL para eliminar el producto por su ID
            $stmt = $conn->prepare("DELETE FROM productos WHERE PRODUCTO_ID=?");
            $stmt->bind_param("i", $producto_id); // Vincula el parámetro $producto_id a la consulta SQL

            // Ejecuta la consulta para eliminar el producto
            $stmt->execute();
            $result = $stmt->get_result(); // Obtiene el resultado

            $conn->close(); // Cierra la conexión a la base de datos

            return $result; // Retorna true si se eliminó correctamente, false si no se pudo eliminar o null en caso de error
        }

        /**
         * Actualiza la información de un producto en la base de datos.
         * @param int $producto_id El ID del producto que se desea actualizar.
         * @param string $nombre_producto El nuevo nombre del producto.
         * @param string $img La nueva ruta o nombre del archivo de imagen del producto.
         * @param string $descripcion La nueva descripción del producto.
         * @param float $precio_unidad El nuevo precio unitario del producto.
         * @param int $categoria_id El nuevo ID de la categoría del producto.
         * @return bool|null Retorna true si la actualización fue exitosa, false si falló o null en caso de error.
         */
        public static function updateProduct($producto_id, $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id){
            $conn = db::connect(); // Establece la conexión a la base de datos

            // Prepara la consulta SQL para actualizar la información del producto
            $stmt = $conn->prepare("UPDATE PRODUCTOS SET NOMBRE_PRODUCTO = ?, IMAGEN = ?, DESCRIPCION = ?, PRECIO_UNIDAD = ?, CATEGORIA_ID = ? WHERE PRODUCTO_ID = ?");
            $stmt->bind_param("sssdii", $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id, $producto_id); // Vincula los parámetros a la consulta SQL

            // Ejecuta la consulta para actualizar el producto
            $stmt->execute();
            $conn->close(); // Cierra la conexión a la base de datos
        }

        public static function insertProduct($nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id){
            $conn = db::connect();
            
            // Consulta para insertar un nuevo producto
            $consulta = "INSERT INTO PRODUCTOS (nombre_producto, img, descripcion, precio_unidad, categoria_id) 
                        VALUES (:nombre_producto, :img, :descripcion, :precio_unidad, :categoria_id)";
            
            $stmt = $conn->prepare($consulta);
            $stmt->bindParam(':nombre_producto', $nombre_producto);
            $stmt->bindParam(':img', $img);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio_unidad', $precio_unidad);
            $stmt->bindParam(':categoria_id', $categoria_id);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>