<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleEditCreatePage.css">
    <title>Edit Page</title>
</head>
<body>
    <div class="contenido containder-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <section class="cont cont-form-edit">
                    <?php if(isset($pedido)) { ?>
                        <form action=<?=url.'?controller=producto&action=editarPedido'?> method="post">
                            <label for="pedido_id_dis">Id pedido</label>
                            <input type="number" disabled id="pedido_id_dis" name="pedido_id_dis" value=<?= $pedido->getId() ?>>
                            <input type="hidden"  name="pedido_id" value="<?=$pedido->getId()?>">

                            <label for="usuario_id">Id usuario</label>
                            <input type="number" id="usuario_id" name="usuario_id" required value="<?=$pedido->getUserId()?>">


                            <label for="estado">Estado pedido</label>
                            <select id="estado" name="estado">
                                <option value="EN PREPARACIÓN">EN PREPARACIÓN</option>
                                <option value="EN REPARTO">EN REPARTO</option>
                                <option value="RECIBIDO">RECIBIDO</option>
                            </select>

                            <label for="fecha">Fecha</label>
                            <input type="date" id="fecha" name="fecha" required value="<?=$pedido->getFechaPedido()?>">

                            <button name="update">ACTUALIZAR</button>
                        </form>

                    <?php }elseif(isset($usuario)) { ?>
                        <form action=<?=url.'?controller=producto&action=editarUsuario'?> method="post">
                            <label for="usuario_id_dis">Id usuario</label>
                            <input type="number" disabled id="usuario_id_dis" name="usuario_id_dis" value=<?= $usuario->getId() ?>>
                            <input type="hidden"  name="usuario_id" value="<?=$usuario->getId()?>">

                            <label for="email">Dirección de correo electrónico</label>
                            <input class="input-text" disabled name="email_dis" type="email" value=<?= $usuario->getEmail() ?>>
                            <input class="input-text" name="email" type="hidden" value=<?= $usuario->getEmail() ?>>

                            <label for="saludo">Saludo</label>
                            <select id="saludo" name="saludo" required>
                                <option value="Mujer">Mujer</option>
                                <option value="Hombre">Hombre</option>
                                <option value="Otros" selected>Otros</option>
                            </select>
                                
                            <label for="nombre">Nombre</label>
                            <input  class="input-text" name="nombre
                            " type="text" required value="<?= $usuario->getName() ?>">

                            <label for="apellidos">Apellidos</label>
                            <input class="input-text" name="apellidos" type="text" required value="<?= $usuario->getApellidos() ?>">

                            <label for="nacimiento">Fecha de nacimiento</label>
                            <input class="input-text" name="nacimiento" type="date" required value="<?= $usuario->getFechaNacimiento() ?>">

                            <label for="telefono">Telefono</label>
                            <input class="input-text" name="telefono" type="number" required value="<?= $usuario->getPhone() ?>">

                            <label for="direccion">Dirección</label>
                            <input class="input-text" name="direccion" type="text" required value="<?= $usuario->getDir() ?>">

                            <button name="update">ACTUALIZAR</button>
                        </form>

                    <?php }elseif(isset($producto)) { ?>
                        <form action=<?=url.'?controller=producto&action=editarProducto'?> method="post">
                            <label for="producto_id_dis">Id producto</label>
                            <input type="number" disabled id="producto_id_dis" name="producto_id_dis" value=<?= $producto->getId() ?>>
                            <input type="hidden"  name="producto_id" value="<?=$producto->getId()?>">

                            <label for="nombre">Nombre producto</label>
                            <input type="text" id="nombre" name="nombre" required value="<?=$producto->getName()?>">

                            <label for="imagen">Imagen </label>
                            <input type="file" id="imagen" name="imagen">

                            <label for="descripcion">Descripcion</label>
                            <input type="text" id="descripcion" name="descripcion" required value="<?=$producto->getDesc()?>">

                            <label for="precio">Precio</label>
                            <input type="double" id="precio" name="precio" required value="<?=$producto->getPrice()?>">

                            <label for="categoria">Categoria</label>
                            <select name="categoria" id="categoria" >
                                <option value=<?=$categoria_producto->getCategoriaId()?> selected><?=$categoria_producto->getName()?></option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value=<?=$categoria->getCategoriaId()?>><?=$categoria->getName()?></option>
                                <?php } ?>
                            </select>

                            <button name="update">ACTUALIZAR</button>
                        </form>

                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>