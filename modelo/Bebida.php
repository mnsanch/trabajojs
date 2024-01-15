<?php
include_once "Producto.php";
class Bebida extends Producto
{
    protected $Alcohol;

    public function __construct()
    {

    }

    /**
     * Get the value of Alcohol
     */
    public function getAlcohol()
    {
        return $this->Alcohol;
    }

    /**
     * Set the value of Alcohol
     */
    public function setAlcohol($Alcohol): self
    {
        $this->Alcohol = $Alcohol;

        return $this;
    }
}
?>