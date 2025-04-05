<?php

class Factura {

    public $Id = 1;
    public $Tipo_Pago = "";
    public $Fecha = "";
    public $Usuario;
    public $SubTotal = 0.0;
    public $Descuento = 0.0;
    public $SubTotalPagar = 0.0;
    public $MontoTotalPagar = 0.0;
    public $Estado;

    public $Numero_Factura;
    public $Codigo_Control;
    public $NIT;
    public $Razon_Social;

    public $Cuf;
    public $cufd;
    public $Sincronizado_Con_Impuestos = 0;
    public $Sincronizado_Con_Impuestos_texto;
    public $Correo;
    public $Total_Literal;
    public $Tipo_Documento;

    public $Complemento;
    public $Leyenda;
    public $Tipo_Emision = "";
    public $Id_Leyenda;
    public $Punto_Venta = 0;

    public $ImporteCreditoFiscal = 0.0;
    public $Llave = "";

    public $Lista_detalle_factura = array();
    public $gestor;

    public function setSubTotal($SubTotal) {
        $this->SubTotal = $SubTotal;
        $this->Calculo_Monto_Total_Pagar_Y_Monto_Total_Sujeto_IVA();
    }

    public function __construct() {
        $this->Id = 1;
    }

    public function Adicionar_Detalle($detalle_factura) {
        $detalle_factura->setFactura($this);
        $this->Lista_detalle_factura[] = $detalle_factura;
        $this->SubTotal = $this->SubTotal + $detalle_factura->getTotal();
    }

    public function Quitar_Detalle($ubicacion) {
        $this->SubTotal = $this->SubTotal - $this->Lista_detalle_factura[$ubicacion]->getTotal();
        array_splice($this->Lista_detalle_factura, $ubicacion, 1);
    }

    public function Guardar() {
        $this->Obtener_Id_Leyenda();
        $this->gestor = new Gestor();
        $this->Id = $this->gestor->Guardar_Factura($this);
        $cont = 0;
        while ($cont < count($this->Lista_detalle_factura)) {
            $this->Lista_detalle_factura[$cont]->setFactura($this);
            $this->Lista_detalle_factura[$cont]->Guardar($this->gestor);
            $cont++;
        }
        $this->gestor->Cerrar_Conexion();
        return $this->Id;
    }

    private function Obtener_Id_Leyenda() {
        $this->Id_Leyenda = (int)floor((rand() * 8) + 1);
    }

    public function Anular_Factura() {
        $this->gestor = new Gestor();
        $this->Id = $this->gestor->Anular_Factura($this);
        return $this->Id;
    }

    public function Existe_Id_Guardado() {
        $this->gestor = new Gestor();
        return $this->gestor->Existe_Dato("Factura", "Id = " . $this->Id);
    }

    public function Actualizar_Hora() {
        $g = new Gestor();
        $g->Acturalizar_Hora_Factura($this);
    }

    public function Calculo_Monto_Total_Pagar_Y_Monto_Total_Sujeto_IVA() {
        $this->MontoTotalPagar = round(($this->SubTotal - $this->Descuento) * 100.0) / 100.0;
        $this->ImporteCreditoFiscal = round(($this->SubTotal - $this->Descuento) * 100.0) / 100.0;
    }

}
?>
