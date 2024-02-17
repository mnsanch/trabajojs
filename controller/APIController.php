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
            // Se llama al comentarioDAO para conseguir todos los comentarios
            $comentarios = ComentarioDAO::mostrarcomentarios();

            // Pasamos los comentarios por JSON al JS
            echo json_encode($comentarios, JSON_UNESCAPED_UNICODE) ; 

            //return para salir de la funcion
            return; 
        }

        public function mostrarcomentariosanonimos(){
            // Se llama al comentarioDAO para conseguir todos los comentarios creados por usuarios anonimos
            $comentarios = ComentarioDAO::mostrarcomentariosanonimos();

            // Pasamos los comentarios por JSON al JS
            echo json_encode($comentarios, JSON_UNESCAPED_UNICODE) ; 

            //return para salir de la funcion
            return; 
        }

        public function mostrarcomentariosvalidados(){
            // Se llama al comentarioDAO para conseguir todos los comentarios creados por usuarios validados
            $comentarios = ComentarioDAO::mostrarcomentariosvalidados();

            // Pasamos los comentarios por JSON al JS
            echo json_encode($comentarios, JSON_UNESCAPED_UNICODE) ; 

            //return para salir de la funcion
            return; 
        }

        public function añadircomentarios(){
            // Recibimos los datos del JS
            $json = file_get_contents('php://input');

            // Descodificamos el JSON
            $datos = json_decode($json, true);

            // Guardamos los datos que recibimos por JSON en variables
            $nombre = $datos['nombre'];
            $comentario = $datos['comentario'];
            $valoracion = $datos['valoracion'];

            // Usamos el comentarioDAO para guradar los comentarios en la base de datos
            ComentarioDAO::guardarcomentarioo($nombre, $comentario, $valoracion);

            //return para salir de la funcion
            return; 
        }


        public function datosultimopedido() {
            // Guardamos en pedidos la array de selecciones que es lo que se usa en la cesta
            $pedidos = $_SESSION['selecciones'];

            // Creamos una array vacia
            $array = [];
            
            // Hacemos un bucle de pedidos para guardar sus valores en la array creada para hacer un array asociativo
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
            
            // Pasamos la array por JSON al JS
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
            return;
        }
        public function comprar(){
            // Recibimos los datos del JS
            $json = file_get_contents('php://input');

            // Descodificamos el JSON
            $datos = json_decode($json, true);

            // Guardamos los datos que recibimos por JSON en variables
            $precio = $datos['total'];
            $propina = $datos['propina'];
            $puntos = $datos['puntos'];
            $puntosantiguos = $datos['puntostotales'];
            $puntosconseguidos = $datos['puntosconseguidos'];
            // Hacemos un calculo para ver cuantos puntos tiene el usuario al restarle los gastados y sumarle los recibidos
            $puntostotales = $puntosantiguos-$puntos+$puntosconseguidos;

            // Usamos UsuarioDAO para modificar los puntos que tiene el  usuario despues de la compra 
			UsuarioDAO::modificarpuntos($puntostotales, $_SESSION['idusuario']);

            // Usamos PedidosUsuarioDAO para guardar en el pedido con el precio y la propina
            PedidosUsuarioDAO::guardarpedido($precio, $propina);
 
            //return para salir de la funcion
            return; 
        }

    public function preciototal(){
        // Guardamos en precio la llamada a Calcularprecios para conseguir el precio total de la cesta actual 
        $precio=Calcularprecios::calcularpreciofinal($_SESSION['selecciones']);

        // Pasamos el precio por JSON al JS
        echo json_encode($precio, JSON_UNESCAPED_UNICODE) ; 

        //return para salir de la funcion
        return; 
    }

    public function cogerpuntosusuario(){
        // Guardamos en puntos la llamada a UsuarioDAO para conseguir los puntos del usuario actual 
        $puntos=UsuarioDAO::cogerpuntosusuario($_SESSION['idusuario']);

        // Pasamos los puntos por JSON al JS
        echo json_encode($puntos, JSON_UNESCAPED_UNICODE) ; 

        //return para salir de la funcion
        return; 

    }

    public function cogernombreusuario(){
        // Guardamos en puntos la llamada a UsuarioDAO para conseguir los puntos del usuario actual 
        if (isset($_SESSION['nombre'])) {
            $nombreusuario=$_SESSION['nombre'];
        }else{
            $nombreusuario= false;
        }

        // Pasamos los puntos por JSON al JS
        echo json_encode($nombreusuario, JSON_UNESCAPED_UNICODE) ; 

        //return para salir de la funcion
        return; 

    }
            
}