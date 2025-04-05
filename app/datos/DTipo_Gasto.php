<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DTipo_Gasto
{
    private $tabla = 'Tipo_Gasto';
    private $Id;
    private $Nombre;
    private $Estado;

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
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * @param mixed $nombre
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
     * @param mixed $estado
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }


    public function insertarTipo_Gasto()
    {
        try {

            $sql = "INSERT INTO Tipo_Gasto(Nombre) VALUES ('$this->Nombre');";
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


    public function modificarTipo_Gasto()
    {
        try {

            $sql = "UPDATE Tipo_Gasto SET 
			Nombre='$this->Nombre' WHERE Id=$this->Id";
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

    public function habilitarTipo_Gasto()
    {
        try {

            $sql = "UPDATE Tipo_Gasto SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarTipo_Gasto()
    {
        try {

            $sql = "UPDATE Tipo_Gasto SET Estado=0 WHERE Id=$this->Id";
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


    public function listadoTipo_Gastos()
    {
        try {
            $sql = "Select Tipo_Gasto.Id,
			Tipo_Gasto.Nombre,
			Tipo_Gasto.Estado FROM 
			Tipo_Gasto";
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function searchTipo_Gastos()
    {
        try {
            $sql = "SELECT Tipo_Gasto.Id,Tipo_Gasto.Nombre 
			FROM Tipo_Gasto WHERE Tipo_Gasto.Estado=1";
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTipo_Gastos()
    {
        try {
            $sql = "SELECT * FROM Tipo_Gasto WHERE Estado=1 ORDER BY nombre ASC";
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