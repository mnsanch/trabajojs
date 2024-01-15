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
            // Se crea una variable vacia para imprimir las categorias de los productos
            $classe= "";
            // bucle para imprimir todos los productos de la base de datos
            foreach ($productos as $producto) {
                // cada vez que la categoria del producto no cincida con la variable classe se imprimira el nombre de la categoria
                if ($classe!=$producto->getIDCategoriaProducto()){
                    $classe=$producto->getIDCategoriaProducto();
                    ?>
                    <h3 class="container CircularSTD negrita separacionprincipal"><?=$classe?></h3>
                    <?php
                }
                ?>

                <div class="col-12 col-md-6 col-lg-4 producto">
                    <!-- Se muestran los datos de los productos -->
                    <div href="productos.html" class="nodecoracion">
                        <div class="imagencontenedor" style="background-image: url('<?=$producto->getImagenProducto()?>');">
                        </div>
                        <p class="productocategoriaproducto negrita mayuscula"><?=$producto->getIDCategoriaProducto()?></p>
                        <h4 class="negrita productonombre mayuscula"><?=$producto->getNombreProducto()?></h4>
                        <p class="productodescripcion mayuscula"><?=$producto->getDescripcion()?></p>
                        <?php
                            // Si el producto tiene el metodo getAlcohol es decir es una bebida mirará su valor y mostrará si lleva o no alcohol
                            if (method_exists($producto, 'getAlcohol')) {
                                if ($producto->getAlcohol() == 1) {
                                    ?>
                                    <p class="productodescripcion mayuscula">tiene alcohol</p>
                                    <?php
                                } else {
                                    ?>
                                    <p class="productodescripcion mayuscula">no tiene alcohol</p>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="row">
                        <!-- Botón para añadir al carrito ademas de darle el id del producto escogido -->
                        <form class="col-4" action="<?=url.'?controller=producto&action=comprar'?>" method="post"> 
                            <input type="hidden" name="id"  value="<?=$producto->getIDProducto()?>">
                            <button class="botonproductoproducto" type="submit">AÑADIR AL CARRITO</button>
                        </form>
                        <p class="col-1 pt-1 ps-0"><?=$producto->getPrecioProducto()?>€</p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>

</body>
</html>