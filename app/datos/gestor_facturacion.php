<?php

require('ConexionMySqli.php');

class Gestor{
  
  
  private $cone = null;
	 
	public function Agregar_Venta_V2($Id_Tienda,$Id_Usuario,$SubTotal,$Descuento,$Total,$Estado){
		$sql="call Agregar_Venta_V2(".$Id_Tienda.",".$Id_Usuario.",".$SubTotal.",".$Descuento.",".$Total.",".$Estado.")";
		
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
	 
	public function Actualizar_Datos_Factura($Id_Factura,$CUF,$Leyenda,$Tipo_Emision,$QR){
		$sql="call Actualizar_Datos_Factura(".$Id_Factura.",'".$CUF."','".$Leyenda."','".$Tipo_Emision."','".$QR."')";
		if($this->$cone==null){
			$this->$cone =  new Database();
		}
		$tabla = $this->$cone->get_json_row($sql);
		return $tabla;
	}
	 
	 public function cerrar(){
		 $cone->cerrar();
	 }
	 
	 
	public function DesHabilitar_AutoCommit(){
		if($this->$cone!=null){
			$this->$cone->DesHabilitar_Commit();
		}else{
			echo '$cone:'.$cone;
		}
	}
	 
	 public function Commit(){
		if($this->$cone!=null){
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