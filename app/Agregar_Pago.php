
<?php
   require('datos/gestor.php');
    //$JSON_venta = $_REQUEST["JSON_venta"];
	//$obj = json_decode($JSON_venta, true);
	
	$Id_Venta = $_REQUEST['Id_Venta'];
	$Id_Usuario = $_REQUEST['Id_Usuario'];
	
	$gestor= new Gestor();
	
	$Agregar_Pago= $gestor->Agregar_Pago($Id_Venta,$Id_Usuario);
	$obj_Agregar_Pago = json_decode($Agregar_Pago, true);
		//var_dump($obj_Agregar_Venta);
		
	$Id_Pago = $obj_Agregar_Pago['Id_Pago'];
	$data['Respuesta'] = "";
	if($Id_Pago>0){
		$data['Respuesta'] = ("GUARDADO OK");
	}else{
		$data['Respuesta'] = ("NO SE REGISTRO EL PAGO");
	}
	
    echo json_encode($data);
?>