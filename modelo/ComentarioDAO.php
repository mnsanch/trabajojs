<?php

include_once 'config/dataBase.php';
include_once 'Comentario.php';


class ComentarioDAO
{
    public static function guardarcomentarioo($nombreusuario, $comentario, $valoracion)
    {
        // Conexion con la base de datos
        $conexion = DataBase::connect();

        if ($nombreusuario!='Anonimo') {
            $idUsuario=$_SESSION['idusuario'];

            // Se prepara la consulta con la base de datos donde guardaremos los datos del pedido
            $stmt = $conexion->prepare("
                    INSERT INTO `comentarios` (`ID_Usuario`, `Comentario`, `Valoracion`)
                    VALUES (?, ?, ?)
                ");
            // Se le pasan los parametros necesarios
            $stmt->bind_param("isi", $idUsuario, $comentario, $valoracion);


            // Se ejecuta la consulta
            $stmt->execute();

            return;

        }else {
            // Se prepara la consulta con la base de datos donde guardaremos los datos del pedido
            $stmt = $conexion->prepare("
                    INSERT INTO `comentarios` ( `Comentario`, `Valoracion`)
                    VALUES (?, ?)
                ");
            // Se le pasan los parametros necesarios
            $stmt->bind_param("si", $comentario, $valoracion);


            // Se ejecuta la consulta
            $stmt->execute();

            return;
        }
         

        
    }

    public static function mostrarcomentarios(){
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

    public static function mostrarcomentariosanonimos(){
        // Conexion con la basse de datos
        $conexion = DataBase::connect();

        // Se hace una consulta con la base de datos donde nos devolvera todaos los comentarios
        $stmt = $conexion->query("
            SELECT comentarios.ID_Comentario, usuario.Nombre_Usuario, comentarios.Comentario, comentarios.Valoracion 
            FROM comentarios 
            LEFT JOIN usuario ON comentarios.ID_Usuario = usuario.ID_Usuario
            WHERE usuario.ID_Usuario IS NULL
        ");

        /// Se crea una array para guardar los valores
        $comentarios = [];

        // Se gurdan los resultados como un objeto de la classe Comentario
        while ($row = $stmt->fetch_assoc()) {
            $comentarios[] = [
                'Nombre_Usuario'=> 'Anónimo',
                'ID_Comentario'=> $row['ID_Comentario'],
                'Comentario'=> $row['Comentario'],
                'Valoracion'=> $row['Valoracion']
            ];
        }


        // Se devuelve comentarios
        return $comentarios;
    }

    public static function mostrarcomentariosvalidados(){
        // Conexion con la basse de datos
        $conexion = DataBase::connect();

        // Se hace una consulta con la base de datos donde nos devolvera todaos los comentarios
        $stmt = $conexion->query("
            SELECT comentarios.ID_Comentario, usuario.Nombre_Usuario, comentarios.Comentario, comentarios.Valoracion 
            FROM comentarios 
            JOIN usuario ON comentarios.ID_Usuario = usuario.ID_Usuario
            WHERE comentarios.ID_Usuario=usuario.ID_Usuario
        ");

        /// Se crea una array para guardar los valores
        $comentarios = [];

        // Se gurdan los resultados como un objeto de la classe Comentario
        while ($row = $stmt->fetch_assoc()) {
            $comentarios[] = [
                'Nombre_Usuario'=> $row['Nombre_Usuario'],
                'ID_Comentario'=> $row['ID_Comentario'],
                'Comentario'=> $row['Comentario'],
                'Valoracion'=> $row['Valoracion']
            ];
        }


        // Se devuelve comentarios
        return $comentarios;
    }

}
?>