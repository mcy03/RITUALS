<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleCuenta.css">
    <title>Mi cuenta Rituals</title>
</head>
<body>
    <input type="hidden" name="id_user_js" value="<?=$user->getId()?>">
    <div class="content">
        <div class="title">
            <img class="user-img" src="img/user-icon-black.png" alt=""><h1><a href=<?=url.'?controller=producto&action=cuenta&account'?>><?= $user->getName()." ".$user->getApellidos() ?></a></h1>
        </div>
        
        <div class="containder-fluid">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <hr class="separate">
                    <section class="menu-opciones">
                        <ul>
                            <li><a href=<?=url.'?controller=producto&action=cuenta&datosPersonales'?>><img src="img/lista-icon.png" alt="icono datos personales usuario"> Datos Personales</a></li>
                            <li><a href=<?=url.'?controller=producto&action=cuenta&misPedidos'?>><img src="img/carrito-icon-black.png" alt="icono pedidos usuario"> Mis Pedidos</a></li>
                            <?php if($user->getPermiso() != 0){ ?>
                                <li>> Admin</li>
                                <li><a href=<?=url.'?controller=producto&action=cuenta&pedidos'?>><img src="img/gestionPedidos.png" alt="icono gestión de pedidos"> Gestionar Pedidos</a></li>
                                <li><a href=<?=url.'?controller=producto&action=cuenta&usuarios'?>><img src="img/users.png" alt="icono gestion de usuarios"> Gestionar Usuarios</a></li>
                                <li><a href=<?=url.'?controller=producto&action=cuenta&productos'?>><img src="img/productos.png" alt="icono gestion productos"> Gestionar Productos</a></li>
                            <?php } ?>
                            <li><a href=<?=url.'?controller=producto&action=cerrar'?>><img src="img/salida.png" alt="icono cerrar sesiñon"> Cerrar Sesión</a></li>
                        </ul>
                    </section>
                    <hr class="separate">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-8">
                    <hr class="separate">
                    <?php if (isset($_GET["account"])) { ?>
                        <section class="data-user">
                            <div class="subtitle">
                                <img class="user-img" src="img/user-icon-black.png" alt="inono de cuenta de usuario"><h2>MY RITUALS</h2>
                            </div>
                            <div class="member-card">
                                <div class="info-card">
                                    <p class="gratitud">GRATITUD</p>
                                    <p class="name-user"><?= $user->getName()." ".$user->getApellidos() ?></p>
                                    <P class="user-code">2622776745466</P>
                                </div>
                            </div>
                        </section>
                        <section class="extra-info">
                            <div class="containder-fluid">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-8 col-lg-6">
                                        <div class="detalles-personales">
                                            <div class="subtitle">
                                                <img class="user-img" src="img/lista-icon.png" alt="icono detalles usuario"><h2>DETALLES PERSONALES</h2>
                                            </div>
                                            <div class="info-extra-content">
                                                <p><?= $user->getName()." ".$user->getApellidos() ?></p>
                                                <p><?= $user->getEmail() ?></p>
                                                <p><?= str_replace('-', '/', $user->getFechaNacimiento()) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-8 col-lg-6">
                                        <div class="direccion-envio">
                                            <div class="subtitle">
                                                <img class="user-img" src="img/ubicacion.png" alt="icono direccion usuario"><h2>DIRECCIÓN DE FACTURACIÓN</h2>
                                            </div>
                                            <div class="info-extra-content">
                                                <?php if ($user->getDir() != NULL) { ?>
                                                    <p><?= $user->getDir() ?></p>
                                                <?php }else{ ?>
                                                    <a href=<?=url.'?controller=producto&action=cuenta&datosPersonales'?>>AÑADIR DIRECCION</a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php }elseif(isset($_GET["datosPersonales"])) {  ?>
                        <section class="datosPersonalesSection">
                            <div class="subtitle datosPersonales">
                                <h2><img src="img/lista-icon.png" alt="icono datos personales usuario">Datos Personales</h2>
                            </div>
                            <form class="form-info-user" action=<?=url.'?controller=producto&action=updateUser'?> method="post">
                                <label for="email">Dirección de correo electrónico</label>
                                <br>
                                <input class="input-text" name="emailMostrar" disabled type="email" value=<?= $user->getEmail() ?>>
                                <input class="input-text" name="email" type="hidden" value=<?= $user->getEmail() ?>>
                                <br>

                                <label for="saludo">Saludo</label>
                                <br>
                                <select id="saludo" name="saludo" required>
                                    <option value="mujer">Mujer</option>
                                    <option value="hombre">Hombre</option>
                                    <option value="otros" selected>Otros</option>
                                </select>
                                <br>
                                
                                <label for="name">Nombre</label>
                                <br>
                                <input  class="input-text" name="name" type="text" required value="<?= $user->getName() ?>">
                                <br>

                                <label for="apellidos">Apellidos</label>
                                <br>
                                <input class="input-text" name="apellidos" type="text" required value="<?= $user->getApellidos() ?>">
                                <br>

                                <label for="nacimiento">Fecha de nacimiento</label>
                                <br>
                                <input class="input-text" name="nacimiento" type="date" required value="<?= $user->getFechaNacimiento() ?>">
                                <br>

                                <label for="pwd">Contraseña</label>
                                <br>
                                <input class="input-text" name="pwd" type="password" required placeholder="Contraseña actual...">
                                <?php if($_GET["datosPersonales"] == "error"){  ?>
                                    <p class="pwd_error">Contraseña incorrecta</p>
                                <?php } ?>
                                
                                <label for="telefono">Telefono</label>
                                <br>
                                <input class="input-text" name="telefono" type="tel" required value="<?= $user->getPhone() ?>">
                                <br>

                                <label for="direccion">Dirección</label>
                                <br>
                                <input class="input-text" name="direccion" type="text" value="<?= $user->getDir() ?>">
                                <br>

                                <button class="btn btn-dark">CONTINUAR</button>
                            </form>
                        </section>
                    <?php }elseif(isset($_GET["misPedidos"])) {  ?>
                            <section class="pedidosUser">
                                <div class="subtitle">
                                    <h2><img src="img/carrito-icon-black.png" alt="icono pedidos usuario"> HISTORIAL DE PEDIDOS</h2>
                                </div>
                                <?php if(!isset($_POST["pedido_id"])) {  ?>
                                    <?php if ($hayPedidos) { ?>
                                        <table>
                                            <tr>
                                                <td class="tituloTabla">ID</td>
                                                <td class="tituloTabla">USUARIO</td>
                                                <td class="tituloTabla">ESTADO</td>
                                                <td class="tituloTabla">FECHA DEL PEDIDO</td>
                                                <td class="tituloTabla">PRECIO TOTAL</td>
                                            </tr>
                                            <?php foreach (array_reverse($pedidos_user) as $pedidos) { ?>
                                                <tr>
                                                    <td><?= $pedidos->getId() ?></td>
                                                    <td><?= $pedidos->getUserId() ?></td>
                                                    <td><?= $pedidos->getEstado() ?></td>
                                                    <td><?= $pedidos->getFechaPedido() ?></td>
                                                    <td><?= ProductosPedidosDAO::calcPricePedidoById($pedidos->getId()) ?> €</td>
                                                    <form action="#" method="post">
                                                        <input type="hidden" name="pedido_id" value= "<?=$pedidos->getId()?>">
                                                        <td><button type="submit">VER</button></td>
                                                    </form>
                                                </tr>
                                                <tr>    
                                                    <td colspan=5 class="td_separate"><hr class="separate"></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php }else { ?>
                                        <p><?= PedidosBBDD::tienePedidosUser($user->getId()) ?></p>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <table>
                                        <tr>
                                            <td class="tituloTabla"></td>
                                            <td class="tituloTabla">PRODUCTO</td>
                                            <td class="tituloTabla">CANTIDAD</td>
                                            <td class="tituloTabla">PRECIO</td>
                                        </tr>
                                        <?php foreach ($productosPedido as $productos) { ?>
                                            <?php $producto = Producto::getProductById($productos->getProductoId())?>
                                            <tr>
                                                <td class="td-img"><img class="img-product" src="<?= $producto->getImg() ?>" alt="imagen de producto del pedido"></td>
                                                <td><?= $producto->getName() ?></td>
                                                <td><?= $productos->getCantidad() ?></td>
                                                <td><?= $productos->calcPrice() ?> €</td>
                                            </tr>
                                            <tr>    
                                                <td colspan=5 class="td_separate"><hr class="separate"></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>    
                                            <td></td>
                                            <td>
                                                <form action=<?=url.'?controller=producto&action=recuperarPedido'?> method="post">
                                                    <input type="hidden" name="pedido_id" value= "<?= $_POST["pedido_id"] ?>">
                                                    <button type="submit">RECUPERAR PEDIDO</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } ?>
                            </section>
                    <?php } ?>
                    <?php if($user->getPermiso() != 0){ ?>
                        <?php if(isset($_GET["pedidos"])){ ?>
                            <section class="gestionPedidos">
                                <div class="subtitle">
                                    <div class="titulo">
                                        <h2><img src="img/gestionPedidos.png" alt="icono gestiñon de pedidos"> GESTIONAR PEDIDOS</h2>
                                    </div>
                                    
                                    <div class="cont-añadir">
                                        <form action=<?=url.'?controller=producto&action=accionPedido'?> method="post">
                                            <button type="submit" name="anadir">AÑADIR</button>
                                        </form>
                                    </div>
                                    <?php if (isset($mensaje)) { ?>
                                        <div class="error">
                                            <p style='color: <?=$color?>;'><?=$mensaje?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                                <table class="tableAll">
                                    <tr>
                                        <td class="tituloTabla">ID</td>
                                        <td class="tituloTabla">USUARIO</td>
                                        <td class="tituloTabla">ESTADO</td>
                                        <td class="tituloTabla">FECHA DEL PEDIDO</td>
                                        <td class="tituloTabla">PRECIO TOTAL</td>
                                    </tr>
                                    <?php foreach (array_reverse($todos_pedidos) as $all_comands) { ?>
                                        <tr>
                                            <td><?= $all_comands->getId() ?></td>
                                            <td><?= $all_comands->getUserId() ?></td>
                                            <td><?= $all_comands->getEstado() ?></td>
                                            <td><?= $all_comands->getFechaPedido() ?></td>
                                            <td><?= ProductosPedidosDAO::calcPricePedidoById($all_comands->getId()) ?> €</td>
                                            <form action=<?=url.'?controller=producto&action=accionPedido'?> method="post">
                                                <input type="hidden" name="pedido_id" value= "<?=$all_comands->getId()?>">
                                                <td class="button-form">
                                                    <button type="submit" name="editar">MODIFICAR</button>
                                                    <button type="submit" name="eliminar">ELIMINAR</button>
                                                </td>
                                            </form>
                                        </tr>
                                        <tr>    
                                            <td colspan=5 class="td_separate"><hr class="separate"></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                        
                        <?php }elseif(isset($_GET["usuarios"])){ ?>
                            <section class="gestionUsuarios">
                                <div class="subtitle">
                                    <div class="titulo">
                                        <h2><img src="img/users.png" alt="icono gestiñon de usuarios"> GESTIONAR USUARIOS</h2>
                                    </div>
                                    
                                    <div class="cont-añadir">
                                        <form action=<?=url.'?controller=producto&action=accionUsuario'?> method="post">
                                            <button type="submit" name="anadir">AÑADIR</button>
                                        </form>
                                    </div>
                                    <?php if (isset($mensaje)) { ?>
                                        <div class="error">
                                            <p style='color: <?=$color?>;'><?=$mensaje?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                                
                                <table class="tableAll">
                                    <tr>
                                        <td class="tituloTabla">USUARIO_ID</td>
                                        <td class="tituloTabla">EMAIL</td>
                                        <td class="tituloTabla">NOMBRE</td>
                                        <td class="tituloTabla">TELEFONO</td>
                                    </tr>
                                    <?php foreach (array_reverse($todos_usuarios) as $all_users) { ?>
                                        <tr>
                                            <td><?= $all_users->getId() ?></td>
                                            <td><?= $all_users->getEmail() ?></td>
                                            <td><?= $all_users->getName() ?></td>
                                            <td><?= $all_users->getPhone() ?></td>
                                            <form action=<?=url.'?controller=producto&action=accionUsuario'?> method="post">
                                                <input type="hidden" name="usuario_id" value= "<?=$all_users->getId()?>">
                                                <td class="button-form">
                                                    <button type="submit" name="editar">MODIFICAR</button>
                                                    <button type="submit" name="eliminar">ELIMINAR</button>
                                                </td>
                                            </form>
                                        </tr>
                                        <tr>    
                                            <td colspan=5 class="td_separate"><hr class="separate"></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                        
                        <?php }elseif(isset($_GET["productos"])){ ?>
                            <section class="gestionProductos">
                                <div class="subtitle">
                                    <div class="titulo">
                                        <h2><img src="img/productos.png" alt="icono gestiñon de productos"> GESTIONAR PRODUCTOS</h2>
                                    </div>
                                    
                                    <div class="cont-añadir">
                                        <form action=<?=url.'?controller=producto&action=accionProducto'?> method="post">
                                            <button type="submit" name="anadir">AÑADIR</button>
                                        </form>
                                    </div>

                                    <?php if (isset($mensaje)) { ?>
                                        <div class="error">
                                            <p style='color: <?=$color?>;'><?=$mensaje?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                                <table class="tableAll">
                                    <tr>
                                        <td class="tituloTabla">ID</td>
                                        <td class="tituloTabla">IMAGEN</td>
                                        <td class="tituloTabla">NOMBRE</td>
                                        <td class="tituloTabla">PRECIO UNIDAD</td>
                                    </tr>
                                    <?php foreach (array_reverse($todos_productos) as $all_products) { ?>
                                        <tr>
                                            <td><?= $all_products->getId() ?></td>
                                            <td><img src="<?= $all_products->getImg() ?>" alt="imagen del produto"></td>
                                            <td><?= $all_products->getName() ?></td>
                                            <td><?= $all_products->getPrice() ?> €</td>
                                            <form action=<?=url.'?controller=producto&action=accionProducto'?> method="post">
                                                <input type="hidden" name="producto_id" value= "<?=$all_products->getId()?>">
                                                <td class="button-form">
                                                    <button type="submit" name="editar">MODIFICAR</button>
                                                    <button type="submit" name="eliminar">ELIMINAR</button>
                                                </td>
                                            </form>
                                        </tr>
                                        <tr>
                                            <td colspan=5 class="td_separate"><hr class="separate"></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                        
                        <?php } ?>
                        </section>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/notie"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script src="./scripts/cuenta.js"></script>
</body>
</html>