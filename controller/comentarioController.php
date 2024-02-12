<?php

// Creamos el controlador de pedidos
include_once 'modelo/Usuario.php';
include_once 'modelo/UsuarioDAO.php';
include_once 'modelo/Usuario.php';
include_once 'modelo/PedidosUsuarioDAO.php';




class comentarioController
{

    public function añadircomentario()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelCrearcomentarios.html';

        //fotter
        include_once 'vistas/footer.php';

    }

    public function mostrarcomentario()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelMostrarcomentarios.html';

        //fotter
        include_once 'vistas/footer.php';

    }

}
?>