<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleEditCreatePage.css">
    <title>Create Page</title>
</head>
<body>
    <div class="contenido containder-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <section class="cont cont-form-edit">
                    <?php if(isset($_GET['pedido'])) { ?>
                        <?php if(isset($num_products)) { ?>
                            <h2>Crear Pedido</h2>
                            <form action=<?=url.'?controller=producto&action=addPedido'?> method="post">
                                <label for="user_id">Usuario</label>
                                <select name="user_id" id="user_id" >
                                    <option value="undefined" selected>Selecciona un usuario...</option>
                                    <?php foreach ($usuarios as $usuario) { ?>
                                        <option value=<?=$usuario->getId()?>><?=$usuario->getEmail()?></option>
                                    <?php } ?>
                                </select>

                                
                                <label for="estado">Estado pedido</label>
                                <select id="estado" name="estado">
                                    <option value="undefined" selected>Selecciona un estado para el pedido...</option>
                                    <option value="EN PREPARACIÓN">EN PREPARACIÓN</option>
                                    <option value="EN REPARTO">EN REPARTO</option>
                                    <option value="RECIBIDO">RECIBIDO</option>
                                </select>

                                <input type="hidden" name="cant_products" value="<?=$num_products?>">

                                <label for="productos">Productos</label> <br>
                                <?php for ($i=0; $i < $num_products; $i = $i + 1) { ?>
                                    <select name="producto<?=$i?>" id="select_product">
                                        <option value="undefined" selected>Seleccionar producto...</option>
                                        <?php foreach ($productos as $producto) { ?>
                                            <option value="<?=$producto->getId()?>"><?=$producto->getId()?></option>
                                        <?php } ?>
                                    </select>
                                    <input name="cantidad<?=$i?>" id="input_cantidad" type="number" placeholder="Introducir cantidad"> <br>
                                <?php } ?>
                                
                                <button type="submit" name="add">AÑADIR</button>
                            </form>
                        <?php }else{ ?>
                            <form action=<?=url.'?controller=producto&action=createPage&pedido'?> method="post">
                                <label for="num_products">Cantidad de productos</label>
                                <input type="number" id="num_products" name="num_products" placeholder="Introduce la cantidad de productos del pedido...">

                                <button type="submit" name="siguiente">Siguiente</button>
                            </form>
                        <?php } ?> 
                            
                        

                    <?php }elseif(isset($_GET['usuario'])) { ?>
                        <h2>Crear Usuario</h2>
                        <form action=<?=url.'?controller=producto&action=addUsuario'?> method="post">
                            <label for="email">Dirección de correo electrónico</label>
                            <input class="input-text" name="email" type="email" >

                            <label for="saludo">Saludo</label>
                            <select id="saludo" name="saludo" required>
                                <option value="Mujer">Mujer</option>
                                <option value="Hombre">Hombre</option>
                                <option value="Otros" selected>Otros</option>
                            </select>
                                
                            <label for="nombre">Nombre</label>
                            <input  class="input-text" name="nombre" type="text" required>

                            <label for="apellidos">Apellidos</label>
                            <input class="input-text" name="apellidos" type="text" required>

                            <label for="nacimiento">Fecha de nacimiento</label>
                            <input class="input-text" name="nacimiento" type="date" required>

                            <label for="pwd">Constraseña</label>
                            <input class="input-text" name="pwd" type="password" required>

                            <label for="telefono">Telefono</label>
                            <input class="input-text" name="telefono" type="tel" required>

                            <label for="direccion">Dirección</label>
                            <input class="input-text" name="direccion" type="text" >

                            <label for="permiso">Permiso</label>
                            <select name="permiso" id="permiso">
                                <option value="usuario">Usuario</option>
                                <option value="administrador">Administrador</option>
                            </select>
                            
                            <button name="add">AÑADIR</button>
                        </form>

                    <?php }elseif(isset($_GET['producto'])) { ?>
                        <h2>Crear Producto</h2>
                        <form action=<?=url.'?controller=producto&action=addProducto'?> method="post" enctype="multipart/form-data">
                            <label for="nombre">Nombre producto</label>
                            <input type="text" id="nombre" name="nombre" required>

                            <label for="imagen">Imagen </label>
                            <input type="file" id="imagen" name="imagen">

                            <label for="descripcion">Descripcion</label>
                            <input type="text" id="descripcion" name="descripcion" required>

                            <label for="precio">Precio</label>
                            <input type="double" id="precio" name="precio" required>

                            <label for="categoria_id">Categoria</label>
                            <select name="categoria_id" id="categoria_id" >
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value=<?=$categoria->getCategoriaId()?>><?=$categoria->getName()?></option>
                                <?php } ?>
                            </select>

                            <button name="add">AÑADIR</button>
                        </form>

                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
</body>
</html>