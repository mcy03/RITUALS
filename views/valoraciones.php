<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Incluye FontAwesome (asegúrate de tener una conexión a Internet para cargar los íconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleValoraciones.css">
    
    
    <title>Valoraciones rituals</title>
</head>
<body>
    <div class="contenido containder-fluid">
        <div class="row d-flex justify-content-center">
            <section class="col-12 col-sm-12 col-md-10 col-lg-10 cont">
                <div class="title">
                    <h2>Deja tu reseña sobre nosotros</h2>
                </div>
                <div class="resena">
                    <form id="formularioValoracion">
                        <div class="user-resena">
                            <img class="img-user" src="./img/user-icon-black.png" alt="">
                            <input type="text" disabled id="nombre_dis" value="<?= $user->getName() ?> <?= $user->getApellidos() ?>">
                            <input type="hidden" id="nombre" name="nombre" value="<?= $user->getName() ?> <?= $user->getApellidos() ?>">
                        </div>  
                        <div class="form-resena">  
                            <div class="container-inputs">
                                <div class="cont-id-pedido">
                                    <label for="pedido" class="label-id-pedido">Pedido</label>
                                    <select name="pedido" id="pedido">
                                        <option value="undefined" selected>Mis pedidos</option>
                                        <?php foreach ($pedidosUser as $pedido) { ?>
                                            <option value="<?= $pedido->getId() ?>"><?= $pedido->getId() ?></option>
                                        <?php } ?>
                                    </select>
                                </div>  
                            
                                <div class="valoracion">  
                                    <label for="valoracion-label">Valoración</label>
                                    <p class="clasificacion">
                                        <input class="input-estrella" id="radio1" type="radio" name="estrellas" value="5">
                                        <label class="label-estrella" for="radio1">★</label>
                                        <input class="input-estrella" id="radio2" type="radio" name="estrellas" value="4">
                                        <label class="label-estrella" for="radio2">★</label>
                                        <input class="input-estrella" id="radio3" type="radio" name="estrellas" value="3">
                                        <label class="label-estrella" for="radio3">★</label>
                                        <input class="input-estrella" id="radio4" type="radio" name="estrellas" value="2">
                                        <label class="label-estrella" for="radio4">★</label>
                                        <input class="input-estrella" id="radio5" type="radio" name="estrellas" value="1">
                                        <label class="label-estrella" for="radio5">★</label>
                                    </p>
                                </div>
                            </div>
                            <input type="text" id="input-asunto" placeholder="Asunto">
                            <textarea name="resena" id="comentario" cols="100" rows="10" required placeholder="Cuéntale a otros usuarios tu experiencia en nuestra página..." data-bs-toggle="tooltip" title="valoración del pedido"></textarea>

                            <button type="submit">Enviar Valoración</button>
                        </div>
                    </form>
                </div>
            </section>
            <section class="col-12 col-sm-12 col-md-10 col-lg-10 cont cont-resenas">
                <div class="cont-title-filter">
                    <div class="title">
                        <h2>Reseñas</h2>
                    </div>
                    <div class="filtro">
                        <label for="orden">Puntuación: </label>
                        <select name="orden" id="orden" >
                            <option value="">Orden</option>
                            <option value="ASC">Ascendente</option>
                            <option value="DESC">Descendiente</option>
                        </select>
                        <input type="number" id="filtro-input" placeholder="Puntuación" min="1" max="5">
                    </div>
                </div>
                <div id="resenas">
                    
                </div>

            </section>
        </div>
    </div>
    <script src="https://unpkg.com/notie"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./scripts/valoraciones.js"></script>
</body>
</html>
