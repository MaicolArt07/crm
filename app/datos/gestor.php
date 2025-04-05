<?php

require('ConexionMySqli.php');

class Gestor{
  
  
  private $cone = null;
   
     public function login($Login,$Clave){
       $sql="call Login_APP('".$Login."','".$Clave."')";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
  
  public function Obtener_Lista_Productos_A_Transportar($Id_Usuario,$Id_Tienda){
       $sql="call Obtener_Lista_Productos_A_Transportar(".$Id_Usuario.",".$Id_Tienda.")";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
  
  public function Obtener_Lista_Productos_Activos($Id_Tienda){
       $sql="call Obtener_Lista_Productos_Activos(".$Id_Tienda.")";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
	 
  public function Obtener_Lista_Tiendas_App(){
       $sql="call Obtener_Lista_Tiendas_App()";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
  
  public function Obtener_Lista_Tiendas_Con_Deudas_App(){
       $sql="call Obtener_Lista_Tiendas_Con_Deudas_App()";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
	 
  public function Colocar_Devolver_Producto($Tienda,$Id_Usuario,$Producto,$Cantidad,$Accion){
       $sql="call Colocar_Devolver_Producto('$Tienda',$Id_Usuario,'$Producto',$Cantidad,'$Accion')";
	   $cone =  new Database();
		$tabla = $cone->get_json_row($sql);
		return $tabla;
     }
	 
	public function Agregar_Venta($Id_Tienda,$Id_Usuario,$Total){
       $sql="call Agregar_Venta(".$Id_Tienda.",".$Id_Usuario.",".$Total.")";
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Venta_V2($Id_Tienda,$Id_Usuario,$SubTotal,$Descuento,$Total,$Estado){
       $sql="call Agregar_Venta_V2(".$Id_Tienda.",".$Id_Usuario.",".$SubTotal.",".$Descuento.",".$Total.",".$Estado.")";
	   
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Reponer($Id_Tienda,$Id_Usuario){
       $sql="call Agregar_Reponer(".$Id_Tienda.",".$Id_Usuario.")";
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Cambiar($Id_Tienda,$Id_Usuario){
       $sql="call Agregar_Cambiar(".$Id_Tienda.",".$Id_Usuario.")";
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Accion_Vender_Reponer_Cambiar($Id_Venta,$Id_Reponer,$Id_Cambiar){
       $sql="call Agregar_Accion_Vender_Reponer_Cambiar(".$Id_Venta.",".$Id_Reponer.",".$Id_Cambiar.")";
	   //echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Accion_Vender_Reponer_Cambiar_v1($Id_Venta,$Id_Reponer,$Id_Cambiar,$Id_Tienda,$Id_Usuario){
		$sql="call Agregar_Accion_Vender_Reponer_Cambiar_V1(".$Id_Venta.",".$Id_Reponer.",".$Id_Cambiar.",".$Id_Tienda.",".$Id_Usuario.")";
		//echo $sql;
		if($this->$cone==null){
			$this->$cone =  new Database();
		}
		 $tabla = $this->$cone->get_json_row($sql);
		 return $tabla;
	  }

	 public function Agregar_Detalle_Reponer($Id_Reponer,$Producto,$Cantidad,$Id_Usuario){
       $sql="call Agregar_Detalle_Reponer(".$Id_Reponer.",'".$Producto."',".$Cantidad.",".$Id_Usuario.")";
		//echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Detalle_Cambiar($Id_Cambiar,$Producto_Colocar,$Producto_Retirar,$Cantidad,$Id_Usuario){
       $sql="call Agregar_Detalle_Cambiar(".$Id_Cambiar.",'".$Producto_Colocar."','".$Producto_Retirar."',".$Cantidad.",".$Id_Usuario.")";
	   //echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 
	 public function Agregar_Detalle_Venta($Id_Venta,$Producto,$Cantidad,$Precio,$Descuento,$Precio_Final,$Total,$Id_Usuario){
       $sql="call Agregar_Detalle_Venta(".$Id_Venta.",'".$Producto."',".$Cantidad.",".$Precio.",".$Descuento.",".
	   $Precio_Final.",".$Total.",".$Id_Usuario.")";
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	public function Agregar_Factura($Id_Venta,$Id_Tienda){
       $sql="call Agregar_Factura(".$Id_Venta.",".$Id_Tienda.")";
	   //echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
	   
		$tabla = $this->$cone->get_json_row($sql);
		//print($tabla);
		return $tabla;
     }
	 
	 public function Agregar_Factura_V2($Id_Venta,$Id_Tienda,$CUF,$Tipo_Documento,$Leyenda,$Tipo_Emision){
       $sql="call Agregar_Factura_V2(".$Id_Venta.",".$Id_Tienda.",'".$CUF."',".$Tipo_Documento.",'".$Leyenda."','".$Tipo_Emision."')";
	   //echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
	   
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Agregar_Pago($Id_Venta,$Id_Usuario){
       $sql="call Agregar_Pago(".$Id_Venta.",".$Id_Usuario.")";
	   //echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Anular_Venta($Id_Venta){
		$sql="call Anular_Venta(".$Id_Venta.")";
		//echo $sql;
		if($this->$cone==null){
			$this->$cone =  new Database();
		}
		 $tabla = $this->$cone->get_json_row($sql);
		 return $tabla;
	  }

	  public function Anular_Cambiar($Id_Cambiar){
		$sql="call Anular_Cambiar(".$Id_Cambiar.")";
		//echo $sql;
		if($this->$cone==null){
			$this->$cone =  new Database();
		}
		 $tabla = $this->$cone->get_json_row($sql);
		 return $tabla;
	  }

	  public function Anular_Reponer($Id_Reponer){
		$sql="call Anular_Reponer(".$Id_Reponer.")";
		//echo $sql;
		if($this->$cone==null){
			$this->$cone =  new Database();
		}
		 $tabla = $this->$cone->get_json_row($sql);
		 return $tabla;
	  }

	 public function Colocar_Codigo_Control_Factura($Id_Factura,$Codigo_Control){
       $sql="call Colocar_Codigo_Control_Factura(".$Id_Factura.",'".$Codigo_Control."')";
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Actualizar_Datos_Factura($Id_Factura,$CUF,$Leyenda,$Tipo_Emision,$QR){
       $sql="call Actualizar_Datos_Factura(".$Id_Factura.",'".$CUF."','".$Leyenda."','".$Tipo_Emision."','".$QR."')";
	   //echo $sql;
	   if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
     }
	 
	 public function Obtener_Reporte_Ventas_App($Id_Usuario){
       $sql="call Obtener_Reporte_Ventas_App(".$Id_Usuario.")";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }

	 public function Obtener_Reporte_Accion_Vender_Reponer_Cambiar_App($Id_Usuario){
		$sql="call Obtener_Reporte_Accion_Vender_Reponer_Cambiar_App(".$Id_Usuario.")";
		$cone =  new Database();
		 $tabla = $cone->get_json_rows($sql);
		 return $tabla;
	  }
	 
	  public function Obtener_Reporte_Accion_Vender_Reponer_Cambiar_App_v1($Id_Usuario){
		$sql="call Obtener_Reporte_Accion_Vender_Reponer_Cambiar_App_v1(".$Id_Usuario.")";
		$cone =  new Database();
		 $tabla = $cone->get_json_rows($sql);
		 return $tabla;
	  }

	 public function Obtener_Reporte_Deudas_App($Id_Tienda){
       $sql="call Obtener_Reporte_Deudas_App(".$Id_Tienda.")";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
	 
	 public function Obtener_Reporte_Deudas_Pagadas_App($Id_Usuario){
       $sql="call Obtener_Reporte_Deudas_Pagadas_App(".$Id_Usuario.")";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
	 
	 public function cerrar(){
		 $cone->cerrar();
	 }
	 
	 public function Obtener_Detalle_Venta($Id_Venta){
       $sql="call Obtener_Detalle_Venta(".$Id_Venta.")";
	   if($cone==null){
		   $cone =  new Database();
	   }
		$tabla = $cone->get_json_rows($sql);
		$cone->cerrar();
		return $tabla.$tabla2;
     }
	 
	 public function Obtener_Detalle_Reponer($Id_Venta){
       $sql="call Obtener_Detalle_Reponer(".$Id_Venta.")";
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }
	 
	 public function Obtener_Detalle_Reponer_v1($Id_Reponer){
		$sql="call Obtener_Detalle_Reponer_v1(".$Id_Reponer.")";
		$cone =  new Database();
		 $tabla = $cone->get_json_rows($sql);
		 return $tabla;
	  }

	 public function Obtener_Detalle_Cambiar($Id_Venta){
       $sql="call Obtener_Detalle_Cambiar(".$Id_Venta.")";
	   /*if($cone==null){
		   $cone =  new Database();
	   }*/
	   $cone =  new Database();
		$tabla = $cone->get_json_rows($sql);
		return $tabla;
     }

	 public function Obtener_Detalle_Cambiar_v1($Id_Cambiar){
		$sql="call Obtener_Detalle_Cambiar_v1(".$Id_Cambiar.")";
		/*if($cone==null){
			$cone =  new Database();
		}*/
		$cone =  new Database();
		 $tabla = $cone->get_json_rows($sql);
		 return $tabla;
	  }
	 
	 public function DesHabilitar_AutoCommit(){
		 if($this->$cone!=null){
			 //echo 'Habilitando Commit';
		   $this->$cone->DesHabilitar_Commit();
		}else{
			echo '$cone:'.$cone;
		}
		 
	 }
	 
	 public function Commit(){
		 if($this->$cone!=null){
			 //echo 'Habilitando Commit';
		   $this->$cone->Commit();
		}else{
			echo '$cone:'.$cone;
		}
		 
	 }
	 
	 public function rollback(){
		 if($this->$cone==null){
		   $this->$cone->rollback();
	   }
		
	}
	
	public function Abrir_Conexion(){
		if($this->$cone==null){
		   $this->$cone =  new Database();
	   }
	}
}

?>