<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DTraspaso.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Traspaso.php';

//$vector = array("Id"=>"1", "Fecha"=>"01-02-2023", "Usuario"=>"eder","Estado"=>"1");
//echo json_encode($vector);
if (isset($_REQUEST['funcion'])) 
{
	$traspaso = new NTraspaso();
    switch ($_REQUEST['funcion']) 
    {
        case "insertar":
            $fecha = $_POST['fecha'];
            $detalle = json_decode($_POST['detalle'], true);  // Decodifica el JSON recibido
            $traspaso->insertarTraspaso($fecha, $detalle);
            break;

        case "listadoTraspasos":
            $traspaso->listadoTraspasos();
        break;
        case "detalleTransporteAbiertos":
            $traspaso->detalleTransporteAbiertos();
        break;
        case "transportesTranspasos":
            $id_usuario = $_REQUEST['id_usuario'];
            $traspaso->transportesTranspasos($id_usuario);
        break;
        
        case "productosTransporteOrigen":
            $id_usuario = $_REQUEST["id_usuario"];
            $id_transporte_origen = $_REQUEST["id_transporte"];
            $traspaso->productosTransporteOrigen($id_usuario, $id_transporte_origen);
        break;
        

		// case "finalizar":
		// 	$id_transporte = $_POST['id_transporte'];
        //     $transportar->finalizar($id_transporte);
        //     break;
    }
}

class NTraspaso
{
    public function insertarTraspaso($fecha, $detalle)
    {
        $traspaso = new DTraspaso();
        $fecha_formato = $traspaso->formatDate($fecha);
        $traspaso->setFecha($fecha_formato);
        
        foreach ($detalle as $value) 
        {
            $id_detalle = $value['id_detalle'];
            $id_transporte_origen = $value['id_transporte_origen'];
            $id_transporte_destino = $value['id_transporte_destino'];
            $id_usuario_transporte = $value['id_usuario_transporte'];
            $id_usuario_destino = $value['id_usuario_destino'];
            $producto = $value['producto'];
            $usuario = $value['usuario'];
            $cantidad_disponible = $value['cantidad_disponible'];
            $transporte_destino = $value['transporte_destino'];
            $cantidad_traspaso = $value['cantidad_traspaso'];
            $id_producto = $value['id_producto'];
            $id_usuario = $value['id_usuario'];

    
            $traspaso->setIdTransporteOrigen($id_transporte_origen);
            $traspaso->setIdTransporteDestino($id_transporte_destino);
            $traspaso->setIdUsuario($id_usuario);

            // $traspaso->setIdDetalleTransporte($id_detalle);
            // $traspaso->setIdDetalleCantidadTraspaso($cantidad);
            // $traspaso->setIdProducto($id_producto);

            $result = $traspaso->insertarTraspaso();

            if($result)
            {
                $id_traspaso = $traspaso->getId();

                // Creamos una instancia en el detalle para obtener sus atributos y funcionalidades
                $detalle_traspaso = new DDetalleTraspaso();

                $detalle_traspaso->setIdTraspaso($id_traspaso);
                $detalle_traspaso->setCantidad($cantidad_traspaso);
                $detalle_traspaso->setIdDetalleTraspasoOrigen($id_detalle);

                $detalle = $detalle_traspaso->insertarDetalleTranporteDestino();

                if($detalle)
                {
                    // Insertamos en el detalel traspaso
                    $detalle_traspaso = $detalle_traspaso->insertarDetalleTraspaso($id_traspaso, $fecha);
                }
            }else{
                break;
            }
        }

            if($detalle_traspaso)
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

    public function transportesTranspasos($id_usuario)
    {
        $traspaso = new DTraspaso();
        $traspaso->setIdUsuario($id_usuario);
        $lista = $traspaso->transportesTranspasos();
        echo $lista;
    }

    public function productosTransporteOrigen($id_usuario, $id_transporte_origen)
    {
        $traspaso = new DTraspaso();
        $traspaso->setIdUsuario($id_usuario);
        $traspaso->setIdTransporteOrigen($id_transporte_origen);

        $lista = $traspaso->productosTransporteOrigen();
        echo $lista;
    }

}