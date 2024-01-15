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
        <div class="row">
            <?php
            // Se crea una variable para saber por que pedido se va
            $id=0;
                // Se hace un bucle para imprimir todos los pedidos 
                foreach ($pedidos as $pedido) {
                    // Si la variable id es diferente al id del pedido significa que es un pedido nuevo
                    if ($id!=$pedido->getIDPedido()) {
                        // Si es la primera vez unicamente cambiara el valor de id pero si ya es la segunda o mas hará una linea de separación
                        if ($id==0){
                            $id=$pedido->getIDPedido(); 
                        }else{
                        ?>
                            <hr class="separacionsecundaria">
                            <?php
                            $id=$pedido->getIDPedido();
                        }
                        ?>
                        <!-- Se muestra el precio del pedido -->
                        <h4 class="negrita productonombre mayuscula separacionsecundaria">El precio de este pedido fue de <?=$pedido->getPrecioPedido()?>€</h4>
                        <?php
                    }
            ?>

            <!-- Se imprimen los valores de los productos -->
            <div class="col-12 col-md-6 col-lg-4 producto">
                <div class="imagencontenedor" style="background-image: url('<?=$pedido->getImagenProducto()?>');">
                </div>
                <h4 class="negrita productonombre mayuscula"><?=$pedido->getNombreProducto()?></h4>
                <p class="productodescripcion mayuscula"><?=$pedido->getDescripcion()?></p>
                <p class="productodescripcion mayuscula">Cantidad: <?=$pedido->getCantidad()?></p>
            </div>
            <?php
                }
            ?>
        </div>
        <!-- Botón para volver atras -->
        <div class="row justify-content-center separacionsecundaria">
        <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
      </div>
    </section>

</body>
</html>