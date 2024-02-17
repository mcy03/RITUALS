<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleQr.css">
    <title>Resumen pedido</title>
</head>
<body>
    <div class="body-qr">
        <section class="resume-command">
            <div class="info-command">
                <h1 class="tittle-tiket">RESUMEN DE SU PEDIDO</h1>

                <div id="PEDIDO_ID" class="info"><p>Pedido</p><p class="valor"></p></div>
                <div id="USUARIO_ID" class="info"><p>Usuario</p><p class="valor"></p></div>
                <div id="ESTADO" class="info"><p>Estado</p><p class="valor"></p></div>
                <div id="FECHA_PEDIDO" class="info"><p>Fecha del pedido</p><p class="valor"></p></div>
                <div id="COSTE_PEDIDO" class="info"><p>Coste inicial</p><p class="valor"></p></div>
                <div id="PROPINA" class="info"><p>Propina</p><p class="valor"></p></div>
                <div id="PUNTOS_APLICADOS" class="info"><p>Puntos utilizados</p><p class="valor"></p></div>
                <div id="COSTE_FINAL" class="info"><p>Coste final</p><p class="valor"></p></div>
                
            </div>
            <div id="codigoQR">
                
            </div>
        </section>
    
    </div>

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> 
    <script src="./scripts/procesarPedidoYmostrarlo.js"></script>
    
</body>
</html>
