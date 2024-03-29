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
            // Se crea una variable para saber por que producto se va
            $id=0;
            // Se hace un bucle para mostrar todos los productos
            foreach ($productos as $producto) {
                // Si la variable id es diferente al id del producto significa que es un producto` nuevo
                if ($id!=$producto->getIDProducto()) {
                    // Si es la primera vez unicamente cambiara el valor de id pero si ya es la segunda o mas hará una linea de separación
                    if ($id==0){
                        $id=$producto->getIDProducto(); 
                    }else{
                    ?>
                        <hr class="separacionsecundaria">
                        <?php
                        $id=$producto->getIDProducto();
                    }
                    ?>
                    <?php
                }
                ?>
                <!-- Se muestran los valores del producto -->
                <div class="row d-flex align-items-center">
                    <div class="col-4">
                        <div class="imagencontenedor" style="background-image: url('<?=$producto->getImagenProducto()?>');">
                        </div>
                    </div>
                    <div class="col-3">
                        <h4 class="negrita productonombre mayuscula"><?=$producto->getNombreProducto()?></h4>
                        <p class="productodescripcion mayuscula"><?=$producto->getIDCategoriaProducto()?></p>
                        <p class="productodescripcion mayuscula"><?=$producto->getPrecioProducto()?></p>
                    </div>
                    <div class="col-3">
                    <p class="productodescripcion mayuscula"><?=$producto->getDescripcion()?></p>
                    <?php
                    // Esto se muestra si es una bebida
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
                        ?>
                        <?php
                    }
                    ?>
                    </div>
                    
                    
                    <div class="col-2">
                        <!-- Boton de modificar donde se le pasa todo lo necesario del producto seleccionado -->
                        <form class="row justify-content-center" action="<?=url.'?controller=producto&action=editarproducto'?>" method="post">
                            <input type="hidden" name="categoria" value="<?=$producto->getIDCategoriaProducto() ?>">
                            <input type="hidden" name="nombre" value="<?=$producto->getNombreProducto() ?>">
                            <input type="hidden" name="precio" value="<?=$producto->getPrecioProducto() ?>">
                            <input type="hidden" name="imagen" value="<?=$producto->getImagenProducto() ?>">
                            <input type="hidden" name="descripcion" value="<?=$producto->getDescripcion() ?>">
                            <!-- Estos datos unicamente se pasan si el producto es una bebida -->
                            <?php
                                if (method_exists($producto, 'getAlcohol')) {
                                    ?>
                                    <input type="hidden" name="alcohol" value="<?=$producto->getAlcohol() ?>">
                                    <?php
                                }
                            ?>
                            <button type="submit" name="modificar" value="<?=$producto->getIDProducto() ?>" class="botonproducto">Modificar</button>
                        </form>
                        <!-- Boton de eliminar -->
                        <form class="row justify-content-center separacionsecundaria" action="<?=url.'?controller=producto&action=eliminarproducto'?>" method="post">
                            <button type="submit" name="eliminar" value="<?=$producto->getIDProducto()?>" class="botonproducto">Eliminar</button>
                        </form>
                    </div>

                    
                </div>
                
                <?php
            }
            ?>

        </div>
        <!-- Botones de volver atras y añadir productos -->
        <form class="row justify-content-center separacionsecundaria" action="<?=url.'?controller=producto&action=añadirproducto'?>" method="post">
            <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
            <button type="submit" name="añadir" class="botonproducto ms-5">Añadir Productos</button>
        </form>
    </section>

</body>
</html>