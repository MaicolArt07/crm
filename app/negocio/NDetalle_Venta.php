<?php
//require $_SERVER['DOCUMENT_ROOT'].'/Breadking/app/datos/Venta.php';
//require $_SERVER['DOCUMENT_ROOT'].'/Breadking/app/datos/DDetalle_venta.php';
//require '/../datos/venta.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Venta.php';
//echo"hola";
if (isset($_REQUEST['funcion'])) {
    $detalle_venta = new NDetalleVenta();
    switch ($_REQUEST['funcion']) {

        case "listado":
            $id_venta = $_POST['id_venta'];
            $detalle_venta->listadoDetalleVenta($id_venta);
            break;
        case "detalle":
            $id_venta = $_REQUEST['id_venta'];
            $detalle_venta->getDetalleVenta($id_venta);
			//echo "hola"; 
            break;
    }
}

class NDetalleVenta
{

    public function listadoDetalleVenta($id_venta)
    {
        $detalle_venta = new DDetalleVenta();
        $detalle_venta->setIdVenta($id_venta);
        $lista = $detalle_venta->listadoDetalleVenta();
        echo $lista;
    }

    public function getDetalleVenta($id_venta)
    {
        $detalle_venta_insumo = new DDetalleVenta();
        $detalle_venta_insumo->setIdVenta($id_venta);
		$lista_detalle = $detalle_venta_insumo->getDetalleVenta();
        echo $lista_detalle;
    }

}
