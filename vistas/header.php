<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="https://www.google.com/s2/favicons?domain=cosmocaixa.org&sz=16" type="image/x-icon">
</head>

<!-- Bootstrap JS (popper.js y bootstrap.js son requeridos) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<header class="CircularSTD">
    <section class="container-xl">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Es el logo que tambien te lleva a la pagina de inicio -->
                <a class="navbar-brand" href="<?=url.'?controller=producto'?>">
                    <div class="logo"></div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Panel de busqueda -->
                    <form class="d-flex  me-auto mb-2 mb-lg-0" role="search">
                        <input class="form-control me-2" type="search" placeholder="BUSCADOR" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">BUSCAR</button>
                    </form>
                    <ul class="navbar-nav">
                        <!-- Botón de inicio -->
                        <li class="nav-item ">
                            <a class="nav-link active botonheader" aria-current="page" href="<?=url.'?controller=producto'?>">INICIO</a>
                        </li>
                        <!-- Botón de productos -->
                        <li class="nav-item">
                            <a class="nav-link active botonheader" aria-current="page"
                                href="<?=url.'?controller=producto&action=productos'?>">PRODUCTOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active botonheader" aria-current="page"
                                href="<?=url.'?controller=comentario&action=mostrarcomentario'?>">COMENTARIOS</a>
                        </li>
                        <!-- Botón de la cesta -->
                        <li class="nav-item">
                            <a class="nav-link active botonheader" aria-current="page" href="<?=url.'?controller=producto&action=compra'?>">
                                <img class="carrito" src="Imagenes/Iconos/carro-de-la-carretilla.svg " alt="Ir a la cesta">
                            </a>
                        </li>
                        <!-- Botón de login -->
                        <li class="nav-item">
                            <a class="nav-link active botonheader" aria-current="page" href="<?=url.'?controller=usuario&action=login'?>">
                                <img class="carrito" src="Imagenes/Iconos/usuario.svg " alt="Iniciar sesión">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
</header>
</html>