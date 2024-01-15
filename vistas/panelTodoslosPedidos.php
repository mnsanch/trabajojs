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
                        <div class="row">
                        <!-- Se muestra el comprador y precio del pedido -->
                        <h4 class="col-12 col-sm-8 negrita productonombre mayuscula separacionsecundaria">El precio de este pedido fue echo por <?=$pedido->getNombreUsuario()?> con un valor de <?=$pedido->getPrecioPedido()?>€</h4>
                        <div class="col-12 col-sm-4 py-2 row">
                        <!-- Boton de modificar donde se le pasa todo lo necesario del pedido seleccionado -->
                        <form class="row m-0 col-6 justify-content-center" action="<?=url.'?controller=pedido&action=editarpedido'?>" method="post">
                            <button type="submit" name="modificar" value="<?=$pedido->getIDPedido() ?>" class="botonproducto">Modificar</button>
                        </form>
                        <!-- Boton de eliminar pedido-->
                        <form class="row m-0 col-6 justify-content-center separacionsecundaria" action="<?=url.'?controller=pedido&action=eliminarpedido'?>" method="post">
                            <button type="submit" name="eliminar" value="<?=$pedido->getIDPedido()?>" class="botonproducto">Eliminar</button>
                        </form>
                    </div>
                    </div>



                        
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
        <!-- Botones de volver atras y añadir pedido -->
        <form class="row justify-content-center separacionsecundaria" action="<?=url.'?controller=pedido&action=añadirpedido'?>" method="post">
            <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
            <button type="submit" name="añadir" class="botonproducto ms-5">Añadir Pedidos</button>
        </form>
    </section>

</body>
</html>