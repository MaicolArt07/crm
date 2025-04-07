<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DTraspaso.php';
// require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Transporte.php';
//$vector = array("Id"=>"1", "Fecha"=>"01-02-2023", "Usuario"=>"eder","Estado"=>"1");
//echo json_encode($vector);
if (isset($_REQUEST['funcion'])) {
	$traspaso = new NTraspaso();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $id_usuario = $_POST['id_usuario'];
            $fecha = $_POST['fecha'];
            $detalle = json_decode($_POST['detalle'], true);  // Decodifica el JSON recibido
        
            // Llama a la función para insertar el transporte
            $traspaso->insertarTransporte($id_usuario, $fecha, $detalle);
            break;
		// case "agregar_producto":
		// 	$id_transporte = $_POST['id_transporte'];
        //     $detalle_transporte = $_POST['detalle_transporte'];
        //     $transportar->agregarProductoTransporte($id_transporte, $detalle_transporte);
        //     break;
        case "listadoTraspasos":
            $traspaso->listadoTraspasos();
        break;
        case "detalleTransporteAbiertos":
            $traspaso->detalleTransporteAbiertos();
        break;

        case "trasportesAbiertos":
            $id_usuario = $_REQUEST["id_usuario"];
            $id_producto = $_REQUEST["id_producto"];
            
            $traspaso->trasportesAbiertos($id_usuario, $id_producto);
        break;
        

		// case "finalizar":
		// 	$id_transporte = $_POST['id_transporte'];
        //     $transportar->finalizar($id_transporte);
        //     break;
    }
}

class NTraspaso
{
    public function insertarTransporte($id_usuario, $fecha, $detalle)
    {
        $traspaso = new DTraspaso();
		$fecha_formato = $traspaso->formatDate($fecha);
        $traspaso->setFecha($fecha_formato);
        
        foreach ($detalle as $value) 
        {
            $id_detalle = $value['idDetalle'];
            $id_transporte = $value['idTransporte'];
            $cantidad = $value['cantidad'];
            $id_producto = $value['idProducto'];


            $traspaso->setIdTrasporteDestino($id_transporte);
            $traspaso->setIdDetalleTransporte($id_detalle);
            $traspaso->setIdDetalleCantidadTraspaso($cantidad);
            $traspaso->setIdProducto($id_producto);

            $result = $traspaso->insertarTraspaso();

            if($result)
            {
                $id_traspaso = $traspaso->getId();
                $detalle = $traspaso->insertarDetalleTraspaso($id_traspaso);

                if($detalle)
                {
                    $modificar_transporte = $traspaso->modificarDetalleTransporte();
                    if($modificar_transporte)
                    {
                        $actualizar_detalle_transpaso = $traspaso->actualizarDetalleTransporteDestino();
                        
                    }
                }
            }else{
                break;
            }
        }

            if($actualizar_detalle_transpaso)
            {
                echo "Se guardó la orden de Transporte";
            }else{
                echo "No se guardó la orden de Traspaso";
            }


		// //echo 'guardo transporte';
		// if ($result) {
		// 	//echo 'ingresa a guardar detalle transporte';
        //     $id_transporte = $traspaso->getId();
		// 	$t_detalle_transporte = json_decode($detalle, TRUE);
		// 	foreach ($t_detalle_transporte as $value) {
        //         $id_producto = $value['p'];
		// 		$cantidad = $value['c'];
        //         $detalle_transporte = new DDetalleTransporte();
        //         $detalle_transporte->setIdTransportar($id_transporte);
		// 		$detalle_transporte->setIdProducto($id_producto);
        //         $detalle_transporte->setCantidad($cantidad);
        //         $detalle_transporte->insertarDetalleTransporte();
        //         /*try {
        //             if(!$detalle_transporte->insertarDetalleTransporte())
        //             {
        //                 echo ', No se guardó la orden de Transporte';
        //                 $transportar->EliminarTransporte();
        //                 return false;
        //             }
        //         }
        //         catch(\Exception $e){
        //             echo "hola";
        //         }*/
                 
		// 	}
        //     echo 'Orden de transporte guardada satisfactoriamente.';
        // }else {
        //     echo 'Error ';
		// 	echo $result;
        // }
    }

	// public function agregarProductoTransporte($id_transporte, $tabla_detalle_transporte)
    // {
    //     //$id_transporte = $transportar->getId();
	// 		$t_detalle_transporte = json_decode($tabla_detalle_transporte, TRUE);
	// 		foreach ($t_detalle_transporte as $value) {
    //             $id_producto = $value['p'];
	// 			$cantidad = $value['c'];
    //             $detalle_transporte = new DDetalleTransporte();
    //             $detalle_transporte->setIdTransportar($id_transporte);
	// 			$detalle_transporte->setIdProducto($id_producto);
    //             $detalle_transporte->setCantidad($cantidad);
	// 			if(!$detalle_transporte->agregarDetalleTransporte())
	// 			{
	// 				echo ', No se guardó la orden de Transporte';
	// 				return false;
	// 			}
	// 		}
    //         echo 'Orden de transporte guardada satisfactoriamente.';
    // }

    public function listadoTraspasos()
    {
        $traspaso = new DTraspaso();
        $lista = $traspaso->listadoTraspasos();
        echo $lista;
    }
	
    public function detalleTransporteAbiertos()
    {
        $traspaso = new DTraspaso();
        $lista = $traspaso->detalleTransporteAbiertos();
        echo $lista;
    }

    public function trasportesAbiertos($id_usuario, $id_producto)
    {
        $traspaso = new DTraspaso();
        $traspaso->setIdUsuario($id_usuario);

        $lista = $traspaso->trasportesAbiertos();
        echo $lista;
    }

}