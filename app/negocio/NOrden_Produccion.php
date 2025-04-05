<?php
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DOrden_Produccion.php';
//require $_SERVER['DOCUMENT_ROOT'].'/Breadking/app/datos/DDetalle_Orden_Produccion.php';
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DDetalle_Receta.php';


//require '/../datos/orden_produccion.php';
//require '/../datos/detalle_orden_produccion.php';
//require '/../datos/detalle_receta_insumo.php';

if (isset($_REQUEST['funcion'])) {
	//echo "prueba";
    $orden_produccion = new NOrdenProduccion();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $fecha = $_POST['fecha'];
            $cantidad_produccion = $_POST['cantidad'];
            $cantidad_disponible = $_POST['cantidad_disponible'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $id_receta = $_POST['id_receta'];
            $id_producto = $_POST['id_producto'];
            $id_usuario = $_POST['id_usuario'];
            $orden_produccion->insertarOrdenProduccion($fecha, $cantidad_produccion, $cantidad_disponible, $fecha_vencimiento, $id_receta, $id_producto, $id_usuario);
            break;
        case "confirmar":
            $id_orden_produccion = $_POST['id_orden_produccion'];
            $cantidad_produccion = $_POST['cantidad_produccion'];
            $orden_produccion->confirmarCantidadProduccion($id_orden_produccion, $cantidad_produccion);
            break;
        case "listado":
            $orden_produccion->listadoProduccion();
            break;
        case "detalle_modal":
            $id_orden_produccion = $_POST['id_orden_produccion'];
            $orden_produccion->detalleProduccion($id_orden_produccion);
            break;
        case "detalle":
			
            $orden_produccion->listarOrdenProduccionBusqueda();
            break;
    }
}

class NOrdenProduccion
{

    public function insertarOrdenProduccion($fecha, $cantidad_produccion, $cantidad_disponible, $fecha_vencimiento, $id_receta, $id_producto, $id_usuario)
    {
		//echo 'insertadndo';
        $orden_produccion = new DOrdenProduccion();
        $fecha_formato = $orden_produccion->formatDate($fecha);
        $orden_produccion->setFecha($fecha_formato);
        $orden_produccion->setCantidadProduccion($cantidad_produccion);
        $orden_produccion->setCantidadDisponible($cantidad_disponible);
        $orden_produccion->setFechaVencimiento($orden_produccion->formatDate($fecha_vencimiento));
        $orden_produccion->setIdReceta($id_receta);
        $orden_produccion->setIdProducto($id_producto);
        $orden_produccion->setIdUsuario($id_usuario);
        $result = $orden_produccion->insertarOrdenProduccion();
				$Id = $result["Id"];
				//echo $result;
		if($Id<0)
		{
			echo 'No se pueder crear la Orden de Produccion, se necesitan '.$result["Cantidad"].' '.$result["Unidad_Medida"].' del insumo '.$result["Insumo"].' y falta '.$result["Diferencia"].' '.$result["Unidad_Medida"];
		}else
		{
			echo 'Guardado Correctamente';
		}       
	
	}

    public function listadoProduccion()
    {
        $orden_produccion = new DOrdenProduccion();
        $lista = $orden_produccion->listadoProduccion();
        echo $lista;
    }

    public function confirmarCantidadProduccion($id_orden_produccion, $cantidad_produccion)
    {
        $orden_produccion = new DOrdenProduccion();
        $orden_produccion->setId($id_orden_produccion);
        $orden_produccion->setCantidadProduccion($cantidad_produccion);
        $result = $orden_produccion->confirmarCantidadProduccion();
        if ($result) {
            echo 'Confirmación satisfactoria';
        } else {
            echo 'Error en la confirmación de la cantidad de producción';
        }
    }

    public function detalleProduccion($id_orden_produccion)
    {
        $orden_produccion = new DOrdenProduccion();
        $orden_produccion->setId($id_orden_produccion);
        $lista = $orden_produccion->detalleProduccion();
        echo $lista;
    }

    public function listarOrdenProduccionBusqueda()
    {
        $orden_produccion = new DOrdenProduccion();
        $lista = $orden_produccion->listarOrdenProduccionBusqueda();
        echo $lista;
    }

}

?>