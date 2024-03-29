<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleCarta.css">
    <title>Carta Rituals</title>
</head>
<body class="body mx-auto">

    <section class="banner container-fluid d-flex flex-column">
        <div class="row">
            <div class="col-12">
                <h1>Carta Rituals Essentials</h1>
            </div>
        </div>
    </section>

    <section class="container productos">
        <div id="row-productos" class="row masonry-grid">
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 masonry-column">
                <div class="sel-categorias">
                    <h4 class="ruta">Home / Carta <?=$name_cat?></h4>
                    <h2 class="titleCat">COMPRAR POR PRODUCTO</h2>

                    <form id="checkboxForm" class="botones-categorias">
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox1" class="checkboxes" name="opciones1" value="BreezeBills">
                            <label for="checkbox1">BreezeBills</label>
                        </div>
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox2" class="checkboxes" name="opciones2" value="Fruit essence cocktail">
                            <label for="checkbox2">Fruit essence cocktail</label>
                        </div>
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox3" class="checkboxes" name="opciones3" value="Café fusion">
                            <label for="checkbox3">Café fusion</label>
                        </div>
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox4" class="checkboxes" name="opciones4" value="Seasonal Sips Collection">
                            <label for="checkbox4">Seasonal Sips Collection</label>
                        </div>
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox5" class="checkboxes" name="opciones5" value="Zero-Proof Mixology Colle">
                            <label for="checkbox5">Zero-Proof Mixology Colle</label>
                        </div>
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox6" class="checkboxes" name="opciones6" value="Global Mix Collection">
                            <label for="checkbox6">Global Mix Collection</label>
                        </div>
                        <div class="divCheck">
                            <input type="checkbox" id="checkbox7" class="checkboxes" name="opciones7" value="Craft Mixology Collection">
                            <label for="checkbox7">Craft Mixology Collection</label>
                        </div>
                    </div>
                </form>

                <div class="promo card">
                    <h5 class="card-title">PARA MIEMBROS DE MY RITUALS</h5>
                    <h3 class="card-title">Tu aperitivo GRATIS por hacer un pedido de 25€ o mas</h3>
                    <img src="img/imgPromo.jpg " class="card-img-top" alt="imagen promoción aperitivo">
                    <a href="<?=url?>?controller=producto&action=login" class="btn btn-primary">INICIA SESIÓN O  CREA UNA CUENTA</a>
                    <p class="sub-promo card-text">Envíos gratis con pedidos superiores a 20€.</p>
                </div>
                <div id="tarjetas-productos"></div>
            
            </div>
        </div>
    </section>
    
    <script src="https://unpkg.com/notie"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script src="./scripts/carta.js"></script>
</body>
</html> 