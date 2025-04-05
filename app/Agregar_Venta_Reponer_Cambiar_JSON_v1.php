<?php
  
   require('datos/gestor.php');
   require('Sin/Enviar_Factura_v2.php');
   
	
   $JSON_venta = $_REQUEST["JSON_venta"];
	$obj = json_decode($JSON_venta, true);
	$Id_Tienda = $obj['Id_Tienda'];
	$Id_Usuario = $obj['Id_Usuario'];
    //echo "Id_Tienda ".$Id_Tienda;
	$Id_Venta = 0;
	
	$gestor= new Gestor();
	$gestor->Abrir_Conexion();
	$gestor->DesHabilitar_AutoCommit();
	
	if(($obj['lista_detalle_venta']!="") &&(count($obj['lista_detalle_venta'])>0)){
		

		$SubTotal = $obj['SubTotal'];
		$Descuento = $obj['Descuento'];
		$Total = $obj['Total'];
		$Facturado = $obj['Facturado'];
		$Estado = $obj['Estado'];
		
		
		
		$Agregar_Venta= $gestor->Agregar_Venta_V2($Id_Tienda,$Id_Usuario,$SubTotal,$Descuento,$Total,$Estado);
		
		$obj_Agregar_Venta = json_decode($Agregar_Venta, true);
		//var_dump($obj_Agregar_Venta);
		$Id_Venta = $obj_Agregar_Venta['Id_Venta'];
		//echo " venta: ".$Id_Venta;
		if($Id_Venta > 0){
			//echo ' Respuesta al Agregar_Venta:'.$Id_Venta;
		}else{
			$gestor->rollback();
			$data['Respuesta'] = 'ERROR-> Agregar_Venta_JSON.php: aplicacion finalizada al Agregar_Venta';
			exit(json_encode($data));
		}
		$Fecha_Hora = $obj_Agregar_Venta['Fecha_hora'];
		$fecha = $obj_Agregar_Venta['Fecha_hora'];//10/08/2010/2020-07-13
		$parts = explode(" ",$fecha);
		$fecha = $parts[0];
		$fecha = str_replace('-','',$fecha);
		$cont =0;
		$Lista_detalle_factura = array();
		foreach ($obj['lista_detalle_venta'] as $detalle_venta) {
			//echo "\$a[$i] => $v.\n";
			$Producto = $detalle_venta['Producto'];
			if($Producto == null || $Producto == ""){
				$Producto = $detalle_venta['Nombre_Producto'];
			}
			$Cantidad = $detalle_venta['Cantidad'];
			$Precio = $detalle_venta['Precio'];
			$Descuento = $detalle_venta['Descuento'];
			$Precio_Final = $detalle_venta['Precio_Final'];
			if($Precio_Final == null || $Precio_Final == ""){
				$Precio_Final = $detalle_venta['PrecioFinal'];
			}
			$Total = $detalle_venta['Total'];
			$Agregar_Detalle_Venta = $gestor->Agregar_Detalle_Venta($Id_Venta,$Producto,$Cantidad,$Precio,$Descuento,$Precio_Final,$Total,$Id_Usuario);
			
			//echo ($Agregar_Detalle_Venta);
			$dec_Agregar_Detalle_Venta = json_decode($Agregar_Detalle_Venta, true);
			$detalle_factura['Id_Producto'] = $dec_Agregar_Detalle_Venta['Id_Producto'];
			$detalle_factura['Nombre_Producto'] = $Producto;
			$detalle_factura['Cantidad'] = $detalle_venta['Cantidad'];
			$detalle_factura['Total'] = $detalle_venta['Total'];
			if($Agregar_Detalle_Venta==-1){
				$gestor->rollback();
				$data['Respuesta_Venta'] = 'No se pudo Guardar, error al registrar el detalle de Venta del Producto '.$Producto.' con cantidad '.$Cantidad;
				exit(json_encode($data));
			}
			$Lista_detalle_factura[$cont] = $detalle_factura;
			$cont++;
			
		}
		
		//echo json_encode($Lista_detalle_factura);
		if($Facturado==1){
			//echo "facturado";
			$Agregar_Factura = $gestor->Agregar_Factura($Id_Venta,$Id_Tienda);
			$obj_Agregar_Factura = json_decode($Agregar_Factura, true);
			//echo " obj_Agregar_Factura = ".$obj_Agregar_Factura;
			$Id_Factura = $obj_Agregar_Factura["Id_Factura"];
			if($Id_Factura > 0){
			//echo ' Respuesta al Agregar_Factura:'.$Id_Factura;
			}else{
				//$gestor->rollback();
				$data['Respuesta_Venta'] = 'ERROR-> Agregar_Venta_JSON.php: aplicacion finalizada al
				 Agregar_Factura Facturado==1';
				 //$gestor->Commit();
				exit(json_encode($data));
			}
			//var_dump($obj_Agregar_Factura);
			$Razon_Social=$obj_Agregar_Factura["Razon_Social"];
			$autorizacion=$obj_Agregar_Factura["Autorizacion"];
			$Fecha_Limite_Emision = $obj_Agregar_Factura["Fecha_Limite_Emision"];
			$nrofactura=$obj_Agregar_Factura["Numero_Factura"];
			$nitci=$obj_Agregar_Factura["NIT"];
			$fecha = $fecha;
			$monto=$Total;
			$llave=$obj_Agregar_Factura['llave_dosificacion'];
			
			
			$obj_factura['Llave']="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJicmVhZGtpbmcucGFuYWRlcmlhQGdtYWlsLmNvbSIsImNvZGlnb1Npc3RlbWEiOiI3NzU0MjEzNTNBNTlEQkNDOEEyNEM1RSIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTJOTE13TkRNd01nY0FWNHp2b3drQUFBQT0iLCJpZCI6NTM5MDA4NywiZXhwIjoxNzcyMjczNjAyLCJpYXQiOjE3NDA3NTE5NzIsIm5pdERlbGVnYWRvIjozMTY4MTYwMjcsInN1YnNpc3RlbWEiOiJTRkUifQ.8gX6ujayDTh6Xo-JAm67ihHcP_GcL2mQr0Vo9ZgDMxZ-bxlXRCQGNgzWygWExDzoqUVpr3cYKjC9OrYYORc8ZA";
			$obj_factura['Tipo_Pago']="Efectivo";
			$obj_factura['Fecha']="2022-10-28";
			$obj_factura['SubTotal']=$obj['SubTotal'];
			$obj_factura['Descuento']=$obj['Descuento'];
			$obj_factura['Total']=$obj['SubTotal']-$obj['Descuento'];
			$obj_factura['montoTotal']=$obj['SubTotal']-$obj['Descuento'];
			$obj_factura['Numero_Factura']=$obj_Agregar_Factura["Numero_Factura"];
			$obj_factura['NIT']=$obj_Agregar_Factura["NIT"];
			$obj_factura['Razon_Social']=$obj_Agregar_Factura["Razon_Social"];
			$obj_factura['Correo']=$obj_Agregar_Factura["Correo"]; 
			$obj_factura['Total_Literal']=$obj['Total_Literal'];
			$obj_factura['Tipo_Documento']=5;
			$obj_factura['Complemento']="";
			$obj_factura['Usuario']="Cajero";
			$obj_factura['Lista_detalle_factura']=$Lista_detalle_factura;
			
			//echo (json_encode($obj_factura));
			
			$enviar_factura = new EnviarFactura();
			$json = "";
			$res = $enviar_factura->enviar_v2(json_encode($obj_factura));
			
			$obj_res = json_decode($res, true);
	
			if($nitci==""){
				$nitci="1";
			}
			
			$data['Id_Venta'] = $Id_Venta;
			$data['Fecha']=$Fecha_Hora;
			$data['Id_Factura'] = $Id_Factura;
			$data['Numero_Factura'] = $nrofactura;
			$data['NIT'] = $nitci;
			$data['Razon_Social'] = $Razon_Social;
			$data['Autorizacion'] = $autorizacion;
			$data['Fecha_Limite_Emision'] = $Fecha_Limite_Emision;
			$data['Codigo_Control'] = $obj_res['Cuf'];
			$data['Tipo_Emision'] = $obj_res['Tipo_Emision'];
			$data['Fecha']=$obj_res['Fecha'];
			$data['Leyenda']=$obj_res['Leyenda'];
			$data['Qr']=$obj_res['Qr'];
			
			
			$gestor->Actualizar_Datos_Factura($Id_Factura,$obj_res['Cuf'],$obj_res['Leyenda'],$obj_res['Tipo_Emision'],$obj_res['Qr']);
			if($obj_res['Cuf']==null){
				//echo "error: ".implode($obj_res);
				$data['Respuesta_Venta']="La Venta no se guardo, hubo error al registrar la factura, Error: ".implode($obj_res);
				exit(json_encode($data));
			}else{
				$data['Respuesta_Venta'] = 'GUARDADO OK';
			}
			
		}else{
			$data['Id_Venta'] = $Id_Venta;
			$data['Id_Factura'] = -1;
			$data['Fecha']=$fecha;
			$data['Respuesta_Venta'] = 'GUARDADO OK';
			
		}
	}else{
		$data['Id_Venta'] = -1;
		$data['Respuesta_Venta'] = 'NO APLICA GUARDADO';
	}
	
	$JSON_reponer = $_REQUEST["JSON_reponer"];
	$obj = json_decode($JSON_reponer, true);
	//echo "reporner".$obj['lista_detalle_reponer'];
	$Id_Reponer = 0;
	if(($obj['lista_detalle_reponer']!="") && (count($obj['lista_detalle_reponer'])>0)){
		$Id_Tienda = $obj['Id_Tienda'];
		$Id_Usuario = $obj['Id_Usuario'];
		//echo 'datos para reponer';
		$Agregar_Reponer = $gestor->Agregar_Reponer($Id_Tienda,$Id_Usuario);
		$obj_Agregar_Reponer = json_decode($Agregar_Reponer, true);
		$Id_Reponer = $obj_Agregar_Reponer['Id_Reponer'];
		foreach ($obj['lista_detalle_reponer'] as $detalle_reponer) {
			//echo "\$a[$i] => $v.\n";
			$Producto = $detalle_reponer['Producto'];
			$Cantidad = $detalle_reponer['Cantidad'];
			$Agregar_Detalle_Reponer = $gestor->Agregar_Detalle_Reponer($Id_Reponer,$Producto,$Cantidad,$Id_Usuario);
			$obj_Agregar_Detalle_Reponer = json_decode($Agregar_Detalle_Reponer, true);
			$Id_Detalle_Reponer = $obj_Agregar_Detalle_Reponer['Id_Detalle_Reponer'];
			if($Id_Detalle_Reponer==-1){
				$gestor->rollback();
				$data['Respuesta_Reponer'] = 'ERROR-> No se pudo Guardar, error al registrar el detalle de Reponer del Producto '.$Producto.' con cantidad '.$Cantidad;
				exit(json_encode($data));
			}
			$cont++;
		}
		$data['Id_Reponer'] = $Id_Reponer;
	}else{
		$data['Id_Reponer'] = -1;
		$data['Respuesta_Reponer'] = 'NO APLICA GUARDADO';
	}
	
	$JSON_cambiar = $_REQUEST["JSON_cambiar"];
	$obj = json_decode($JSON_cambiar, true);
	//echo "cambiar*  ".$obj['lista_detalle_cambiar']."    *";
	$Id_Cambiar = 0;
	if(($obj['lista_detalle_cambiar']!="") && (count($obj['lista_detalle_cambiar']))>0){
		$Id_Tienda = $obj['Id_Tienda'];
		$Id_Usuario = $obj['Id_Usuario'];
		$Agregar_Cambiar = $gestor->Agregar_Cambiar($Id_Tienda,$Id_Usuario);
		$obj_Agregar_Cambiar = json_decode($Agregar_Cambiar, true);
		$Id_Cambiar = $obj_Agregar_Cambiar['Id_Cambiar'];
		//echo "cambiar".$Id_Cambiar;
		foreach ($obj['lista_detalle_cambiar'] as $detalle_cambiar) {
			//echo "\$a[$i] => $v.\n";
			$Producto_Colocar = $detalle_cambiar['Producto_Colocar'];
			$Producto_Retirar = $detalle_cambiar['Producto_Retirar'];
			$Cantidad = $detalle_cambiar['Cantidad'];
			//echo "producto colocar ".$Producto_Colocar;
			$Agregar_Detalle_Cambiar = $gestor->Agregar_Detalle_Cambiar($Id_Cambiar,$Producto_Colocar,
			$Producto_Retirar,$Cantidad,$Id_Usuario);
			$obj_Agregar_Detalle_Cambiar = json_decode($Agregar_Detalle_Cambiar, true);
			$Id_Detalle_Cambiar = $obj_Agregar_Detalle_Cambiar['Id_Detalle_Cambiar'];
			if($Id_Detalle_Cambiar==-1){
				$gestor->rollback();
				$data['Respuesta_Cambiar'] = 'ERROR-> No se pudo Guardar, error al registrar el detalle de Cambiar del Producto Ingresar '.$Producto_Colocar.' y producto retirar '.$Producto_Retirar.' con cantidad '.$Cantidad;
				exit(json_encode($data));
			}
			$cont++;
		}
		$data['Id_Cambiar'] = $Id_Cambiar;
		//echo $Id_Cambiar;
	}else{
		$data['Id_Cambiar'] = -1;
		$data['Respuesta_Cambiar'] = 'NO APLICA GUARDADO';
	}
	
	if($Id_Venta>0 || $Id_Reponer>0 || $Id_Cambiar>0){
		 $Accion_Vender_Reponer_Cambiar = $gestor->Agregar_Accion_Vender_Reponer_Cambiar_V1($Id_Venta,$Id_Reponer,$Id_Cambiar,$Id_Tienda,$Id_Usuario);
		 $obj_Accion_Vender_Reponer_Cambiar = json_decode($Accion_Vender_Reponer_Cambiar, true);
		 $Id_Accion_Vender_Reponer_Cambiar = $obj_Accion_Vender_Reponer_Cambiar['Id_Accion_Vender_Reponer_Cambiar'];
		 if($Id_Accion_Vender_Reponer_Cambiar==null){
				$gestor->rollback();
				$data['Respuesta'] = 'No se pudo Guardar, error al registrar la Accion con Id_Venta '.$Id_Venta.', Id_Reponer '.$Id_Reponer.' y Id_Cambiar '.$Id_Cambiar;
				exit(json_encode($data));
			}
		 $data['Id_Accion_Vender_Reponer_Cambiar'] = $Id_Accion_Vender_Reponer_Cambiar;
		 $data['Respuesta'] = 'GUARDADO OK';
	}else{
		$data['Respuesta'] = 'No se Guardó la acción porque no hay Venta, Reposición o Cambio';
	}
	
	$gestor->Commit();
	echo json_encode($data);
?>