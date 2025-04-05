<?php

class Detalle_Factura_para_php {

    public $Nombre_Producto;
    public $Id_Producto;
    public $Cantidad;
    public $Total = 0.0;
    public $factura;

    public function __construct() {
        $this->Cantidad = -1;
    }

    public function Guardar($gestor) {
        return $gestor->Guardar_Detalle_Factura($this);
    }
}
?>