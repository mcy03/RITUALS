<?php
/*  
======================================================================
                    CLASE Categoria
======================================================================
º Inicializamos la clase Categoria en la cual recuperaremos          º
º las categorias de la base de datos y trataremos con ellas          º
======================================================================  
*/
include_once 'db.php'; //incluimos "db.php" ya que es la clase que da la conexión a la base de datos
class Categoria {
    protected $CATEGORIA_ID; //atributo identificador de la categoria
    protected $NOMBRE_CATEGORIA; //atributo que contiene el nombre de la categoria

    //constructor vacio ya que recuperaremos los datos de la BBDD
    public function ___construct(){
            
    }

    /**
     * Esta función estática obtiene todas las filas de la tabla 'categorias' de la base de datos.
     * Conecta a la base de datos, ejecuta una consulta SQL y devuelve un array de objetos 'Categoria'.
     * @return array|void Devuelve un array de objetos 'Categoria' o nada si la consulta falla.
     */
    public static function getCat(){
        $conn = db::connect(); // Establecer una conexión a la base de datos
        $consulta = "SELECT * FROM categorias"; // Consulta SQL para seleccionar todos los registros de la tabla 'categorias'

        if ($resultado = $conn->query($consulta)) {  // Verificar y ejecutar la consulta SQL
            while ($obj = $resultado->fetch_object('Categoria')) { /* obtener el array de objetos */
                $arrayCat []= $obj; // Agregar cada objeto 'Categoria' al array
            }
            
            $resultado->close(); /* liberar el conjunto de resultados */
            return $arrayCat;
        }
    }

    /**
     * Establece el ID de la categoría.
     * @param int $cat_id El ID de la categoría a establecer.
     * @return void
     */
    public function setCategoriaId($cat_id){
        $this->CATEGORIA_ID = $cat_id;
    }

    /**
     * Obtiene el ID de la categoría.
     * @return int El ID de la categoría.
     */
    public function getCategoriaId(){
        return $this->CATEGORIA_ID;
    }

    /**
     * Establece el nombre de la categoría.
     * @param string $name El nombre de la categoría a establecer.
     * @return void
     */
    public function setName($name){
        $this->NOMBRE_CATEGORIA = $name;
    }

    /**
     * Obtiene el nombre de la categoría.
     * @return string El nombre de la categoría.
     */
    public function getName(){
        return $this->NOMBRE_CATEGORIA;
    }

    /**
     * Obtiene una categoría por su ID.
     * @param int $id El ID de la categoría que se busca.
     * @return object|false Devuelve un objeto de la clase 'Categoria' si se encuentra la categoría,
     * o 'false' si no se encuentra o hay un error en la consulta.
     */
    public static function getCatById($id){
        $conn = db::connect(); // Establecer una conexión a la base de datos
        $stmt = $conn->prepare("SELECT * FROM categorias WHERE CATEGORIA_ID = ?");  // Preparar la consulta SQL parametrizada para seleccionar una categoría por su ID
        $stmt->bind_param("i", $id); // Vincular el parámetro ID a la consulta SQL
            
        $stmt->execute(); // Ejecutar la consulta preparada
        $result=$stmt->get_result(); // Obtener el resultado de la consulta
        $conn->close(); // Cerrar la conexión a la base de datos

        $categoria = $result->fetch_object('Categoria'); // Obtener el objeto 'Categoria' si hay resultados
        return $categoria;  // Devolver la categoría o 'false' si no se encontró o hubo un error
    }

    /**
     * Obtiene el nombre de una categoría por su ID.
     * @param int $id El ID de la categoría para la cual se busca el nombre.
     * @return string|false Devuelve el nombre de la categoría si se encuentra,
     * o 'false' si no se encuentra o hay un error en la consulta.
     */
    public static function getCatNameById($id){
        $conn = db::connect(); // Establecer una conexión a la base de datos

        $query = $conn->prepare("SELECT NOMBRE_CATEGORIA FROM categorias WHERE CATEGORIA_ID = ?"); // Preparar una consulta SQL parametrizada para obtener el nombre de la categoría por su ID
        $query->bind_param("i", $id); // Vincular el parámetro ID

        $query->execute(); // Ejecutar la consulta preparada

        $result = $query->get_result(); // Obtener el resultado de la consulta

        $resultado = $result->fetch_assoc(); // Obtener el nombre de la categoría del resultado como un array asociativo

        $conn->close(); // Cerrar la conexión a la base de datos

        // Devolver el nombre de la categoría o 'false' si no se encontró o hubo un error
        return isset($resultado['NOMBRE_CATEGORIA']) ? $resultado['NOMBRE_CATEGORIA'] : false;
    }

    /**
     * Obtiene el ID de una categoría por su nombre.
     * @param string $name El nombre de la categoría para la cual se busca el ID.
     * @return int|false Devuelve el ID de la categoría si se encuentra,
     * o 'false' si no se encuentra o hay un error en la consulta.
     */
    public static function getCatIdByName($name){
        $conn = db::connect(); // Establecer una conexión a la base de datos

        // Preparar una consulta SQL parametrizada para obtener la categoría por su nombre
        $stmt = $conn->prepare("SELECT * FROM categorias WHERE NOMBRE_CATEGORIA = ?");
        $stmt->bind_param("s", $name); // Vincular el parámetro del nombre

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Cerrar la conexión a la base de datos
        $conn->close();

        // Obtener el objeto 'Categoria' del resultado si hay resultados
        $categoria = $result->fetch_object('Categoria');

        // Devolver el ID de la categoría o 'false' si no se encontró o hubo un error
        return ($categoria !== null) ? $categoria->getCategoriaId() : false;
    }

    public static function getCatExcludeId($id){
        $conn = db::connect(); // Establecer una conexión a la base de datos
        $consulta = "SELECT * FROM categorias WHERE CATEGORIA_ID != $id"; // Consulta SQL para seleccionar todos los registros de la tabla 'categorias'

        if ($resultado = $conn->query($consulta)) {  // Verificar y ejecutar la consulta SQL
            while ($obj = $resultado->fetch_object('Categoria')) { /* obtener el array de objetos */
                $arrayCat []= $obj; // Agregar cada objeto 'Categoria' al array
            }
            
            $resultado->close(); /* liberar el conjunto de resultados */
            return $arrayCat;
        }
    }
}