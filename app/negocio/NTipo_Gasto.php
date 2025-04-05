<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DTipo_Gasto.php';

if (isset($_REQUEST['funcion'])) {
    $Tipo_Gasto = new NTipo_Gasto();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $Nombre = $_POST['Nombre'];
            $Estado = $_POST['Estado'];
            $Tipo_Gasto->insertarTipo_Gasto($Nombre, $Estado);
            break;
        case "modificar":
            $Id = $_POST['Id'];
            $Nombre = $_POST['Nombre'];
            $Tipo_Gasto->modificarTipo_Gasto($Id, $Nombre);
            break;
        case "habilitar":
            $Id = $_POST['Id'];
            $Tipo_Gasto->habilitarTipo_Gasto($Id);
            break;
        case "deshabilitar":
            $Id = $_POST['Id'];
            $Tipo_Gasto->deshabilitarTipo_Gasto($Id);
            break;
        case "listado":
            $Tipo_Gasto->listadoTipo_Gastos();
            break;
        case "search":
            $Tipo_Gasto->searchTipo_Gastos();
            break;
    }
}

class NTipo_Gasto
{
    public function insertarTipo_Gasto($Nombre, $Estado)
    {
        $Tipo_Gasto = new DTipo_Gasto();
        $Tipo_Gasto->setNombre($Nombre);
        $result = $Tipo_Gasto->insertarTipo_Gasto();
        if ($result) {
            echo 'Tipo de Gasto guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }

    }

    public function modificarTipo_Gasto($Id, $Nombre)
    {

        $Tipo_Gasto = new DTipo_Gasto();
        $Tipo_Gasto->setId($Id);
        $Tipo_Gasto->setNombre($Nombre);
        $result = $Tipo_Gasto->modificarTipo_Gasto();
        if ($result) {
            echo 'Tipo de Gasto modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarTipo_Gasto($Id)
    {
        $Tipo_Gasto = new DTipo_Gasto();
        $Tipo_Gasto->setId($Id);
        $result = $Tipo_Gasto->habilitarTipo_Gasto();
        if ($result) {
            echo 'Tipo de Gasto habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarTipo_Gasto($Id)
    {
        $Tipo_Gasto = new DTipo_Gasto();
        $Tipo_Gasto->setId($Id);
        $result = $Tipo_Gasto->deshabilitarTipo_Gasto();
        if ($result) {
            echo 'Tipo de Gasto deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoTipo_Gastos()
    {
        $Tipo_Gasto = new DTipo_Gasto();
        $lista = $Tipo_Gasto->listadoTipo_Gastos();
        echo $lista;
    }

    public function searchTipo_Gastos()
    {
        $Tipo_Gasto = new DTipo_Gasto();
        $lista = $Tipo_Gasto->searchTipo_Gastos();
        echo $lista;
    }
}