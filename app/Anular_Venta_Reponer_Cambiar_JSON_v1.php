<?php
  
	require('datos/gestor.php');
	require('Sin/Anular_Factura.php');
	
	
	$obj = json_decode($_REQUEST["JSON_venta"], true);
	$Id_Venta = $obj['Id'];
	$gestor= new Gestor();
	$gestor->Abrir_Conexion();
	if($Id_Venta!=""){

		//echo "Id_Venta".$Id_Venta;
		$Cuf = $obj['Factura']['Codigo_Control'];
		
		
		$Anular_Venta= $gestor->Anular_Venta($Id_Venta);
		$data['Respuesta'] = '-Venta Anulada ';
		//print_r($Anular_Venta);
		if($Cuf!=""){
			$anular_factura = new AnularFactura();
			$obj_factura['Llave']="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJicmVhZGtpbmcucGFuYWRlcmlhQGdtYWlsLmNvbSIsImNvZGlnb1Npc3RlbWEiOiI3NzU0MjEzNTNBNTlEQkNDOEEyNEM1RSIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTJOTE13TkRNd01nY0FWNHp2b3drQUFBQT0iLCJpZCI6NTM5MDA4NywiZXhwIjoxNzcyMjczNjAyLCJpYXQiOjE3NDA3NTE5NzIsIm5pdERlbGVnYWRvIjozMTY4MTYwMjcsInN1YnNpc3RlbWEiOiJTRkUifQ.8gX6ujayDTh6Xo-JAm67ihHcP_GcL2mQr0Vo9ZgDMxZ-bxlXRCQGNgzWygWExDzoqUVpr3cYKjC9OrYYORc8ZA";
			$obj_factura['Cuf']=$Cuf;
			$res = $anular_factura->anular(json_encode($obj_factura));
			$data['Respuesta'] = $data['Respuesta'].'-Factura Anulada ';
		}
		
		
	}
	
	$obj = json_decode($_REQUEST["JSON_reponer"], true);
	$Id_Reponer = $obj['Id'];
	if($Id_Reponer!=""){
		//echo "Id_Reponer".$Id_Reponer;
		$Anular_Reponer= $gestor->Anular_Reponer($Id_Reponer);
		$data['Respuesta'] = $data['Respuesta'].'Reponosición Anulada';
	}

	$obj = json_decode($_REQUEST["JSON_cambiar"], true);
	$Id_Cambiar = $obj['Id'];
	if($Id_Cambiar!=""){
		//echo "Id_Cambiar".$Id_Cambiar;
		$Anular_Cambiar= $gestor->Anular_Cambiar($Id_Cambiar);
		$data['Respuesta'] = $data['Respuesta'].'Cambio Anulado';
	}
	
	echo json_encode($data);
?>