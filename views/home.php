<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleHome.css">
    <title>Home Rituals</title>
</head>
<body class="mx-auto">
    <div class="div-body">
        <section class="banner container-fluid d-flex flex-column">
        
                <div class="p-2">
                    <img src="img/rituals.svg" alt="Logo ritals svg para banner principal">
                </div>
                <div class="p-2">
                    <h1>Fruit essence cocktail</h1>
                </div>
                <div class="p-2">
                    <p class = "content">Acompaña un acontecimiento especial con una bebida especial "Fruit essence cocktail" es la opcion idonea para estas fiestas.</p>
                </div>
                <div class="p-2">
                    <button href=<?=url.'?controller=producto&action=carta&cat=Fruit%20essence%20cocktail'?> type="button" class="btn btn-outline-light">SOLO ESTE FIN DE SEMANA</button> 
                </div>
        </section>

        <section class="slide">
            <div class="slide-inner">
                <input class="slide-open" type="radio" id="slide-1" 
                    name="slide" aria-hidden="true" hidden="" checked="checked">
                <div class="slide-item">
                    <div>
                        <h3>A TU SERVICIO</h3>
                        <p>Entrega gratis a pedidos de 25€ o más en artículos</p>
                    </div>
                </div>
                <input class="slide-open" type="radio" id="slide-2" 
                    name="slide" aria-hidden="true" hidden="">
                <div class="slide-item">
                    <div>    
                        <h3>CREA TU CUENTA</h3>
                        <p>Crea tu cuenta en dos sencillos pasos <a href="<?=url.'?controller=producto&action=login'?>">aquí.</a></p>
                    </div>
                </div>
                <input class="slide-open" type="radio" id="slide-3" 
                    name="slide" aria-hidden="true" hidden="">
                <div class="slide-item">
                    <div>
                        <h3>PRODUCTOS 100% ECOLÓGICOS</h3>
                        <p>Disfruta de nuestros productos 100% ecológicos.</p>
                    </div>
                </div>

                <ol class="slide-indicador">
                    <li>
                        <label for="slide-1" class="slide-circulo">•</label>
                    </li>
                    <li>
                        <label for="slide-2" class="slide-circulo">•</label>
                    </li>
                    <li>
                        <label for="slide-3" class="slide-circulo">•</label>
                    </li>
                </ol>
            </div>
        </section>

        <section class="publi-entradas d-flex justify-content-around">
            <div class="publi card">
                <div class="card-body">
                    <h3>RITUALS RESTAURANT</h3>
                    <h2 class="card-title">The Rituals Restaurant</h2>
                    <p class="card-text">Visita nuestro local y prueba nuestros cocteles donde tenemos desde clasicos como invenciones propias para tu disfrute.</p>
                    <a href=<?=url.'?controller=producto&action=carrito'?> class="boton-simple btn btn-primary">COMPRAR AHORA</a>
                </div>
                <img src="img/cocteleria.jfif" class="card-img-top" alt="img cocteleria anuncio home">
            </div>
            <div class="publi card">
                <div class="card-body">
                <h3>9 COCTELES DISTINTOS A DEGUSTAR</h3>
                <h2 class="card-title">Fruit Essence Cocktail</h2>
                <p class="card-text">Una colección de cócteles que capturan la esencia de diversas frutas para liberar tu potencial*€</p>
                <a href=<?=url.'?controller=producto&action=carta&cat=Fruit%20essence%20cocktail'?> class="boton-simple btn btn-primary">DESCUBRIR</a>
                </div>
                <img src="img/anunciosHome.jpg" class="card-img-top" alt="img publicidad de nueva colección de productos">
            </div>
        </section>

        <section class="slider-categorias">
            <div class="intro card">
                <div class="card-body">
                    <h3>NUEVA EDICIÓN LIMITADA</h3>
                    <h2 class="card-title">Fruit Essence Cocktail</h2>
                    <p class="card-text">Descubre nuestra nueva edición limitada de 9 cócteles a base de concentrado de diversas esencias de frutas.</p>
                    <a href=<?=url.'?controller=producto&action=carta&cat=Fruit%20essence%20cocktail'?> class="boton-simple btn btn-primary">COMPRAR AHORA</a>
                </div>
            </div>
            <?php foreach($productos_cat_a as $productosA){?>
                <div class="cartaProducto card">
                    <div class="containerProduct">
                        <img src="<?=$productosA->getImg()?>" class="card-img-top" alt="imagen del producto">
                    </div>
                    <div class="bodyProduct card-body">
                        <h4 class="card-title"><?=$productosA->getName()?></h4>
                        <p class="card-text"><?=$productosA->getDesc()?></p>
                        <div class= "priceCarrito">
                            <p class="price"><?=$productosA->getPrice()?>€</p>

                            <a href=<?=url.'?controller=producto&action=sel&producto_id='.$productosA->getId()?>><img src="img/boton_carrito.png" alt="boton añadir producto a la cesta" class="addButton"></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>

        <section class="publi-entradas d-flex justify-content-around">
            <div class="publi card">
                <div class="card-body">
                    <h3>DULCE, AFRUTADO, REFRESCANTE</h3>
                    <h2 class="card-title">Un Coctel Especial</h2>
                    <p class="card-text">Con toques de melocotón, ron y manzana, nuestro nuevo cóctel Tom Collins contiene productos frescos de kilometro 0.</p>
                    <a href=<?=url.'?controller=producto&action=carta&cat=Fruit%20essence%20cocktail'?> class="boton-simple btn btn-primary">COMPRAR AHORA</a>
                </div>
                <img src="img/imgSeccionPubli1.png" class="card-img-top" alt="publicidad coleccion cocteles">
            </div>
            <div class="publi card">
                <div class="card-body">
                <h3>NUEVOS SABORES</h3>
                <h2 class="card-title">Baileys Y Café</h2>
                <p class="card-text">Descubre nuestros nuevos cocteles con Baileys o café como ingrediente principal</p>
                <a href=<?=url.'?controller=producto&action=carta&cat=Café%20fusion'?> class="boton-simple btn btn-primary">COMPRAR AHORA</a>
                </div>
                <div class="cont-img-publi">
                    <img src="img/imgSeccionPubli2.jpg" class="card-img-top" alt="publicidad coleccion cocteles">
                </div>
                
            </div>
        </section>

        <section class="slider-categorias">
            <div class="intro card">
                <div class="card-body">
                    <h3>NUEVA EDICIÓN</h3>
                    <h2 class="card-title">Colección BreezeBliss</h2>
                    <p class="card-text">Una explosión de frescura y sabores frutales que despiertan tu poder interior. ¿Listo para el viaje?</p>
                    <a href=<?=url.'?controller=producto&action=carta&cat=BreezeBills'?> class="boton-simple btn btn-primary">COMPRAR AHORA</a>
                </div>
            </div>
            <?php foreach($productos_cat_b as $productosB){?>
                <div class="cartaProducto card">
                    <div class="containerProduct">
                        <img src="<?=$productosB->getImg()?>" class="card-img-top" alt="imagen producto">
                    </div>
                    <div class="bodyProduct card-body">
                        <h4 class="card-title"><?=$productosB->getName()?></h4>
                        <p class="card-text"><?=$productosB->getDesc()?></p>
                        <div class= "priceCarrito">
                            <p class="price"><?=$productosB->getPrice()?>€</p>
                            <a href=<?=url.'?controller=producto&action=sel&producto_id='.$productosB->getId()?>><img src="img/boton_carrito.png" alt="añadir producto al carrito" class="addButton"></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
</div>
</body>
</html> 