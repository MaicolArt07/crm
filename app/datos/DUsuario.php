<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DUsuario
{
    private $tabla = 'Usuario';

    private $Id;
    private $Nombre;
    private $Login;
    private $Clave;
    private $Tipo;
    private $Estado;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $id_usuario
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
     * @param mixed $Nombre
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->Login;
    }

    /**
     * @param mixed $Login
     */
    public function setLogin($Login)
    {
        $this->Login = $Login;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->Clave;
    }

    /**
     * @param mixed $Clave
     */
    public function setClave($Clave)
    {
        $this->Clave = $Clave;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @param mixed $Tipo
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
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

	
	function getDataUsuario()
    {
		
        try {
            $sql = "SELECT * FROM Usuario WHERE Login='$this->Login' and Clave='$this->Clave'";
			
			$cone =  new Database();
			$row = $cone->get_Row($sql);
            if ($row['Clave'] == $this->Clave) {
                return (array('Id' => $row['Id'], 'Nombre' => $row['Nombre']));
            } else {
                return null;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
		return null;
    }

    function listaUsuariosByEstado()
    {
        try {
            $sql = "SELECT Id as 'Id', Nombre as 'Nombre' FROM" . $this->tabla . "WHERE Estado=1";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if ($statement) {
                return $statement;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getUsuarios_Transportar()
    {
        try {
            $sql = "select * from Usuario where Usuario.Id not in (select Id_Usuario from Transportar where Estado=3 or Estado=4)
			and Tipo like '%Vendedor%'";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if ($statement) {
                return $statement;
            }
        } catch (Exception $exception) {
            echo $exception->getTraceAsString();
        }
    }
	
	public function getUsuarios_Reporte_Venta()
    {
        try {
            $sql = "SELECT * FROM Usuario WHERE Estado=1 ORDER BY Nombre ASC";
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

	public function insertarUsuario()
    {
        try {
            $sql = "INSERT INTO Usuario(Nombre, Login, Clave, Tipo) VALUES ('$this->Nombre','$this->Login','$this->Clave','$this->Tipo')";
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

    public function modificarUsuario()
    {
        try {
            $sql = "UPDATE Usuario SET Nombre='$this->Nombre', Login='$this->Login',Clave='$this->Clave',Tipo='$this->Tipo' WHERE Id=$this->Id";
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

    public function habilitarUsuario()
    {
        try {
            $sql = "UPDATE Usuario SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarUsuario()
    {
        try {
            $sql = "UPDATE Usuario SET Estado=0 WHERE Id=$this->Id";
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

    public function listadoUsuarios()
    {
        try {
            $sql = "SELECT * FROM Usuario";
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
			
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}