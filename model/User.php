<?php
    include_once 'db.php';
    include_once 'Admin.php';
    class User {
        /**
         * Atributos de la clase User que representan la información de un usuario.
         */
        protected $USUARIO_ID;         // Identificador único del usuario
        protected $EMAIL;              // Correo electrónico del usuario
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
        public function getUsername(){
            return $this->USERNAME;
        }
        public function setUsername($username){
            $this->USERNAME = $username;
        }
        public function getPass(){
            return $this->PASSWORD;
        }
        public function setPass($pass){
            $this->PASS = $pass;
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
        public function getPermiso(){
            return $this->PERMISO;
        }
        public function setPermiso($permiso){
            $this->PERMISO = $permiso;
        }

        public static function getUsers(){
            $conn = db::connect();

            $consulta = "SELECT * FROM usuarios WHERE PERMISO = 0";
            $arrayUsers = array();
            if ($resultado = $conn->query($consulta)) {
                /* obtener el array de objetos */
                while ($obj = $resultado->fetch_object('User')) {
                    $arrayUsers []= $obj;
                }
            
                /* liberar el conjunto de resultados */
                $resultado->close();
                
            }

            $consulta = "SELECT * FROM usuarios WHERE PERMISO != 0";
            $arrayAdmin = array();
            if ($resultado = $conn->query($consulta)) {
                /* obtener el array de objetos */
                while ($obj = $resultado->fetch_object('Admin')) {
                    $arrayAdmin []= $obj;
                }
            
                /* liberar el conjunto de resultados */
                $resultado->close();
                
            }
            $arrayFinal = array_merge($arrayUsers, $arrayAdmin);
            return $arrayFinal;
        }
        public static function getUserById($id){
            $conn = db::connect();
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE USUARIO_ID = ?");
            $stmt->bind_param("i", $id);
            
            $stmt->execute();
            $result=$stmt->get_result();
            $conn->close();

            $user = $result->fetch_object('User');
            return $user;
        }
        public static function getUserByEmail($email){
            $conn = db::connect();
            
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            
            $stmt->execute();
            $result=$stmt->get_result();
            $conn->close();
            
            $user = $result->fetch_object('User');
            return $user;
        }

        public static function insertUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $PASSWORD, $TELEFONO, $DIRECCION, $PERMISO = 0){
            $conn = db::connect();
            
            $stmt = $conn->prepare("INSERT INTO usuarios (EMAIL, SALUDO, NOMBRE, APELLIDOS, FECHA_NACIMIENTO, PASSWORD, TELEFONO, DIRECCION, PERMISO) VALUES ('$EMAIL', '$SALUDO', '$NOMBRE', '$APELLIDOS', '$FECHA_NACIMIENTO', '$PASSWORD', '$TELEFONO', '$DIRECCION', $PERMISO)");
            
            //ejecutamos consulta
            $stmt->execute();
            $result=$stmt->get_result();

            $conn->close();
            return $result;
        }

        public static function updateUser($EMAIL, $SALUDO, $NOMBRE, $APELLIDOS, $FECHA_NACIMIENTO, $TELEFONO, $DIRECCION){
            $conn = db::connect();

            $stmt = $conn->prepare("UPDATE USUARIOS SET SALUDO = '$SALUDO', NOMBRE = '$NOMBRE', APELLIDOS = '$APELLIDOS', FECHA_NACIMIENTO = '$FECHA_NACIMIENTO', TELEFONO = '$TELEFONO', DIRECCION = '$DIRECCION' WHERE EMAIL = '$EMAIL'");

            //ejecutamos consulta
            $stmt->execute();
            $conn->close();
        }
        
    }
    
?>