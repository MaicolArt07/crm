<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DPago.php';

if (isset($_REQUEST['funcion'])) {
    $pago = new NPago();
    switch ($_REQUEST['funcion']) {
        case "listadoPagos":
			$Id_Transportar = $_REQUEST['id_transporte'];
            $pago->listadoPagos($Id_Transportar);
            break;
        case "listadoPagosWeb":
            //$Id_Transportar = $_REQUEST['id_transporte'];
            $pago->listadoPagosWeb();
            break;
        case "guardar_pago_masivo":
            $id_usuario = $_POST['id_usuario'];
            $tienda_grupo_tienda = $_POST['tienda_grupo_tienda'];
            $metodoPago = $_POST['metodoPago'];
            $codigo_documento = $_POST['codigo_documento'];
            $totalpagar = $_POST['totalpagar'];
            $ventas_a_pagar = $_POST['ventas_a_pagar'];
            $pago->guardar_pago_masivo($id_usuario,$tienda_grupo_tienda,$metodoPago,$codigo_documento,$totalpagar,$ventas_a_pagar);
            break;
        case "detalle_pago_Web":
            $id_pago = $_REQUEST['id_pago'];
            $pago->detalle_pago_Web($id_pago);
            break;
    }
}



class NPago
{
    public function listadoPagos($Id_Transportar)
    {
        $pago = new DPago();
        $lista = $pago->listadoPagos($Id_Transportar);
        echo $lista;
    }

    public function listadoPagosWeb()
    {
        $pago = new DPago();
        $lista = $pago->listadoPagosWeb();
        echo $lista;
    }

    public function detalle_pago_Web($id_pago)
    {
        $pago = new DPago();
        $lista = $pago->detalle_pago_Web($id_pago);
        echo $lista;
    }

    public function guardar_pago_masivo($id_usuario,$tienda_grupo_tienda,$metodoPago,$codigo_documento,$totalpagar,$lista_ventas_a_pagar)
    {
        
        $pago = new DPago();
        $pago->Abrir_Conexion();
        $pago->DesHabilitar_AutoCommit();
        
        $Agregar_Pago = $pago->Agregar_Pago($id_usuario,$tienda_grupo_tienda,$metodoPago,$codigo_documento,$totalpagar);
        $obj_Agregar_Pago = json_decode($Agregar_Pago, true);
		$Id_Pago = $obj_Agregar_Pago['id_pago'];
        //echo "Id_Pago: ".$Id_Pago;
        /*error_log("Prueba Breadking: Este es un mensaje de error personalizado.", 0);
        $Agregar_Pago = $pago->Agregar_Pago($id_usuario,$tienda_grupo_tienda,$metodoPago,$codigo_documento,$totalpagar);
        $obj_Agregar_Pago = json_decode($Agregar_Pago, true);
		$Id_Pago = $obj_Agregar_Pago['id_pago'];*/
        //$pago->Commit();
        //echo "Id_Pago: ".$Id_Pago;
        //error_log("Prueba Breadking: Este es un mensaje de error personalizado.", 0);
        if($Id_Pago>0){
            $ventas = json_decode($lista_ventas_a_pagar, true);
            if (is_array($ventas)) {
                foreach ($ventas as $venta) {
                    // Accedemos a cada venta y su monto
                    $id_venta = $venta['venta'];
                    $monto = $venta['monto'];
                    //echo "venta ".$id_venta;
                    // Aquí puedes realizar la lógica necesaria, por ejemplo:
                    // Registrar cada venta asociada al pago
                    $pago->Agregar_Detalle_Pago($id_usuario,$Id_Pago, $id_venta, $monto);
                }
            }else{
                echo "No se pudo registrar el pago";
            }
            $pago->Commit();
            echo "pago registrado correctamente";
            return 1;
        }else{
            $pago->rollback();
            echo "No se pudo registrar el pago";
            return 0;
        }
        
        return 1;
    }
}

