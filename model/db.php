<?php
    class db {
        public static function connect($servername = 'localhost', $username = 'root', $password = '', $database = 'rituals'){
            $conn = mysqli_connect($servername, $username, $password, $database);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            return $conn;
        }
    }