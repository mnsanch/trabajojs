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
        <?php
        // Se mira que la cookie este creada
        if (isset ($_COOKIE[$_SESSION['idusuario']])) {
            $precio=PedidosUsuarioDAO::revisarprecio($_COOKIE[$_SESSION['idusuario']]);

            ?>
            <!-- Se pone el precio del pedido sacandola de una de las dos cookies -->
            <h3>El ultimo pedido te costo <?=$precio?>€</h3>
            <div class="row">
                <?php
                $id=0;
                // Se hace un bucle para cojer todos los productos del pedido sacando el id del pedido de la cookie
                foreach ( (PedidosUsuarioDAO::cogerpedido($_COOKIE[$_SESSION['idusuario']])) as $producto) {
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 producto">
                        <div class="imagencontenedor" style="background-image: url('<?=$producto->getImagenProducto()?>');">
                        </div>
                        <h4 class="negrita productonombre mayuscula"><?=$producto->getNombreProducto()?></h4>
                        <p class="productodescripcion mayuscula"><?=$producto->getDescripcion()?></p>
                        <p class="productodescripcion mayuscula">Cantidad: <?=$producto->getCantidad()?></p>
                    </div>
                <?php
                };
                ?>
            </div>
                <!-- Botón para volver atras -->
            <div class="row justify-content-center separacionsecundaria">
                <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
            </div>
            <?php
        }else{
            ?>
            <!-- Mensaje que sale cuando no hay cookie -->
            <div class="contenedorlogin separacionprincipal col-10 col-sm-5">
                <h1>Hece mucho que no compras en nuestra pagina</h1>
                <!-- Botón para volver atras -->
                <div class="row justify-content-center separacionsecundaria">
                <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
                </div>
            </div>
        <?php
        }
        ?>
    </section>

</body>
</html>