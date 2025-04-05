<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DProveedor
{
    private $tabla = 'Proveedor';
    private $Id;
    private $Nombre;
    private $Nit;
    private $Direccion;
    private $Telefono;
    private $Correo;
    private $Estado;

    /**
     * @return mixed
     */
    public function getIdProveedor()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdProveedor($Id)
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
    public function getNit()
    {
        return $this->Nit;
    }

    /**
     * @param mixed $Nit
     */
    public function setNit($Nit)
    {
        $this->Nit = $Nit;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->Direccion;
    }

    /**
     * @param mixed $Direccion
     */
    public function setDireccion($Direccion)
    {
        $this->Direccion = $Direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->Telefono;
    }

    /**
     * @param mixed $Telefono
     */
    public function setTelefono($Telefono)
    {
        $this->Telefono = $Telefono;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->Correo;
    }

    /**
     * @param mixed $Correo
     */
    public function setCorreo($Correo)
    {
        $this->Correo = $Correo;
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


    public function insertarProveedor()
    {
        try {
            $sql = "INSERT INTO Proveedor(Nombre, Nit, Direccion, Telefono, Correo) VALUES ('$this->Nombre','$this->Nit','$this->Direccion','$this->Telefono','$this->Correo')";
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

    public function modificarProveedor()
    {
        try {
            $sql = "UPDATE Proveedor SET Nombre='$this->Nombre', Nit='$this->Nit',Direccion='$this->Direccion',Telefono='$this->Telefono',Correo='$this->Correo' WHERE Id=$this->Id";
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

    public function habilitarProveedor()
    {
        try {
            $sql = "UPDATE Proveedor SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarProveedor()
    {
        try {
            $sql = "UPDATE Proveedor SET Estado=0 WHERE Id=$this->Id";
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

    public function listadoProveedores()
    {
        try {
            $sql = "SELECT * FROM Proveedor;";
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_proveedor["data"][] = $data;
            }
            echo json_encode($lista_proveedor);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores()
    {
        try {
            $sql = "SELECT * FROM Proveedor WHERE Estado=1 ORDER BY Nombre ASC";
           // $conexion = Conexion::getInstance();
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