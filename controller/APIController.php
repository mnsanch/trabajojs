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

        // public function añadircomentarios(){
        //         // Si quieres devolverle información al JS, codificas en json un array con la información
        //         // y se los devuelves al JS
        //         $comentario = ComentarioDAO::guardarcomentarioo($w,$w,$w);

        //         echo json_encode($comentario, JSON_UNESCAPED_UNICODE) ; 

        //         return; //return para salir de la funcion
        // }


        public function datosultimopedido() {
                $pedidos = $_SESSION['selecciones'];
                $array = [];
            
                foreach ($pedidos as $pedido) {
            
                    $array[] = [
                        'ID_Producto' => $pedido->getProducto()->getIDProducto(),
                        'ID_Categoria_Producto' => $pedido->getProducto()->getIDCategoriaProducto(),
                        'Nombre_Producto' => $pedido->getProducto()->getNombreProducto(),
                        'Precio_Producto' => $pedido->getProducto()->getPrecioProducto(),
                        'Imagen_Producto' => $pedido->getProducto()->getImagenProducto(),
                        'Descripcion' => $pedido->getProducto()->getDescripcion(),
                        'cantidad' => $pedido->getCantidad(),
                    ];
                }
            
                echo json_encode($array, JSON_UNESCAPED_UNICODE);
                return;
        }
        public function comprar(){
            // Si quieres devolverle información al JS, codificas en json un array con la información
            // y se los devuelves al JS
            $json = file_get_contents('php://input');

                    // Decodificar el JSON a un array asociativo de PHP
            $datos = json_decode($json, true);

            // Obtener el precio del array asociativo
            $precio = $datos['total'];
            $propina = $datos['propina'];
            PedidosUsuarioDAO::guardarpedido($precio, $propina);


            return; //return para salir de la funcion
    }

    public function preciototal(){
        // Si quieres devolverle información al JS, codificas en json un array con la información
        // y se los devuelves al JS
        $precio=Calcularprecios::calcularpreciofinal($_SESSION['selecciones']);

        echo json_encode($precio, JSON_UNESCAPED_UNICODE) ; 

        return; //return para salir de la funcion
    }
            
}