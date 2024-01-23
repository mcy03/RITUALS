<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleLogin.css">
    <title>Login Rituals</title>
</head>
<body>
    <div class="contenido">

        <div class="back-button">
            <img id="menor-que" src="img/menorQue.svg" alt=""> <a href=<?=url.'?controller=producto&action='.$return_page?> class="text-back-button">VOLVER</a>
        </div>

        <div class="carrito-header">
            <h1 class="carrito-title"><?=$title?></h1>
        </div>

        <div class="containder-fluid">
            <div class="row">
                <div class="col-6 col-lg-6 col-md-12 col-sm-12">
                    <section class="cont cont-form-login">
                        <?php if (isset($sign)) { ?>
                            <form action=<?=url.'?controller=producto&action=sign'?> method="post">
                            <label for="email">Dirección de correo electrónico</label>
                            <br>
                            <input class="input-text email" name="email-mostrar" disabled type="email" value=<?= $correo ?>>
                            <input name="email" type="hidden" value=<?= $correo ?>>
                            <br>

                            <label for="saludo">Saludo</label>
                            <br>
                            <select id="saludo" name="saludo">
                                <option value="mujer">Mujer</option>
                                <option value="hombre">Hombre</option>
                                <option value="otros">Otros</option>
                            </select>
                            <br>
                            
                            <label for="name">Nombre</label>
                            <br>
                            <input  class="input-text" name="name" type="text" placeholder="Nombre..." required>
                            <br>

                            <label for="apellidos">Apellidos</label>
                            <br>
                            <input class="input-text" name="apellidos" type="text" placeholder="Apellidos..." required>
                            <br>

                            <label for="nacimiento">Fecha de nacimiento</label>
                            <br>
                            <input class="input-text" name="nacimiento" type="date" required>
                            <br>

                            <label for="pwd">Contraseña</label>
                            <br>
                            <input class="input-text" name="pwd" type="password" required placeholder="Contraseña..." required>

                            <label for="telefono">Telefono</label>
                            <br>
                            <input class="input-text" name="telefono" type="tel" placeholder="Por ejemplo: +34 623 919 191" required>
                            <br>

                            <label for="direccion">Dirección</label>
                            <br>
                            <input class="input-text" name="direccion" type="text" placeholder="Dirección... (No obligatoria)">
                            <br>

                            <p class="politicas">* Rituals utilizará tus datos personales como se describe en nuestra <a href="#" class="enlace-politicas"> Política de privacidad.</a></p>
                            <p class="politicas pol-2">Al hacer clic en “CONTINUAR", confirmas que aceptas los <a href="#" class="enlace-politicas">Términos y condiciones de My Rituals.</a></p>
                        <?php }else{ ?>
                            <?php if (isset($pwd_error)) { ?>
                                <div class="error-message">
                                    <p class="p-error">Lo sentimos, estos datos no coinciden con nuestros registros. Revisa la ortografía e inténtalo de nuevo.</p>
                                </div>
                            <?php  } ?>
                        <form action=<?=url.'?controller=producto&action=login'?> method="post">
                            <label for="email">Dirección de correo electrónico</label>
                            <br>
                            <?php if ($correct_email){ ?>
                                <input class="input-text" name="email" type="email" value=<?= $correo ?> required>
                                <br>
                                <label for="pwd">Contraseña</label>
                                <br>
                                <input class="input-text" name="pwd" type="password" placeholder="Contraseña..." required>
                            <?php  }else{ ?>
                                <input class="input-text" name="email" type="email" placeholder="Correo electrónico" required>
                            <?php  }?>
                        <?php } ?>
                            <button class="btn btn-dark">CONTINUAR</button>
                        </form>
                        
                    </section>
                </div>
                <div class="col-6 col-lg-6 col-md-12 col-sm-12">
                    <section class="cont cont-ventajas">
                        <span class="ventajas-subtitle">Únete a&nbsp;My Rituals</span>
                        <h3 class="ventajas-title">Lo que consigues al hacerte miembro de My Rituals</h3>
                        <ul class="ventajas-list">
                            <li>
                                <img src="img/verificacion.png" alt="check ventajas" class="check">
                                <span>Maravillosas sorpresas y regalos</span>
                            </li>
                            <li>
                                <img src="img/verificacion.png" alt="check ventajas" class="check">
                                <span>Invitaciones para eventos exclusivos</span>
                            </li>
                            <li>
                                <img src="img/verificacion.png" alt="check ventajas" class="check">
                                <span>Inspiración y ofertas personalizadas</span>
                            </li>
                        </ul>
                        <div class="img-cinta">
                            <img src="img/decoracion-cinta.svg" alt="cinta esquina">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="./scripts/login.js"></script>
</body>
</html>