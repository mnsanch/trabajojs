<?php
//Esto es un NUEVO CONTROLADOR
//hacer todas las configuraciones necesarias para que funcione como controlador

/** IMPORTANTE**/
//Cargar Modelos necesarios BBDD

/** IMPORTANTE**/
//Instala la extensión Thunder Client en VSC. Te permite probar si tu API funciona correctamente.

include_once 'modelo/ComentarioDAO.php';
class APIController{    
 
    public function mostrarcomentarios(){
            // Si quieres devolverle información al JS, codificas en json un array con la información
            // y se los devuelves al JS
            $comentarios = ComentarioDAO::mostrarcomentarios();

            echo json_encode($comentarios, JSON_UNESCAPED_UNICODE) ; 

            return; //return para salir de la funcion

    }

}