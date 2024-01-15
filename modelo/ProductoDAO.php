<?php

include_once 'config/dataBase.php';
include_once 'Producto.php';
include_once 'Bebida.php';
include_once 'Pedido.php';

class ProductoDAO
{
    public static function getAllProductos()
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se hace una consulta con la base de datos donde nos devolvera toda la comida 
        $stmt = $conexion->query(
            "SELECT producto.ID_Producto,
                categoria_producto.Nombre_Categoria_Producto AS ID_Categoria_Producto,
                producto.Nombre_Producto,
                producto.Precio_Producto,
                producto.Imagen_Producto,
                producto.Descripcion
            FROM producto
            JOIN categoria_producto ON producto.ID_Categoria_Producto = categoria_producto.ID_Categoria_Producto
            where Alcohol is null
            ORDER BY categoria_producto.ID_Categoria_Producto ASC;"
        );

        // Se crea una array para guardar los valores
        $productos = [];

        // Se gurdan los resultados como un objeto de la classe Producto
        while ($obj = $stmt->fetch_object('Producto')) {
            $productos[] = $obj;
        }

        // Se hace una consulta con la base de datos donde nos devolvera toda la bebida 
        $stmt = $conexion->query(
            "SELECT producto.ID_Producto,
                categoria_producto.Nombre_Categoria_Producto AS ID_Categoria_Producto,
                producto.Nombre_Producto,
                producto.Precio_Producto,
                producto.Imagen_Producto,
                producto.Descripcion,
                producto.Alcohol
            FROM producto
            JOIN categoria_producto ON producto.ID_Categoria_Producto = categoria_producto.ID_Categoria_Producto
            where Alcohol is not null
            ORDER BY categoria_producto.ID_Categoria_Producto ASC;"
        );

        // Se gurdan los resultados como un objeto de la classe Bebida
        while ($obj = $stmt->fetch_object('Bebida')) {
            $productos[] = $obj;
        }

