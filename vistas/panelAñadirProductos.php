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
    // Si al añadir el producto has intentado añadir una babida sin definirle el alcohol salta esto
    if(isset($errorbebida)){
        ?>
        <h2>No puedes añadir una bebida sin definir alcohol</h2>
        <?php
    // Si al añadir el producto has intentado añadir una comida con alcohol salta esto
    }elseif (isset($errorcomida)) {
        ?>
        <h2>No puedes añadir una comida definiendo alcohol</h2>
        <?php
    // Este es el que sale por defecto cuando entras
    }else{
        ?>
        <h2>Añadir Producto</h2>
        <?php
    }
    ?>
    <form action="<?=url.'?controller=producto&action=crear'?>" method="post">
      
        <!-- Desplegable con las categorias que puede ser el producto -->
        <label for="categoria">Categoría:</label>
        <select class="inputlogin" id="categoria" name="categoria" required>
            <option>Bocadillo Frio</option>
            <option>Bocadillo Caliente</option>
            <option>Bocadillo Vegano</option>
            <option>Bocadillo Gourmet</option>
            <option>Hamburguesa Mixta</option>
            <option>Hamburguesa de Pollo</option>
            <option>Hamburguesa Vegetal</option>
            <option>Bebida con Gas</option>
            <option>Bebida sin Gas</option>
            <option>Bebida Alcohólica</option>
        </select>

        <!-- Mas campos de formulario como nombre, precio... todas obligatorias -->
        <label class="separacionsecundaria" for="nombre">Nombre:</label>
        <input class="inputlogin" type="text" id="nombre" name="nombre" required>

        <label class="separacionsecundaria" for="precio">Precio:</label>
        <input class="inputlogin" type="number" id="precio" name="precio" step="0.01" required>

        <label class="separacionsecundaria" for="imagen">Ruta de la Imagen:</label>
        <input class="inputlogin" type="text" id="imagen" name="imagen" required>

        <label class="separacionsecundaria" for="descripcion">Descripción:</label>
        <textarea class="inputlogin" id="descripcion" name="descripcion" required></textarea>

        <!-- Campo para definir el alcohol este no es obligatoria -->
        <label class="separacionsecundaria" for="descripcion">Tiene Alcohol:</label>
        <div>
            <label for="si">Sí</label>
            <input type="radio" id="si" name="alcohol" value="si" >
        </div>
        <div>
            <label for="no">No</label>
            <input type="radio" id="no" name="alcohol" value="no">
        </div>
     
        <!-- Botones para volver a la pagina anterior o para crear el producto -->
        <div class="row justify-content-center separacionsecundaria">
            <a class="botonproducto" href="<?=url.'?controller=producto&action=modificardatoproducto'?>">Volver</a>
            <button class="botonproducto ms-5" name="id" value="<?=$_POST['modificar']?>" type="submit">Crear Producto</button>
        </div>
    </form>
</div>

</body>
</html>
