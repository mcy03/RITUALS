<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleCarrito.css">
    <title>Carrito Rituals</title>
</head>
<body class="mx-auto">
    <div class="div-body">
        <div class="back-button">
            <img id="menor-que" src="img/menorQue.svg" alt="icono back button"> <a href=<?=url.'?controller=producto&action=carta'?> class="text-back-button">SEGUIR COMPRANDO</a>
        </div>
        <div class="container">
            <div class="row">
                <?php if (isset($sinProductos)) { ?>
                    <div class="columna1 col-12 col-sm-12 col-md-10 col-lg-8">
                        <section class="carritoVacio">
                            <div class="carrito-header">
                                <h1 class="carrito-title">Mi cesta de la compra</h1>
                            </div>
                            <div class="view-carrito-vacio">
                                <div class="card-list-header">
                                    <h2 class="text-header header-vacio">¡Vaya, está vacía! Llénala de alegría</h2>
                                </div>
                                <div class="button-header">
                                    <a href="<?=url.'?controller=producto&action=carta'?>" class="btn btn-carrito-vacio">VAMOS DE COMPRAS</a>
                                </div>
                            </div>
                        </section>
                    </div>

                <?php }else { ?>
                    <div class="columna1 col-12 col-sm-8 col-md-8 col-lg-8">
                        <section class="command ">
                            <div class="carrito-header">
                                <h1 class="carrito-title">Mi cesta de la compra</h1>
                            </div>
                            <div class="view-comand">
                                <div class="card-list-header">
                                    <h2 class="text-header">Tus artículos</h2>
                                </div>
                                <div class="card-list-columns">
                                    <h3 class="title-column title-column-prod">Productos</h3>
                                    <h3 class="title-column title-column-cat">Cantidad</h3>
                                    <h3 class="title-column title-column-price">Precio</h3>
                                </div>
                                <?php 
                                $pos = 0;
                                foreach($_SESSION['selecciones'] as $pedido){ ?>
                                    <hr class="separate">
                                    <div class="div-product">
                                        <div class="img-product">
                                            <img src=<?=$pedido->getProducto()->getImg()?> class="card-img-top" alt="imagen producto seleccionado en el carrito">
                                        </div>
                                        <form action=<?=url.'?controller=producto&action=carrito'?> method="post">
                                            <div class="info-product">
                                                <h5 class="cat-product"><?=mb_strtoupper(Categoria::getCatNameById($pedido->getProducto()->getCat()),"UTF-8")?></h5>
                                                <h4 class="name-product"><?=ucwords($pedido->getProducto()->getName())?></h4>
                                                <button type="submit" name="destroy" value=<?=$pos?> class="eliminar btn btn-link"><img src="img/icon-eliminar.svg" alt="icono X eliminar producto carrito">Eliminar</button>
                                            </div>
                                        </form>
                                        <form action=<?=url.'?controller=producto&action=carrito'?> method="post">
                                            <div class="d-flex align-items-center buttons-cant">
                                                <input type="hidden" name="pos" value=<?=$pos?>>
                                                <input type="hidden" name="cantidad" value=<?=$pedido->getCantidad()?>>
                                                <button type="submint" name="del" class="cantidad-product restar">-</button>
                                                <input  type="text" name="cantidadIntro" value=<?=$pedido->getCantidad()?> class="cantidad-product cantidad">
                                                <button type="submit" name="add" class="cantidad-product sumar">+</button>
                                            </div>
                                        </form>
                                        <div class="price-product">
                                            <p><?=CalculadoraPrecios::remplazarChar('.', ',', CalculadoraPrecios::comprobarYPasarDecimal($pedido->calcPrice()))?> €</p>
                                        </div>
                                    </div>
                                <?php 
                                    $pos++;
                                } ?>
                            </div>
                        </section>
                        
                    </div>
                    
                    <div class="columna col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <section class="resume-comand">
                            <div class="resume-body">
                                <div class="cont-resume-header">
                                    <h2 class="text-header">Resumen</h2>
                                </div>
                                <div class="cont-postal-code-sub">
                                    <p class="resume-sub-header">Consulta cuándo puedes recibir estos artículos</p>
                                </div>
                                <ul class="ventajas-list">
                                    <li><img class="img-verification" src="img/verificacion.png" alt="verificacion"><p>Envío gratis a domicilio en pedidos superiores a 35€</p></li>
                                    <li><img class="img-verification" src="img/verificacion.png" alt="verificacion"><p>Punto de recogida cercano disponible</p></li>
                                    <li><img class="img-verification" src="img/verificacion.png" alt="verificacion"><p>Click &amp; Collect gratis en una tienda Rituals cercana</p></li>
                                </ul>
                            </div>
                            <hr class="separate-resume-comand">
                            <div class="subtotal">
                                <h3 class="subtotal-text"><b>Subtotal</b></h3>
                                <h3 class="subtotal-price"><?=CalculadoraPrecios::mostrarPrecioPedido($_SESSION['selecciones'])?> €</h3>
                            </div>
                            <hr class="separate-resume-comand">
                            <div class="envio">
                                <h3 class="envio-text"><b>Coste de envío</b></h3>
                                <h3 class="envio-price"><?=CalculadoraPrecios::mostrarGastoEnvio($_SESSION['selecciones'])?></h3>
                            </div>
                            <hr class="separate-resume-comand">
                            <div id="puntosFidelidad" class="envio">
                                <h3 class="envio-text"><b>Aplicar puntos</b></h3>
                                <input type="number" name="puntos-aplicados" placeholder="%">
                            </div>
                            <hr class="separate-resume-comand">
                            <div id="propina" class="envio">
                                <h3 class="envio-text"><b>Propina</b></h3>
                                <a href="#" id="dar-propina">Dar propina</a>

                                <form id="form-propina" action="">
                                    <input type="number" name="porcentaje-propina" value="3">
                                    <input type="submit" value="Aplicar">
                                </form>

                                <div class="totalPropina">
                                    <a href="#" id="quitar-propina">Quitar</a>
                                    <h3 id="costePropina" class="envio-price"></h3>
                                </div>
                            </div>
                            <hr class="separate-resume-comand">
                            <div class="total">
                                <div class="cont-total-text">
                                    <h3 class="total-text"><b>Total</b></h3>
                                    <p class="total-impuestos-text">Impuestos incluidos</p>
                                </div>
                                <input type="hidden" name="costePedido" value="<?=CalculadoraPrecios::calculadorTotalPedido($_SESSION['selecciones'])?>">
                                <h3 class="total-price"><?=CalculadoraPrecios::calculadorTotalPedido($_SESSION['selecciones'])?> €</h3>
                            </div>
                            <hr class="separate-resume-comand">
                            <div class="cont-button-comprar">
                                <a href=<?=url.'?controller=producto&action=pagar'?> id="pagar" class="boton-simple btn btn-primary">PAGAR</a>
                            </div>
                            <div class="cont-pago-seguro">
                                <img class="candado-pago-seguro" src="img/candado.png" alt="">
                                <p class="pago-seguro"> PAGO SEGURO</p>
                            </div>
                        </section>
                    <?php } ?>
                    <?php if (isset($sinProductos)) { ?>
                        <div class="columna col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <?php } ?>
                        <?php if(isset($pedidoAnterior)){ ?>
                            <section class="recuperar-pedido">
                                <div class="view-last-comand">
                                    <div class="cont-header-last-comand">
                                        <h2 class="text-header header-last-comand">Último pedido</h2>
                                        <div class="cont-button-comprar cont-button-ver">
                                            <form action=<?=url.'?controller=producto&action=cuenta&misPedidos'?> method="post">
                                                <input type="hidden" name="pedido_id" value="<?=$infoPedidoAnterior[0]?>">
                                                <button type="submit" class="boton-simple btn btn-primary">VER</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <hr class="separate-last-comand">

                                    <div class="fila-last-comand">
                                        <h3 class="text-title-last-comant">Productos</h3>
                                        <h3 class="text-last-comant"><?= sizeOf($pedidoAnterior) ?></h3>
                                    </div>  
                                    <hr class="separate-last-comand">

                                    <div class="fila-last-comand">
                                        <h3 class="text-title-last-comant">Usuario</h3>
                                        <h3 class="text-last-comant"><?= $infoPedidoAnterior[1] ?></h3>
                                    </div>
                                    <hr class="separate-last-comand">

                                    <div class="fila-last-comand">
                                        <h3 class="text-title-last-comant">Fecha del pedido</h3>
                                        <p class="text-last-comant"><?= $infoPedidoAnterior[2] ?></p>
                                    </div>
                                    <hr class="separate-last-comand">

                                    <div class="fila-last-comand">
                                        <h3 class="text-title-last-comant">Precio total</h3>
                                        <h3 class="text-last-comant"><?= $infoPedidoAnterior[3] ?></h3>
                                    </div>
                                    <hr class="separate-last-comand">

                                    <div class="cont-button-comprar button-recuperar">
                                        <a href=<?=url.'?controller=producto&action=recuperarPedido'?>  class="boton-simple btn btn-primary">RECUPERAR PEDIDO ANTERIOR</a>
                                    </div>
                                </div>
                            </section>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="./scripts/propinas.js"></script>
    <script src="./scripts/puntosFidelidad.js"></script>
</body>
</html>