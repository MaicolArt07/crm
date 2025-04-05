<?php
//require '/../datos/unidad_medida.php';

require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DUnidad_Medida.php';

if (isset($_REQUEST['funcion'])) {
    $unidad_medida = new NUnidadMedida();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $nombre = $_POST['nombre'];
            $unidad_medida->insertarUnidadMedida($nombre);
            break;
        case "modificar":
            $id_unidad_medida = $_POST['id_unidad_medida'];
            $nombre = $_POST['nombre'];
            $unidad_medida->modificarUnidadMedida($id_unidad_medida, $nombre);
            break;
        case "habilitar":
            $id_unidad_medida = $_POST['id_unidad_medida'];
            $unidad_medida->habilitarUnidadMedida($id_unidad_medida);
            break;
        case "deshabilitar":
            $id_unidad_medida = $_POST['id_unidad_medida'];
            $unidad_medida->deshabilitarUnidadMedida($id_unidad_medida);
            break;
        case "listado":
            $unidad_medida->listadoUnidadMedidas();
            break;
    }
}

class NUnidadMedida
{
    public function insertarUnidadMedida($nombre)
    {
        $unidad_medida = new DUnidadMedida();
        $unidad_medida->setNombre($nombre);
        $result = $unidad_medida->insertarUnidadMedida();
        if ($result) {
            echo 'Unidad de medida guardada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function modificarUnidadMedida($id_unidad_medida, $nombre)
    {
        $unidad_medida = new DUnidadMedida();
        $unidad_medida->setIdUnidadMedida($id_unidad_medida);
        $unidad_medida->setNombre($nombre);
        $result = $unidad_medida->modificarUnidadMedida();
        if ($result) {
            echo 'Unidad de medida modificada satisfactoriamente';
        } else {
            echo 'Error en la modificación de los datos ' + $result;
        }
    }

    public function habilitarUnidadMedida($id_unidad_medida)
    {
        $unidad_medida = new DUnidadMedida();
        $unidad_medida->setIdUnidadMedida($id_unidad_medida);
        $result = $unidad_medida->habilitarUnidadMedida();
        if ($result) {
            echo 'Unidad de medida habilitada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function deshabilitarUnidadMedida($id_unidad_medida)
    {
        $unidad_medida = new DUnidadMedida();
        $unidad_medida->setIdUnidadMedida($id_unidad_medida);
        $result = $unidad_medida->deshabilitarUnidadMedida();
        if ($result) {
            echo 'Unidad de medida habilitada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function listadoUnidadMedidas()
    {
        $unidad_medida = new DUnidadMedida();
        $lista = $unidad_medida->listadoUnidadMedidas();
        echo $lista;
    }
}