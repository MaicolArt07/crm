<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DTransportar.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Transporte.php';
//$vector = array("Id"=>"1", "Fecha"=>"01-02-2023", "Usuario"=>"eder","Estado"=>"1");
//echo json_encode($vector);
if (isset($_REQUEST['funcion'])) {
	$transportar = new NTransportar();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $id_usuario = $_POST['id_usuario'];
            $fecha = $_POST['fecha'];
            $detalle_transporte = $_POST['detalle_transporte'];
            $transportar->insertarTransporte($id_usuario, $fecha, $detalle_transporte);
            break;
		case "agregar_producto":
			$id_transporte = $_POST['id_transporte'];
            $detalle_transporte = $_POST['detalle_transporte'];
            $transportar->agregarProductoTransporte($id_transporte, $detalle_transporte);
            break;
        case "listado":
            $transportar->listadoTransportes();
			//echo "hola";
            break;
		case "finalizar":
			$id_transporte = $_POST['id_transporte'];
            $transportar->finalizar($id_transporte);
            break;
    }
}

class NTransportar
{
    public function insertarTransporte($id_usuario, $fecha, $tabla_detalle_transporte)
    {
        $transportar = new DTransportar();
		$transportar->setIdUsuario($id_usuario);
		$fecha_formato = $transportar->formatDate($fecha);
        $transportar->setFecha($fecha_formato);
        $result = $transportar->insertarTransporte();
		//echo 'guardo transporte';
		if ($result) {
			//echo 'ingresa a guardar detalle transporte';
            $id_transporte = $transportar->getId();
			$t_detalle_transporte = json_decode($tabla_detalle_transporte, TRUE);
			foreach ($t_detalle_transporte as $value) {
                $id_producto = $value['p'];
				$cantidad = $value['c'];
                $detalle_transporte = new DDetalleTransporte();
                $detalle_transporte->setIdTransportar($id_transporte);
				$detalle_transporte->setIdProducto($id_producto);
                $detalle_transporte->setCantidad($cantidad);
                $detalle_transporte->insertarDetalleTransporte();
                /*try {
                    if(!$detalle_transporte->insertarDetalleTransporte())
                    {
                        echo ', No se guardó la orden de Transporte';
                        $transportar->EliminarTransporte();
                        return false;
                    }
                }
                catch(\Exception $e){
                    echo "hola";
                }*/
                 
			}
            echo 'Orden de transporte guardada satisfactoriamente.';
        }else {
            echo 'Error ';
			echo $result;
        }
    }

	public function agregarProductoTransporte($id_transporte, $tabla_detalle_transporte)
    {
        //$id_transporte = $transportar->getId();
			$t_detalle_transporte = json_decode($tabla_detalle_transporte, TRUE);
			foreach ($t_detalle_transporte as $value) {
                $id_producto = $value['p'];
				$cantidad = $value['c'];
                $detalle_transporte = new DDetalleTransporte();
                $detalle_transporte->setIdTransportar($id_transporte);
				$detalle_transporte->setIdProducto($id_producto);
                $detalle_transporte->setCantidad($cantidad);
				if(!$detalle_transporte->agregarDetalleTransporte())
				{
					echo ', No se guardó la orden de Transporte';
					return false;
				}
			}
            echo 'Orden de transporte guardada satisfactoriamente.';
    }

    public function listadoTransportes()
    {
        $transportar = new DTransportar();
        $lista = $transportar->listadoTransportes();
        echo $lista;
    }
	
	public function finalizar($id_transporte)
    {
        $transportar = new DTransportar();
		$transportar->setId($id_transporte);
        $respuesta = $transportar->Finalizar();
        echo $respuesta;
    }
}