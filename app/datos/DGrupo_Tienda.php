<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DGrupo_Tienda
{
    private $tabla = 'Grupo_Tienda';
    private $Id;
    private $Nombre;
    private $Estado;
    private $PermitirCobrar;

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
    public function getPermitirCobrar()
    {
        return $this->PermitirCobrar;
    }

    /**
     * @param mixed $PermitirCobrar
     */
    public function setPermitirCobrar($PermitirCobrar)
    {
        $this->PermitirCobrar = $PermitirCobrar;
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


    public function insertarGrupo_Tienda()
    {
        try {

            $sql = "INSERT INTO Grupo_Tienda(Nombre,Cobrar_desde_App) VALUES ('$this->Nombre',$this->PermitirCobrar);";
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


    public function modificarGrupo_Tienda()
    {
        try {
            $sql = "UPDATE Grupo_Tienda SET 
			Nombre='$this->Nombre', Cobrar_desde_App='$this->PermitirCobrar' WHERE Id=$this->Id";
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

    public function habilitarGrupo_Tienda()
    {
        try {

            $sql = "UPDATE Grupo_Tienda SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarGrupo_Tienda()
    {
        try {

            $sql = "UPDATE Grupo_Tienda SET Estado=0 WHERE Id=$this->Id";
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


    public function listadoGrupo_Tiendas()
    {
        try {
            $sql = "Select Grupo_Tienda.Id,
			Grupo_Tienda.Nombre,
			Grupo_Tienda.Estado,
            Grupo_Tienda.Cobrar_desde_App
            FROM 
			Grupo_Tienda";
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function searchGrupo_Tiendas()
    {
        try {
            $sql = "SELECT Grupo_Tienda.Id,Grupo_Tienda.Nombre 
			FROM Grupo_Tienda WHERE Grupo_Tienda.Estado=1";
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_Grupo_Tienda["data"][] = $data;
            }
            echo json_encode($lista_Grupo_Tienda);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupo_Tiendas()
    {
        try {
            $sql = "SELECT * FROM Grupo_Tienda WHERE Estado=1 ORDER BY nombre ASC";
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