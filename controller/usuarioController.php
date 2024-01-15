<?php

// Creamos el controlador de pedidos
session_start();
include_once 'modelo/Usuario.php';
include_once 'modelo/UsuarioDAO.php';
include_once 'modelo/Usuario.php';
include_once 'modelo/PedidosUsuarioDAO.php';




class usuarioController
{

    public function login()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelLogin.php';

        //fotter
        include_once 'vistas/footer.php';

    }

    public function modificardatosusuario()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelModificarUsuario.php';

        //fotter
        include_once 'vistas/footer.php';

    }

    public function verpedido()
    {
        //Llamo al modelo para obtener los datos
        $pedidos = PedidosUsuarioDAO::cogerpedidosusuario($_SESSION['idusuario']);

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelPedidosUsuario.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function iniciosesion()
    {
        // Mira si se la ha dado a iniciar sesion o a registrarse
        if (isset($_POST['iniciar'])) {
            // si le da a iniciar sesion
            // Crea una variable de error en falso
            $error = false;

            // Comprueba que el usuario existe
            $usuarios = UsuarioDAO::validarusuario($_POST['correo'], $_POST['contraseña']);

            if ($usuarios == false) {
                // Si al comprobar el usuario no existe cambia la variable de error a verdadero
                $error = true;
            }

            //Redirige a la pagina de registro
            //cabecera
            include_once 'vistas/header.php';

            // Panel
            include_once 'vistas/panelLogin.php';

            //fotter
            include_once 'vistas/footer.php';
        } elseif (isset($_POST['registrarse'])) {
            // Si se le da a registrarse redirige a la pagina de registro redirige a su pagina
            //cabecera
            include_once 'vistas/header.php';

            // Panel
            include_once 'vistas/panelRegistrarse.php';

            //fotter
            include_once 'vistas/footer.php';
        }
    }

    public function crearsesion()
    {
        // Primero se mira si el correo ya existe
        $mirarcorreo = UsuarioDAO::comprobarcorreo($_POST['correo']);

        // Si existe se crea una variable de error y se redirige al panel de registrarse
        if ($mirarcorreo == false) {
            $correo = false;
            //cabecera
            include_once 'vistas/header.php';

            // Panel
            include_once 'vistas/panelRegistrarse.php';

            //fotter
            include_once 'vistas/footer.php';

            // Si no existe se crea el usuario
        } else {
            // Se comprueba que el usuario haya puesto bien la contraseña
            $validar = UsuarioDAO::comprobarcontraseña($_POST['contraseña'], $_POST['confirmar_contrasena']);
            if ($validar == true) {
                // Se encripta la contraseña
                $contraseñaencriptada = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
                // Si esta bien puesta se crea el usuario
                UsuarioDAO::crearusuario($_POST['nombre'], $_POST['correo'], $_POST['direccion'], $_POST['telefono'], $contraseñaencriptada);

                // Una vez el usuario se ha creado se guardan sus datos en variables de sesiony se redirige al panel de login
                $usuarios = UsuarioDAO::validarusuario($_POST['correo'], $_POST['contraseña']);
                $this->login();
            } else {
                // Si las contraseñas son diferentes se crea la variable de error y se redirige al panel de registrarse
                $crear = false;

                //cabecera
                include_once 'vistas/header.php';

                // Panel
                include_once 'vistas/panelRegistrarse.php';

                //fotter
                include_once 'vistas/footer.php';
            }
        }
    }
    public function salirsesion()
    {
        // Se destruyen todas las variables de sesion que hubiesen creadas y se redirige al home
        session_destroy();
        ProductoController::index();
    }

    public function modificarsesion()
    {

        // Primero se mira si el correo ya existe o o si es el suyo
        $mirarcorreo = UsuarioDAO::comprobarmodificarcorreo($_POST['correo'], $_POST['correoantiguo']);

        // Si existe se crea una variable de error y se redirige al panel de modificar
        if ($mirarcorreo == false) {
            $correo = false;
            //cabecera
            include_once 'vistas/header.php';

            // Panel
            include_once 'vistas/panelModificarUsuario.php';

            //fotter
            include_once 'vistas/footer.php';

            // Si no existe o es el suyo modifica el usuario
        } else {

            // Comprueba que las contraseñas sean iguales
            $validar = UsuarioDAO::comprobarcontraseña($_POST['contraseña'], $_POST['confirmar_contrasena']);

            // Si las contraseñas son las mismas modifica el usuario
            if ($validar == true) {

                // Se encripta la contraseña
                $contraseñaencriptada = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

                // Modificamos el usuario en la base de datos con los datos obtenidos
                $usuario = UsuarioDAO::modificarusuario($_POST['nombre'], $_POST['correo'], $_POST['direccion'], $_POST['telefono'], $contraseñaencriptada, $_SESSION['idusuario']);

                // Eliminamos todas las variables de sesion del usuario
                unset($_SESSION['nombre']);
                unset($_SESSION['correo']);
                unset($_SESSION['contraseña']);
                unset($_SESSION['direccion']);
                unset($_SESSION['telefono']);
                unset($_SESSION['idusuario']);
                unset($_SESSION['categoria']);

                // Creamos las variables de sesion del usuario con los nuevos datos
                $_SESSION['nombre'] = $usuario->getNombreUsuario();
                $_SESSION['correo'] = $usuario->getCorreo();
                $_SESSION['contraseña'] = $usuario->getContraseña();
                $_SESSION['direccion'] = $usuario->getDireccion();
                $_SESSION['telefono'] = $usuario->getTelefono();
                $_SESSION['idusuario'] = $usuario->getIDUsuario();
                $_SESSION['categoria'] = $usuario->getNombreCategoriaUsuario();

                // redirigimos a la pagina del login
                $this->login();
            } else {
                // Si las contraseñas son diferentes se crea la variable de error y se redirige al panel de modificar
                $modificar = false;

                //cabecera
                include_once 'vistas/header.php';

                // Panel
                include_once 'vistas/panelModificarUsuario.php';

                //fotter
                include_once 'vistas/footer.php';
            }
        }

    }

}
?>