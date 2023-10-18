<?php
    include_once 'db.php';
    class Producto {
        
        protected $PRODUCTO_ID;
        protected $NOMBRE_PRODUCTO;
        protected $IMG;
        protected $DESCRIPCION;
        protected $PRECIO_UNIDAD;
        protected $CATEGORIA_ID;

        public function __construct($producto_id){
            $conn = db::connect();
            $resultado = $conn->query("SELECT * FROM productos WHERE producto_id = $producto_id");
            while ($producto = $resultado->fetch_assoc()) {
                $this->PRODUCTO_ID = $producto['id'];
                $this->NOMBRE_PRODUCTO = $producto['nombre_producto'];
                $this->IMG = $producto['img'];
                $this->DESCRIPCION = $producto['descripcion'];
                $this->PRECIO_UNIDAD = $producto['precio_uniad'];
                $this->CATEGORIA_ID = $producto['categoria_id'];
            }
        }
        
        public function getId(){
            return $this->PRODUCTO_ID;
        }
        public function getName(){
            return $this->NOMBRE_PRODUCTO;
        }
        public function getImg(){
            return $this->IMG;
        }
        public function getDesc(){
            return $this->DESCRIPCION;
        }
        public function getPrice(){
            return $this->PRECIO_UNIDAD;
        }
        public function getCat(){
            return $this->CATEGORIA_ID;
        }
        public function getTableProduct(){
            $table = "<table>";
                $table .= "<tr>";
                    $table .= "<td>".$this->NOMBRE_PRODUCTO."</td>";
                $table .= "</tr>";
                $table .= "<tr>";
                    $table .= "<td>".$this->IMG."</td>";
                $table .= "</tr>";
                $table .= "<tr>";
                    $table .= "<td>".$this->DESCRIPCION."</td>";
                $table .= "</tr>";
                $table .= "<tr>";
                    $table .= "<td>".$this->PRECIO_UNIDAD."</td>";
                $table .= "</tr>";
            $table .= "<table>";
        }
        public function embedProductTable(){
            $table = "<tr>";
                $table .= "<td>".$this->NOMBRE_PRODUCTO."</td>";
            $table .= "</tr>";
            $table .= "<tr>";
                $table .= "<td>".$this->IMG."</td>";
            $table .= "</tr>";
            $table .= "<tr>";
                $table .= "<td>".$this->DESCRIPCION."</td>";
            $table .= "</tr>";
            $table .= "<tr>";
                $table .= "<td>".$this->PRECIO_UNIDAD."</td>";
            $table .= "</tr>";
        }
    }
    
?>