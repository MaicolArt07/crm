<?php
//require '/../datos/venta.php';
//require '/../datos/detalle_venta.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DVenta.php';
//require $_SERVER['DOCUMENT_ROOT'] . '/Breadking/app/datos/detalle_venta.php';
if (isset($_REQUEST['funcion'])) {
    $venta = new NVenta();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $fecha = $_POST['fecha'];
            $total = $_POST['total'];
            $id_proveedor = $_POST['id_proveedor'];
            $estado = $_POST['estado'];
            $id_usuario = $_POST['id_usuario'];
            $detalle_venta = $_POST['detalle_venta'];
            $venta->insertarVenta($fecha, $total, $id_proveedor, $estado, $id_usuario, $detalle_venta);
            break;
        case "modificar":
            $id_venta = $_POST['id_venta'];
            $fecha = $_POST['fecha'];
            $id_proveedor = $_POST['id_proveedor'];
            $estado = $_POST['estado'];
            $total = $_POST['total'];
            $id_usuario = $_POST['id_usuario'];
            $detalle_venta = $_POST['detalle_venta'];
            $array_delete = $_POST['array_delete'];
            $venta->modificarVenta($id_venta, $fecha, $total, $id_proveedor, $estado, $id_usuario, $detalle_venta, $array_delete);
            break;
        case "cancelar":
            $id_venta = $_POST['id_venta'];
            $venta->cancelarVenta($id_venta);
            break;
        case "pagar":
            $id_venta = $_POST['id_venta'];
            $venta->pagarVenta($id_venta);
            break;
        case "Ventas_Reporte_Venta":
			$FechaI = $_POST['FechaI'];
			$FechaF = $_POST['FechaF'];
			$Tienda = $_POST['Tienda'];
			$Usuario = $_POST['Usuario'];
			$Estado = $_POST['Estado'];
            $venta->Ventas_Reporte_Venta($FechaI,$FechaF,$Tienda,$Usuario,$Estado);
            break;
        case "Ventas_Reporte_Venta_Exportar":
            $FechaI = $_POST['FechaI'];
            $FechaF = $_POST['FechaF'];
            $Tienda = $_POST['Tienda'];
            $Usuario = $_POST['Usuario'];
            $Estado = $_POST['Estado'];
            $Estado_factura = $_POST['Estado_factura'];
            $Grupo_Tienda= $_POST['Grupo_Tienda'];
            $venta->Ventas_Reporte_Venta_Exportar($FechaI,$FechaF,$Tienda,$Usuario,$Estado,$Estado_factura,$Grupo_Tienda);
            break;
		case "listadoVentasTransporte":
			$Id_Transportar = $_REQUEST['id_transporte'];
            $venta->listadoVentasTransporte($Id_Transportar);
            break;
        case "Listar_Ventas_Pendiente_Pago":
            $id_tienda = $_POST['id_tienda'];
            $id_grupotienda = $_POST['id_grupotienda'];
            $venta->Listar_Ventas_Pendiente_Pago($id_tienda,$id_grupotienda);
            break;
    }
}

class NVenta
{

    public function insertarVenta($fecha, $total, $id_proveedor, $estado, $id_usuario, $tabla_detalle_venta)
    {
        $venta = new DVenta();
        $fecha_formato = $venta->formatDate($fecha);
        $venta->setFecha($fecha_formato);
        $venta->setTotal($total);
        $venta->setEstado($estado);
        $venta->setIdProveedor($id_proveedor);
        $venta->setIdUsuario($id_usuario);
        $result = $venta->insertarVenta();

        if ($result) {
            $id_venta = $venta->getIdVenta();

            $t_detalle_venta = json_decode($tabla_detalle_venta, TRUE);

            foreach ($t_detalle_venta as $value) {
                $fecha_vencimiento = $value['fecha_vencimiento'];
                $fecha_vencimiento_formato = $venta->formatDate($fecha_vencimiento);
                $cantidad = $value['cantidad'];
                $costo = $value['costo'];
                $id_insumo = $value['id_insumo'];
                $subtotal = $value['subtotal'];

                $detalle_venta = new DDetalleVenta();
                $detalle_venta->setIdVenta($id_venta);
                $detalle_venta->setFechaVencimiento($fecha_vencimiento_formato);
                $detalle_venta->setCantidad($cantidad);
                $detalle_venta->setCosto($costo);
                $detalle_venta->setIdInsumo($id_insumo);
                $detalle_venta->setSubtotal($subtotal);
                $detalle_venta->insertarDetalleVenta();
            }

            echo 'Orden de venta guardada satisfactoriamente';
        } else {
            echo "Error " + $result;
        }
    }

