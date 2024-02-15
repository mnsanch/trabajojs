<?php
class Usuario
{
        protected $ID_Usuario;
        protected $Nombre_Usuario;
        protected $Correo;
        protected $Direccion;
        protected $Telefono;
        protected $contraseña;
        protected $Nombre_Categoria_Usuario;
        protected $Puntos;

        public function __construct()
        {
        }





        /**
         * Get the value of ID_Usuario
         */
        public function getIDUsuario()
        {
                return $this->ID_Usuario;
        }

        /**
         * Set the value of ID_Usuario
         */
        public function setIDUsuario($ID_Usuario): self
        {
                $this->ID_Usuario = $ID_Usuario;

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

        /**
         * Get the value of Correo
         */
        public function getCorreo()
        {
                return $this->Correo;
        }

        /**
         * Set the value of Correo
         */
        public function setCorreo($Correo): self
        {
                $this->Correo = $Correo;

                return $this;
        }

        /**
         * Get the value of Direccion
         */
        public function getDireccion()
        {
                return $this->Direccion;
        }

        /**
         * Set the value of Direccion
         */
        public function setDireccion($Direccion): self
        {
                $this->Direccion = $Direccion;

                return $this;
        }

        /**
         * Get the value of Telefono
         */
        public function getTelefono()
        {
                return $this->Telefono;
        }

        /**
         * Set the value of Telefono
         */
        public function setTelefono($Telefono): self
        {
                $this->Telefono = $Telefono;

                return $this;
        }

        /**
         * Get the value of contraseña
         */
        public function getContraseña()
        {
                return $this->contraseña;
        }

        /**
         * Set the value of contraseña
         */
        public function setContraseña($contraseña): self
        {
                $this->contraseña = $contraseña;

                return $this;
        }

        /**
         * Get the value of Nombre_Categoria_Usuario
         */
        public function getNombreCategoriaUsuario()
        {
                return $this->Nombre_Categoria_Usuario;
        }

        /**
         * Set the value of Nombre_Categoria_Usuario
         */
        public function setNombreCategoriaUsuario($Nombre_Categoria_Usuario): self
        {
                $this->Nombre_Categoria_Usuario = $Nombre_Categoria_Usuario;

                return $this;
        }

        /**
         * Get the value of Puntos
         */
        public function getPuntos()
        {
                return $this->Puntos;
        }

        /**
         * Set the value of Puntos
         */
        public function setPuntos($Puntos): self
        {
                $this->Puntos = $Puntos;

                return $this;
        }
}
?>