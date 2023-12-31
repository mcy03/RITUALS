<?php 
    include_once "controller/productoController.php";
    include_once "config/parameters.php";
?>

<head>
    <link rel="stylesheet" href="styleViewProductos.css">
</head>
<body>
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>img</th>
            <th>desc</th>
            <th>price</th>
            <th>category</th>
        </tr>
        <?php foreach($productos as $productosA){?>
            <tr>
                <td><?=$productosA->getId()?></td>
                <td><?=$productosA->getName()?></td>
                <td><?=$productosA->getImg()?></td>
                <td><?=$productosA->getDesc()?></td>
                <td><?=$productosA->getPrice()?></td>
                <td><?=$productosA->getCat()?></td>
                <td>
                    <form action=<?= url . "?controller=producto&action=eliminar"?> method="POST">
                        <input type="hidden" name="id" value="<?= $productosA->getId() ?>" >
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
                <td>
                    <form action=<?= url . "?controller=producto&action=editar"?> method="POST">
                        <input type="hidden" name="id" value="<?= $productosA->getId() ?>" >
                        <button type="submit">Editar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
