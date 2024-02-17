<?php
    include_once 'db.php';
    include_once 'Admin.php';
    class User {
        /**
         * Atributos de la clase User que representan la información de un usuario.
         */
        protected $USUARIO_ID;         // Identificador único del usuario
        protected $EMAIL;              // Correo electrónico del usuario
        protected $PUNTOS;
        protected $SALUDO;             // Saludo (Hombre, Mujer, Otro)
        protected $NOMBRE;             // Nombre del usuario
        protected $APELLIDOS;          // Apellidos del usuario
        protected $FECHA_NACIMIENTO;   // Fecha de nacimiento del usuario
        protected $PASSWORD;           // Contraseña del usuario
        protected $TELEFONO;           // Número de teléfono del usuario
        protected $DIRECCION;          // Dirección física del usuario
        protected $PERMISO;            // Nivel de permisos o rol del usuario



        public function __construct(){
            
        }
        public function getId(){
            return $this->USUARIO_ID;
        }
        public function setId($user_id){
            $this->USUARIO_ID = $user_id;
        }
        public function getPass(){
            return $this->PASSWORD;
        }
        public function setPass($pass){
            $this->PASS = $pass;
        }
        public function getSaludo(){
            return $this->SALUDO;
        }
        public function getName(){
            return $this->NOMBRE;
        }
        public function setName($name){
            $this->NOMBRE = $name;
        }
        public function getApellidos(){
            return $this->APELLIDOS;
        }
        public function setApellidos($apellidos){
            $this->APELLIDOS = $apellidos;
        }
        public function getPhone(){
            return $this->TELEFONO;
        }
        public function setPhone($phone){
            $this->PHONE = $phone;
        }
        public function getFechaNacimiento(){
            return $this->FECHA_NACIMIENTO;
        }
        public function setFechaNacimiento($FechaNacimiento){
            $this->FECHA_NACIMIENTO = $FechaNacimiento;
        }
        public function getDir(){
            return $this->DIRECCION;
        }
        public function setDir($direccion){
            $this->DIRECCION = $direccion;
        }
        public function getEmail(){
            return $this->EMAIL;
        }
        public function setEmail($email){
            $this->EMAIL = $email;
        }
        public function getPuntos(){
            return $this->PUNTOS;
        }
        public function setPuntos($puntos){
            $this->PUNTOS = $puntos;
        }
        public function getPermiso(){
            return $this->PERMISO;
        }
        public function setPermiso($permiso){
            $this->PERMISO = $permiso;
        }

        public static function getUsers(){
            $conn = db::connect(); // Establecer conexión a la base de datos
        
            $consulta = "SELECT * FROM usuarios WHERE PERMISO = 0"; // Consulta para obtener usuarios con permiso igual a 0 (usuarios normales)
            $arrayUsers = array();
        
            // Ejecutar la consulta y obtener resultados para usuarios normales
            if ($resultado = $conn->query($consulta)) {
                // Obtener el array de objetos para usuarios normales
                while ($obj = $resultado->fetch_object('User')) {
                    $arrayUsers []= $obj;
                }
                
                // Liberar el conjunto de resultados
                $resultado->close();
            }
        
            // Consulta para obtener usuarios con permiso diferente de 0 (usuarios administradores)
            $consulta = "SELECT * FROM usuarios WHERE PERMISO != 0";
            $arrayAdmin = array();
        
            // Ejecutar la consulta y obtener resultados para usuarios administradores
            if ($resultado = $conn->query($consulta)) {
                // Obtener el array de objetos para usuarios administradores
                while ($obj = $resultado->fetch_object('Admin')) {
                    $arrayAdmin []= $obj;
                }
                
                // Liberar el conjunto de resultados
                $resultado->close();
            }
        
            // Combinar los arrays de usuarios normales y administradores
            $arrayFinal = array_merge($arrayUsers, $arrayAdmin);
        
            // Devolver el array combinado de usuarios
            return $arrayFinal;
        }
        
        public static function getUserById($id){
            $conn = db::connect(); // Establecer conexión a la base de datos

            // Establecer conexión a la base de datos y ejecutar la primera consulta
            $conn = db::connect();
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE USUARIO_ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Cerrar la primera conexión
            $conn->close();
            $conn = db::connect(); // Establecer conexión a la base de datos

            // Obtener el objeto de usuario a partir del primer resultado
            $user = $result->fetch_object('User');

            // Establecer conexión a la base de datos y ejecutar la primera consulta
            $conn = db::connect();
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE USUARIO_ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $conn->close();
            
            // Verificar el permiso del usuario y obtener el objeto correcto (User o Admin)
            if ($user->getPermiso() == 0) {
                // Si el usuario es normal, obtener el objeto de usuario
                $user = $result->fetch_object('User');
            } else {
                // Si el usuario es administrador, obtener el objeto de administrador
                $user = $result->fetch_object('Admin');
            }

            // Devolver el objeto de usuario
            return $user;
            
        }
        
        public static function getUserByEmail($email){
            // Establecer conexión a la base de datos y ejecutar la primera consulta
            $conn = db::connect();
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Cerrar la primera conexión
            $conn->close();
        
            // Obtener el objeto de usuario a partir del primer resultado
            $user = $result->fetch_object('User');
        
            // Establecer una nueva conexión para la segunda consulta
            $conn = db::connect();
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Cerrar la segunda conexión
            $conn->close();
        
            // Verificar el permiso del usuario y obtener el objeto correcto (User o Admin)
            if ($user->getPermiso() == 0) {
                // Si el usuario es normal, obtener el objeto de usuario
                $user = $result->fetch_object('User');
            } else {
                // Si el usuario es administrador, obtener el objeto de administrador
                $user = $result->fetch_object('Admin');
            }
        
            // Devolver el objeto de usuario
            return $user;
        }        

        public static function insertUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $PASSWORD, $TELEFONO, $DIRECCION, $PERMISO = 0){
            $hash = password_hash($PASSWORD, PASSWORD_DEFAULT); // Encriptar la contraseña
            
            $conn = db::connect(); // Establecer conexión a la base de datos
        
            // Preparar la consulta de inserción de usuario con parámetros seguros
            $stmt = $conn->prepare("INSERT INTO usuarios (EMAIL, SALUDO, NOMBRE, APELLIDOS, FECHA_NACIMIENTO, PASSWORD, TELEFONO, DIRECCION, PERMISO) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
            // Vincular parámetros a la consulta preparada
            $stmt->bind_param("ssssssssi", $EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $hash, $TELEFONO, $DIRECCION, $PERMISO);
        
            $stmt->execute(); // Ejecutar la consulta
            $result = $stmt->get_result();// Obtener el resultado de la ejecución (puede no ser necesario)
            $conn->close(); // Cerrar la conexión a la base de datos
    
            return $result; // Devolver el resultado de la ejecución de la consulta 
        }
        

        public static function updateUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION){
            $conn = db::connect(); // Establecer conexión a la base de datos
        
            // Preparar la consulta de actualización de usuario
            $stmt = $conn->prepare("UPDATE USUARIOS SET SALUDO = ?, NOMBRE = ?, APELLIDOS = ?, FECHA_NACIMIENTO = ?, TELEFONO = ?, DIRECCION = ? WHERE EMAIL = ?");
        
            // Vincular parámetros a la consulta preparada
            $stmt->bind_param("sssssss", $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION, $EMAIL);
        
            $stmt->execute();// Ejecutar la consulta
            $conn->close(); // Cerrar la conexión a la base de datos
        }  


        public static function getPointsById($id){
            $conn = db::connect();

            $stmt = $conn->prepare("SELECT PUNTOS as puntos FROM USUARIOS WHERE USUARIO_ID = $id");
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            $conn->close();
            
            $puntos = $result->fetch_assoc();
            
            return $puntos['puntos'];
        }

        public static function updatePuntos($id, $puntos){
            $conn = db::connect(); // Establecer conexión a la base de datos
        
            // Preparar la consulta de actualización de usuario
            $stmt = $conn->prepare("UPDATE USUARIOS SET PUNTOS = ? WHERE USUARIO_ID = ?");
        
            // Vincular parámetros a la consulta preparada
            $stmt->bind_param("ii", $puntos, $id);
        
            $stmt->execute();// Ejecutar la consulta
            $conn->close(); // Cerrar la conexión a la base de datos
        }
    }      
?>