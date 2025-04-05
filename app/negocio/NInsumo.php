<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DInsumo.php';

if (isset($_REQUEST['funcion'])) {
    $insumo = new NInsumo();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id_unidad_medida = $_POST['id_unidad_medida'];
            $estado = $_POST['estado'];
            $insumo->insertarInsumo($nombre, $descripcion, $id_unidad_medida, $estado);
            break;
        case "modificar":
            $id_insumo = $_POST['id_insumo'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id_unidad_medida = $_POST['id_unidad_medida'];
            $insumo->modificarInsumo($id_insumo, $nombre, $descripcion, $id_unidad_medida);
            break;
        case "habilitar":
            $id_insumo = $_POST['id_insumo'];
            $insumo->habilitarInsumo($id_insumo);
            break;
        case "deshabilitar":
            $id_insumo = $_POST['id_insumo'];
            $insumo->deshabilitarInsumo($id_insumo);
            break;
        case "listado":
            $insumo->listadoInsumos();
            break;
        case "search":
            $insumo->searchInsumos();
            break;
    }
}

class NInsumo
{
    public function insertarInsumo($nombre, $descripcion, $id_unidad_medida, $estado)
    {
        $insumo = new DInsumo();
        $insumo->setNombre($nombre);
        $insumo->setDescripcion($descripcion);
        $insumo->setEstado($estado);
        $insumo->setIdUnidadMedida($id_unidad_medida);
        $result = $insumo->insertarInsumo();
        if ($result) {
            echo 'Insumo guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }

    }

    public function modificarInsumo($id_insumo, $nombre, $descripcion, $id_unidad_medida)
    {

        $insumo = new DInsumo();
        $insumo->setIdInsumo($id_insumo);
        $insumo->setNombre($nombre);
        $insumo->setDescripcion($descripcion);
        $insumo->setIdUnidadMedida($id_unidad_medida);
        $result = $insumo->modificarInsumo();
        if ($result) {
            echo 'Insumo modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarInsumo($id_insumo)
    {
        $insumo = new DInsumo();
        $insumo->setIdInsumo($id_insumo);
        $result = $insumo->habilitarInsumo();
        if ($result) {
            echo 'Insumo habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarInsumo($id_insumo)
    {
        $insumo = new DInsumo();
        $insumo->setIdInsumo($id_insumo);
        $result = $insumo->deshabilitarInsumo();
        if ($result) {
            echo 'Insumo deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoInsumos()
    {
        $insumo = new DInsumo();
        $lista = $insumo->listadoInsumos();
        echo $lista;
		//echo null;
    }

    public function searchInsumos()
    {
        $insumo = new DInsumo();
        $lista = $insumo->searchInsumos();
        echo $lista;
    }
}