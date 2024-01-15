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
<body>

<div class="CircularSTD contenedorlogin separacionprincipal col-10 col-sm-5">
<?php
  // Si el corro que se ha puesto no esta en la base de datos saldra esto
  if (isset($correo) && $correo==false){
  ?>
    <h2>Correo no valido</h2>
    <?php
  // Si la contraseña es incorrecta saldra esto otro
  }elseif (isset($modificar) && $modificar==false){
  ?>
    <h2>Contraseñas no coinciden</h2>
    <?php
  // Este es el que sale por defecto cada vez que entras
  }else{
    ?>
    <h2 >Modificar Usuario</h2>
    <?php
  }
    ?>
    <p class="logo"></p>
    <form action="<?=url.'?controller=usuario&action=modificarsesion'?>" method="post">
      <!-- Campos de formulario para editar el usuario -->
      <label for="nombre">Nombre:</label>
      <input class="inputlogin" type="text" id="nombre" name="nombre" value="<?=$_SESSION['nombre']?>" required>      

      <label class="separacionsecundaria" for="correo">Correo electrónico:</label>
      <input class="inputlogin" type="email" id="correo" name="correo" value="<?=$_SESSION['correo']?>" required>
      <!-- Campo invisible para obtener el correo antiguo -->
      <input type="hidden" id="correoantiguo" name="correoantiguo" value="<?=$_SESSION['correo']?>">


      <label class="separacionsecundaria" for="direccion">Dirección:</label>
      <input class="inputlogin" type="text" id="direccion" name="direccion" value="<?=$_SESSION['direccion']?>" required>

      <label class="separacionsecundaria" for="telefono">Telefono:</label>
      <input class="inputlogin" type="number" id="telefono" name="telefono" value="<?=$_SESSION['telefono']?>" required>

      <label class="separacionsecundaria" for="password">Contraseña:</label>
      <input class="inputlogin" type="password" id="contraseña" name="contraseña"  required>
      
      <label class="separacionsecundaria" for="confirmar_contrasena">Confirmar Contraseña:</label>
      <input class="inputlogin" type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>

      <!-- Botones para volver atras o modificar los datos -->
      <div class="row justify-content-center separacionsecundaria">
        <a class="botonproducto" href="<?=url.'?controller=usuario&action=login'?>">Volver</a>
        <button class="botonproducto ms-5" type="submit">Modificar datos</button>
      </div>
    </form>
  </div>

</body>
</html>
