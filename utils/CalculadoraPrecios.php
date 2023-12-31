<?php
/*  
======================================================================
                    CLASE CacluladoraPrecios
======================================================================
º Inicializamos la clase CalculadoraPrecios en la cual tendremos     º
º funciones que calcularan, mostraran o compararan precios.          º
======================================================================  
*/
final class CalculadoraPrecios {   
    /**
     * Funcion calculadorPrecioPedido() la que nos devolvera el coste total de las selecciones del carrito del usuario
     * @param selecciones Array con las selecciones del carrito del usuario
     * 
     * @return precioTotal Return del coste toal calculado
     */
    public static function calculadorPrecioPedido($selecciones){
        $precioTotal = 0; //inicializamos la variable que acumulara el precio de cada seleccion del usuario

        //Recorremos el array 
        foreach ($selecciones as $seleccion) {
            //Por cada posicion del array llamamos a la funcion encargada de hacer la operacion de precio_producto por cantidad de la clase Pedido 
            //y la sumamos a la variable $precioTotal
            $precioTotal += $seleccion->calcPrice();
        }
        return $precioTotal;
    }

    /**
     * Funcion gastoEnvio() que nos devolvera el gasto de envio si no supera cierto coste y en el caso de superarlo, devolvera 0 (Coste de envio "GRATIS") 
     * este nos servira para sumarlo al coste del pedido
     * @param selecciones Array con las selecciones del carrito del usuario 
     * 
     * @return gastos Devolvemos el gasto calculado
     */
    public static function gastoEnvio($selecciones){
        $costeTotal = CalculadoraPrecios::calculadorPrecioPedido($selecciones);

        if($costeTotal < 25){ //Comprobamos si el coste total del pedido es menor a el coste minimo para quitar gastos de envio
            $gastos = 5.00;
        }else{
            $gastos = 0; //En caso de ser mayor al minimo establecido, el coste de envio sera 0
        }
        
        return $gastos;
    }

    /**
     * Funcion comprobarYPasarDecimal() la cual comprobara si el valor pasado es decimal o entero y lo pasara a string con dos decimales.
     * Nos sirve para pasar los valores de la BBDD a decimales para mostrarlos en la web
     * 
     * @param valor numero a pasar a doble decimal String
     * 
     * @return valor devolvemos el mismo valor pero con dos decimales y String
     */
    public static function comprobarYPasarDecimal($valor){
        $decimal = strpos($valor, '.'); //Buscamos la posicion del punto decimal en el valor

        if ($decimal == false) { //Si no existe el punto cocatenamos ".00"
            $valor = $valor.".00";
        }else{ //Si existe el punto entraremos aqui
            $caracteres_despues = strlen(substr($valor, $decimal + 1)); //Comprobamos cuantos numeros hay a la derecha del punto
            if ($caracteres_despues < 2) { //Si hay un decimal solo, concatenaremos un 0 y e caso contrario significara que ya hay dos decimales en el valor original
                $valor = $valor."0";
            }
        }
        return $valor;
    }

    /**
     * Funcion remplazarChar() que nos devolvera el valor recibido semplazando el valor $char por $replazo
     * @param selecciones Array con las selecciones del carrito del usuario 
     * 
     * @return return cadena $valor con el remplazo de caracteres hecho
     */
    public static function remplazarChar($char, $remplazo, $valor){
        return str_replace($char, $remplazo, $valor); //llamamos a str_replace() y le pasamos los valores para que haga el remplazo de caracteres
    }

    /**
     * Funcion mostrarGastoEnvio() que nos devolvera el gasto de envio si no supera cierto coste y en el caso de superarlo, devolvera 0 (Coste de envio "GRATIS") 
     * este nos servira para sumarlo al coste del pedido
     * @param selecciones Array con las selecciones del carrito del usuario 
     * 
     * @return retorno return de gastos de envio en formato texo, puede ser 
     * "GRATIS" en caso de no haber gasto de envio o el gasto de envio con coma decimal en vez de punto
     */
    public static function mostrarGastoEnvio($selecciones){
        $gastoEnvio = CalculadoraPrecios::gastoEnvio($selecciones); //Primero llamamos a la funcion gatoEnvio() y le pasamos $selecciones para que nos devuelva el coste de envio
        $retorno = 0;

        if($gastoEnvio == 0){ //Si el valor devuelto por la funcion es 0, devolveremos "GRATIS" ya que no hay gasto de envio
            $retorno = "Gratis";
        }else{ //en caso de no ser 0
            $gastoEnvio = CalculadoraPrecios::comprobarYPasarDecimal($gastoEnvio); //comprobamos el decimal y lo pasamos a formato con dos decimales

            //guardaremos en la variable de retoro el coste de envio con dos decimales, cambiando el punto por una coma y concatenando el simbolo de euro
            $retorno = CalculadoraPrecios::remplazarChar('.', ',', $gastoEnvio)." €";
        }
        return $retorno;
    }

    /**
     * Funcion mostrarPrecioPedido() que nos preparara solo el total de los productos seleccionados por el usuario con el formato a mostrar en la web
     * 
     * @param selecciones Array con las selecciones del carrito del usuario 
     * 
     * @return total total de las selecciones con formato correcto para mostrar directamente
     */
    public static function mostrarPrecioPedido($selecciones){
        $precioPedido = CalculadoraPrecios::calculadorPrecioPedido($selecciones); //nos guardamos el coste total de las selecciones del usuario gracias a calculadorPrecioPedido()
        $precioPedido = CalculadoraPrecios::comprobarYPasarDecimal($precioPedido); //pasamos ese total a decimal en caso de no serlo

        $precioPedido = CalculadoraPrecios::remplazarChar('.', ',', $precioPedido); //remplazamos el punto por una coma para que corresponda al formato de la web
        
        return $precioPedido;
    }

    /**
     * Funcion calculadorTotalPedido() que nos calculara el precio total de las selecciones de productos del usuario mas el gasto de envio 
     * en formato correcto para poder mostrarlo directamete
     * 
     * @param selecciones Array con las selecciones del carrito del usuario 
     * 
     * @return total total de las selecciones mas el gasto de envio con formato correcto para mostrar directamente
     */
    public static function calculadorTotalPedido($selecciones){
        $total = CalculadoraPrecios::calculadorPrecioPedido($selecciones); //nos guardamos el precio total del pedido con la funcion calculadorPrecioPedido()
        $gastoEnvio = CalculadoraPrecios::gastoEnvio($selecciones); //nos guardamos el gasto de envio con la funcion gastoEnvio()

        //comprobamos si el gasto de envio de conjunto de las selecciones es double, lo cual significara que hay gasto de envio porque sino seria 0
        if (getType($gastoEnvio) ==  'double'){
            $total += $gastoEnvio; //en caso de ser double, se sumara al total el gasto de envio
        }

        $total = CalculadoraPrecios::comprobarYPasarDecimal($total); //pasamos el total a decimal en caso de no serlo
        return CalculadoraPrecios::remplazarChar('.', ',', $total); //pasamos el punto a coma del valor total
    }
}//Final de la clase CalculadoraPrecios
