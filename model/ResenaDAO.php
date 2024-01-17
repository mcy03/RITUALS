<?php
    include_once 'db.php';
    class ResenaDAO {
        protected $RESENA_ID;
        protected $PEDIDO_ID;
        protected $ASUNTO;
        protected $COMENTARIO;
        protected $FECHA_RESENA;
        protected $VALORACION;

        public function getId(){
            return $this->RESENA_ID;
        }
        public function getPedidoId(){
            return $this->PEDIDO_ID;
        }
        public function getAsunto(){
            return $this->ASUNTO;
        }
        public function getComentario(){
            return $this->COMENTARIO;
        }
        public function getFechaResena(){
            return $this->FECHA_RESENA;
        }
        public function getValoracion(){
            return $this->VALORACION;
        }

        public function setId($RESENA_ID){
            $this->RESENA_ID = $RESENA_ID;
        }
        public function setPedidoId($PEDIDO_ID){
            $this->PEDIDO_ID = $PEDIDO_ID;
        }
        public function setAsunto($ASUNTO){
            $this->ASUNTO = $ASUNTO;
        }
        public function setComentario($COMENTARIO){
            $this->COMENTARIO = $COMENTARIO;
        }
        public function setFechaResena($FECHA_RESENA){
            $this->FECHA_RESENA = $FECHA_RESENA;
        }
        public function setValoracion($VALORACION){
            $this->VALORACION = $VALORACION;
        }

        public static function getResenas(){
            $conn = db::connect(); // Establece la conexión a la base de datos
            $consulta = "SELECT * FROM resena"; // Consulta para seleccionar todas las reseñas
            
            if ($resultado = $conn->query($consulta)) {
                $arrayResenas = []; // Inicializa un array para almacenar las reseñas
                
                // Obtiene el array de objetos Resena
                while ($obj = $resultado->fetch_object('ResenaDAO')) {
                    $arrayResenas[] = $obj;
                }
                
                $resultado->close(); // Libera el conjunto de resultados
                $conn->close(); // Cierra la conexión a la base de datos
                
                return $arrayResenas; // Retorna el array de resenas si hay resenas en la base de datos
            } else {
                // Retorna null si no se encuentran resenas o hay un error en la consulta
                return null;
            }
        }

        public static function getResenaById($id){
            $conn = db::connect(); // Establece la conexión a la base de datos
            
            // Prepara la consulta SQL para seleccionar una resena por su ID
            $stmt = $conn->prepare("SELECT * FROM resena WHERE RESENA_ID = ?");
            $stmt->bind_param("i", $id); // Vincula el parámetro $id a la consulta SQL
            
            $stmt->execute(); // Ejecuta la consulta
            $result = $stmt->get_result(); // Obtiene el conjunto de resultados
            
            $conn->close(); // Cierra la conexión a la base de datos
            
            $resena = $result->fetch_object('ResenaDAO'); // Obtiene el objeto Resena
            
            // Retorna el objeto Resena si se encuentra la resena con el ID proporcionado, de lo contrario retorna null
            return $resena;
        }

        public static function deleteResena($resena_id){
            $conn = db::connect(); // Establece la conexión a la base de datos

            // Prepara la consulta SQL para eliminar el resena por su ID
            $stmt = $conn->prepare("DELETE FROM resena WHERE RESENA_ID=?");
            $stmt->bind_param("i", $resena_id); // Vincula el parámetro $resena_id a la consulta SQL

            // Ejecuta la consulta para eliminar el resena
            $stmt->execute();
            $result = $stmt->get_result(); // Obtiene el resultado

            $conn->close(); // Cierra la conexión a la base de datos

            return $result; // Retorna true si se eliminó correctamente, false si no se pudo eliminar o null en caso de error
        }
        
        public static function updateResena($RESENA_ID, $PEDIDO_ID, $ASUNTO, $COMENTARIO, $FECHA_RESENA, $VALORACION){
            $conn = db::connect(); // Establece la conexión a la base de datos

            // Prepara la consulta SQL para actualizar la información del resena
            $stmt = $conn->prepare("UPDATE RESENA SET PEDIDO_ID = ?, ASUNTO = ?, COMENTARIO = ?, FECHA_RESENA = ?, VALORACION = ? WHERE RESENA_ID = ?");
            $stmt->bind_param("isssii", $PEDIDO_ID, $ASUNTO, $COMENTARIO, $FECHA_RESENA, $VALORACION, $RESENA_ID); // Vincula los parámetros a la consulta SQL

            // Ejecuta la consulta para actualizar el resena
            $stmt->execute();
            $conn->close(); // Cierra la conexión a la base de datos
        }

        public static function insertResena($PEDIDO_ID, $ASUNTO, $COMENTARIO, $FECHA_RESENA, $VALORACION){
            $conn = db::connect();
            
            // Consulta para insertar una nueva resena
            $consulta = "INSERT INTO RESENA (PEDIDO_ID, ASUNTO, COMENTARIO, FECHA_RESENA, VALORACION) 
                        VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($consulta);
            $stmt->bind_param("isssi", $PEDIDO_ID, $ASUNTO, $COMENTARIO, $FECHA_RESENA, $VALORACION);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>