        // Se devuelve productos
        return $productos;
    }



    public static function getProductoByID($id)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos devolvera el producto que queramos 
        $stmt = $conexion->prepare("SELECT producto.ID_Producto,
            categoria_producto.Nombre_Categoria_Producto AS ID_Categoria_Producto,
            producto.Nombre_Producto,
            producto.Precio_Producto,
            producto.Imagen_Producto,
            producto.Descripcion
            FROM producto
            JOIN categoria_producto ON producto.ID_Categoria_Producto = categoria_producto.ID_Categoria_Producto
            WHERE ID_producto=?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $id);

        // Ejecutamos la consulta
        $stmt->execute();

        // Se guarda el resultado
        $resultado = $stmt->get_result();

        $conexion->close();

        // Se devuelve el resultado como un abjeto de la clase Producto
        return $resultado->fetch_object('Producto');
    }

    public static function eliminarproducto($id)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Desactivamos temporalmente las restricciones de clave foránea para poder eliminar el registro
        $conexion->query('SET foreign_key_checks = 0');

        // Se prepara la consulta con la base de datos donde eliminara el producto que queramos 
        $stmt = $conexion->prepare("DELETE FROM `producto` WHERE ID_Producto=?");
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

    public static function idcategoriaproducto($nombrecategoria)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos dara el ID de la categoria que queramos 
        $stmt = $conexion->prepare("SELECT ID_Categoria_Producto 
            FROM `categoria_producto` 
            WHERE Nombre_Categoria_Producto=?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("s", $nombrecategoria);

        // Ejecutamos la consulta
        $stmt->execute();

        // Se vincula el resultado a una variable
        $stmt->bind_result($resultado);

        // Se obtiene del resultado
        $stmt->fetch();
        $conexion->close();

        // Se devuelve el resultado
        return $resultado;
    }

    public static function tienealcohol($alcohol)
    {
        // Si la variable es si se vuelve 1 si es no 0
        if ($alcohol == 'si') {
            return 1;
        } else {
            return 0;
        }

    }

    public static function crearproducto($categoria, $nombre, $precio, $imagen, $descripcion)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde creara un producto con las variables que le pasemos 
        $stmt = $conexion->prepare("INSERT INTO `producto`(
                `ID_Categoria_Producto`,
                `Nombre_Producto`,
                `Precio_Producto`,
                `Imagen_Producto`,
                `Descripcion`
            )
            VALUES(?, ?, ?, ?, ?)");
        // Se le dan los parametros necesarios
        $stmt->bind_param("isdss", $categoria, $nombre, $precio, $imagen, $descripcion);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }

    public static function crearbebida($categoria, $nombre, $precio, $imagen, $descripcion, $alcohol)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde creara una bebida con las variables que le pasemos 
        $stmt = $conexion->prepare("INSERT INTO `producto`(
                `ID_Categoria_Producto`,
                `Nombre_Producto`,
                `Precio_Producto`,
                `Imagen_Producto`,
                `Descripcion`, 
                `Alcohol`
            )
            VALUES(?, ?, ?, ?, ?, ?)");
        // Se le dan los parametros necesarios
        $stmt->bind_param("isdssi", $categoria, $nombre, $precio, $imagen, $descripcion, $alcohol);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }


    public static function actualizarproducto($id, $categoria, $nombre, $precio, $imagen, $descripcion)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde actualizara un producto con las variables que le pasemos 
        $stmt = $conexion->prepare("UPDATE `producto`
            SET
              `ID_Categoria_Producto` = ?,
              `Nombre_Producto` = ?,
              `Precio_Producto` = ?,
              `Imagen_Producto` = ?,
              `Descripcion` = ?
            WHERE `ID_Producto` = ?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("isdssi", $categoria, $nombre, $precio, $imagen, $descripcion, $id);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }

    public static function actualizarbebida($id, $categoria, $nombre, $precio, $imagen, $descripcion, $alcohol)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde actualizara una bebida con las variables que le pasemos 
        $stmt = $conexion->prepare("UPDATE `producto`
            SET
              `ID_Categoria_Producto` = ?,
              `Nombre_Producto` = ?,
              `Precio_Producto` = ?,
              `Imagen_Producto` = ?,
              `Descripcion` = ?,
              `Alcohol` = ?
            WHERE `ID_Producto` = ?");
        // Se le dan los parametros necesarios
        $stmt->bind_param("isdssii", $categoria, $nombre, $precio, $imagen, $descripcion, $alcohol, $id);

        // Ejecutamos la consulta
        $stmt->execute();

        $conexion->close();

        // Se devuelve cierto
        return true;
    }

    public static function getProductosPedido($idpedido)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos devolvera los productos del pedido que queramos 
        $stmt = $conexion->prepare("SELECT producto.ID_Producto,
        categoria_producto.Nombre_Categoria_Producto AS ID_Categoria_Producto,
        producto.Nombre_Producto,
        producto.Precio_Producto,
        producto.Imagen_Producto,
        producto.Descripcion
        FROM producto
        JOIN categoria_producto ON producto.ID_Categoria_Producto = categoria_producto.ID_Categoria_Producto
        JOIN pedido_producto ON producto.ID_Producto = pedido_producto.ID_Producto
        WHERE pedido_producto.ID_pedido=? AND producto.Alcohol is null");
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $idpedido);

        // Ejecutamos la consulta
        $stmt->execute();

        // Se guarda el resultado
        $resultado = $stmt->get_result();
        // Se crea una array para guardar los valores
        $productos = [];

        // Si no hay comida no se añaden
        if ($resultado!= false) {
            // Se gurdan los resultados como un objeto de la classe Producto
            while ($obj = $resultado->fetch_object('Producto')) {
                $pedido = new Pedido($obj);
                $idproducto= $pedido->getProducto()->getIDProducto();
                $conexion->close();
                $conexion = DataBase::connect();
                // Se prepara la consulta con la base de datos donde nos devolvera la cantidad del producto que queremos 
                $stmt = $conexion->prepare("SELECT Cantidad FROM `pedido_producto` WHERE ID_Producto=? AND ID_Pedido=?");
                // Se le dan los parametros necesarios
                $stmt->bind_param("ii", $idproducto, $idpedido);
            
                // Ejecutamos la consulta
                $stmt->execute();

                // Se vincula el resultado a una variable
                $stmt->bind_result($cantidad);

                // Se obtiene del resultado
                $stmt->fetch();

                
                
                $pedido->setCantidad($cantidad);


                array_push($productos, $pedido);
            }
        }
        $conexion->close();
        $conexion = DataBase::connect();
        // Se prepara la consulta con la base de datos donde nos devolvera las bebidas del pedido que queramos 
        $stmt = $conexion->prepare("SELECT producto.ID_Producto,
        categoria_producto.Nombre_Categoria_Producto AS ID_Categoria_Producto,
        producto.Nombre_Producto,
        producto.Precio_Producto,
        producto.Imagen_Producto,
        producto.Descripcion,
        producto.Alcohol
        FROM producto
        JOIN categoria_producto ON producto.ID_Categoria_Producto = categoria_producto.ID_Categoria_Producto
        JOIN pedido_producto ON producto.ID_Producto = pedido_producto.ID_Producto
        WHERE pedido_producto.ID_pedido=? AND producto.Alcohol is not null");
        
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $idpedido);

        // Ejecutamos la consulta
        $stmt->execute();
        // Se guarda el resultado
        $resultado = $stmt->get_result();

        // Si no hay bebida no se añaden
        if ($resultado!= false) {
            // Se gurdan los resultados como un objeto de la classe Bebida
            while ($obj = $resultado->fetch_object('Producto')) {
                $pedido = new Pedido($obj);
                $idproducto= $pedido->getProducto()->getIDProducto();
                
                $conexion->close();
                $conexion = DataBase::connect();
                // Se prepara la consulta con la base de datos donde nos devolvera la cantidad del producto que queremos 
                $stmt = $conexion->prepare("SELECT Cantidad FROM `pedido_producto` WHERE ID_Producto=? AND ID_Pedido=?");
                // Se le dan los parametros necesarios
                $stmt->bind_param("ii", $idproducto, $idpedido);
            
                // Ejecutamos la consulta
                $stmt->execute();

                // Se vincula el resultado a una variable
                $stmt->bind_result($cantidad);

                // Se obtiene del resultado
                $stmt->fetch();

                
                
                $pedido->setCantidad($cantidad);


                array_push($productos, $pedido);
            }
        }

        // Se devuelve productos
        return $productos;
    }



}
?>