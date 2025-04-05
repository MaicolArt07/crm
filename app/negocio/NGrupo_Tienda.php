<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DGrupo_Tienda.php';

if (isset($_REQUEST['funcion'])) {
    $Grupo_Tienda = new NGrupo_Tienda();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $Nombre = $_POST['Nombre'];
            $PermitirCobrar = $_POST['PermitirCobrar'];
            $Grupo_Tienda->insertarGrupo_Tienda($Nombre, $PermitirCobrar);
            break;
        case "modificar":
            $Id = $_POST['Id'];
            $Nombre = $_POST['Nombre'];
            $PermitirCobrar = $_POST['PermitirCobrar'];
            $Grupo_Tienda->modificarGrupo_Tienda($Id, $Nombre,$PermitirCobrar);
            break;
        case "habilitar":
            $Id = $_POST['Id'];
            $Grupo_Tienda->habilitarGrupo_Tienda($Id);
            break;
        case "deshabilitar":
            $Id = $_POST['Id'];
            $Grupo_Tienda->deshabilitarGrupo_Tienda($Id);
            break;
        case "listado":
            $Grupo_Tienda->listadoGrupo_Tiendas();
            break;
        case "search":
            $Grupo_Tienda->searchGrupo_Tiendas();
            break;
    }
}

class NGrupo_Tienda
{
    public function insertarGrupo_Tienda($Nombre, $PermitirCobrar)
    {
        $Grupo_Tienda = new DGrupo_Tienda();
        $Grupo_Tienda->setNombre($Nombre);
        $Grupo_Tienda->setPermitirCobrar($PermitirCobrar);
        $result = $Grupo_Tienda->insertarGrupo_Tienda();
        if ($result) {
            echo 'Grupo de Tienda guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }

    }

    public function modificarGrupo_Tienda($Id, $Nombre, $PermitirCobrar)
    {

        $Grupo_Tienda = new DGrupo_Tienda();
        $Grupo_Tienda->setId($Id);
        $Grupo_Tienda->setNombre($Nombre);
        $Grupo_Tienda->setPermitirCobrar($PermitirCobrar);
        $result = $Grupo_Tienda->modificarGrupo_Tienda();
        if ($result) {
            echo 'Grupo de Tienda modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarGrupo_Tienda($Id)
    {
        $Grupo_Tienda = new DGrupo_Tienda();
        $Grupo_Tienda->setId($Id);
        $result = $Grupo_Tienda->habilitarGrupo_Tienda();
        if ($result) {
            echo 'Grupo de Tienda habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarGrupo_Tienda($Id)
    {
        $Grupo_Tienda = new DGrupo_Tienda();
        $Grupo_Tienda->setId($Id);
        $result = $Grupo_Tienda->deshabilitarGrupo_Tienda();
        if ($result) {
            echo 'Grupo de Tienda deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoGrupo_Tiendas()
    {
        $Grupo_Tienda = new DGrupo_Tienda();
        $lista = $Grupo_Tienda->listadoGrupo_Tiendas();
        echo $lista;
    }

    public function searchGrupo_Tiendas()
    {
        $Grupo_Tienda = new DGrupo_Tienda();
        $lista = $Grupo_Tienda->searchGrupo_Tiendas();
        echo $lista;
    }
}