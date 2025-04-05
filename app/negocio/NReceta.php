<?php
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DReceta.php';
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DDetalle_Receta.php';
//require '/../datos/receta.php';
//require '/../datos/detalle_receta_insumo.php';
if (isset($_REQUEST['funcion'])) {
    $receta = new NReceta();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $nombre = $_POST['nombre'];
            $cantidad = $_POST['cantidad'];
            $id_producto = $_POST['id_producto'];
            $detalle = $_POST['detalle'];
            $receta->insertarReceta($nombre, $cantidad, $id_producto, $detalle);
            break;
        case "modificar":
            $id_receta = $_POST['id_receta'];
            $nombre = $_POST['nombre'];
            $cantidad = $_POST['cantidad'];
            $id_producto = $_POST['id_producto'];
            $detalle = $_POST['detalle'];
            $lista = $_POST['lista'];
            $receta->modificarReceta($id_receta, $nombre, $cantidad, $id_producto, $detalle, $lista);
            break;
        case "habilitar":
            $id_receta = $_POST['id_receta'];
            $receta->habilitarReceta($id_receta);
            break;
        case "deshabilitar":
            $id_receta = $_POST['id_receta'];
            $receta->deshabilitarReceta($id_receta);
            break;
        case "listado":
            $receta->listadoRecetas();
            break;
        case "recetas":
            $receta->recetas();
            break;
    }
}

class NReceta
{

    public function insertarReceta($nombre, $cantidad, $id_producto, $detalle)
    {
        $receta = new DReceta();
        $receta->setNombre($nombre);
        $receta->setCantidad($cantidad);
        $receta->setIdProducto($id_producto);
        $result = $receta->insertarReceta();
			
        if ($result) {
            $id_receta = $receta->getId();
            $t_detalle = json_decode($detalle, true);
            foreach ($t_detalle as $value) {
                $id_insumo = $value['id_insumo'];
                $cantidad = $value['cantidad'];
                $detalle_receta_insumo = new DDetalleReceta();
                $detalle_receta_insumo->setIdReceta($id_receta);
                $detalle_receta_insumo->setIdInsumo($id_insumo);
                $detalle_receta_insumo->setCantidad($cantidad);
                $detalle_receta_insumo->insertarDetalleReceta();
            }
            echo 'Receta guardada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function modificarReceta($id_receta, $nombre, $cantidad, $id_producto, $detalle, $lista)
    {
        $receta = new DReceta();
        $receta->setId($id_receta);
        $receta->setNombre($nombre);
        $receta->setCantidad($cantidad);
        $receta->setIdProducto($id_producto);

        $result = $receta->modificarReceta();
        if ($result) {


            $t_detalle_receta_insumo = json_decode($detalle, TRUE);

            foreach ($t_detalle_receta_insumo as $value) {


                $id_detalle_receta_insumo = $value['Id'];
                $id_insumo = $value['Id_Insumo'];
                $cantidad = $value['Cantidad'];
				
                if ($id_detalle_receta_insumo == "") {
                    $detalle_receta_insumo = new DDetalleReceta();
                    $detalle_receta_insumo->setIdReceta($id_receta);
                    $detalle_receta_insumo->setIdInsumo($id_insumo);
                    $detalle_receta_insumo->setCantidad($cantidad);
                    $detalle_receta_insumo->insertarDetalleReceta();
                } else {
                    $detalle_receta_insumo = new DDetalleReceta();
                    $detalle_receta_insumo->setIdDetalleReceta($id_detalle_receta_insumo);
                    $detalle_receta_insumo->setCantidad($cantidad);
                    $detalle_receta_insumo->modificarDetalleReceta();
                }
            }
            if ($lista != '') {
                for ($index = 0; $index < count($lista); $index++) {
                    $id_detalle_receta_insumo_delete = $lista[$index];
                    $this->eliminar($id_detalle_receta_insumo_delete);
                }
            }
            echo 'Receta modificada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function eliminar($id_detalle)
    {
        $id_detalle_receta_insumo = (int)$id_detalle;
		echo 'Eliminar '.$id_detalle_receta_insumo;
        $detalle_receta_insumo = new DDetalleReceta();
        $detalle_receta_insumo->setIdDetalleReceta($id_detalle_receta_insumo);
        $detalle_receta_insumo->eliminarDetalleReceta();
    }

    public function habilitarReceta($id_receta)
    {
        $receta = new DReceta();
        $receta->setId($id_receta);
        $result = $receta->habilitarReceta();
        if ($result) {
            echo 'Receta habilitada satisfactoriamente';
        } else {
            echo 'Error ' . $result;
        }
    }

    public function deshabilitarReceta($id_receta)
    {
        $receta = new DReceta();
        $receta->setId($id_receta);
        $result = $receta->deshabilitarReceta();
        if ($result) {
            echo 'Receta deshabilitada satisfactoriamente';
        } else {
            echo 'Error ' . $result;
        }
    }

    public function listadoRecetas()
    {
        $receta = new DReceta();
        $lista = $receta->listadoRecetas();
        echo $lista;
    }

    public function recetas()
    {
        $receta = new DReceta();
        $lista = $receta->recetas();
        echo $lista;
    }
}