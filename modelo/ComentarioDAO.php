<?php

include_once 'config/dataBase.php';
include_once 'Comentario.php';


class ComentarioDAO
{
    public static function guardarcomentarioo()
    {
        // Conexion con la base de datos
        $conexion = DataBase::connect();

        // Guardamos en variables los datos que necesitemos
        $idUsuario = $_SESSION['idusuario'];
        $precio = Calcularprecios::calcularpreciofinal($_SESSION['selecciones']);
        $fechaActual = date("Y-m-d");

        // Se prepara la consulta con la base de datos donde guardaremos los datos del pedido
        $stmt = $conexion->prepare("
                INSERT INTO `pedido` (ID_Usuario, Precio_Pedido, Fecha_Pedido)
                VALUES (?, ?, ?)
            ");
        // Se le pasan los parametros necesarios
        $stmt->bind_param("ids", $idUsuario, $precio, $fechaActual);


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


















    public static function mostrarcomentarios()
    {
        // Conexion con la basse de datos
        $conexion = DataBase::connect();

        // Se hace una consulta con la base de datos donde nos devolvera todaos los comentarios
        $stmt = $conexion->query("
            SELECT comentarios.ID_Comentario, usuario.Nombre_Usuario, comentarios.Comentario, comentarios.Valoracion 
            FROM comentarios 
            LEFT JOIN usuario ON comentarios.ID_Usuario = usuario.ID_Usuario
            WHERE comentarios.ID_Usuario=usuario.ID_Usuario or comentarios.ID_Usuario IS NULL
        ");

        /// Se crea una array para guardar los valores
        $comentarios = [];

        // Se gurdan los resultados como un objeto de la classe Comentario
        while ($row = $stmt->fetch_assoc()) {
            if ($row['Nombre_Usuario']==null) {
                $comentarios[] = [
                    'Nombre_Usuario'=> 'Anónimo',
                    'ID_Comentario'=> $row['ID_Comentario'],
                    'Comentario'=> $row['Comentario'],
                    'Valoracion'=> $row['Valoracion']
                ];
            }else{
                $comentarios[] = [
                    'Nombre_Usuario'=> $row['Nombre_Usuario'],
                    'ID_Comentario'=> $row['ID_Comentario'],
                    'Comentario'=> $row['Comentario'],
                    'Valoracion'=> $row['Valoracion']
                ];
            }
        }


        // Se devuelve comentarios
        return $comentarios;
    }

}
?>