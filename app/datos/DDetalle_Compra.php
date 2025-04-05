<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DDetalleCompra
{
    private $tabla = 'Detalle_Compra';
    private $Id;
    private $Id_Compra;
    private $Id_Insumo;
    private $Fecha_Vencimiento;
    private $Cantidad;
    private $Total;
    private $Costo;

    /**
     * @return mixed
     */
    public function getFechaVencimiento()
    {
        return $this->Fecha_Vencimiento;
    }

    /**
     * @param mixed $Fecha_Vencimiento
     */
    public function setFechaVencimiento($Fecha_Vencimiento)
    {
        $this->Fecha_Vencimiento = $Fecha_Vencimiento;
    }

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
    public function getIdCompra()
    {
        return $this->Id_Compra;
    }

    /**
     * @param mixed $Id_Compra
     */
    public function setIdCompra($Id_Compra)
    {
        $this->Id_Compra = $Id_Compra;
    }

    /**
     * @return mixed
     */
    public function getIdInsumo()
    {
        return $this->Id_Insumo;
    }

    /**
     * @param mixed $Id_Insumo
     */
    public function setIdInsumo($Id_Insumo)
    {
        $this->Id_Insumo = $Id_Insumo;
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
    public function getTotal()
    {
        return $this->Total;
    }

    /**
     * @param mixed $Total
     */
    public function setTotal($Total)
    {
        $this->Total = $Total;
    }

    /**
     * @return mixed
     */
    public function getCosto()
    {
        return $this->Costo;
    }

    /**
     * @param mixed $Costo
     */
    public function setCosto($Costo)
    {
        $this->Costo = $Costo;
    }

    public function insertarDetalleCompra()
    {
        try {
			$cone =  new Database();
			$sql ="CALL Insertar_Detalle_Compra($this->Id_Compra,$this->Id_Insumo,'$this->Fecha_Vencimiento',$this->Cantidad,$this->Costo,$this->Total);";
			//echo $sql;
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			
			$statement = $cone->get_Row_Procedure_Select_Insert($sql);
			//echo $sql;
			
			if($data["Resultado"]==1){
				return true;
			}else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function modificarDetalleCompra()
    {
        try {
			$sql = "CALL Modificar_Detalle_Compra($this->Id,$this->Id_Compra,'$this->Fecha_Vencimiento',$this->Cantidad,$this->Costo,$this->Total,$this->Id_Insumo);";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


    public function eliminarDetalleCompra()
    {
        try {
            $sql = "DELETE FROM Detalle_Compra WHERE Id=$this->Id";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function listadoDetalle()
    {

        try {
            $sql = "SELECT * FROM detalle_compra";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function listadoDetalleCompra()
    {

        try {
            $sql = "SELECT detalle_compra.Id,insumo.nombre,detalle_compra.Fecha_Vencimiento,detalle_compra.Cantidad,detalle_compra.Costo, detalle_compra.Total FROM insumo,compra,detalle_compra WHERE insumo.Id_Insumo=detalle_compra.Id_Insumo AND detalle_compra.Id_Compra=compra.Id_Compra AND detalle_compra.Id_Compra=$this->Id_Compra";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getDetalleCompra()
    {
        try {
			$sql = "select 
			Detalle_Compra.Id,
			Insumo.Id as Id_Insumo,
			Insumo.Nombre as Insumo,
			Unidad_Medida.Nombre as Unidad_Medida,
			DATE_FORMAT(Detalle_Compra.Fecha_Vencimiento,\"%d/%m/%Y\") as Fecha_Vencimiento,
			Detalle_Compra.Cantidad,
			Detalle_Compra.Costo,
			Detalle_Compra.Total
			from
			Detalle_Compra 
            inner join Insumo on Detalle_Compra.Id_Insumo = Insumo.Id
			INNER join Unidad_Medida on Insumo.Id_Unidad_Medida = Unidad_Medida.Id
			WHERE Detalle_Compra.Id_Compra =$this->Id_Compra";
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


}

?>