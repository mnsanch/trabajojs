<!DOCTYPE html>
<html lang="es">
<head>
    <title>Restaurante Cosmocaixa Productos</title>
    <meta charset="UTF-8" lang="es" author="Marc Nicolás">
    <meta name="title" content="Restaurante Cosmocaixa">
    <meta name="description" content="Descripción de la WEB">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body class="CircularSTD">

  <div class="contenedorlogin separacionprincipal col-10 col-sm-5">
    <?php
      // Se mira si hay una sesion iniciada mediante la variable de sasion
      if (isset($_SESSION['correo'])) {
        ?>
      <!-- Si la sesion existe te muestra esta sección -->
      <h1>Hola <?php echo $_SESSION['nombre']?></h1>
      <p>Tienes <?php echo $_SESSION['puntos']?> puntos</p>
      <section class="row separacionsecundaria">
        <div class="col-12 mb-3 row justify-content-around">
          <!-- Boton para modificar los datos del usuario -->
          <form class="col-6 col-sm-4 ps-5" action="<?=url.'?controller=usuario&action=modificardatosusuario'?>" method="post">
            <button class="botonproducto ms-2" type="submit">Modificar Datos</button>
          </form>
          <!-- boton para ver los pedidos del usuario -->
          <form class="col-6 col-sm-4 ps-5" action="<?=url.'?controller=usuario&action=verpedido'?>" method="post">
            <button class="botonproducto ms-2" type="submit">Ver Pedidos</button>
          </form>
        </div>
        <div class="col-12 mb-3 row justify-content-around">
          <!-- Boton para ver el ultimo pedido hecho mediante la cookie -->
          <form class="col-6 col-sm-4 ps-5" action="<?=url.'?controller=pedido&action=ultimopedido'?>" method="post">
            <button class="botonproducto ms-2" type="submit">Ver ultimpo pedido</button>
          </form>
          <!-- Boton para cerrar la sesión -->
          <form class="col-6 col-sm-4 ps-5" action="<?=url.'?controller=usuario&action=salirsesion'?>" method="post">
            <button class="botonproducto ms-2" type="submit">Cerrar Sesión</button>
          </form>
        </div> 
        <?php
        // Estos botones unicamente se muestran si el usuario es un administrador
        if ($_SESSION['categoria']=="Administrador") {
          ?>
          <div class="col-12 mb-3 row justify-content-around">
            <!-- Boton para modificar productos -->
            <form class="col-6 col-sm-4 ps-5" action="<?=url.'?controller=producto&action=modificardatoproducto'?>" method="post">
              <button class="botonproducto ms-2" type="submit">Modificar Productos</button>
            </form>
            <!-- Boton para modificar pedidos -->
            <form class="col-6 col-sm-4 ps-5" action="<?=url.'?controller=pedido&action=modificarpedidos'?>" method="post">
              <button class="botonproducto ms-2" type="submit">Modificar Pedidos</button>
            </form>
          </div> 
          <?php
        }
        ?>
      </section>
      <?php
      // Si la sesión no está iniciada mostrará esto otro
      }else{
        // Si al iniciar sesion hay alhun error te mostrará este mensaje
        if (isset($error) && $error==true){
          ?>
          <h1>Error</h1>
          <?php
        // Este es el mensaje por defecto 
        }else{
          ?>
          <h1 >Iniciar Sesión</h1>
          <?php
        }
        ?>
        <p class="logo"></p>
        <!-- Formulario de inicio de sesión -->
        <form class="" action="<?=url.'?controller=usuario&action=iniciosesion'?>" method="post">
          <label for="email">Correo electronico:</label>
          <input class="inputlogin" type="email" id="correo" name="correo" required>

          <label class="separacionsecundaria" for="password">Contraseña:</label>
          <input class="inputlogin" type="password" id="contraseña" name="contraseña" required>
          <!-- Botones de inicar sesión y registrarse -->
          <div class="row justify-content-center separacionsecundaria">
            <button class="botonproducto  me-2" name="iniciar" type="submit">Iniciar Sesión</button>
            <button class="botonproducto ms-2" name="registrarse" type="submit">Registrarse</button>
          </div>
        </form>
        <?php
      }
        ?>
  </div>

</body>
</html>
