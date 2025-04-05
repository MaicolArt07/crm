<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DGasto.php';

if (isset($_REQUEST['funcion'])) {
    $gasto = new NGasto();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
			$id_tipo_gasto = $_POST['id_tipo_gasto'];
			$fecha = $_POST['fecha'];
			$total = $_POST['total'];
            $gasto->insertarGasto($nombre, $descripcion, $fecha, $total, $id_tipo_gasto);
            break;
        case "modificar":
            $id_gasto = $_POST['id_gasto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
			$id_tipo_gasto = $_POST['id_tipo_gasto'];
			$fecha = $_POST['fecha'];
			$total = $_POST['total'];
            $gasto->modificarGasto($id_gasto, $nombre, $descripcion, $fecha, $total, $id_tipo_gasto);
            break;
        case "habilitar":
            $id_gasto = $_POST['id_gasto'];
            $gasto->habilitarGasto($id_gasto);
            break;
        case "deshabilitar":
            $id_gasto = $_POST['id_gasto'];
            $gasto->deshabilitarGasto($id_gasto);
            break;
        case "listado":
            $gasto->listadoGastos();
            break;
        case "search":
            $gasto->searchGastos();
            break;
    }
}

class NGasto
{
    public function insertarGasto($nombre, $descripcion, $fecha, $total, $id_tipo_gasto)
    {
		//echo ' nombre:'.$nombre.' desc:'.$descripcion.' fecha'.$fecha.' total:'.$total.' tipo_gasto:'.$id_tipo_gasto;
        $gasto = new DGasto();
        $gasto->setNombre($nombre);
        $gasto->setDescripcion($descripcion);
        $gasto->setIdTipoGasto($id_tipo_gasto);
        $gasto->setFecha($gasto->formatDate($fecha));
		$gasto->setTotal($total);
        $result = $gasto->insertarGasto();
        if ($result) {
            echo 'Gasto guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }

    }

    public function modificarGasto($id_gasto, $nombre, $descripcion, $fecha, $total, $id_tipo_gasto)
    {
        
		$gasto = new DGasto();
        $gasto->setIdGasto($id_gasto);
        $gasto->setNombre($nombre);
        $gasto->setDescripcion($descripcion);
        $gasto->setIdTipoGasto($id_tipo_gasto);
		$gasto->setFecha($gasto->formatDate($fecha));
		$gasto->setTotal($total);
        $result = $gasto->modificarGasto();
        if ($result) {
            echo 'Gasto modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarGasto($id_gasto)
    {
        $gasto = new DGasto();
        $gasto->setIdGasto($id_gasto);
        $result = $gasto->habilitarGasto();
        if ($result) {
            echo 'Gasto habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarGasto($id_gasto)
    {
        $gasto = new DGasto();
        $gasto->setIdGasto($id_gasto);
        $result = $gasto->deshabilitarGasto();
        if ($result) {
            echo 'Gasto deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoGastos()
    {
        $gasto = new DGasto();
        $lista = $gasto->listadoGastos();
        echo $lista;
    }

    public function searchGastos()
    {
        $gasto = new DGasto();
        $lista = $gasto->searchGastos();
        echo $lista;
    }
}