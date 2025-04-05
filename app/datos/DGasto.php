<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DGasto
{
    private $tabla = 'Gasto';
    private $Id;
	private $Id_Tipo_Gasto;
    private $Nombre;
    private $Descripcion;
	private $Fecha;
    private $Total;
    private $Estado;

    /**
     * @return mixed
     */
    public function getIdGasto()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdGasto($Id)
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
    public function getIdTipoGasto()
    {
        return $this->Id_Tipo_Gasto;
    }

    /**
     * @param mixed $Id_Tipo_Gasto
     */
    public function setIdTipoGasto($Id_Tipo_Gasto)
    {
        $this->Id_Tipo_Gasto = $Id_Tipo_Gasto;
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

    public function insertarGasto()
    {
        try {

            $sql = "INSERT INTO Gasto(Nombre, Descripcion, Id_Tipo_Gasto, Fecha, Total) VALUES ('$this->Nombre','$this->Descripcion',$this->Id_Tipo_Gasto,'$this->Fecha',$this->Total);";
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


    public function modificarGasto()
    {
        try {

            $sql = "UPDATE Gasto SET 
				Nombre='$this->Nombre',
				Descripcion='$this->Descripcion',
				Id_Tipo_Gasto=$this->Id_Tipo_Gasto,
				Fecha='$this->Fecha',
				Total=$this->Total
				WHERE Id=$this->Id";
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

    public function habilitarGasto()
    {
        try {

            $sql = "UPDATE Gasto SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarGasto()
    {
        try {

            $sql = "UPDATE Gasto SET Estado=0 WHERE Id=$this->Id";
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


    public function listadoGastos()
    {
        try {
            $sql = "select 
			Gasto.Id,
			Gasto.Nombre,
			Gasto.Descripcion,
			Tipo_Gasto.Nombre as Tipo_Gasto,   
			DATE_FORMAT(Gasto.Fecha,\"%d/%m/%Y\") as Fecha,
			Gasto.Total,
			Gasto.Estado
			from Gasto
			inner join Tipo_Gasto on Gasto.Id_Tipo_Gasto = Tipo_Gasto.Id;";
            
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function searchGastos()
    {
        try {
            $sql = "select 
				Gasto.Id,
				Gasto.Nombre,
				Tipo_Gasto.Nombre as Tipo_Gasto,
				Gasto.Descripcion,
				Gasto.Total
			from Gasto
				inner join Tipo_Gasto on Gasto.Id_Tipo_Gasto = Tipo_Gasto.Id
			where Gasto.Estado = 1;";
			
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGastos()
    {
        try {
            $sql = "SELECT * FROM Gasto WHERE Estado=1 ORDER BY Nombre ASC";
           $cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if ($statement) {
                return $statement;
            }
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