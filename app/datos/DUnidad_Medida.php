<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DUnidadMedida
{
    private $tabla = 'Unidad_Medida';

    private $Id;
    private $Nombre;
    private $Estado;

    /**
     * @return mixed
     */
    public function getIdUnidadMedida()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdUnidadMedida($Id)
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

    public function insertarUnidadMedida()
    {
        try {
            $sql = "INSERT INTO Unidad_Medida (Nombre) VALUES ('$this->Nombre');";
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

    public function modificarUnidadMedida()
    {
        try {

            $sql = "UPDATE Unidad_Medida SET Nombre='$this->Nombre' WHERE Id=$this->Id";
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

    public function habilitarUnidadMedida()
    {
        try {

            $sql = "UPDATE Unidad_Medida SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarUnidadMedida()
    {
        try {

            $sql = "UPDATE Unidad_Medida SET Estado=0 WHERE Id=$this->Id";
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

    public function listadoUnidadMedidas()
    {
        try {
            $sql = "SELECT * FROM Unidad_Medida";
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUnidadMedida()
    {
        try {
            $sql = "SELECT * FROM " . $this->tabla . " WHERE Estado = 1";
            
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