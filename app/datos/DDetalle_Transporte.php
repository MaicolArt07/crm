<?php
//include_once 'conexion.php';
//include_once 'ConexionMySqli.php';
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DDetalleTransporte
{
    private $tabla = 'Detalle_Transporte';
    private $Id;
    private $Id_Transportar;
    private $Id_Producto;
    private $Cantidad;
    private $Disponible;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getIdTransportar()
    {
        return $this->Id_Transportar;
    }

    /**
     * @param mixed $Id_Transportar
     */
    public function setIdTransportar($Id_Transportar)
    {
        $this->Id_Transportar = $Id_Transportar;
    }

    /**
     * @return mixed
     */
    public function getIdProducto()
    {
        return $this->Id_Producto;
    }

    /**
     * @param mixed $Id_Producto
     */
    public function setIdProducto($Id_Producto)
    {
        $this->Id_Producto = $Id_Producto;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->Cantidad;
    }

    /**
     * @param mixed $Cantidad
     */
    public function setCantidad($Cantidad)
    {
        $this->Cantidad = $Cantidad;
    }

    /**
     * @return mixed
     */
    public function getDisponible()
    {
        return $this->Disponible;
    }

    /**
     * @param mixed $Disponible
     */
    public function setDisponible($Disponible)
    {
        $this->Disponible = $Disponible;
    }

    public function insertarDetalleTransporte()
    {
		$db= new Database();
		$sql = "call Insertar_Detalle_Transporte($this->Id_Transportar,$this->Id_Producto,$this->Cantidad);";

        $data = $db->get_Row_Procedure_Select_Insert($sql);
        /*if (!$statement) {
            return false;
        } else {
            $lista = $statement;
            while ($data = $lista->fetch_array()) {
                if ($data["Resultado"]<1){
                    echo 'No se puede guardar la orden de Transporte, el usuario tiene la orden '.$data["Id"].' pendiente de Transportar de Fecha '.$data["Fecha"];
                    return false;
                }else{
                    return true;
                }

                //$this->Id = $data["Id"];
                //echo ' Id de Transporte:'+ $this->Id;
            }
            return true;
        }*/
		//echo "*".$this->Cantidad."*";
		//return $sql;
		
		//$data = $db->get_Row_Procedure_Select_Insert($sql);
		//$cone =  new Database();
		//$statement = $cone->ejecutar_idu($sql);
		/*echo " R=".$data." ";
		if($data["Resultado"]==-1){
			echo $data["Descripcion"].', se pide transportar '.$data["Cantidad"].' y solo hay disponible '.$data["Cantidad_Disponible"].' Unidades del Producto '.$data["Producto"];
			return false;
		}
		return true;*/
    }

	public function agregarDetalleTransporte()
    {
		$db= new Database();
		$sql = "call Agregar_Detalle_Transporte($this->Id_Transportar,$this->Id_Producto,$this->Cantidad);";
		//echo "*".$this->Cantidad."*";
		//echo $sql;
		
		$data = $db->get_Row_Procedure_Select_Insert($sql);
		//$cone =  new Database();
		//$statement = $cone->ejecutar_idu($sql);
		//echo " R=".$data." ";
		if($data["Resultado"]==-1){
			echo $data["Descripcion"].', se pide transportar '.$data["Cantidad"].' y solo hay disponible '.$data["Cantidad_Disponible"].' Unidades del Producto '.$data["Producto"];
			return false;
		}
		return true;
    }

	function getDetalleTransporte()
    {
        try {
			$sql = "Select DT.Id_Detalle_Transporte as Aux,P.Id_Producto, P.Nombre,ifnull(DT.Inicio,0) as Inicio,
                ifnull(DT.Saldo,0) as Saldo,
                ifnull(V.Venta,0) as Venta,
                ifnull(R.Devolucion_Reposicion,0) as Devolucion_Reposicion, 
				ifnull(C.Devolucion_Cambio,0) as  Devolucion_Cambio
				from
				(select Producto.Id  Id_Producto, Producto.Nombre Nombre from Producto) as P
				left join
				(select Detalle_Transporte.Id as Id_Detalle_Transporte,Producto.Id  Id_Producto,
							sum(Detalle_Transporte.Cantidad) as Inicio, sum(Detalle_Transporte.Disponible) as Saldo
				from  Producto left join Orden_Produccion on Orden_Produccion.Id_Producto = Producto.Id
				left join Detalle_Transporte on Detalle_Transporte.Id_Orden_Produccion = Orden_Produccion.Id
				left join Transportar on  Detalle_Transporte.Id_Transportar = Transportar.Id
				where  (Transportar.Id = $this->Id_Transportar)
				group by Producto.Id) as DT on P.Id_Producto = DT.Id_Producto
				left join
				(select Producto.Id Id_Producto,
							sum(Detalle_Venta.Cantidad) as Venta
				from  Producto left join Detalle_Venta on Detalle_Venta.Id_Producto = Producto.Id
				left join Venta on Venta.Id = Detalle_Venta.Id_Venta
				left join Transportar on  Venta.Id_Transportar  = Transportar.Id 
				where (Transportar.Id = $this->Id_Transportar and Venta.Estado!=2)
				group by Producto.Id) as V on P.Id_Producto = V.Id_Producto
                left join
				(select Producto.Id Id_Producto,
							sum(Detalle_Reponer.Cantidad) as Devolucion_Reposicion
				from  Producto left join Detalle_Reponer on Detalle_Reponer.Id_Producto = Producto.Id
				left join Reponer on Reponer.Id = Detalle_Reponer.Id_Reponer
				left join Transportar on  Reponer.Id_Transportar  = Transportar.Id 
				where (Transportar.Id = $this->Id_Transportar)
				group by Producto.Id) as R on P.Id_Producto = R.Id_Producto
				left join
				(select Producto.Id as Id_Producto,
							sum(Detalle_Cambiar.Cantidad) as Devolucion_Cambio
				from  Producto left join Detalle_Cambiar on Detalle_Cambiar.Id_Producto_Retirar = Producto.Id
				left join Cambiar on Cambiar.Id = Detalle_Cambiar.Id_Cambiar
				left join Transportar on  Cambiar.Id_Transportar  = Transportar.Id 
				where (Transportar.Id = $this->Id_Transportar)
				group by Producto.Id) as C on P.Id_Producto = C.Id_Producto
				where (Inicio>0 or Devolucion_Reposicion>0 or Devolucion_Cambio>0)
				";
             
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
	
	function getDetalleTransporte_Modificar()
    {
        try {
			$sql = "select 
			Detalle_Transporte.Id as Id_Detalle_Transporte,
			Orden_Produccion.Id_Producto as id_producto,
			Producto.Nombre as Nombre,
			 Detalle_Transporte.Cantidad as Cantidad, 
			 Detalle_Transporte.Disponible as Saldo,
			Detalle_Transporte.Id_Orden_Produccion, 
			Orden_Produccion.Id_Producto
			 from Detalle_Transporte 
			inner join Orden_Produccion on Detalle_Transporte.Id_Orden_Produccion = Orden_Produccion.Id
			inner join Producto on Producto.Id = Orden_Produccion.Id_Producto
			where Id_Transportar = $this->Id_Transportar";
             
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function modificarDetalleTransporte()
    {
        try {

            $sql = "UPDATE detalle_transporte SET Cantidad='$this->Cantidad', Disponible='$this->Disponible' WHERE Id=$this->Id";
			// echo " sql".$sql;
            $cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement)
                return false;
            else
                return true;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function eliminarDetalleTransporte()
    {
        try {

            $sql = "DELETE FROM detalle_transporte WHERE Id=$this->Id";
			// echo " sql".$sql;
            $cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement)
                return false;
            else
                return true;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
?>