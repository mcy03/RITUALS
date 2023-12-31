<!-- Page content -->
<html>
    <body>
        <div>
            <table>
                <form action=<?= url ."?controller=producto&action=actualizar" ?> method="post">
                    <tr>
                        <th>id</th>
                        <td>
                            <input type="hidden" name="id" value="<?= $product->getId()?>"/>
                            <input name="idDis" disabled value="<?= $product->getId()?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>nombre</th>
                        <td>
                        <input name="name" value="<?= $product->getName()?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>imagen</th>
                        <td>
                        <input name="img" value="<?= $product->getImg()?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>descripción</th>
                        <td>
                        <input name="desc" value="<?= $product->getDesc()?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>precio unidad</th>
                        <td>
                        <input name="price" value="<?= $product->getPrice()?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>categoria</th>
                        <td>
                        <input name="cat" value="<?= $product->getCat()?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <button type="submit">Actualizar</button>
                        </td>
                    </tr>
                </form>
            </table>
        </div> 
    </body>
</html>