<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DDetalleVenta
{
    private $tabla = 'Detalle_Venta';
    private $Id;
    private $Id_Venta;
    private $Id_Producto;
    private $Precio;
    private $Cantidad;
    private $Total;

    
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
    public function getIdVenta()
    {
        return $this->Id_Venta;
    }

    /**
     * @param mixed $Id_Venta
     */
    public function setIdVenta($Id_Venta)
    {
        $this->Id_Venta = $Id_Venta;
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
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
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
    public function getPrecio()
    {
        return $this->Precio;
    }

    /**
     * @param mixed $Precio
     */
    public function setPrecio($Precio)
    {
        $this->Precio = $Precio;
    }

    function insertarDetalleVenta()
    {
        try {
            $sql = "CALL detalle_venta_insumo($this->id_venta,'$this->fecha_vencimiento',$this->cantidad,$this->Precio,$this->subtotal,$this->id_insumo);";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function modificarDetalleVenta()
    {
        try {
            $sql = "CALL modificar_detalle_venta_insumo($this->id_detalle_venta,$this->id_venta,'$this->fecha_vencimiento',$this->cantidad,$this->Precio,$this->subtotal,$this->id_insumo);";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


    function eliminarDetalleVenta()
    {
        try {
            $sql = "DELETE FROM detalle_venta WHERE id_detalle_venta=$this->id_detalle_venta";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
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
            $sql = "SELECT * FROM detalle_venta";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_detalle_venta["data"][] = $data;
            }
            echo json_encode($lista_detalle_venta);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function listadoDetalleVenta()
    {

        try {
            $sql = "SELECT detalle_venta.id_detalle_venta,insumo.nombre,detalle_venta.fecha_vencimiento,detalle_venta.cantidad,detalle_venta.Precio, detalle_venta.subtotal FROM insumo,venta,detalle_venta WHERE insumo.id_insumo=detalle_venta.id_insumo AND detalle_venta.id_venta=venta.id_venta AND detalle_venta.id_venta=$this->id_venta";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
            $cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
			$rows = array();
            while ($data = $statement->fetch_array()) {
                $rows[] = $data;
            }
            echo json_encode($rows);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getDetalleVenta()
    {
		//tuis
        try {
            $sql = "select Detalle_Venta.Id,
					Producto.Nombre as Producto,
					Detalle_Venta.Precio,
					Detalle_Venta.Cantidad,
					Detalle_Venta.Total
					from Detalle_Venta
					inner join Producto on Detalle_Venta.Id_Producto = Producto.Id
					where Detalle_Venta.Id_Venta =$this->Id_Venta";//$this->Id_Venta
			//echo $sql;
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_detalle["data"][] = $data;
            }
            echo json_encode($lista_detalle);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


}