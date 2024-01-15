<?php
class Calcularprecios
{
    public static function calcularpreciofinal($pedidos)
    {
        // Se inici una variable en 0
        $preciofinal = 0;

        // Se crea un bucle donde se van sumando los productos para obtener el precio final
        foreach ($pedidos as $pedido) {
            $preciofinal += $pedido->getProducto()->getPrecioProducto() * $pedido->getCantidad();
        }

        // se devuelve el precio final con 2 decimales
        return number_format($preciofinal, 2);
    }

    public static function calcularprecio($pedidos, $productos)
    {
        // Se inici una variable en 0
        $preciofinal = 0;
        // Se crea un bucle donde se mira lo que cuesta cada producto del pedido y se suma a la cantidad final
        foreach ($pedidos as $pedido) {
            foreach ($productos as $producto) {
                if ($producto->getNombreProducto()==$pedido->getNombreProducto()){
                    $preciofinal += $producto->getPrecioProducto() * $pedido->getCantidad();
                }
            }
        }

        // se devuelve el precio final con 2 decimales
        return number_format($preciofinal, 2);
    }
    
    public static function calaularprecioproducto($producto, $cantidad)
    {
        // Se hace el calculo
        $preciofinal = $producto*$cantidad;
        
        // se devuelve el precio final con 2 decimales
        return number_format($preciofinal, 2);
    }

}
?>