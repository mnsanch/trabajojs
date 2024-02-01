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
<form class="container-sm CircularSTD">
        <label>Estrellas:</label>
        <input type="checkbox" id="Bocadillo_frio" value="Bocadillo_frio" >
        <label for="Bocadillo_frio">Bocadillo frio</label>
        <input type="checkbox" id="Bocadillo_caliente" value="Bocadillo_caliente">
        <label for="Bocadillo_caliente">Bocadillo caliente</label>
        <input type="checkbox" id="Bocadillo_vegano" value="Bocadillo_vegano">
        <label for="Bocadillo_vegano">Bocadillo vegano</label>
        <input type="checkbox" id="Bocadillo_gourmet" value="Bocadillo_gourmet">
        <label for="Bocadillo_gourmet">Bocadillo gourmet</label>
        <input type="checkbox" id="Hamburgesa_mixta" value="Hamburgesa_mixta">
        <label for="Hamburgesa_mixta">Hamburgesa mixta</label>
        <input type="checkbox" id="Hamburgesa_pollo" value="Hamburgesa_pollo">
        <label for="Hamburgesa_pollo">Hamburgesa pollo</label>
        <input type="checkbox" id="Hamburgesa_vegetal" value="Hamburgesa_vegetal">
        <label for="Hamburgesa_vegetal">Hamburgesa vegetal</label>
        <input type="checkbox" id="Bebida_con_gas" value="Bebida_con_gas">
        <label for="Bebida_con_gas">Bebida con gas</label>
        <input type="checkbox" id="Bebida_sin_gas" value="Bebida_sin_gas">
        <label for="Bebida_sin_gas">Bebida sin gas</label>
        <input type="checkbox" id="Bebida_alcoholica" value="Bebida_alcoholica">
        <label for="Bebida_alcoholica">Bebida alcoholica</label>
    </form>    
    <section class="container-xxl CircularSTD">
        <div class="row">
            <?php
            // Se crea una variable vacia para imprimir las categorias de los productos
            $classe= "";
            // bucle para imprimir todos los productos de la base de datos
            foreach ($productos as $producto) {
                // cada vez que la categoria del producto no cincida con la variable classe se imprimira el nombre de la categoria
                if ($classe!=str_replace('_', ' ', $producto->getIDCategoriaProducto())){
                    $classe=str_replace('_', ' ', $producto->getIDCategoriaProducto());
                    ?>
                    <h3 class="container CircularSTD negrita separacionprincipal <?=$producto->getIDCategoriaProducto()?>"><?=$classe?></h3>
                    <?php
                }
                ?>

                <div class="col-12 col-md-6 col-lg-4 producto <?=$producto->getIDCategoriaProducto()?>">
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
    <script src="js/mostrarproductos.js"></script>


</body>
</html>