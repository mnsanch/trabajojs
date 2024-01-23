<?php
class Comentario
{
        protected $ID_Comentario;
        protected $Nombre_Usuario;
        protected $Comentario;
        protected $Valoracion;

        public function __construct ($ID_Comentario, $Nombre_Usuario, $Comentario, $Valoracion){
                $this->$ID_Comentario=$ID_Comentario;
                $this->$Nombre_Usuario=$Nombre_Usuario;
                $this->$Comentario=$Comentario;
                $this->$Valoracion=$Valoracion;
        }


        /**
         * Get the value of ID_Comentario
         */
        public function getIDComentario()
        {
                return $this->ID_Comentario;
        }

        /**
         * Set the value of ID_Comentario
         */
        public function setIDComentario($ID_Comentario): self
        {
                $this->ID_Comentario = $ID_Comentario;

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
         * Get the value of Comentario
         */
        public function getComentario()
        {
                return $this->Comentario;
        }

        /**
         * Set the value of Comentario
         */
        public function setComentario($Comentario): self
        {
                $this->Comentario = $Comentario;

                return $this;
        }

        /**
         * Get the value of Valoracion
         */
        public function getValoracion()
        {
                return $this->Valoracion;
        }

        /**
         * Set the value of Valoracion
         */
        public function setValoracion($Valoracion): self
        {
                $this->Valoracion = $Valoracion;

                return $this;
        }
}
?>