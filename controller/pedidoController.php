<?php

// Creamos el controlador de pedidos
include_once 'modelo/Pedido.php';
include_once 'modelo/PedidosUsuarioDAO.php';




class pedidoController
{

    public function confirmar()
    {
        if (!isset($_SESSION['correo'])) {
            // Si no te has registrado te llevara al panel de login para que lo hagas
            usuarioController::login();
        } else {
            // // Almacena el pedido en la base de datos
            // $idpedido = PedidosUsuarioDAO::guardarpedido();

            // // Guarda el id del pedido en una cookie  con el nombre del usuario que durara 1h
            // setcookie($_SESSION['idusuario'], $idpedido, time() + 3600);
            // // Guarda en otra cookie el precio de la compra que durara 1h
            // setcookie($_SESSION['idusuario'] . 'precio', ($precio = Calcularprecios::calcularpreciofinal($_SESSION['selecciones'])), time() + 3600);

            // Elimina la sesión de selecciones.
            unset($_SESSION['selecciones']);

            // Redirige a la página principal
            productoController::index();
        }
    }

    public function ultimopedido()
    {
        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelUltimoPedido.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function modificarpedidos()
    {
        //Llamo al modelo para obtener los datos
        $pedidos = PedidosUsuarioDAO::cogertodoslospedidos();

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelTodoslosPedidos.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function editarpedido()
    {
        //Llamo al modelo para obtener los datos
        $productos = ProductoDAO::getProductosPedido($_POST["modificar"]);
        $idpedido=$_POST["modificar"];
        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelEditarPedidos.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function editarproductopedido()
    {
        //Llamo al modelo para obtener los datos

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelEditarProductosPedido.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function añadirproducto()
    {
        //Llamo al modelo para obtener los datos
        $productos = ProductoDAO::getAllProductos();

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelAñadirPedidoProductos.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function añadirpedido()
    {
        //Llamo al modelo para obtener los datos
        $productos = ProductoDAO::getAllProductos();
        $usuarios = UsuarioDAO::getAllUsuarios();

        //cabecera
        include_once 'vistas/header.php';

        // Panel
        include_once 'vistas/panelCrearPedido.php';

        //fotter
        include_once 'vistas/footer.php';
    }

    public function eliminarpedido()
    {
        // Elimina el pedido seleccionado de la base de datos
        PedidosUsuarioDAO::eliminarpedido($_POST["eliminar"]);

        // Redirige al panel de modificar productos
        $this->modificarpedidos();
    }

    public function modificar()
    {

        //Se actualiza la cantidad en la base de datos con los datos entregados y se cambia el precio del pedido
        PedidosUsuarioDAO::cantidad($_POST['id'], $_POST['pedido'], $_POST['cantidad']);
        PedidosUsuarioDAO::revisarprecio($_POST['pedido']);
      
        $this->modificarpedidos();
    }

    public function eliminarproductopedido()
    {
        // Elimina el producto del pedido seleccionado de la base de datos y se cambia el precio del pedido
        PedidosUsuarioDAO::eliminarproductopedido($_POST['eliminar'], $_POST['idpedido']);
        PedidosUsuarioDAO::revisarprecio($_POST['idpedido']);

        // Redirige al panel de modificar productos
        $this->modificarpedidos();
    }

    public function añadirproductopedido()
    {
        //Se añade un producto al pedido seleccionado y se cambia el precio del pedido
        PedidosUsuarioDAO::añadirproductopedido($_POST['producto'], $_POST['idpedido'], $_POST['cantidad']);
        PedidosUsuarioDAO::revisarprecio($_POST['idpedido']);
        // Redirige al panel de modificar productos
        $this->modificarpedidos();
        
        
    }

    public function crearpedido()
    {
        // Se mira cuanto ha costado el producto con su cantidad
        $precio= Calcularprecios::calaularprecioproducto($_POST['producto'], $_POST['cantidad']);
        //Se crea un pedido nuevo
        PedidosUsuarioDAO::crearpedido($_POST['producto'],$precio, $_POST['cantidad'], $_POST['usuario']);

        // Redirige al panel de modificar productos
        $this->modificarpedidos();
        
    }

}
?>