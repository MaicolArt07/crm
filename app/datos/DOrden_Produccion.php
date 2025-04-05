<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DOrdenProduccion
{
    private $tabla = 'Orden_Produccion';
    private $Id;
    private $Fecha;
    private $Cantidad_Produccion;
    private $Cantidad_Disponible;
    private $Fecha_Vencimiento;
    private $Id_Receta;
    private $Id_Producto;
    private $Estado;
    private $Id_Usuario;

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
        return $this->Fecha;
    }

    /**
     * @param mixed $Fecha
     */
    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    /**
     * @return mixed
     */
    public function getCantidadProduccion()
    {
        return $this->Cantidad_Produccion;
    }

    /**
     * @param mixed $Cantidad_Produccion
     */
    public function setCantidadProduccion($Cantidad_Produccion)
    {
        $this->Cantidad_Produccion = $Cantidad_Produccion;
    }

    /**
     * @return mixed
     */
    public function getCantidadDisponible()
    {
        return $this->Cantidad_Disponible;
    }

    /**
     * @param mixed $Cantidad_Disponible
     */
    public function setCantidadDisponible($Cantidad_Disponible)
    {
        $this->Cantidad_Disponible = $Cantidad_Disponible;
    }

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
    public function getIdReceta()
    {
        return $this->Id_Receta;
    }

    /**
     * @param mixed $Id_Receta
     */
    public function setIdReceta($Id_Receta)
    {
        $this->Id_Receta = $Id_Receta;
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
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @param mixed $Estado
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->Id_Usuario;
    }

    /**
     * @param mixed $Id_Usuario
     */
    public function setIdUsuario($Id_Usuario)
    {
        $this->Id_Usuario = $Id_Usuario;
    }


    public function formatDate($Fecha)
    {
        $date_p = explode('/', $Fecha);
        $date_u = array($date_p[2], $date_p[1], $date_p[0]);
        $date_f = implode('-', $date_u);
        return $date_f;
    }

    public function insertarOrdenProduccion()
    {
        try {
			$sql= "CALL Insertar_Orden_Produccion($this->Id_Receta,$this->Id_Usuario,'$this->Fecha',$this->Cantidad_Produccion,'$this->Fecha_Vencimiento');";
			//echo $sql;
			$cone =  new Database();
			return $cone->get_Row($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function confirmarCantidadProduccion()
    {
        try {
            $sql = "CALL Confirmar_Cantidad_Produccion ($this->Id,$this->Cantidad_Produccion)";
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

    public function listadoProduccion()
    {
        try {
            
			$sql = "select Orden_Produccion.Id,
       Orden_Produccion.Fecha,
        Receta.Nombre as Receta,
        Producto.Nombre as Producto,
        Orden_Produccion.Cantidad_Disponible as Cantidad,
        Orden_Produccion.Cantidad_Produccion,
        Orden_Produccion.Estado
   from Orden_Produccion
   inner join Receta on Orden_Produccion.Id_Receta = Receta.Id
   inner join Producto on Orden_Produccion.Id_Producto = Producto.Id ORDER by Producto.Orden";
   //echo $sql;
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_orden_produccion["data"][] = $data;
            }
            echo json_encode($lista_orden_produccion);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function detalleProduccion()
    {
        try {
            $sql = "SELECT 
			Insumo.Id, Insumo.Nombre, Insumo.Descripcion, Detalle_Orden_Produccion.Cantidad_Insumo
			FROM Detalle_Orden_Produccion
			inner join Insumo on Detalle_Orden_Produccion.Id_Insumo = Insumo.Id
			WHERE Detalle_Orden_Produccion.Id_Orden_Produccion=$this->Id";
			/*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            $rows = array();
            while ($data = mysql_fetch_assoc($statement)) {
                $rows[] = $data;
            }
            echo json_encode($rows);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function listarOrdenProduccionBusqueda()
    {
        try {
            $sql = "SELECT Producto.Id as Id_Producto, 
				Producto.Nombre ,
				SUM(Orden_Produccion.Cantidad_Disponible) as Cantidad_Disponible,
                Producto.Orden
				FROM Orden_Produccion
				inner join Producto on Orden_Produccion.Id_Producto=Producto.Id 
				and Orden_Produccion.Estado = 0 and Orden_Produccion.Cantidad_Disponible>0
			GROUP BY Orden_Produccion.Id_Producto ORDER BY Producto.Orden";
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}