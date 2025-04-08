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

        case "actualizar_detalle_transporte":
            $id_detalle = $_REQUEST['id_detalle'];
            $cantidad = $_REQUEST['cantidad'];
            $cantidad_disponible = $_REQUEST['disponible'];
            $response_detalle_transporte = $detalle_transporte->modificarDetalleTransporte($id_detalle, $cantidad, $cantidad_disponible);
            echo json_encode($response_detalle_transporte);
        break;
        // case "eliminar_detalle_transporte":
        //     $id_detalle = $_REQUEST['id_detalle'];
        //     $response_detalle_transporte = $detalle_transporte->eliminarDetalleTransporte($id_detalle);
        //     echo json_encode($response_detalle_transporte);
        // break;
    }
}

class NDetalleTransporte
{

    public function listadoDetalleTransporte($id_transporte)
    {
        $detalle_transporte = new DDetalleTransporte();
        $detalle_transporte->setIdTransportar($id_transporte);
        // ! Esta funcion no existe en la clase detalle transporte, no se realizo ningun cambio ya inicio con el proyecto.
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

    public function modificarDetalleTransporte($id_detalle, $cantidad, $cantidad_disponible)
    {
        $detalle_transporte = new DDetalleTransporte();
        $detalle_transporte->setId($id_detalle);
        $detalle_transporte->setCantidad($cantidad);
        $detalle_transporte->setDisponible($cantidad_disponible);
		$response = $detalle_transporte->modificarDetalleTransporte();

        if($response)
        {
            $detalle_transporte->aumentarOrdenProduccion();
        }
        // Si las cantidad es igual a cero y la cantidad disponible del mismo modo eliminamos el detalle
        if($cantidad <= 0 && $cantidad_disponible <= 0)
        {
            $detalle_transporte->eliminarDetalleTransporte();
        }
        
        return $response;
    }

    // public function eliminarDetalleTransporte($id_detalle)
    // {
    //     $detalle_transporte = new DDetalleTransporte();
    //     $detalle_transporte->setId($id_detalle);
	// 	$response = $detalle_transporte->eliminarDetalleTransporte();
    //     return $response;
    // }
}
 ?>