<?php
class PedidosUsuario
{
        protected $ID_Pedido;
        protected $Precio_Pedido;
        protected $Cantidad;
        protected $Nombre_Producto;
        protected $Imagen_Producto;
        protected $Descripcion;
        protected $Nombre_Usuario;

        public function __construct()
        {
        }

        

        /**
         * Get the value of ID_Pedido
         */
        public function getIDPedido()
        {
                return $this->ID_Pedido;
        }

        /**
         * Set the value of ID_Pedido
         */
        public function setIDPedido($ID_Pedido): self
        {
                $this->ID_Pedido = $ID_Pedido;

                return $this;
        }

        /**
         * Get the value of Precio_Pedido
         */
        public function getPrecioPedido()
        {
                return $this->Precio_Pedido;
        }

        /**
         * Set the value of Precio_Pedido
         */
        public function setPrecioPedido($Precio_Pedido): self
        {
                $this->Precio_Pedido = $Precio_Pedido;

                return $this;
        }

        /**
         * Get the value of Cantidad
         */
        public function getCantidad()
        {
                return $this->Cantidad;
        }

        /**
         * Set the value of Cantidad
         */
        public function setCantidad($Cantidad): self
        {
                $this->Cantidad = $Cantidad;

                return $this;
        }

        /**
         * Get the value of Nombre_Producto
         */
        public function getNombreProducto()
        {
                return $this->Nombre_Producto;
        }

        /**
         * Set the value of Nombre_Producto
         */
        public function setNombreProducto($Nombre_Producto): self
        {
                $this->Nombre_Producto = $Nombre_Producto;

                return $this;
        }

        /**
         * Get the value of Imagen_Producto
         */
        public function getImagenProducto()
        {
                return $this->Imagen_Producto;
        }

        /**
         * Set the value of Imagen_Producto
         */
        public function setImagenProducto($Imagen_Producto): self
        {
                $this->Imagen_Producto = $Imagen_Producto;

                return $this;
        }

        /**
         * Get the value of Descripcion
         */
        public function getDescripcion()
        {
                return $this->Descripcion;
        }

        /**
         * Set the value of Descripcion
         */
        public function setDescripcion($Descripcion): self
        {
                $this->Descripcion = $Descripcion;

                return $this;
        }

        /**
         * Get the value of Nombre_Usuario
         */
        public function getNombreUsuario()
        {
                return $this->Nombre_Usuario;
        }

        /**
         * Set the value of Nombre_Usuario
         */
        public function setNombreUsuario($Nombre_Usuario): self
        {
                $this->Nombre_Usuario = $Nombre_Usuario;

                return $this;
        }
}
?>