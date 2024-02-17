<!DOCTYPE html>
<html>

<head>
    <title>Restaurante Cosmocaixa Carrito</title>
    <meta charset="UTF-8" lang="es" author="Marc Nicolás">
    <meta name="title" content="Restaurante Cosmocaixa">
    <meta name="description" content="Descripción de la WEB">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notie/dist/notie.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notie/dist/notie.min.js"></script>

    
</head>

<body class="Nunito_Sans">
<section class="container-xxl">
<?php
    // Si selecciones esta vacia pero existe la elimina
    if (isset($_SESSION['selecciones'])){
        if (count($_SESSION['selecciones'])==0) {
            unset($_SESSION['selecciones']);
        }
    }
    // Si no existe selecciones te muestra esto
    if (!isset($_SESSION['selecciones'])){
        ?>
        <div class="row fondocarrito separacioncarrito ms-0 me-3">
            <!-- Imagen del cosmocaixa -->
            <div class="col-6 col-sm-2 p-0">
                <img src="Imagenes/imagen compra.jpg" class="imagencompra col-6 col-sm-2" alt="Imagen cosmocaixa">
            </div>
            <!-- Mensaje de que esta vacio -->
            <div class="col-6 fondocarrito d-flex align-items-center">
                <h3 class="d-felx align-content-center negrita">EL CARRITO SE ENCUENTRA VACIO</h3> 
            </div>
        </div>
        <?php
    // Si si existe selecciones se muestra esto otro
    }else {?>
        <div class="row fondocarrito separacioncarrito ms-0 me-3">
            <!-- Imagen del cosmocaixa -->
            <div class="col-6 col-sm-2 p-0">
                <img src="Imagenes/imagen compra.jpg" class="imagencompra" alt="Imagen cosmocaixa">
            </div>
            <!-- Texto de la barra superior -->
            <div class="col-6 fondocarrito">
                <h3 class="d-felx align-content-center negrita pt-2">RESTAURANTE COSMOCAIXA</h3>
                <p>Para llevar</p>   
            </div>
        </div>

    <?php
        $hr=true;
        include_once 'utils/precios.php';
            $posicion=0;
            foreach ($_SESSION['selecciones'] as $pedido) {
                // Se hace una linea cada vez que pone un producto debajo de uno existente ademas que la primera vez se añaden los botones de eliminar y editar todo
                if ($hr==true) {
                    ?>
                    <div class="row py-0 my-0">
                        <div class="col-8 col-sm-10 py-0 my-0"></div>
                        <!-- Botón de eliminar todo -->
                        <form action="<?=url.'?controller=producto&action=borrartodo'?>" class="col-2" method="post">
                            <button class="botoncompra editareliminar separacionborrar py-0 my-0 negrita"><img class="imageneditareliminar"src="Imagenes/Iconos/basura.svg" alt="Eliminar todo">Borrar todo</button>
                        </form>
                    </div>
                    <?php
                }
                if ($hr==false) {
                ?>
                <hr>
                <?php
            }
            $hr=false;
    ?>
        
        <div class="row">
            <!-- Imagen y nombre del producto -->
            <img class="col-4 col-sm-2" src="<?=$pedido->getProducto()->getImagenProducto()?>" alt="<?=$pedido->getProducto()->getNombreProducto()?> Imagen">
            <h4 class="texto col-3 col-sm-5 p-0 d-flex align-items-center"><?=$pedido->getProducto()->getNombreProducto()?></h4>
            <!-- Se añade la cantidad que tiene y una mas y menos al lado para poder sumar y restar la cantidad -->
            <div class="row col-1 d-flex align-items-center justify-content-center p-0">
                <p class="col-12 col-sm-6"><?=$pedido->getCantidad()?></p>
                <form action="<?=url.'?controller=producto&action=sumarrestar'?>" class="col-12 col-sm-6" method="post">
                    <button class="botoncompra p-0" type="submit" name="mas" value="<?=$posicion?>"><img src="Imagenes/Iconos/mas.png" alt="Añadir mas cantidad"></button>
                    <button class="botoncompra p-0" type="submit" name="menos"value="<?=$posicion?>"><img src="Imagenes/Iconos/menos.png" alt="Quitar cantidad"></button>
                </form>
            </div>
            <!-- Precio del producto -->
            <div class="d-flex align-items-center col-4">
                <div class="col-4 col-sm-3">
                  <p class="texto justify-content-end row">General</p>
                </div>
                <div class="col-2 col-sm-4"></div>
                <div class="col-2 col-sm-3">
                    <p class="texto justify-content-end row"><?=number_format(($pedido->getProducto()->getPrecioProducto()*$pedido->getCantidad()),2)?>€</p>   
                </div>
                <div class="col-1 col-sm-2">
                <form action="<?=url.'?controller=producto&action=borrar'?>" class="col-6" method="post">
                    <button class="botoncompra" type="submit" name="borrar" value="<?=$posicion?>"><img class="imageneditareliminar ms-4 mb-4" src="Imagenes/Iconos/basura.svg" alt="Eliminar producto"></button>
                </form>

                </div>
                
            </div>
        
        </div>    


            <p></p>
            <?php
            $posicion+=1;
        }
    ?>
    <div class="row">
            <!-- Filtro de propina que quieres ponerle al pedido -->
            <div class="col-7">
                <form class="container-sm CircularSTD column" id="formPropina">
                    <input type="radio" id="0%" name="propina" value="0" >
                    <label for="0%">Nada</label>
                    <input type="radio" id="0.03%" name="propina" value="0.03" checked>
                    <label for="0.03%">3%</label>
                    <input type="radio" id="0.05%" name="propina" value="0.05">
                    <label for="0.05%">5%</label>
                    <input type="radio" id="0.21%" name="propina" value="0.21">
                    <label for="0.21%">21%</label>
                    <input type="radio" id="0.5%" name="propina" value="0.5">
                    <label for="0.5%">50%</label>
                </form>
            </div>
            
            <div class="row col-1 d-flex align-items-center justify-content-center p-0">
            </div>
            <!-- Propina que se suma -->
            <div class="d-flex align-items-center col-4">
                <div class="col-4 col-sm-3">
                  <p class="texto justify-content-end row">Propina</p>
                </div>
                <div class="col-2 col-sm-4"></div>
                <div class="col-2 col-sm-3">
                    <p class="texto justify-content-end row" id="propina"></p>   
                </div>
            </div>
        
    </div>
        <?php
        if (!ISSET ($_SESSION['puntos'])){
        ?>
            <div class="row">
                <!-- Mensaje de no gastar puntos si no estas logeado -->
                <div class="col-7">
                    <p class="texto">No puedes gastar puntos porque no te has registrado</p>
                </div>
                
                <div class="row col-1 d-flex align-items-center justify-content-center p-0">
                </div>
                <div class="d-flex align-items-center col-4">

                </div>
            
            </div>
        <?php
        }else{
        ?>
            <div class="row">
                <!-- Filtros para gastar o no puntos -->
                <div class="col-7">
                    <p class="texto">Tienes <b><span id="puntosbd"></span></b> puntos quieres gastarlos</p>
                    <form class="container-sm CircularSTD column" id="formPropina">
                    <input type="radio" id="no" name="puntos" value="0" checked>
                    <label for="no">No</label>
                    <input type="radio" id="si" name="puntos" value="0.03">
                    <label for="si">Si</label>
                    <input type="number" id="textopuntos" disabled>
                </form>
                </div>
                
                <div class="row col-1 d-flex align-items-center justify-content-center p-0">
                </div>
                <!-- Puntos que se muestran -->
                <div class="d-flex align-items-center col-4">
                    <div class="col-4 col-sm-3">
                    <p class="texto justify-content-end row">Puntos</p>
                    </div>
                    <div class="col-2 col-sm-4"></div>
                    <div class="col-2 col-sm-3">
                        <p class="texto justify-content-end row" id="puntos">0</p>   
                    </div>
                    
                    
                </div>
            
            </div>
        <?php
        }
        ?>

        <!-- Precio total de la compra -->
        <div class="row separacioncarrito ms-0 me-1 ">
            <div class="col-4 col-sm-8 fondocarrito">
            <p class=" totalcompra negrita" id="puntosconseguidos"></p>

            </div>
            <div class="col-8 col-sm-4 row fondocarrito pt-1">
                <div class="col-7 col-sm-5 pe-4">
                          <h3 class=" totalcompra justify-content-end row negrita">Total a pagar</h3>

          
                </div>
                <div class="col-1"></div>
                <h3 class="col-4 col-sm-6 pe-1 totalcompra justify-content-end row negrita" id="total"><?=Calcularprecios::calcularpreciofinal($_SESSION['selecciones'])?>€</h3>
            </div>
        </div>
        <div class="row CircularSTD separacionsecundaria justify-content-center">

            <!-- Botón para volver a la carta -->
            <form class="col-10 col-sm-4" action="<?=url.'?controller=producto&action=productos'?>" method="post"> 
                <button class="botonproductovolver negrita " type="submit">CONTINUAR COMPRANDO</button>
            </form>
            <div class="col-0 col-sm-4"></div>
            <!-- Botón para finalizar el pedido -->
            <form class="col-10 col-sm-4 pt-2" action="<?=url.'?controller=pedido&action=confirmar'?>" method="post"> 
                <button id="botonComprar" class="botoncomprar negrita" type="submit">COMPRAR</button>
            </form>
        </div>
        <?php
    }
    ?>
    </section>
    <!-- llamada al JS para el local storage -->
    <script src="js/guardarLocalStorage.js"></script>
    <!-- llamada al JS para la propina y los puntos -->
    <script src="js/propinaypuntos.js"></script>
</body>
</html>

