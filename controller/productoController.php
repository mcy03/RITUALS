<?php
include_once("model/Categoria.php");
include_once("model/Producto.php");
include_once("model/Pedido.php");
include_once("model/User.php");
include_once("model/PedidosBBDD.php");
include_once("model/ProductosPedidosDAO.php");
include_once("utils/CalculadoraPrecios.php");
include_once 'config/parameters.php';
class productoController{
    public function prueba(){
        $categorias = Categoria::getCat();
        require_once("views/prueba.php");
    }

    public function index(){
        session_start();

        if (!isset($_SESSION['selecciones'])) {
            $_SESSION['selecciones'] = array();
        }
        $productos_cat_a = Producto::getProductByIdCat(2, 3);
        $productos_cat_b = Producto::getProductByIdCat(1, 3);
        //cabecera
        require_once("views/header.php");
        //include home
        require_once("views/home.php");
        //require_once("views/panelPedido.php");
        //footer
        require_once("views/footer.php");
    }

    public function carta(){
        session_start();
        $categorias = Categoria::getCat();
        $name_cat = "";
        if (isset($_GET['cat'])) {
            $name_cat = " / ".$_GET['cat'];
            $cat_filtro = Categoria::getCatIdByName($_GET['cat']);
            $productos = Producto::getProductByIdCat($cat_filtro);
            if (sizeof($productos) % 2 != 0) {
                $contador = 1;
            }else{
                $contador = 2;
            }
            $suma = 1;
        }else{
            $productos = Producto::getProducts();
            $contador = 0;
            $suma = 0;
        }
        $auxiliar = 0;
        $col = 1;
        //cabecera
        require_once("views/header.php");
        //include carta
        require_once("views/carta.php");
        //require_once("views/panelPedido.php");
        //footer
        require_once("views/footer.php");
    }

    public function carrito(){
        session_start();
        if (isset($_COOKIE['ultimoPedido'])) {
            $pedidoAnterior = unserialize($_COOKIE['ultimoPedido']);
            $infoPedidoAnterior = unserialize($_COOKIE['infoPedido']);
        }

        if(isset($_POST['cantidad'], $_POST['cantidadIntro'])){
            if ($_POST['cantidadIntro'] != $_POST['cantidad'] && $_POST['cantidadIntro'] > 0) {
                $_SESSION['selecciones'][$_POST['pos']]->setCantidad($_POST['cantidadIntro']);
            }else if (isset($_POST['add'])) {
                //Añadimos uno a la cantidad del producto en el pedido
                $_SESSION['selecciones'][$_POST['pos']]->aumentaCant();
            }else if (isset($_POST['del']) or $_POST['cantidadIntro'] <= 0) {
                $pedido = $_SESSION['selecciones'][$_POST['pos']];
                if ($pedido->getCantidad()<=1 or $_POST['cantidadIntro'] <= 0) {
                    unset($_SESSION['selecciones'][$_POST['pos']]);
                    //re-indexar array
                    $_SESSION['selecciones'] = array_values($_SESSION['selecciones']);
                }else{
                    $pedido = $_SESSION['selecciones'][$_POST['pos']];
                    $_SESSION['selecciones'][$_POST['pos']]->setCantidad($pedido->getCantidad()-1);
                }
            }
        }
        if (isset($_POST['destroy'])) {
            unset($_SESSION['selecciones'][$_POST['destroy']]);
            //re-indexar array
            $_SESSION['selecciones'] = array_values($_SESSION['selecciones']);
        }
        if (isset($_POST['destroy_session'])) {
            $_SESSION['selecciones'] = array();
        }
        if ( sizeof($_SESSION['selecciones']) < 1) {
            $sinProductos = true;
        }
        //cabecera
        require_once("views/header.php");
        //include carta
        require_once("views/carrito.php");
        
        //footer
        require_once("views/footer.php");
    }

    public static function eliminar(){
        $id_product = 10;  //$_POST['id']
        Producto::deleteProduct($id_product);
        header("Location:".url.'?controller=producto');
    }

    public static function editar(){
        $id_product = 10;  //$_POST['id']
        
        $product = Producto::getProductById($id_product);
        include_once 'views/editarProducto.php';
    }

    public static function actualizar(){
        echo "actualizar producto ";
        $producto_id = $_POST['id'];
        $nombre_producto = $_POST['name'];
        $img = $_POST['img'];
        $descripcion = $_POST['desc'];
        $precio_unidad = $_POST['price'];
        $categoria_id = $_POST['cat'];
        
        Producto::updateProduct($producto_id, $nombre_producto, $img, $descripcion, $precio_unidad, $categoria_id);
        header("Location:".url.'?controller=producto');
    }

    public function sel(){
        session_start();
        if (isset($_POST['id'])) {
            $exist = false;
            foreach ($_SESSION['selecciones'] as $selecciones) {
                if ($selecciones->getProducto()->getId() == $_POST['id']) {
                    $selecciones->aumentaCant();
                    $exist = true;
                }
            }
            if (!$exist) {
                $pedido = new Pedido(Producto::getProductById($_POST['id']));

                array_push($_SESSION['selecciones'], $pedido);
            }
            
        }

        if (isset($_POST['page'])) {
            header("Location:".url.'?controller=producto&action='.$_POST['page']);
        }else{
            header("Location:".url.'?controller=producto&action=index');
        }
        
    }

