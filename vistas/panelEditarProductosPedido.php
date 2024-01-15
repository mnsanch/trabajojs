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

    <h2>Modificar Producto</h2>
    <form action="<?=url.'?controller=pedido&action=modificar'?>" method="post">
      
        <!-- Desplegable con las categorias que puede ser el producto donde por defecto se escoje la que tiene el producto-->
        <label for="categoria">Categoría:</label>
        <select class="inputlogin" id="categoria" name="categoria" required disabled>
            <option <?php if ($_POST['categoria'] == 'Bocadillo frio') echo 'selected'; ?>>Bocadillo Frio</option>
            <option <?php if ($_POST['categoria'] == 'Bocadillo caliente') echo 'selected'; ?>>Bocadillo Caliente</option>
            <option <?php if ($_POST['categoria'] == 'Bocadillo vegano') echo 'selected'; ?>>Bocadillo Vegano</option>
            <option <?php if ($_POST['categoria'] == 'Bocadillo gourmet') echo 'selected'; ?>>Bocadillo Gourmet</option>
            <option <?php if ($_POST['categoria'] == 'Hamburguesa mixta') echo 'selected'; ?>>Hamburguesa Mixta</option>
            <option <?php if ($_POST['categoria'] == 'Hamburguesa pollo') echo 'selected'; ?>>Hamburguesa de Pollo</option>
            <option <?php if ($_POST['categoria'] == 'Hamburguesa vegetal') echo 'selected'; ?>>Hamburguesa Vegetal</option>
            <option <?php if ($_POST['categoria'] == 'Bebida con gas') echo 'selected'; ?>>Bebida con Gas</option>
            <option <?php if ($_POST['categoria'] == 'Bebida sin gas') echo 'selected'; ?>>Bebida sin Gas</option>
            <option <?php if ($_POST['categoria'] == 'Bebida alcoholica') echo 'selected'; ?>>Bebida Alcohólica</option>
        </select>
        
        <!-- Mas campos de formulario como nombre, precio... todas con el valor cojido de la base de datos -->
        <label class="separacionsecundaria" for="nombre">Nombre:</label>
        <input class="inputlogin" type="text" id="nombre" name="nombre" value="<?=$_POST['nombre']?>" required disabled>

        <label class="separacionsecundaria" for="precio">Precio:</label>
        <input class="inputlogin" type="number" id="precio" name="precio" step="0.01" value="<?=$_POST['precio']?>" required disabled>

        <label class="separacionsecundaria" for="imagen">Ruta de la Imagen:</label>
        <input class="inputlogin" type="text" id="imagen" name="imagen" value="<?=$_POST['imagen']?>" required disabled>

        <label class="separacionsecundaria" for="imagen">Cantidad:</label>
        <input class="inputlogin" type="number" id="cantidad" name="cantidad" value="<?=$_POST['cantidad']?>" required>

        <label class="separacionsecundaria" for="descripcion">Descripción:</label>
        <textarea class="inputlogin" id="descripcion" name="descripcion" required disabled><?=$_POST['descripcion']?></textarea>

        <?php
        // Si el producto a editar tiene alcohol aparecera esto si no no
        if (isset($_POST['alcohol'])) {
            if ($_POST['alcohol']==1){
            ?>
            <label class="separacionsecundaria" for="descripcion">Tiene Alcohol:</label>
        
            <div>
                <label for="si">Sí</label>
                <input type="radio" id="si" name="alcohol" value="si" required disabled checked>
            </div>
        
            <div>
                <label for="no">No</label>
                <input type="radio" id="no" name="alcohol" value="no">
            </div>
            <?php
            }else{
                ?>
                <label class="separacionsecundaria" for="descripcion">Tiene Alcohol:</label>
            
                <div>
                    <input type="radio" id="si" name="alcohol" value="si" required>
                    <label for="si">Sí</label>
                </div>
            
                <div>
                    <input type="radio" id="no" name="alcohol" value="no" checked v>
                    <label for="no">No</label>
                </div>
                <?php                
            }
        }
        ?>

        <!-- Botones de volver atras y modificar el producto -->
        <div class="row justify-content-center separacionsecundaria">
            <input type="hidden" id="pedido" name="pedido" value="<?=$_POST["idpedido"];?>" >
            <button class="botonproducto ms-5" name="id" value="<?=$_POST['modificar']?>" type="submit">Modificar Producto</button>
        </div>
    </form>
</div>

</body>
</html>
