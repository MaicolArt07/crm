<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Transporte.php';

if (isset($_REQUEST['funcion'])) {
    $detalle_transporte = new NDetalleTransporte();
    switch ($_REQUEST['funcion']) {

        case "listado":
            $id_transporte = $_POST['id_transporte'];
            $detalle_transporte->listadoDetalleTransporte($id_transporte);
            break;
        case "detalle":
            $id_transporte = $_REQUEST['id_transporte'];
            $detalle_transporte->getDetalleTransporte($id_transporte);
            break;
		case "detalle_modificar":
            $id_transporte = $_REQUEST['id_transporte'];
            $detalle_transporte->getDetalleTransporte_Modificar($id_transporte);
            break;
    }
}

class NDetalleTransporte
{

    public function listadoDetalleTransporte($id_transporte)
    {
        $detalle_transporte = new DDetalleTransporte();
        $detalle_transporte->setIdTransportar($id_transporte);
        $lista = $detalle_transporte->listadoDetalleTransporte();
        echo $lista;
    }

    public function getDetalleTransporte($id_transporte)
    {
        $detalle_transporte_insumo = new DDetalleTransporte();
        $detalle_transporte_insumo->setIdTransportar($id_transporte);
		//echo $id_transporte;
		$lista_detalle = $detalle_transporte_insumo->getDetalleTransporte();
        echo $lista_detalle;
    }
	
	public function getDetalleTransporte_Modificar($id_transporte)
    {
        $detalle_transporte_insumo = new DDetalleTransporte();
        $detalle_transporte_insumo->setIdTransportar($id_transporte);
		//echo $id_transporte;
		$lista_detalle = $detalle_transporte_insumo->getDetalleTransporte_Modificar();
        echo $lista_detalle;
    }

}
 ?>