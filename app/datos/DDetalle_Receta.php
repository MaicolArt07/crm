<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DDetalleReceta
{
    private $tabla = 'Detalle_Receta';
    private $Id;
    private $Id_Receta;
    private $Id_Insumo;
    private $Cantidad;

    /**
     * @return mixed
     */
    public function getIdDetalleReceta()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdDetalleReceta($Id)
    {
        $this->Id = $Id;
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

    public function insertarDetalleReceta()
    {
        try {
            $sql = "INSERT INTO " . $this->tabla . "(Id_Receta, Id_Insumo,Cantidad) VALUES ($this->Id_Receta,$this->Id_Insumo,$this->Cantidad)";
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

    public function modificarDetalleReceta()
    {

        try {

            $sql = "UPDATE " . $this->tabla . " SET Cantidad=$this->Cantidad WHERE Id=$this->Id";
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

    public function eliminarDetalleReceta()
    {
        try {
            $sql = "DELETE FROM " . $this->tabla . " WHERE Id=$this->Id";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            if (!$statement) {
                return FALSE;
            } else {
                return TRUE;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function listadoDetalle()
    {
        try {
            $sql = "SELECT 
			   Detalle_Receta.Id,
			   Detalle_Receta.Id_Insumo,
			   Insumo.Nombre as Insumo,
			   Unidad_Medida.Nombre as Unidad_Medida,
			   Detalle_Receta.Cantidad        

			from Detalle_Receta
				inner join Insumo on Detalle_Receta.Id_Insumo = Insumo.Id
				inner join Unidad_Medida on Insumo.Id_Unidad_Medida = Unidad_Medida.Id
			where Detalle_Receta.Id_Receta = $this->Id_Receta;";
            
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

    public function getDetalle()
    {
        try {
            $sql = "SELECT Insumo.Id, Insumo.Nombre, Insumo.Descripcion, Insumo.Stock, Detalle_Receta.Cantidad 
				FROM Detalle_Receta 
				inner JOIN Receta on Receta.Id = Detalle_Receta.Id_Receta
				inner join Insumo on Detalle_Receta.Id_Insumo = Insumo.Id
				WHERE Receta.Id =$this->Id_Receta";
            
			$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            $rows = array();
            while ($data = mysql_fetch_assoc($statement)) {
                $rows[] = $data;
            }
            echo json_encode($rows);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function insumos() {

        try {
            $sql = "SELECT Insumo.Id, Detalle_Receta.Cantidad 
				FROM Detalle_Receta 
				inner JOIN Receta on Receta.Id = Detalle_Receta.Id_Receta
				inner join Insumo on Detalle_Receta.Id_Insumo = Insumo.Id
				WHERE Receta.Id = $this->Id_Receta";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            $rows = array();
            while ($data = mysql_fetch_assoc($statement)) {
                $rows[] = $data;
            }
            return json_encode($rows);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}