    public static function login(){
        $users = User::getUsers();
        session_start();
        if(isset($_SESSION['user'])){
            header("location:".url.'?controller=producto&action=cuenta&account');
        }
        $correct_email = false;
        $title = "Inicia sesión o crea una cuenta";
        $return_page = "home";
        include_once 'views/header.php';
        if (isset($_POST["email"])) {
            $correo = $_POST["email"];
            foreach ($users as $for_users) {
                if($for_users->getEmail() == $_POST["email"]){
                    if (isset($_POST["pwd"])) {
                        if($for_users->getPass() == $_POST["pwd"]){
                            $_SESSION['user'] = User::getUserByEmail($_POST["email"]);
                            header("location:".url.'?controller=producto&action=cuenta&account');
                        }
                        $pwd_error = true;
                    }
                    $correct_email = true;
                }
            }
            if ($correct_email == false) {
                $sign = true;
                $title = "Crea una nueva cuenta";
                $return_page = "login";
            }
        }
        include_once 'views/login.php';
    }

    public static function sign(){
        session_start();
        if (isset($_POST["email"])) {
            //insertar usuario
            $valid = User::insertUser($_POST["email"], $_POST["saludo"], $_POST["name"], $_POST["apellidos"], $_POST["nacimiento"], $_POST["pwd"], $_POST["telefono"], $_POST["direccion"]);
            
            $_SESSION['user'] = User::getUserByEmail($_POST["email"]);
        }
        
        header("location:".url.'?controller=producto&action=login');

    }

    public static function cuenta(){
        session_start();
        
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            if($user->getPermiso() != 0){
                $todos_pedidos = PedidosBBDD::getPedidosBBDD();
            }
            $hayPedidos = PedidosBBDD::tienePedidosUser($user->getId());

            if ($hayPedidos) {
                $pedidos_user = PedidosBBDD::getPedidosBBDD_ByIdUser($user->getId());
            }
            if(isset($_POST["pedido_id"])) {
                $productosPedido = ProductosPedidosDAO::getPedidosBBDD_ByIdPedido($_POST["pedido_id"]);
            }
            include_once 'views/header.php';
            include_once 'views/cuenta.php';
            //footer
            require_once("views/footer.php");
        }else{
            header("location:".url.'?controller=producto&action=login');
        }
    }

    public static function updateUser(){
        session_start();
        if(isset($_SESSION['user'], $_POST["email"])){
            if($_SESSION['user']->getPass() == $_POST["pwd"]){
                $valid = User::updateUser($_POST["email"], $_POST["saludo"], $_POST["name"], $_POST["apellidos"], $_POST["nacimiento"], $_POST["telefono"], $_POST["direccion"]);
                $_SESSION['user'] = User::getUserByEmail($_POST["email"]);
                header("location:".url.'?controller=producto&action=cuenta&account');
            }else{
                header("location:".url.'?controller=producto&action=cuenta&datosPersonales=error');
            }
        }else{
            header("location:".url.'?controller=producto&action=cuenta&account');
        }
    }

    public static function cerrar(){
        session_start();
        if(isset($_SESSION['user'])){
            session_destroy();
            header("location:".url.'?controller=producto&action=home');
        }
    }

    public static function pagar(){
        session_start();
        
        if (isset($_SESSION["user"], $_SESSION["selecciones"])) {
            $pedido = $_SESSION["selecciones"];
            $costeTotal = 0;
            if (sizeof($pedido) > 0) {
                PedidosBBDD::procesarPedido($_SESSION["user"], $pedido);
                $pedidoId = PedidosBBDD::getIdUltimoPedido();
                $fecha = getdate();
                $fechaPedido = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];;
                $usuarioPedido = $_SESSION["user"];
                foreach ($pedido as $producto) {
                    $costeTotal += $producto->calcPrice();
                }
                $infoPedido = array($pedidoId, $fechaPedido, $usuarioPedido->getEmail(), $costeTotal);
                setcookie('ultimoPedido', serialize($pedido), time()+86400);
                setcookie('infoPedido', serialize($infoPedido), time()+86400);

                header("location:".url.'?controller=producto&action=cuenta&pedidos');
            }else{
                header("location:".url.'?controller=producto&action=carrito');
            }
        }else{
            header("location:".url.'?controller=producto&action=login');
        }
    }

    public static function mostrarBBDD(){
        var_dump(PedidosBBDD::getPedidosBBDD());
    }

    public static function recuperarPedido(){
        session_start();
        $_SESSION['selecciones'] = array();
        if (isset($_POST["pedido_id"]) or isset($_COOKIE['ultimoPedido'])) {
            if (isset($_POST["pedido_id"])) {
                $articulosPedidos = ProductosPedidosDAO::getPedidosBBDD_ByIdPedido($_POST["pedido_id"]);
                foreach ($articulosPedidos as $productos) {
                    $pedido = new Pedido(Producto::getProductById($productos->getProductoId()));
                    $pedido->setCantidad($productos->getCantidad());
                    array_push($_SESSION['selecciones'], $pedido);
                }
            }elseif (isset($_COOKIE['ultimoPedido'])) {
                $_SESSION['selecciones'] = unserialize($_COOKIE['ultimoPedido']);
            }
            
            header("location:".url.'?controller=producto&action=carrito');
        }
    }
}