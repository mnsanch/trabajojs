<?php

include_once 'config/dataBase.php';
include_once 'PedidosUsuario.php';


class PedidosUsuarioDAO
{
    public static function guardarpedido($precio, $propina)
    {
        // Conexion con la base de datos
        $conexion = DataBase::connect();

        // Guardamos en variables los datos que necesitemos
        $idUsuario = $_SESSION['idusuario'];
        // $precio = Calcularprecios::calcularpreciofinal($_SESSION['selecciones']);
        $fechaActual = date("Y-m-d");

        // Se prepara la consulta con la base de datos donde guardaremos los datos del pedido
        $stmt = $conexion->prepare("
                INSERT INTO `pedido` (ID_Usuario, Precio_Pedido, Propina, Fecha_Pedido)
                VALUES (?, ?, ?, ?)
            ");
        // Se le pasan los parametros necesarios
        $stmt->bind_param("idds", $idUsuario, $precio, $propina, $fechaActual);


        // Se ejecuta la consulta
        $stmt->execute();

        //Se hace otra consulta para guardar el id del pedido que se acaba de crear
        $stmt = $conexion->prepare("
            SELECT ID_Pedido FROM `pedido` ORDER BY ID_Pedido DESC LIMIT 1
            ");

        $id = $conexion->insert_id;

        // Se hace un bucle para guardar los pedidos
        foreach ($_SESSION['selecciones'] as $pedido) {
            // Guardamos en variables los datos que necesitemos
            $cantidad = $pedido->getCantidad();
            $productos = $pedido->getProducto()->getIDProducto();

            // Se prepara la consulta con la base de datos donde crearemos los valores de la tabla intermedia para asociar el pedido con sus productos
            $stmt = $conexion->prepare("
                INSERT INTO PEDIDO_PRODUCTO (ID_Pedido, ID_Producto, Cantidad)
                VALUES
                (?, ?, ?)
                ");
            // Se le pasan los parametros necesarios
            $stmt->bind_param("iii", $id, $productos, $cantidad);

            // Se ejecuta la consulta
            $stmt->execute();
        }

        // Se devuelve el id del pedido que se ha creado
        return $id;
    }

    public static function cogerpedido($id)
    {
        // Conexion con la basse de datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos devolvera todo el pedido con la id que le damos
        $stmt = $conexion->prepare("
            SELECT pedido.ID_Pedido, pedido.Precio_Pedido, pedido_producto.Cantidad, producto.Nombre_Producto, producto.Imagen_Producto, producto.Descripcion 
            FROM pedido 
            JOIN pedido_producto ON pedido.ID_Pedido = pedido_producto.ID_Pedido
            JOIN producto  ON pedido_producto.ID_Producto = producto.ID_Producto
            WHERE pedido_producto.ID_Pedido = ?
            ");
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $id);

        // Ejecutamos la consulta
        $stmt->execute();

        // Guardamos el resultado rn una variable
        $resultado = $stmt->get_result();

        /// Se crea una array para guardar los valores
        $productos = [];

        // Se gurdan los resultados como un objeto de la classe PedidosUsuario
        while ($obj = $resultado->fetch_object('PedidosUsuario')) {
            $productos[] = $obj;
        }

        // Se devuelve productos
        return $productos;
    }

    public static function cogerpedidosusuario($id)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos devolvera todos los pedidos del usuario que queramos
        $stmt = $conexion->prepare("
            SELECT pedido.ID_Pedido, pedido.Precio_Pedido, pedido_producto.Cantidad, producto.Nombre_Producto, producto.Imagen_Producto, producto.Descripcion, usuario.Nombre_Usuario
            FROM pedido 
            JOIN pedido_producto ON pedido.ID_Pedido = pedido_producto.ID_Pedido
            JOIN producto  ON pedido_producto.ID_Producto = producto.ID_Producto
            JOIN usuario on pedido.ID_Usuario = usuario.ID_Usuario
            WHERE pedido.ID_Usuario = ?
            ORDER BY pedido.ID_Pedido ASC
            ");
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $id);

        // Ejecutamos la consulta
        $stmt->execute();

        //Se guarda el resultado en una variable
        $resultado = $stmt->get_result();

        /// Se crea una array para guardar los valores
        $productos = [];

        // Se gurdan los resultados como un objeto de la classe PedidosUsuario
        while ($obj = $resultado->fetch_object('PedidosUsuario')) {
            $productos[] = $obj;
        }

        // Se devuelve productos
        return $productos;
    }

    public static function cogertodoslospedidos()
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se hace una consulta con la base de datos donde nos devolvera todos los pedidos
        $stmt = $conexion->query("
            SELECT pedido.ID_Pedido, pedido.Precio_Pedido, pedido_producto.Cantidad, producto.Nombre_Producto, producto.Imagen_Producto, producto.Descripcion, usuario.Nombre_Usuario
            FROM pedido 
            JOIN pedido_producto ON pedido.ID_Pedido = pedido_producto.ID_Pedido
            JOIN producto  ON pedido_producto.ID_Producto = producto.ID_Producto
            JOIN usuario on pedido.ID_Usuario = usuario.ID_Usuario
            ORDER BY pedido.ID_Pedido ASC
            ");

        /// Se crea una array para guardar los valores
        $productos = [];

        // Se gurdan los resultados como un objeto de la classe PedidosUsuario
        while ($obj = $stmt->fetch_object('PedidosUsuario')) {
            $productos[] = $obj;
        }

        // Se devuelve productos
        return $productos;
    }

    public static function eliminarpedido($id)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Desactivamos temporalmente las restricciones de clave foránea para poder eliminar el registro
        $conexion->query('SET foreign_key_checks = 0');

        // Se prepara la consulta con la base de datos donde eliminara el pedido que queramos 
        $stmt = $conexion->prepare("DELETE FROM `pedido` WHERE ID_Pedido =?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $id);

        // Ejecutamos la consulta
        $stmt->execute();

        // Volvemos a activar las restricciones de clave foránea
        $conexion->query('SET foreign_key_checks = 1');

        $conexion->close();

        // Se devuelve verdadero
        return true;
    }

    public static function revisarprecio($idpedido)
    {
        // Se cogen todos los productos del pedido
        $pedido= PedidosUsuarioDAO::cogerpedido($idpedido);

        // Se cogen todos los productos
        $productos = ProductoDAO::getAllProductos();

    // Se calcula el precio del pedido
        $precio = Calcularprecios::calcularprecio($pedido, $productos);
 


        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde actualizara el precio del pedido 
        $stmt = $conexion->prepare("UPDATE `pedido` SET Precio_Pedido=? WHERE ID_Pedido=? ");
        // Se le dan los parametros necesarios
        $stmt->bind_param("ii", $precio, $idpedido);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return $precio;
    }

    public static function cantidad($idproducto, $idpedido, $cantidad)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde actualizara un producto con las variables que le pasemos 
        $stmt = $conexion->prepare("UPDATE `pedido_producto` SET Cantidad=? WHERE ID_Pedido=? AND ID_Producto=?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("iii", $cantidad, $idpedido, $idproducto);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }

    public static function eliminarproductopedido($idproducto, $idpedido)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde actualizara un producto con las variables que le pasemos 
        $stmt = $conexion->prepare("DELETE FROM `pedido_producto` WHERE ID_Pedido=? AND ID_Producto=?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("ii", $idpedido, $idproducto);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }

    public static function añadirproductopedido($idproducto, $idpedido, $cantidad)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde añadira un producto al pedido que queramos 
        $stmt = $conexion->prepare("INSERT INTO `pedido_producto`(`ID_Pedido`, `ID_Producto`, `Cantidad`) VALUES (?,?,?)");
        // Se le dan los parametros necesarios
        $stmt->bind_param("iii", $idpedido, $idproducto, $cantidad);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }

    public static function crearpedido($producto, $precio, $cantidad, $usuario)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Guardamos en variables los datos que necesitemos
        $fechaActual = date("Y-m-d");

        // Se prepara la consulta con la base de datos donde guardaremos los datos del pedido
        $stmt = $conexion->prepare("
        INSERT INTO `pedido` (ID_Usuario, Precio_Pedido, Fecha_Pedido)
        VALUES (?, ?, ?)
        ");
        // Se le pasan los parametros necesarios
        $stmt->bind_param("ids", $usuario, $precio, $fechaActual);

        
        // Se ejecuta la consulta
        $stmt->execute();

         //Se hace otra consulta para guardar el id del pedido que se acaba de crear
        $stmt = $conexion->prepare("
            SELECT ID_Pedido FROM `pedido` ORDER BY ID_Pedido DESC LIMIT 1
             ");
        
        $id = $conexion->insert_id;

        // Se prepara la consulta con la base de datos donde crearemos los valores de la tabla intermedia para asociar el pedido con sus productos
        $stmt = $conexion->prepare("
        INSERT INTO PEDIDO_PRODUCTO (ID_Pedido, ID_Producto, Cantidad)
        VALUES
        (?, ?, ?)
        ");
        // Se le pasan los parametros necesarios
        $stmt->bind_param("iii", $id, $producto, $cantidad);

        // Se ejecuta la consulta
        $stmt->execute();

        return true;
    }
}
?>