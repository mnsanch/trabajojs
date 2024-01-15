<?php

include_once 'config/dataBase.php';
include_once 'Usuario.php';


class UsuarioDAO
{
    public static function getAllUsuarios()
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se hace una consulta con la base de datos donde nos devolvera todaos los usuarios
        $stmt = $conexion->query(
            "SELECT usuario.ID_Usuario,
                usuario.Nombre_Usuario,
                usuario.Correo,
                usuario.Direccion,
                usuario.Telefono,
                contraseñas.contraseña,
                categoria_usuario.Nombre_Categoria_Usuario
                FROM usuario
                JOIN contraseñas on usuario.ID_Usuario = contraseñas.ID_Usuario
                JOIN categoria_usuario on usuario.ID_Categoria_Usuario = categoria_usuario.ID_Categoria_Usuario"
        );

        // Se crea una array para guardar los valores
        $usuarios = [];

        // Se gurdan los resultados como un objeto de la classe Usuario
        while ($obj = $stmt->fetch_object('Usuario')) {
            $usuarios[] = $obj;
        }

        // Se devuelve usuarios
        return $usuarios;
    }



    public static function getUsuarioByID($id)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos devolvera el usuario que queramos 
        $stmt = $conexion->prepare(
            "SELECT usuario.ID_Usuario,
                usuario.Nombre_Usuario,
                usuario.Correo,
                usuario.Direccion,
                usuario.Telefono,
                contraseñas.contraseña,
                categoria_usuario.Nombre_Categoria_Usuario
                FROM usuario
                JOIN contraseñas on usuario.ID_Usuario = contraseñas.ID_Usuario
                JOIN categoria_usuario on usuario.ID_Categoria_Usuario = categoria_usuario.ID_Categoria_Usuario
                WHERE usuario.ID_Usuario=?"
        );
        // Se le dan los parametros necesarios
        $stmt->bind_param("i", $id);

        // Ejecutamos la consulta
        $stmt->execute();

        // Se guarda el resultado
        $resultado = $stmt->get_result();

        $conexion->close();

        // Se devuelve el resultado como un abjeto de la clase Usuario
        return $resultado->fetch_object('Usuario');
    }

    public static function validarusuario($correo, $contraseña)
    {
        // Se cojen todos los usuarios
        $usuarios = UsuarioDAO::getAllUsuarios();

        // Se crean variables de validacion
        $correobd = false;
        $contraseñabd = false;

        // Se hace un bucle que recorre todos los usuarios
        foreach ($usuarios as $usuario) {
            // Si el correo que nos da el usuario es igual a alguno de nuestros usuarios la variable de correodb se vuelve verdadero
            if ($usuario->getCorreo() == $correo) {
                $correobd = true;
            }
            // Si tenemos la variable de corro en verdadero y la contrseña que nos da el usuario es igual a algunoa de nuestras contraseñas la variable de contraseñadb se vuelve verdadero
            if ($correobd == true && password_verify($contraseña, $usuario->getContraseña())) {
                $contraseñabd = true;
            }
            // Si las dos variables son ciertas se guardan en variables de sesion todos los datos del usuario que necesitemos y cierra la funcion
            if ($correobd == true && $contraseñabd == true) {
                $_SESSION['nombre'] = $usuario->getNombreUsuario();
                $_SESSION['correo'] = $usuario->getCorreo();
                $_SESSION['contraseña'] = $usuario->getContraseña();
                $_SESSION['direccion'] = $usuario->getDireccion();
                $_SESSION['telefono'] = $usuario->getTelefono();
                $_SESSION['idusuario'] = $usuario->getIDUsuario();
                $_SESSION['categoria'] = $usuario->getNombreCategoriaUsuario();
                return true;
            }
            // Si el correo es igual pero la contraseña no correodb se vuelve falso para evitar que un corro pueda entrar con otra contraseña
            $correobd = false;
        }
        // Se devuelve falso
        return false;

    }

    public static function crearusuario($nombre, $correo, $direccion, $telefono, $contraseña)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde creara un usuario con las variables que le demos  
        $stmt = $conexion->prepare("
                INSERT INTO `usuario`(`ID_Categoria_Usuario`, `Nombre_Usuario`, `Correo`, `Direccion`, `telefono`)
                VALUES ('2',?,?,?,?);
            ");
        // Se le dan los parametros necesarios
        $stmt->bind_param("sssi", $nombre, $correo, $direccion, $telefono);

        // Ejecutamos la consulta
        $resultado = $stmt->execute();

        // Se prepara la consulta con la base de datos donde nos devolvera el id del usuario que queramos 
        $stmt = $conexion->prepare("
            SELECT ID_Usuario FROM `usuario` ORDER BY ID_Usuario DESC LIMIT 1
            ");

        $id = $conexion->insert_id;

        // Se prepara la consulta con la base de datos donde creara la contraseña del usuario recien creado 
        $stmt = $conexion->prepare("
            INSERT INTO `contraseñas`(`ID_Usuario`, `Contraseña`) VALUES (?,?);
            ");
        // Se le dan los parametros necesarios
        $stmt->bind_param("is", $id, $contraseña);

        // Ejecutamos la consulta
        $stmt->execute();

        // Se devuelve verdadero
        return true;

    }

    public static function modificarusuario($nombre, $correo, $direccion, $telefono, $contraseña, $id)
    {
        // Conexion con la base da datos
        $conexion = DataBase::connect();

        // Se prepara la consulta con la base de datos donde nos actualizara el usuario con los valores que nos da el propio usuario 
        $stmt = $conexion->prepare(
            "UPDATE
                    usuario
                JOIN contraseñas ON usuario.ID_Usuario = contraseñas.ID_Usuario
                SET
                    usuario.Nombre_Usuario = ?,
                    usuario.Correo = ?,
                    usuario.Direccion = ?,
                    usuario.Telefono = ?,
                    contraseñas.Contraseña = ?
                WHERE
                    contraseñas.ID_Usuario = ?"
        );
        // Se le dan los parametros necesarios
        $stmt->bind_param("sssisi", $nombre, $correo, $direccion, $telefono, $contraseña, $id);

        // Ejecutamos la consulta
        $stmt->execute();

        // COjemos el usuario con los cambios realizados
        $usuario = UsuarioDAO::getUsuarioByID($id);

        // Se devuelve el usuario
        return $usuario;

    }

    public static function comprobarcontraseña($contraseña, $contraseñaconfirmada)
    {
        // Si las contraseñas coinciden devuelve verdadero si no falso
        if ($contraseña == $contraseñaconfirmada) {
            return true;
        } else {
            return false;
        }
    }

    public static function comprobarcorreo($correo)
    {
        // Cojemos todos los usuarios
        $usuarios = UsuarioDAO::getAllUsuarios();
        // Miramos todos los correos de los usuarios para que no coincidan con los existentes
        foreach ($usuarios as $usuario) {
            if ($usuario->getCorreo() == $correo) {
                return false;
            }
        }
        return true;
    }

    public static function comprobarmodificarcorreo($correo, $correoantiguo)
    {
        // Si el correo antiguo es el mismo al nuevo devuelve verdadero
        if ($correo == $correoantiguo) {
            return true;
        }
        // Cojemos todos los usuarios
        $usuarios = UsuarioDAO::getAllUsuarios();
        // Miramos todos los correos de los usuarios para que no coincidan con los existentes
        foreach ($usuarios as $usuario) {
            if ($usuario->getCorreo() == $correo) {
                return false;
            }
        }
        return true;
    }
}
?>