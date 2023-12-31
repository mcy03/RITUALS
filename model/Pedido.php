<?php
/*  
=========================================================================
                            CLASE Pedido
=========================================================================
º Inicializamos la clase Pedido la cual formara el carrito del usaurio, º
º por cada objeto de esta clase es un producto con la cantidad          º
º seleccionada por el usuario.                                          º
=========================================================================
*/
class Pedido {
    protected $producto; // Almacena el producto asociado al pedido
    protected $cantidad = 1; // La cantidad predeterminada es 1

    /**
     * Constructor de la clase Pedido.
     * @param Producto $producto El producto que se asigna al pedido.
     */
    public function __construct($producto){
        $this->producto = $producto;
    }

    /**
     * Obtiene el producto asociado al pedido.
     * @return Producto|null Retorna el objeto Producto asociado al pedido o null si no hay producto asignado.
     */
    public function getProducto(){
        return $this->producto;
    }

    /**
     * Establece el producto asociado al pedido.
     * @param Producto $producto El objeto Producto a asignar al pedido.
     * @return Pedido Devuelve la instancia actual de Pedido, permitiendo el encadenamiento de métodos.
     */
    public function setProducto($producto){
        $this->producto = $producto;
        return $this;
    }

    /**
     * Obtiene la cantidad del producto en el pedido.
     * @return int La cantidad del producto en el pedido.
     */
    public function getCantidad(){
        return $this->cantidad;
    }

    /**
     * Establece la cantidad del producto en el pedido.
     * @param int $cantidad La cantidad a establecer para el producto en el pedido.
     */
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }

    /**
     * Aumenta la cantidad del producto en el pedido en 1.
     */
    public function aumentaCant(){
        $this->cantidad++;
    }

    /**
     * Calcula el precio total del pedido.
     * @return float El precio total del pedido, multiplicando el precio del producto por la cantidad.
     */
    public function calcPrice(){
        return $this->producto->getPrice() * $this->cantidad;
    }

    /**
     * Obtiene el precio del producto asociado al pedido.
     * @return float El precio del producto en el pedido.
     */
    public function getPriceProduct(){
        return $this->producto->getPrice();
    }

    /**
     * Obtiene el ID del producto asociado al pedido.
     * @return int|null El ID del producto en el pedido o null si no hay un producto asignado.
     */
    public function getIdProduct(){
        return $this->producto->getId();
    }

}
