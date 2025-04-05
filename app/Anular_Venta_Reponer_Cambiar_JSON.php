<?php
  
   require('datos/gestor.php');
   require('Sin/Anular_Factura.php');
   
   $JSON_venta = $_REQUEST["JSON_venta"];
   //echo $JSON_venta;
	$obj = json_decode($JSON_venta, true);
	$Id_Venta = $obj['Id'];
	
	$Cuf = $obj['Factura']['Codigo_Control'];
	//echo "Cuf".$Id_Venta;

	//$Id_Tienda = $obj['Id_Tienda'];
	//$Id_Usuario = $obj['Id_Usuario'];
	
	//echo "Id_Venta ".$Id_Venta;
	//$Id_Venta = 0;
	
	$gestor= new Gestor();
	$gestor->Abrir_Conexion();
	$Anular_Venta= $gestor->Anular_Venta($Id_Venta);
	//print_r($Anular_Venta);
	if($Cuf!=""){
		$anular_factura = new AnularFactura();
			$obj_factura['Llave']="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIzMTY4MTYwMjdBYSIsImNvZGlnb1Npc3RlbWEiOiI3NzU0MjEzNTNBNTlEQkNDOEEyNEM1RSIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTJOTE13TkRNd01nY0FWNHp2b3drQUFBQT0iLCJpZCI6NTE5NzYzLCJleHAiOjE3MjM1OTM2MDAsImlhdCI6MTY5MjEzMTU1OSwibml0RGVsZWdhZG8iOjMxNjgxNjAyNywic3Vic2lzdGVtYSI6IlNGRSJ9.FPCX9XY1ZsqC_ZQF7A1x_pn6AwtFSstQvcHiA5zHF3ygx1ssggiwIQ7a6r3_nA6N4MD9C8wdQ8N6kf5_JA4F6Q";
			$obj_factura['Cuf']=$Cuf;
			$res = $anular_factura->anular(json_encode($obj_factura));
	}
	$data['Respuesta'] = 'Venta y Factura Anulada';
	echo json_encode($data);
?>