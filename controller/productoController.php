<?php

// Creamos el controlador de pedidos
include_once 'modelo/ProductoDAO.php';
include_once 'modelo/UsuarioDAO.php';
include_once 'modelo/Pedido.php';
include_once 'utils/precios.php';





class productoController
{

    public static  function index()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelHome.php';

        //fotter
        include_once 'vistas/footer.php';

    }

    public function productos()
    {

        //Llamo al modelo para obtener los datos
        $productos = ProductoDAO::getAllProductos();
        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelPedido.php';

        //fotter
        include_once 'vistas/footer.php';

    }

    public function compra()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelCompra.php';

        //fotter
        include_once 'vistas/footer.php';

    }

    public function modificardatoproducto()
    {
        //Llamo al modelo para obtener los datos
        $productos = ProductoDAO::getAllProductos();

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelModificarEliminarProductos.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function añadirproducto()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelAñadirProductos.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function editarproducto()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelEditarProductos.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function comprar()
    {
        // Verifica si existe selecciones dentro de la variable $_SESSION
        if (!isset($_SESSION['selecciones'])) {
            // Si no existe la crea y agrega el primer pedido
            $_SESSION['selecciones'] = array();
            $pedido = new Pedido(ProductoDAO::getProductoByID($_POST['id']));
            array_push($_SESSION['selecciones'], $pedido);
        } else {
            // Si existe agrega un nuevo pedido en la existente
            $pedido = new Pedido(ProductoDAO::getProductoByID($_POST['id']));
            $existe = false;

            // Recorre los productos en el carrito actual
            foreach ($_SESSION['selecciones'] as $producto) {
                // Si el producto esta en el carrito suma 1 a la cantdad
                if ($producto->getProducto()->getNombreProducto()==$pedido->getProducto()->getNombreProducto()) {
                    $existe = true;
                    $producto->setCantidad($producto->getCantidad()+1);
                }
            }
            // Si el producto no este en el carrito lo añade
            if ($existe==false){
                array_push($_SESSION['selecciones'], $pedido);
            } 
        }

        // Redirige a la página de productos
        $this->productos();
    }

    public function sumarrestar()
    {
        // Primero mira si se le ha dado a mas o menos 
        if (isset($_POST['mas'])) {
            // Si es mas incrementa la cantidad del pedido seleccionado en 1
            $pedido = $_SESSION['selecciones'][$_POST['mas']];
            $pedido->setCantidad($pedido->getCantidad() + 1);
        } elseif (isset($_POST['menos'])) {
            // Si es menos decrementa 1
            $pedido = $_SESSION['selecciones'][$_POST['menos']];

            // Se mira cuanta cantidad hay
            if ($pedido->getCantidad() == 1) {
                // Si hay solo 1 elimina el pedido de selecciones
                unset($_SESSION['selecciones'][$_POST['menos']]);

                // Reindexa el array
                $_SESSION['selecciones'] = array_values($_SESSION['selecciones']);
            } else {
                // si hay mas de 1 decrementa la cantidad del pedido en 1
                $pedido->setCantidad($pedido->getCantidad() - 1);
            }
        }

        // Redirige al carrito
        $this->compra();
    }

    public function borrar()
    {
        // Elimina el pedido seleccionado de selecciones
        unset($_SESSION['selecciones'][$_POST['borrar']]);

        // Reindexa el array
        $_SESSION['selecciones'] = array_values($_SESSION['selecciones']);

        // Redirige al carrito
        $this->compra();
    }

    public function borrartodo()
    {
        // Elimina la sesión de selecciones.
        unset($_SESSION['selecciones']);

        // Redirige al carrito
        $this->compra();
    }

    public function crear()
    {
        // Si se ha escogido como categoria una bebida y no se le ha definido si hay alcohol o no se crea el error y se redirige al panel de vuelta
        if (($_POST['categoria'] == "Bebida con Gas" || $_POST['categoria'] == "Bebida sin Gas" || $_POST['categoria'] == "Bebida Alcohólica") && !isset($_POST['alcohol'])) {
            $errorbebida = true;
            //cabecera
            include_once 'vistas/header.php';

            // Panel
            include_once 'vistas/panelAñadirProductos.php';

            //fotter
            include_once 'vistas/footer.php';
            // Si en canvio lo que se ha echo es cojer una comida y definirle el alcohol crea otro error y redirige de vuelta
        } elseif (($_POST['categoria'] != "Bebida con Gas" || $_POST['categoria'] != "Bebida sin Gas" || $_POST['categoria'] != "Bebida Alcohólica") && isset($_POST['alcohol'])) {
            $errorcomida = true;
            //cabecera
            include_once 'vistas/header.php';

            // Panel
            include_once 'vistas/panelAñadirProductos.php';

            //fotter
            include_once 'vistas/footer.php';
            /// si se ha echo todo vien se crea el producto
        } else {
            // Se mira si se ha definido el alcohol para crear o comida o bebida
            if (isset($_POST['alcohol'])) {
                // Se convierte el nombre de la categoria en in id
                $idcategoria = productoDAO::idcategoriaproducto($_POST['categoria']);
                // Se convierte el si lleva alcohol o no en un valor numerico
                $alcohol = productoDAO::tienealcohol($_POST['alcohol']);

                //Se crea la bebida
                productoDAO::crearbebida($idcategoria, $_POST['nombre'], $_POST['precio'], $_POST['imagen'], $_POST['descripcion'], $alcohol);
            } else {
                // Se convierte el nombre de la categoria en in id
                $idcategoria = productoDAO::idcategoriaproducto($_POST['categoria']);

                //Se crea la comida
                productoDAO::crearproducto($idcategoria, $_POST['nombre'], $_POST['precio'], $_POST['imagen'], $_POST['descripcion']);
            }

            // Redirige al panel de modificar productos
            $this->modificardatoproducto();
        }
    }

    public function modificar()
    {
        //Se mira si existe el valor alcohol para saber si es comida o bebida
        if (isset($_POST['alcohol'])) {
            // Se convierte el nombre de la categoria en in id
            $idcategoria = productoDAO::idcategoriaproducto($_POST['categoria']);
            // Se convierte el si lleva alcohol o no en un valor numerico
            $alcohol = productoDAO::tienealcohol($_POST['alcohol']);

            //Se actualiza la bebida en la base de datos con los datos entregados
            productoDAO::actualizarbebida($_POST['id'], $idcategoria, $_POST['nombre'], $_POST['precio'], $_POST['imagen'], $_POST['descripcion'], $alcohol);
        } else {
            // Se convierte el nombre de la categoria en in id
            $idcategoria = productoDAO::idcategoriaproducto($_POST['categoria']);

            //Se actualiza la comida en la base de datos con los datos entregados
            productoDAO::actualizarproducto($_POST['id'], $idcategoria, $_POST['nombre'], $_POST['precio'], $_POST['imagen'], $_POST['descripcion']);
        }
        $this->modificardatoproducto();
    }

    public function eliminarproducto()
    {
        // Elimina el producto seleccionado de la base de datos
        ProductoDAO::eliminarproducto($_POST["eliminar"]);

        // Redirige al panel de modificar productos
        $this->modificardatoproducto();
    }


}
?>