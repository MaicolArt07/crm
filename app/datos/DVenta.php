<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DVenta
{
    private $tabla = 'Venta';
    private $Id;
	private $Id_Transportar;
	private $Id_Tienda;
    private $Id_Usuario;
    private $Fecha;
	private $Estado;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getIdId_Transportar()
    {
        return $this->Id_Transportar;
    }

    /**
     * @param mixed $Id_Transportar
     */
    public function setId_Transportar($Id_Transportar)
    {
        $this->Id_Transportar = $Id_Transportar;
    }
	
	/**
     * @return mixed
     */
    public function getIdId_Tienda()
    {
        return $this->Id_Tienda;
    }

    /**
     * @param mixed $Id_Transportar
     */
    public function setId_Tienda($Id_Tienda)
    {
        $this->Id_Tienda = $Id_Tienda;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

	function listadoVentasTransporte($Id_Transportar)
    {
        try {
            $sql = "SELECT Venta.Id as Id,Venta.fecha AS Fecha,Venta.Id as Venta, Venta.total as Total
FROM Venta WHERE Estado = 1 and Venta.Id_Transportar=".$Id_Transportar;
			//echo $sql;
			$cone =  new Database();
			$tabla1 = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla1 . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
	
    function insertarVenta()
    {
        try {
            $sql = "INSERT INTO venta(fecha, total,estado,id_proveedor,id_usuario) VALUES ('$this->fecha',$this->total,$this->estado,$this->id_proveedor,$this->id_usuario);";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            $this->Id = $conexion->last_id();
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function modificarVenta()
    {
        try {
            $sql = "UPDATE venta SET fecha='$this->fecha',total=$this->total,estado=$this->estado,id_proveedor=$this->id_proveedor,id_usuario=$this->id_usuario WHERE Id=$this->Id";
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

    function cancelarVenta()
    {
        try {
            $sql = "UPDATE venta SET estado=0 WHERE Id=$this->Id";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            if (!$statement) {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return true;
    }

    function pagarVenta()
    {
        try {
            $sql = "UPDATE venta SET estado=1 WHERE Id=$this->Id";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            if (!$statement) {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return true;
    }

    function listadoVentas()
    {
        try {
            $sql = "SELECT venta.Id,DATE_FORMAT(venta.fecha, \"%d/%m/%Y\") AS fecha,usuario.Nombre,proveedor.nombre, venta.total, venta.estado FROM venta,proveedor,usuario WHERE venta.id_proveedor=proveedor.id_proveedor AND usuario.id_usuario=venta.id_usuario";
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_venta["data"][] = $data;
            }
            echo json_encode($lista_venta);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
	
	function Ventas_Reporte_Venta_Exportar($FechaI,$FechaF,$Tienda,$Usuario,$Estado,$Estado_factura,$Grupo_Tienda)
    {
        try {
            $FechaF =  date("Y-m-d", strtotime($FechaF . "+1 day"));
            $sql = "SELECT 
                    Factura.Numero_Factura as Numero_Factura,
                    Factura.NIT as NIT,
                    Tienda.Razon_Social as Razon_Social,
                    ifnull(Factura.CUF,'') as Codigo_Control,
                    DATE(Venta.Fecha) as Fecha,
                    Venta.Descuento,
                    Venta.Total,
                    Venta.SubTotal,
                    CASE 
                        WHEN Venta.Estado = 2 THEN 'ANULADA'
                        ELSE 'VALIDA'
                    END as Estado
                    
                     FROM Venta
					inner join Tienda on Venta.Id_Tienda = Tienda.Id
					inner join Usuario on Venta.Id_Usuario = Usuario.Id
					inner join Factura on Venta.Id = Factura.Id_Venta
                    inner join Grupo_Tienda on Tienda.Id_Grupo_Tienda = Grupo_Tienda.Id
					where Venta.Fecha between '".$FechaI."' and '".$FechaF." '";
			//echo $sql;		
			if($Tienda>0){
				$sql =  $sql." and Tienda.Id = $Tienda";
				//echo $sql;
			}
			if($Usuario>0){
				$sql =  $sql." and Usuario.Id = $Usuario";
			}
			
            if($Estado_factura>-1){
                if($Estado_factura==1){
                    $sql = $sql." and Venta.Estado <> 2";
                }else{
                    $sql = $sql." and Venta.Estado = 2";
                }
			}else{
                if($Estado>-1){
                    $sql = $sql." and Venta.Estado = $Estado";
                }
            }	
            
            if($Grupo_Tienda>0){
                $sql = $sql." and Grupo_Tienda.Id = $Grupo_Tienda";
            }
			
			//echo $sql;
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function Ventas_Reporte_Venta($FechaI,$FechaF,$Tienda,$Usuario,$Estado)
    {
        try {
            $FechaF =  date("Y-m-d", strtotime($FechaF . "+1 day"));
            $sql = "SELECT Venta.Id,
					Tienda.Nombre as Tienda,
					Usuario.Nombre as Usuario,
					Venta.Fecha,
					Venta.Estado,
					Venta.Total,
                    CASE 
                    WHEN Factura.Qr IS NOT NULL AND Factura.Qr != '' 
                         THEN CONCAT('<a href=\"',Factura.Qr, '\" target=\"_blank\">',Factura.Numero_Factura,'</a>')
                         ELSE Factura.Qr
                    END AS Numero_Factura,
                    ifnull(Factura.CUF,'') as Codigo_Control
                     FROM Venta
					inner join Tienda on Venta.Id_Tienda = Tienda.Id
					inner join Usuario on Venta.Id_Usuario = Usuario.Id
					left join Factura on Venta.Id = Factura.Id_Venta
					where Venta.Fecha between '".$FechaI."' and '".$FechaF." '";
			//echo $sql;		
			if($Tienda>0){
				$sql =  $sql." and Tienda.Id = $Tienda";
				//echo $sql;
			}
			if($Usuario>0){
				$sql =  $sql." and Usuario.Id = $Usuario";
			}
			if($Estado>-1){
				$sql = $sql." and Venta.Estado = $Estado";
			}			
			
			//echo $sql;
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function Listar_Ventas_Pendiente_Pago($id_tienda,$id_grupotienda)
    {
        try {
            //$FechaF =  date("Y-m-d", strtotime($FechaF . "+1 day"));
            $sql = "SELECT Venta.Id as Id_Venta,
					Tienda.Nombre as Tienda,
					Factura.NIT,
                    CASE 
                    WHEN Factura.Qr IS NOT NULL AND Factura.Qr != '' 
                         THEN CONCAT('<a href=\"',Factura.Qr, '\" target=\"_blank\">',Factura.Numero_Factura,'</a>')
                         ELSE Factura.Qr
                    END AS Factura,
					Venta.Fecha,
                    Venta.Subtotal,
                    Venta.Descuento,
                    Venta.MontoPorPagar,
					Venta.Total
                     FROM Venta
					inner join Tienda on Venta.Id_Tienda = Tienda.Id
					inner join Usuario on Venta.Id_Usuario = Usuario.Id
					left join Factura on Venta.Id = Factura.Id_Venta
					where (Venta.Id_Tienda = ".$id_tienda." or Tienda.Id_Grupo_Tienda = ".$id_grupotienda .")
                    and Venta.Estado = 0 and Venta.Pagada = 0";
			//echo $sql;		
						
			
			//echo $sql;
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function formatDate($date)
    {
        $date_p = explode('/', $date);
        $date_u = array($date_p[2], $date_p[1], $date_p[0]);
        $date_f = implode('-', $date_u);
        return $date_f;
    }

    public function formatDatePicker($date)
    {
        $date_p = explode('-', $date);
        $date_u = array($date_p[2], $date_p[1], $date_p[0]);
        $date_f = implode('/', $date_u);
        return $date_f;
    }


}