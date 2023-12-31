<?php
/*  
=========================================================================
                            CLASE db
=========================================================================
º Inicializamos la clase db la cual hara la coexión a la base de datos  º
=========================================================================
*/
class db {
    // Método estático para establecer la conexión a la base de datos
    public static function connect($servername = 'localhost', $username = 'root', $password = '', $database = 'rituals'){
        // Crear la conexión a la base de datos usando los parámetros proporcionados o valores predeterminados
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Verificar si la conexión falló y mostrar un mensaje de error en caso de fallo
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Devolver el objeto de conexión a la base de datos
        return $conn;
    }
}

?>
