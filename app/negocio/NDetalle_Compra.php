<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Compra.php';

if (isset($_REQUEST['funcion'])) {
    $detalle_compra = new NDetalleCompra();
    switch ($_REQUEST['funcion']) {

        case "listado":
            $id_compra = $_POST['id_compra'];
            $detalle_compra->listadoDetalleCompra($id_compra);
            break;
        case "detalle":
            $id_compra = $_REQUEST['id_compra'];
            $detalle_compra->getDetalleCompra($id_compra);
            break;
    }
}

class NDetalleCompra
{

    public function listadoDetalleCompra($id_compra)
    {
        $detalle_compra = new DDetalleCompra();
        $detalle_compra->setIdCompra($id_compra);
        $lista = $detalle_compra->listadoDetalleCompra();
        echo $lista;
    }

    public function getDetalleCompra($id_compra)
    {
        $detalle_compra_insumo = new DDetalleCompra();
        $detalle_compra_insumo->setIdCompra($id_compra);
		//echo $id_compra;
		$lista_detalle = $detalle_compra_insumo->getDetalleCompra();
        echo $lista_detalle;
    }

}

?>