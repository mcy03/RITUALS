<?php
include_once("model/Categoria.php");
include_once("model/Producto.php");
include_once("model/Pedido.php");
include_once("model/User.php");
include_once("model/PedidosBBDD.php");
include_once("model/ProductosPedidosDAO.php");
include_once("model/ResenaDAO.php");
include_once("utils/CalculadoraPrecios.php");
include_once 'config/parameters.php';
class productoController{
    public function index(){
        session_start(); // Inicia la sesión
        
        // Verifica si no existe la variable de sesión 'selecciones' y la inicializa como un array vacío si es así
        if (!isset($_SESSION['selecciones'])) {
            $_SESSION['selecciones'] = array();
        }
    
        // Obtiene productos de dos categorías diferentes por sus IDs (para mostrar en la página principal)
        $productos_cat_a = Producto::getProductByIdCat(2, 3); // Obtener productos de la categoría ID 2, limitados a 3
        $productos_cat_b = Producto::getProductByIdCat(1, 3); // Obtener productos de la categoría ID 1, limitados a 3
    
        // Incluye archivos de vista para la cabecera, la página principal (home) y el footer
        require_once("views/header.php");
        require_once("views/home.php");
        require_once("views/footer.php");
    }
    

    public function carta(){
        session_start(); // Inicia la sesión
    
        $categorias = Categoria::getCat(); // Obtiene las categorías de la bbdd
    
        $name_cat = "";
        if (isset($_GET['cat'])) {
            $name_cat = " / ".$_GET['cat']; // Obtiene el nombre de la categoría para mostrar en la vista
            $cat_filtro = Categoria::getCatIdByName($_GET['cat']); // Obtiene el id de la categoria por su nombre
            $productos = Producto::getProductByIdCat($cat_filtro); // Obtiene productos por la categoría
    
            // Determina un contador y una suma basada en el número de productos para el diseño de la vista
            if (sizeof($productos) % 2 != 0) {
                $contador = 1;
            } else {
                $contador = 2;
            }
            $suma = 1;
        } else {
            // Si no se especifica una categoría, obtiene todos los productos disponibles
            $productos = Producto::getProducts();
            $contador = 0;
            $suma = 0;
        }
    
        $auxiliar = 0;
        $col = 1;
    
        // Incluye archivos de vista para la cabecera, la página "carta" y el footer
        require_once("views/header.php");
        require_once("views/carta.php");
        require_once("views/footer.php");
    }
    

    public function carrito(){
        session_start(); // Inicia la sesión
    
        // Comprobación y recuperación de datos del último pedido desde las cookies si existen
        if (isset($_COOKIE['ultimoPedido'])) {
            $pedidoAnterior = unserialize($_COOKIE['ultimoPedido']);
            $infoPedidoAnterior = unserialize($_COOKIE['infoPedido']);
        }
    
        // Lógica para actualizar la cantidad de productos en el carrito
        if(isset($_POST['cantidad'], $_POST['cantidadIntro'])){
            // Si se envían datos para actualizar la cantidad de un producto en el carrito
            if ($_POST['cantidadIntro'] != $_POST['cantidad'] && $_POST['cantidadIntro'] > 0) {
                $_SESSION['selecciones'][$_POST['pos']]->setCantidad($_POST['cantidadIntro']);
            } else if (isset($_POST['add'])) {
                // Añade uno a la cantidad del producto en el pedido
                $_SESSION['selecciones'][$_POST['pos']]->aumentaCant();
            } else if (isset($_POST['del']) or $_POST['cantidadIntro'] <= 0) {
                // Lógica para eliminar productos del carrito o reducir su cantidad
                $pedido = $_SESSION['selecciones'][$_POST['pos']];
                if ($pedido->getCantidad() <= 1 or $_POST['cantidadIntro'] <= 0) {
                    // Elimina un producto específico del carrito
                    unset($_SESSION['selecciones'][$_POST['pos']]);
                    // Reindexa el array después de la eliminación
                    $_SESSION['selecciones'] = array_values($_SESSION['selecciones']);
                } else {
                    $pedido = $_SESSION['selecciones'][$_POST['pos']];
                    $_SESSION['selecciones'][$_POST['pos']]->setCantidad($pedido->getCantidad() - 1);
                }
            }
        }
    
        // Eliminar elementos del carrito des de el boton de eliminar
        if (isset($_POST['destroy'])) {
            unset($_SESSION['selecciones'][$_POST['destroy']]);
            // Reindexa el array después de la eliminación
            $_SESSION['selecciones'] = array_values($_SESSION['selecciones']);
        }
    
        // Vaciar completamente el carrito
        if (isset($_POST['destroy_session'])) {
            $_SESSION['selecciones'] = array();
        }
    
        // Comprobación si el carrito está vacío
        if (sizeof($_SESSION['selecciones']) < 1) {
            $sinProductos = true; // Indica que el carrito está vacío
        }
    
        // Inclusión de archivos de vista para el header, el carrito y el footer
        require_once("views/header.php");
        require_once("views/carrito.php");
        require_once("views/footer.php");
    }

