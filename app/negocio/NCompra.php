<?php
//require '/../datos/compra.php';
//require '/../datos/detalle_compra.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DCompra.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Compra.php';
if (isset($_REQUEST['funcion'])) {
    $compra = new NCompra();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $fecha = $_POST['fecha'];
            $total = $_POST['total'];
            $id_proveedor = $_POST['id_proveedor'];
            $estado = $_POST['estado'];
            $id_usuario = $_POST['id_usuario'];
            $detalle_compra = $_POST['detalle_compra'];
            $compra->insertarCompra($fecha, $total, $id_proveedor, $estado, $id_usuario, $detalle_compra);
            break;
        case "modificar":
            $id_compra = $_POST['id_compra'];
            $fecha = $_POST['fecha'];
            $id_proveedor = $_POST['id_proveedor'];
            $estado = $_POST['estado'];
            $total = $_POST['total'];
            $id_usuario = $_POST['id_usuario'];
            $detalle_compra = $_POST['detalle_compra'];
            $array_delete = $_POST['array_delete'];
            $compra->modificarCompra($id_compra, $fecha, $total, $id_proveedor, $estado, $id_usuario, $detalle_compra, $array_delete);
            break;
        case "cancelar":
            $id_compra = $_POST['id_compra'];
            $compra->cancelarCompra($id_compra);
            break;
        case "listado":
            $compra->listadoCompras();
            break;
    }
}

class NCompra
{

    public function insertarCompra($fecha, $total, $id_proveedor, $estado, $id_usuario, $tabla_detalle_compra)
    {
        $compra = new DCompra();
        $fecha_formato = $compra->formatDate($fecha);
        $compra->setFecha($fecha_formato);
        $compra->setTotal($total);
        $compra->setEstado($estado);
        $compra->setIdProveedor($id_proveedor);
        $compra->setIdUsuario($id_usuario);
        $result = $compra->insertarCompra();

        if ($result) {
            $id_compra = $compra->getIdCompra();
            $t_detalle_compra = json_decode($tabla_detalle_compra, TRUE);
            foreach ($t_detalle_compra as $value) {
                $fecha_vencimiento = $value['fecha_vencimiento'];
                $cantidad = $value['cantidad'];
                $costo = $value['costo'];
                $id_insumo = $value['id_insumo'];
                $subtotal = $value['subtotal'];
				
                $detalle_compra = new DDetalleCompra();
                $detalle_compra->setIdCompra($id_compra);
				$detalle_compra->setIdInsumo($id_insumo);
                $detalle_compra->setFechaVencimiento($compra->formatDate($fecha_vencimiento));
                $detalle_compra->setCantidad($cantidad);
                $detalle_compra->setCosto($costo);
                $detalle_compra->setTotal($subtotal);
                $detalle_compra->insertarDetalleCompra();
            }

            echo 'Orden de compra '.$id_compra.' guardada satisfactoriamente';
        } else {
            echo 'Error ';
			echo $result;
        }
    }

    public function modificarCompra($id_compra, $fecha, $total, $id_proveedor, $estado, $id_usuario, $tabla_detalle_compra, $array_delete)
    {
        $compra = new DCompra();
        $compra->setIdCompra($id_compra);
        $compra->setFecha($compra->formatDate($fecha));
        $compra->setTotal($total);
        $compra->setEstado($estado);
        $compra->setIdProveedor($id_proveedor);
        $compra->setIdUsuario($id_usuario);
        $result = $compra->modificarCompra();
        if ($result) {
            $t_detalle_compra = json_decode($tabla_detalle_compra, TRUE);
			//echo "NCompra.php";
            foreach ($t_detalle_compra as $value) {
                $id_detalle_compra = $value['id_detalle_compra'];
                $id_insumo = $value['id_insumo'];
                $fecha_vencimiento = $value['fecha_vencimiento'];
                $cantidad = $value['cantidad'];
                $costo = $value['costo'];
                $subtotal = $value['subtotal'];
                if ($id_detalle_compra == "") {
                    $detalle_compra = new DDetalleCompra();
                    $detalle_compra->setIdCompra($id_compra);
                    $detalle_compra->setIdInsumo($id_insumo);
                    $detalle_compra->setFechaVencimiento($compra->formatDate($fecha_vencimiento));
                    $detalle_compra->setCantidad($cantidad);
                    $detalle_compra->setCosto($costo);
                    $detalle_compra->setTotal($subtotal);
                    $detalle_compra->insertarDetalleCompra();
                } else {
                    $detalle_compra = new DDetalleCompra();
                    $detalle_compra->setId($id_detalle_compra);
                    $detalle_compra->setIdCompra($id_compra);
                    $detalle_compra->setFechaVencimiento($compra->formatDate($fecha_vencimiento));
                    $detalle_compra->setCantidad($cantidad);
                    $detalle_compra->setCosto($costo);
                    $detalle_compra->setTotal($subtotal);
                    $detalle_compra->setIdInsumo($id_insumo);
                    $detalle_compra->modificarDetalleCompra();
                }
            }
            if ($array_delete != '') {
                for ($index = 0; $index < count($array_delete); $index++) {
                    $id_detalle_compra_delete = $array_delete[$index];
                    $this->eliminar($id_detalle_compra_delete);
                }
            }
            echo 'Orden de compra modificada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function eliminar($id_detalle_compra_delete)
    {
        $id_detalle_compra = (int)$id_detalle_compra_delete;
        $id_detalle_compra_insumo = new DDetalleCompra();
        $id_detalle_compra_insumo->setId($id_detalle_compra);
        $id_detalle_compra_insumo->eliminarDetalleCompra();
    }

    public function cancelarCompra($id_compra)
    {
        $compra = new DCompra();
        $compra->setIdCompra($id_compra);
        $compra->cancelarCompra();
        echo 'Se ha cancelado la compra satisfactoriamente';
    }

    public function listadoCompras()
    {
        $compra = new DCompra();
        $lista = $compra->listadoCompras();
        echo $lista;
    }

}

