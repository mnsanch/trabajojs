<?php
    class Producto {
        protected $ID_Producto;
        protected $ID_Categoria_Producto;
        protected $Nombre_Producto;
        protected $Precio_Producto;
        protected $Imagen_Producto;
        protected $Descripcion;
        public function __construct (){
        }



        

        /**
         * Get the value of ID_Producto
         */
        public function getIDProducto()
        {
                return $this->ID_Producto;
        }

        /**
         * Set the value of ID_Producto
         */
        public function setIDProducto($ID_Producto): self
        {
                $this->ID_Producto = $ID_Producto;

                return $this;
        }

        /**
         * Get the value of ID_Categoria_Producto
         */
        public function getIDCategoriaProducto()
        {
                return $this->ID_Categoria_Producto;
        }

        /**
         * Set the value of ID_Categoria_Producto
         */
        public function setIDCategoriaProducto($ID_Categoria_Producto): self
        {
                $this->ID_Categoria_Producto = $ID_Categoria_Producto;

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
         * Get the value of Precio_Producto
         */
        public function getPrecioProducto()
        {
                return number_format($this->Precio_Producto, 2);
                
        }

        /**
         * Set the value of Precio_Producto
         */
        public function setPrecioProducto($Precio_Producto): self
        {
                $this->Precio_Producto = $Precio_Producto;

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
    }
?>