    public function sel(){
        session_start(); // Inicia la sesión
    
        // Verifica si se envió un ID mediante POST (boton añadir de la carta) o GET (boton de añadir de la pagina home)
        if (isset($_POST['id']) or isset($_GET['producto_id'])) {
            // Define el ID según el método de envío (POST o GET)
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
            } elseif(isset($_GET['producto_id'])){
                $id = $_GET['id'];
            }
    
            $exist = false;
            // Itera a través de las selecciones actuales en la sesión para verificar si el producto ya está seleccionado
            foreach ($_SESSION['selecciones'] as $selecciones) {
                if ($selecciones->getProducto()->getId() == $id) {
                    $selecciones->aumentaCant(); // Aumenta la cantidad si el producto ya está seleccionado
                    $exist = true;
                }
            }
            if (!$exist) {
                $pedido = new Pedido(Producto::getProductById($id)); // Obtiene el producto por su ID
    
                array_push($_SESSION['selecciones'], $pedido); // Agrega el producto a la lista de selecciones si no existe aún
            }
        }
        
        // Redirección a la página especificada (o la página de inicio por defecto) después de la operación
        if (isset($_POST['page'])) {
            header("Location:".url.'?controller=producto&action='.$_POST['page']);
        } else {
            header("Location:".url.'?controller=producto&action=index');
        }
    }
    

    public static function login(){
        // Obtiene todos los usuarios
        $users = User::getUsers();
    
        session_start(); // Inicia la sesión
    
        // Si ya hay un usuario en sesión, redirige a la cuenta
        if(isset($_SESSION['user'])){
            header("location:".url.'?controller=producto&action=cuenta&account');
        }
    
        $correct_email = false;
        $title = "Inicia sesión o crea una cuenta";
        $return_page = "home";
    
        include_once 'views/header.php'; // Incluye la cabecera
    
        // Verifica si se ha enviado un correo electrónico
        if (isset($_POST["email"])) {
            $correo = $_POST["email"];
            foreach ($users as $for_users) {
                // Comprueba si el correo electrónico coincide con alguno en la lista de usuarios
                if($for_users->getEmail() == $_POST["email"]){
                    if (isset($_POST["pwd"])) {
                        // Verifica si la contraseña es correcta
                        if(password_verify($_POST["pwd"], $for_users->getPass())){
                            $_SESSION['user'] = $for_users; // Inicia sesión con el usuario actual
                            header("location:".url.'?controller=producto&action=cuenta&account'); // Redirige a la cuenta
                        }
                        $pwd_error = true; // Marca un error si la contraseña es incorrecta
                    }
                    $correct_email = true; // Indica que el correo es correcto
                }
            }
            // Si el correo no está registrado, se prepara para crear una nueva cuenta
            if ($correct_email == false) {
                $sign = true;
                $title = "Crea una nueva cuenta";
                $return_page = "login";
            }
        }
        include_once 'views/login.php'; // Incluye la vista de inicio de sesión
        include_once 'views/footer.php'; // Incluye el footer
    }
    

    public static function sign(){
        session_start(); // Inicia la sesión
    
        // Verifica si se ha enviado un correo electrónico
        if (isset($_POST["email"])) {
            // Inserta un nuevo usuario con los datos proporcionados en el formulario
            $valid = User::insertUser($_POST["email"], $_POST["saludo"], $_POST["name"], $_POST["apellidos"], $_POST["nacimiento"], $_POST["pwd"], $_POST["telefono"], $_POST["direccion"]);
            
            // Obtiene y establece el usuario recién registrado como usuario en sesión
            $_SESSION['user'] = User::getUserByEmail($_POST["email"]);
        }
        
        // Redirige a la página de inicio de sesión, independientemente de si se ha registrado un usuario o no
        header("location:".url.'?controller=producto&action=login');
    }
    

    public static function cuenta(){
        session_start(); // Inicia la sesión
    
        // Verifica si hay un usuario en sesión
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user']; // Obtiene el usuario de la sesión
    
            // Verifica la clase del usuario y realiza acciones dependiendo del parámetro GET recibido
            if(get_class($user)){
                if (isset($_GET['pedidos'])) {
                    $todos_pedidos = PedidosBBDD::getPedidosBBDD();
                } elseif (isset($_GET['usuarios'])) {
                    $todos_usuarios = User::getUsers();
                } elseif (isset($_GET['productos'])) {
                    $todos_productos = Producto::getProducts();
                }
            }
    
            // Verifica si el usuario tiene pedidos asignados
            $hayPedidos = PedidosBBDD::tienePedidosUser($user->getId());
    
            // Si hay pedidos, obtiene los pedidos del usuario
            if ($hayPedidos) {
                $pedidos_user = PedidosBBDD::getPedidosBBDD_ByIdUser($user->getId());
            }
    
            // Si recibimos un id de pedido nos guardamos ese pedido mediante la id
            if(isset($_POST["pedido_id"])) {
                $productosPedido = ProductosPedidosDAO::getPedidosBBDD_ByIdPedido($_POST["pedido_id"]);
            }
            // Mensajes para mostrar errores o confirmaciones
            if (isset($_GET['error'])) {
                $color = "red";
                $mensaje = "ERROR AL ELIMINAR: TIENE PEDIDOS ASIGNADOS";
            } elseif(isset($_GET['mensaje'])) {
                $color = "green";
                $mensaje = "ELIMINADO CORRECTAMENTE";
            } elseif (isset($_GET['modificado'])) {
                $color = "green";
                $mensaje = "MODIFICADO CORRECTAMENTE";
            } elseif (isset($_GET['insertado'])) {
                $color = "green";
                $mensaje = "INSERTADO CORRECTAMENTE";
            }
    
            // Incluye los archivos de cabecera, la vista de cuenta y el footer
            include_once 'views/header.php';
            include_once 'views/cuenta.php';
            include_once 'views/footer.php';
        } else {
            // Si no hay usuario en sesión, redirige a la página de inicio de sesión
            header("location:".url.'?controller=producto&action=login');
        }
    }
    

    public static function updateUser(){
        session_start(); // Inicia la sesión
    
        // Verifica la existencia del usuario en sesión y si hay datos POST
        if(isset($_SESSION['user'], $_POST["email"])){
            // Verifica si la contraseña ingresada coincide con la contraseña del usuario en sesión
            if(password_verify($_POST["pwd"], $_SESSION['user']->getPass())){
                // Actualiza la información del usuario
                $valid = User::updateUser($_POST["email"], $_POST["saludo"], $_POST["name"], $_POST["apellidos"], $_POST["nacimiento"], $_POST["telefono"], $_POST["direccion"]);
                
                // Obtiene y actualiza la información del usuario en sesión después de la actualización
                $_SESSION['user'] = User::getUserByEmail($_POST["email"]);
    
                // Redirige a la página de cuenta
                header("location:".url.'?controller=producto&action=cuenta&account');
            } else {
                // Redirige a la página de cuenta con un mensaje de error si la contraseña es incorrecta
                header("location:".url.'?controller=producto&action=cuenta&datosPersonales=error');
            }
        } else {
            // Redirige a la página de cuenta si no se proporcionan los datos necesarios
            header("location:".url.'?controller=producto&action=cuenta&account');
        }
    }
    

    public static function cerrar(){
        session_start(); // Inicia la sesión
    
        if(isset($_SESSION['user'])){ // Verifica si hay un usuario en sesión
            session_destroy(); // Cierra la sesión actual del usuario
            header("location:".url.'?controller=producto&action=home'); // Redirige a la página de inicio
        }
    }    

    public static function pagar(){
        session_start(); // Inicia la sesión
    
        if (isset($_SESSION["user"], $_SESSION["selecciones"])) { // Verifica si hay un usuario y elementos seleccionados en la sesión
            $pedido = $_SESSION["selecciones"]; // Obtiene los elementos seleccionados
            $costeTotal = 0;
    
            if (sizeof($pedido) > 0) { // Verifica si hay elementos en el pedido
                // Procesa el pedido con los elementos seleccionados
                PedidosBBDD::procesarPedido($_SESSION["user"], $pedido);
                
                // Obtiene el ID del último pedido que es el recien insertado
                $pedidoId = PedidosBBDD::getIdUltimoPedido();
                $fecha = getdate(); //obtenemos la fecha actual
                $fechaPedido = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"]; //concatenamos dia del mes / mes / año por las posiciones del getdate()
                $usuarioPedido = $_SESSION["user"]; //Nos guardamos el usuario que tiene sesion iniciada
    
                // Calcula el costo total del pedido
                foreach ($pedido as $producto) {
                    $costeTotal += $producto->calcPrice();
                }
    
                // Almacena la información del pedido en cookies por un día
                $infoPedido = array($pedidoId, $usuarioPedido->getEmail(), $fechaPedido, $costeTotal);
                setcookie('ultimoPedido', serialize($pedido), time()+86400);
                setcookie('infoPedido', serialize($infoPedido), time()+86400);
    
                // Redirige a la página de cuenta mostrando los pedidos del usuario
                header("location:".url.'?controller=producto&action=cuenta&misPedidos');
            } else {
                // Si no hay elementos en el pedido, redirige al carrito de compras
                header("location:".url.'?controller=producto&action=carrito');
            }
        } else {
            // Si no hay usuario logueado o elementos seleccionados, redirige al inicio de sesión
            header("location:".url.'?controller=producto&action=login');
        }
    }    

    public static function recuperarPedido(){
        session_start(); // Inicia la sesión
        $_SESSION['selecciones'] = array(); // Inicializa el array de selecciones en la sesión
    
        if (isset($_POST["pedido_id"]) or isset($_COOKIE['ultimoPedido'])) { // Verifica si hay un pedido ID enviado o si hay un último pedido en las cookies
            if (isset($_POST["pedido_id"])) { // Si se envió un ID de pedido
                // Obtiene los artículos del pedido por ID y los agrega a la sesión como selecciones
                $articulosPedidos = ProductosPedidosDAO::getPedidosBBDD_ByIdPedido($_POST["pedido_id"]);
                foreach ($articulosPedidos as $productos) {
                    $pedido = new Pedido(Producto::getProductById($productos->getProductoId()));
                    $pedido->setCantidad($productos->getCantidad());
                    array_push($_SESSION['selecciones'], $pedido);
                }
            } elseif (isset($_COOKIE['ultimoPedido'])) { // Si existe un último pedido en las cookies y no un pedido por POST
                $_SESSION['selecciones'] = unserialize($_COOKIE['ultimoPedido']); // Recupera las selecciones del último pedido almacenado en las cookies
            }
            
            header("location:".url.'?controller=producto&action=carrito'); // Redirige al carrito de compras
        }
    }
    

    public static function accionPedido(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['pedido_id'])) { // Verifica si se ha enviado un ID de pedido
            $id = $_POST['pedido_id']; // Obtiene el ID de pedido
            if (isset($_POST['eliminar'])) { // Verifica si se solicitó eliminar el pedido
                $result = $_SESSION['user']->deletePedido($id); // Elimina el pedido usando el método 'deletePedido' del usuario actual
                header("Location:".url.'?controller=producto&action=cuenta&pedidos&mensaje'); // Redirige a la página de la cuenta con un mensaje de confirmación
            } elseif(isset($_POST['editar'])) { // Verifica si se solicitó editar el pedido
                header("Location:".url.'?controller=producto&action=editPage&pedido_id='.$id); // Redirige a la página de edición del pedido
            }
        } elseif(isset($_POST['anadir'])) { // Si se solicita añadir un nuevo pedido
            header("Location:".url.'?controller=producto&action=createPage&pedido'); // Redirige a la página de creación de un nuevo pedido
        } else {
            header("Location:".url.'?controller=producto&action=cuenta&pedidos'); // Si no se especifica ninguna acción, redirige a la página de pedidos de la cuenta
        }
    }    

    public static function accionUsuario(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['usuario_id'])) { // Comprueba si se ha enviado un ID de usuario
            $id = $_POST['usuario_id']; // Obtiene el ID del usuario
    
            if (isset($_POST['eliminar'])) { // Verifica si se solicita eliminar el usuario
                $pedidos = PedidosBBDD::tienePedidosUser($id); // Verifica si el usuario tiene pedidos asociados
    
                if ($pedidos) { // Si el usuario tiene pedidos asociados
                    header("Location:".url.'?controller=producto&action=cuenta&usuarios&error'); // Redirige a la página de cuentas de usuario con un mensaje de error
                } else { // Si el usuario no tiene pedidos asociados
                    $result = $_SESSION['user']->deleteUser($id); // Elimina el usuario usando el método 'deleteUser' del usuario actual
                    header("Location:".url.'?controller=producto&action=cuenta&usuarios&mensaje'); // Redirige a la página de cuentas de usuario con un mensaje de confirmación
                }
            } elseif(isset($_POST['editar'])) { // Verifica si se solicita editar el usuario
                header("Location:".url.'?controller=producto&action=editPage&usuario_id='.$id); // Redirige a la página de edición del usuario
            }
        } elseif(isset($_POST['anadir'])) { // Si se solicita añadir un nuevo usuario
            header("Location:".url.'?controller=producto&action=createPage&usuario'); // Redirige a la página de creación de un nuevo usuario
        } else {
            header("Location:".url.'?controller=producto&action=cuenta&usuarios'); // Si no se especifica ninguna acción, redirige a la página de usuarios de la cuenta
        }
    }    

    public static function accionProducto(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['producto_id'])) { // Verifica si se ha enviado un ID de producto
            $id = $_POST['producto_id']; // Obtiene el ID del producto
    
            if (isset($_POST['eliminar'])) { // Verifica si se solicita eliminar el producto
                $pedidos = ProductosPedidosDAO::estaProductoPedido($id); // Verifica si el producto está en algún pedido
    
                if ($pedidos) { // Si el producto está en algún pedido
                    header("Location:".url.'?controller=producto&action=cuenta&usuarios&error'); // Redirige a la página de cuentas de usuario con un mensaje de error
                } else { // Si el producto no está en ningún pedido
                    $producto = Producto::getProductById($id); // Obtiene el producto por su ID
                    $img = $producto->getImg(); // Obtiene la ruta de la imagen asociada al producto
    
                    if (file_exists($img)) { // Verifica si el archivo de la imagen existe
                        if (unlink($img)) { // Elimina la imagen asociada al producto
                            echo "El archivo ha sido eliminado correctamente."; // Muestra un mensaje de éxito
                        } else {
                            echo "No se pudo eliminar el archivo."; // Muestra un mensaje de error si no se pudo eliminar la imagen
                        }
                    } else {
                        echo "El archivo no existe."; // Muestra un mensaje si la imagen no existe
                    }
    
                    $result = $_SESSION['user']->deleteProduct($id); // Elimina el producto usando el método 'deleteProduct' del usuario actual
                    header("Location:".url.'?controller=producto&action=cuenta&productos&mensaje'); // Redirige a la página de cuentas de productos con un mensaje de confirmación
                }
            } elseif(isset($_POST['editar'])) { // Verifica si se solicita editar el producto
                header("Location:".url.'?controller=producto&action=editPage&producto_id='.$id); // Redirige a la página de edición del producto
            }
        } elseif(isset($_POST['anadir'])) { // Si se solicita añadir un nuevo producto
            header("Location:".url.'?controller=producto&action=createPage&producto'); // Redirige a la página de creación de un nuevo producto
        } else {
            header("Location:".url.'?controller=producto&action=cuenta&productos'); // Si no se especifica ninguna acción, redirige a la página de productos de la cuenta
        }
    }    

    public static function editPage(){
        session_start(); // Inicia la sesión
    
        if (isset($_GET['pedido_id'])) { // Si se proporciona un ID de pedido en la URL
            $id_pedido = $_GET['pedido_id']; // Obtiene el ID del pedido desde la URL
            $pedido = PedidosBBDD::getPedidoById($id_pedido); // Obtiene el pedido por su ID

        } elseif (isset($_GET['usuario_id'])) { // Si se proporciona un ID de usuario en la URL
            $id_usuario = $_GET['usuario_id']; // Obtiene el ID de usuario desde la URL
            $usuario = User::getUserById($id_usuario); // Obtiene el usuario por su ID

        } elseif (isset($_GET['producto_id'])) { // Si se proporciona un ID de producto en la URL
            $id_producto = $_GET['producto_id']; // Obtiene el ID del producto desde la URL
            $producto = Producto::getProductById($id_producto); // Obtiene el producto por su ID
    
            // Obtiene información adicional para editar el producto
            $categoria_producto = Categoria::getCatById($producto->getCat()); // Obtiene la categoría del producto
            $categorias = Categoria::getCatExcludeId($producto->getCat()); // Obtiene otras categorías excluyendo la del producto
        }
    
        // Incluye las partes de la página: cabecera, página de edición y pie de página
        include_once 'views/header.php';
        include_once 'views/editPage.php';
        include_once 'views/footer.php';
    }

    public static function editarPedido(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['pedido_id'])) { // Si se envía un ID de pedido mediante POST
            // Obtiene los datos del formulario de edición del pedido
            $id_pedido = $_POST['pedido_id']; // Obtiene el ID del pedido
            $id_user = $_POST['usuario_id']; // Obtiene el ID del usuario asociado al pedido
            $estado = $_POST['estado']; // Obtiene el nuevo estado del pedido
            $fecha = $_POST['fecha']; // Obtiene la nueva fecha del pedido
    
            // Actualiza el pedido utilizando el método 'updatePedido' del usuario en la sesión
            $_SESSION['user']->updatePedido($id_pedido, $id_user, $estado, $fecha);
        }
    
        // Redirecciona de vuelta a la página de la cuenta con un mensaje de 'modificado'
        header("Location:".url.'?controller=producto&action=cuenta&pedidos&modificado');
    }
    

    public static function editarUsuario(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['usuario_id'])) { // Si se envía un ID de usuario mediante POST
            // Obtiene los datos del formulario de edición del usuario
            $email = $_POST['email']; // Obtiene el email del usuario
            $saludo = $_POST['saludo']; // Obtiene el nuevo saludo del usuario
            $nombre = $_POST['nombre']; // Obtiene el nuevo nombre del usuario
            $apellidos = $_POST['apellidos']; // Obtiene los nuevos apellidos del usuario
            $fecha_nacimiento = $_POST['nacimiento']; // Obtiene la nueva fecha de nacimiento del usuario
            $telefono = $_POST['telefono']; // Obtiene el nuevo número de teléfono del usuario
            $direccion = $_POST['direccion']; // Obtiene la nueva dirección del usuario
            
            // Actualiza la información del usuario utilizando el método 'updateUser' del usuario en la sesión
            $_SESSION['user']->updateUser($email, $saludo, $nombre, $apellidos, $fecha_nacimiento, $telefono, $direccion);
        }
    
        // Redirecciona de vuelta a la página de gestión de usuarios con un mensaje de 'modificado'
        header("Location:".url.'?controller=producto&action=cuenta&usuarios&modificado');
    }    

    public static function editarProducto(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['producto_id'])) { // Si se envía un ID de producto mediante POST
            $producto_id = $_POST['producto_id']; // Obtiene el ID del producto a editar
            $nombre = $_POST['nombre']; // Obtiene el nuevo nombre del producto
            $img_anterior = $_POST['imagen_anterior']; // Obtiene la imagen anterior del producto
            $descripcion = $_POST['descripcion']; // Obtiene la nueva descripción del producto
            $precio = $_POST['precio']; // Obtiene el nuevo precio del producto
            $categoria_id = $_POST['categoria_id']; // Obtiene el ID de la nueva categoría del producto
    
            // Verifica si se está enviando una nueva imagen para el producto
            if ($_FILES["imagen"]["name"] == NULL) {
                // Si no hay una nueva imagen, actualiza el producto con la imagen anterior
                $_SESSION['user']->updateProduct($producto_id, $nombre, $img_anterior, $descripcion, $precio, $categoria_id);
            } elseif ($_FILES["imagen"]["name"] != NULL) {
                // Si hay una nueva imagen, maneja la actualización de la imagen del producto
                // Elimina la imagen anterior si existe
                if (file_exists($img_anterior)) {
                    if (unlink($img_anterior)) {
                        echo "El archivo ha sido eliminado correctamente.";
                    } else {
                        echo "No se pudo eliminar el archivo.";
                    }
                } else {
                    echo "El archivo no existe.";
                }
    
                // Ruta donde se guarda la nueva imagen
                $directory = "img/products/";
                $file = $directory . basename($_FILES["imagen"]["name"]);
    
                // Sube la nueva imagen
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $file)) {
                    // Actualiza el producto con la nueva imagen
                    $_SESSION['user']->updateProduct($producto_id, $nombre, $file, $descripcion, $precio, $categoria_id);
                } else {
                    echo "Hubo un error al subir el archivo.";
                }
            }
        }
    
        // Redirecciona de vuelta a la página de gestión de productos con un mensaje de 'modificado'
        header("Location:".url.'?controller=producto&action=cuenta&productos&modificado');
    }    

    public static function createPage(){
        session_start(); // Inicia la sesión
    
        if (isset($_GET['pedido'])) { // Si se solicita la creación de un pedido
            $usuarios = User::getUsers(); // Obtiene la lista de usuarios
            $productos = Producto::getProducts(); // Obtiene la lista de productos
            if (isset($_POST['num_products'])) {
                $num_products = (int) $_POST['num_products']; // Obtiene el número de productos
            }
        } elseif (isset($_GET['producto'])) { // Si se solicita la creación de un producto
            $categorias = Categoria::getCat(); // Obtiene la lista de categorías de productos
        }
    
        // Incluye los archivos de la cabecera, la página de creación y el pie de página
        include_once 'views/header.php';
        include_once 'views/createPage.php';
        include_once 'views/footer.php';
    }    

    public static function addPedido(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['user_id'])) { // Si se reciben datos del usuario y el pedido
            $user_id = $_POST['user_id']; // Obtiene el ID del usuario
            $estado = $_POST['estado']; // Obtiene el estado del pedido
            $cant_products = $_POST['cant_products']; // Obtiene la cantidad de productos
    
            // Recorre la cantidad de productos para obtener sus detalles
            for ($i=0; $i < $cant_products ; $i++) { 
                $array_products[] = $_POST['producto'.$i]; // Obtiene los productos del pedido
                $array_cant[] = $_POST['cantidad'.$i]; // Obtiene las cantidades de los productos
            }
    
            $user = User::getUserById($user_id); // Obtiene el usuario por su ID
    
            // Realiza la inserción del nuevo pedido
            $result = Admin::insertPedido($user, $array_products, $array_cant);
        }
    
        // Redirecciona a la página de cuenta de pedidos con el mensaje de inserción
        header("Location:".url.'?controller=producto&action=cuenta&pedidos&insertado');
    }    

    public static function addUsuario(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['email'])) { // Si se reciben los datos del nuevo usuario
            // Obtiene los datos del formulario
            $email = $_POST['email'];
            $saludo = $_POST['saludo'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $fecha_nacimiento = $_POST['nacimiento'];
            $pwd = $_POST['pwd'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $permiso = $_POST['permiso'];
    
            // Comprueba el permiso que se ha pasado por POST
            if ($permiso == 'usuario') {
                $permiso = 0; // Si el permiso es 'usuario', establece el valor como 0
            } else {
                $permiso = 1; // Si no, establece el permiso como 1
            }
    
            // Inserta el nuevo usuario con los datos proporcionados
            $_SESSION['user']->insertUser($email, $saludo, $nombre, $apellidos, $fecha_nacimiento, $pwd, $telefono, $direccion, $permiso);
        }
    
        // Redirecciona a la página de cuenta de usuarios con el mensaje de usuario insertado
        header("Location:".url.'?controller=producto&action=cuenta&usuarios&insertado');
    }    

    public static function addProducto(){
        session_start(); // Inicia la sesión
    
        if (isset($_POST['nombre'], $_FILES["imagen"])) { // Verifica si se han enviado los datos del producto y la imagen
            // Obtiene los detalles del nuevo producto del formulario
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria_id'];
    
            $directory = "img/products/"; // Directorio donde se almacenarán las imágenes de los productos
            $file = $directory . basename($_FILES["imagen"]["name"]); // Ruta completa para el archivo de imagen
    
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $file)) { // Intenta mover el archivo de imagen al directorio especificado
                // Llama al método 'insertProduct()' para agregar el nuevo producto al sistema
                $_SESSION['user']->insertProduct($nombre, $file, $descripcion, $precio, $categoria_id);
            } else {
                echo "Hubo un error al subir el archivo."; // Muestra un mensaje de error si falla la carga del archivo
            }
        }
    
        header("Location:".url.'?controller=producto&action=cuenta&productos&insertado'); // Redirecciona a la página de cuenta de productos con un mensaje de inserción exitosa
    }    

    public static function valoraciones(){
        session_start(); // Inicia la sesión
        
        if(isset($_SESSION['user'])){ // Verifica si hay un usuario en sesión
            $user = $_SESSION['user'];
            if(PedidosBBDD::tienePedidosUser($user->getId())){
                $pedidosUser = PedidosBBDD::getPedidosByUser($user->getId());
            }

            
            // Incluye los archivos de la cabecera, la página de creación y el pie de página
            include_once 'views/header.php';
            include_once 'views/valoraciones.php';
            include_once 'views/footer.php';
        }else {
            header("Location:".url.'?controller=producto&action=login');
        }

        
    }    
}

