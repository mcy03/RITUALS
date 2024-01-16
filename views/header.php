<!-- Cabecera HTML -->
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleHeader.css">
</head>
<body>
<div class="body mx-auto">
    <header>
            <div class="sub-header">

            </div>
        
            <nav id="nav" class="nav-header nav navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-nav container-fluid align-items-baseline">
                    <a class="navbar-brand" href="index.php">
                        <img class="logo-name" src="img/logoNameRituals.svg" alt="Logo svg texto RITUALS...">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a id="nav-link" class="nav-link" href="<?=url?>?controller=producto&action=carta">Carta</a>
                            </li>
                            <li class="nav-item">
                                <a id="nav-link" class="nav-link" href="<?=url?>?controller=producto&action=valoraciones">Valoraciones</a>
                            </li>
                        </ul>
                        

                        <form class="form-search d-flex align-items-baseline" role="search">
                            <button class="btn-lupa btn" type="submit"><img class="img-lupa" src="img/lupa.png" alt="icono lupa busqueda"></button>
                            <img class="separe-search" src="img/menos.png" alt="separador del buscador">
                            <input class="input-search" type="search" placeholder="Estoy buscando..." aria-label="Search">
                        </form>

                        <a href=<?=url.'?controller=producto&action=login'?> class="btn-user btn d-flex align-items-baseline">
                            <img class="user-img" src="img/user-icon.png" alt="icono cuenta usuario">
                        </a>
                        <a href=<?=url.'?controller=producto&action=carrito'?> class="btn-carrito-icon btn">
                            <img class="carrito-img" src="img/carrito-img.png" alt="icono carrito">
                            <div class="container-cont-command">
                                <p class="cont-command"><?=count($_SESSION['selecciones'])?></p>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>
    </header>
</div>
</body>