	public function listadoVentasTransporte($Id_Transportar)
    {
        $venta = new DVenta();
        $lista = $venta->listadoVentasTransporte($Id_Transportar);
        echo $lista;
		//'{"data":[{"Id":"3","Fecha":"19-08-2021","Venta":"188","Total":"40"}]}';
    }
	
    public function modificarVenta($id_venta, $fecha, $total, $id_proveedor, $estado, $id_usuario, $tabla_detalle_venta, $array_delete)
    {
        $venta = new DVenta();
        $venta->setIdVenta($id_venta);
        $venta->setFecha($venta->formatDate($fecha));
        $venta->setTotal($total);
        $venta->setEstado($estado);
        $venta->setIdProveedor($id_proveedor);
        $venta->setIdUsuario($id_usuario);
        $result = $venta->modificarVenta();
        if ($result) {
            $t_detalle_venta = json_decode($tabla_detalle_venta, TRUE);

            foreach ($t_detalle_venta as $value) {
                $id_detalle_venta = $value['id_detalle_venta'];
                $id_insumo = $value['id_insumo'];
                $fecha_vencimiento = $value['fecha_vencimiento'];
                $cantidad = $value['cantidad'];
                $costo = $value['costo'];
                $subtotal = $value['subtotal'];
                if ($id_detalle_venta == "") {
                    $detalle_venta = new DDetalleVenta();
                    $detalle_venta->setIdVenta($id_venta);
                    $detalle_venta->setIdInsumo($id_insumo);
                    $detalle_venta->setFechaVencimiento($venta->formatDate($fecha_vencimiento));
                    $detalle_venta->setCantidad($cantidad);
                    $detalle_venta->setCosto($costo);
                    $detalle_venta->setSubtotal($subtotal);
                    $detalle_venta->insertarDetalleVenta();
                } else {
                    $detalle_venta = new DDetalleVenta();
                    $detalle_venta->setIdDetalleVenta($id_detalle_venta);
                    $detalle_venta->setIdVenta($id_venta);
                    $detalle_venta->setFechaVencimiento($fecha_vencimiento);
                    $detalle_venta->setCantidad($cantidad);
                    $detalle_venta->setCosto($costo);
                    $detalle_venta->setSubtotal($subtotal);
                    $detalle_venta->setIdInsumo($id_insumo);
                    $detalle_venta->modificarDetalleVenta();
                }
            }
            if ($array_delete != '') {
                for ($index = 0; $index < count($array_delete); $index++) {
                    $id_detalle_venta_delete = $array_delete[$index];
                    $this->eliminar($id_detalle_venta_delete);
                }
            }
            echo 'Orden de venta modificada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function eliminar($id_detalle_venta_delete)
    {
        $id_detalle_venta = (int)$id_detalle_venta_delete;
        $id_detalle_venta_insumo = new DDetalleVenta();
        $id_detalle_venta_insumo->setIdDetalleVenta($id_detalle_venta);
        $id_detalle_venta_insumo->eliminarDetalleVenta();
    }

    public function cancelarVenta($id_venta)
    {
        $venta = new DVenta();
        $venta->setIdVenta($id_venta);
        $venta->cancelarVenta();
        echo 'Se ha cancelado la venta satisfactoriamente';
    }

    public function pagarVenta($id_venta)
    {
        $venta = new DVenta();
        $venta->setIdVenta($id_venta);
        $venta->pagarVenta();
        echo 'Se ha pagado la venta satisfactoriamente';
    }

    public function Listar_Ventas_Pendiente_Pago($id_tienda,$id_grupotienda)
    {
        $venta = new DVenta();
        $lista = $venta->Listar_Ventas_Pendiente_Pago($id_tienda,$id_grupotienda);
        echo $lista;
    }

    public function Ventas_Reporte_Venta($FechaI,$FechaF,$Tienda,$Usuario,$Estado)
    {
        $venta = new DVenta();
        $lista = $venta->Ventas_Reporte_Venta($FechaI,$FechaF,$Tienda,$Usuario,$Estado);
        echo $lista;
    }

    public function Ventas_Reporte_Venta_Exportar($FechaI,$FechaF,$Tienda,$Usuario,$Estado,$Estado_factura,$Grupo_Tienda)
    {
        $venta = new DVenta();
        $lista = $venta->Ventas_Reporte_Venta_Exportar($FechaI,$FechaF,$Tienda,$Usuario,$Estado,$Estado_factura,$Grupo_Tienda);
        echo $lista;
    }
}

