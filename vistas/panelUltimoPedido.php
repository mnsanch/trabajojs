<!DOCTYPE html>
<html>

<head>
    <title>Restaurante Cosmocaixa Productos</title>
    <meta charset="UTF-8" lang="es" author="Marc Nicolás">
    <meta name="title" content="Restaurante Cosmocaixa">
    <meta name="description" content="Descripción de la WEB">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    

    <section class="container-xxl CircularSTD">
            <!-- Se pone el precio del pedido sacandola de una de las dos cookies -->
            <div class="contenedorlogin col-10 col-sm-5">
                <h3>Este es tu ultimo pedido</h3>
                <div id="qrCodeContainer"></div>
                    <!-- Botón para volver atras -->
                <div class="row justify-content-center separacionsecundaria">
                    <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
                </div>
            </div>
    </section>
    <script src="js/qr.js"></script>
</body>
</html>