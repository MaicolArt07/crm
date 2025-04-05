<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DInsumo
{
    private $tabla = 'Insumo';
    private $Id;
    private $Nombre;
    private $Descripcion;
    private $Stock;
    private $Estado;
    private $Id_Unidad_Medida;

    /**
     * @return mixed
     */
    public function getIdInsumo()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdInsumo($Id)
    {
        $this->Id = $Id;
    }


    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * @param mixed $Nombre
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    /**
     * @param mixed $Descripcion
     */
    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->Stock;
    }

    /**
     * @param mixed $Stock
     */
    public function setStock($Stock)
    {
        $this->Stock = $Stock;
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
    public function getIdUnidadMedida()
    {
        return $this->Id_Unidad_Medida;
    }

    /**
     * @param mixed $Id_Unidad_Medida
     */
    public function setIdUnidadMedida($Id_Unidad_Medida)
    {
        $this->Id_Unidad_Medida = $Id_Unidad_Medida;
    }

    public function insertarInsumo()
    {
        try {

            $sql = "INSERT INTO Insumo(Nombre, Descripcion, Estado, Id_Unidad_Medida) VALUES ('$this->Nombre','$this->Descripcion',$this->Estado,$this->Id_Unidad_Medida);";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			
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


    public function modificarInsumo()
    {
        try {

            $sql = "UPDATE Insumo SET Nombre='$this->Nombre',Descripcion='$this->Descripcion',Id_Unidad_Medida=$this->Id_Unidad_Medida WHERE Id=$this->Id";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			
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

    public function habilitarInsumo()
    {
        try {

            $sql = "UPDATE Insumo SET Estado=1 WHERE Id=$this->Id";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			
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

    public function deshabilitarInsumo()
    {
        try {

            $sql = "UPDATE Insumo SET Estado=0 WHERE Id=$this->Id";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
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


    public function listadoInsumos()
    {
        try {
            $sql = "select 
				Insumo.Id,
				Insumo.Nombre,
				Insumo.Descripcion,
				Unidad_Medida.Nombre as Unidad_Medida,       
				Insumo.Stock,
				Insumo.Estado 
			from Insumo
				inner join Unidad_Medida on Insumo.Id_Unidad_Medida = Unidad_Medida.Id;";
			
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function searchInsumos()
    {
        try {
            $sql = "select 
				Insumo.Id,
				Insumo.Nombre,
				Unidad_Medida.Nombre as Unidad_Medida,
				Insumo.Descripcion,
				Insumo.Stock
			from Insumo
				inner join Unidad_Medida on Insumo.Id_Unidad_Medida = Unidad_Medida.Id
			where Insumo.Estado = 1;";
			
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_insumo["data"][] = $data;
            }
            echo json_encode($lista_insumo);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":['.$tabla.']}';
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function getInsumos()
    {
        try {
            $sql = "SELECT * FROM Insumo WHERE Estado=1 ORDER BY Nombre ASC";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if ($statement) {
                return $statement;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}