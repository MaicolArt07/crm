<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DReceta.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Receta.php';
//require '/../datos/receta.php';
//require '/../datos/detalle_receta_insumo.php';
//echo "prueba";
if (isset($_REQUEST['funcion'])) {
    $detalle_receta_insumo = new NDetalleRecetaInsumo();
    switch ($_REQUEST['funcion']) {

        case "listado":
            $id_receta = $_REQUEST['id_receta'];
            $detalle_receta_insumo->listadoDetalle($id_receta);
            break;
        case "detalle":
            $id_receta = $_REQUEST['id_receta'];
            $detalle_receta_insumo->getDetalle($id_receta);
            break;
    }
}

class NDetalleRecetaInsumo
{

    public function listadoDetalle($id_receta)
    {
        $detalle_receta_insumo = new DDetalleReceta();
        $detalle_receta_insumo->setIdReceta($id_receta);
        $lista = $detalle_receta_insumo->listadoDetalle();
        echo $lista;
    }

    public function getDetalle($id_receta)
    {
        $detalle_receta_insumo = new DDetalleRecetaInsumo();
        $detalle_receta_insumo->setIdReceta($id_receta);
        $lista = $detalle_receta_insumo->getDetalle();
        echo $lista;
    }
}

?>