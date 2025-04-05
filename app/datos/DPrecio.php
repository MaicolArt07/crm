<?php
include_once 'ConexionMySqli.php';

class DPrecio
{
    private $tabla = 'Precio';
    private $Id;
    private $Id_Grupo_Tienda;
	private $Id_Producto;
    private $Monto;
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
    public function getIdGrupo_Tienda()
    {
        return $this->Id_Grupo_Tienda;
    }

    /**
     * @param mixed $Id_Grupo_Tienda
     */
    public function setIdGrupo_Tienda($Id_Grupo_Tienda)
    {
        $this->Id_Grupo_Tienda = $Id_Grupo_Tienda;
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
    public function getMonto()
    {
        return $this->Monto;
    }

    /**
     * @param mixed $Monto
     */
    public function setMonto($Monto)
    {
        $this->Monto = $Monto;
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

	public function insertarPrecio()
    {
        try {
            $sql = "INSERT INTO Precio (Id_Grupo_Tienda,Id_Producto,Monto) VALUES ($this->Id_Grupo_Tienda,$this->Id_Producto,$this->Monto);";
			//echo '<script language="javascript">alert("juas");</script>';
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

	public function modificarPrecio()
    {
        try {
            $sql = "UPDATE Precio SET Id_Grupo_Tienda=$this->Id_Grupo_Tienda,Id_Producto=$this->Id_Producto,Monto=$this->Monto WHERE Id=$this->Id";
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
	
	public function deshabilitarPrecio()
    {
        try {
            $sql = "UPDATE Precio SET Estado=0 WHERE Id=$this->Id";
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

    public function habilitarPrecio()
    {
        try {
            $sql = "UPDATE Precio SET Estado=1 WHERE Id=$this->Id";
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
	
	 public function listadoPrecio()
    {
        try {
            $sql = "select Precio.Id, Grupo_Tienda.Nombre as Grupo_Tienda, Producto.Nombre as Producto, 
					Precio.Monto as Monto, Precio.Estado
					from Precio 
					inner join Producto on Precio.Id_Producto = Producto.Id
					inner join Grupo_Tienda on Precio.Id_Grupo_Tienda = Grupo_Tienda.Id";
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}