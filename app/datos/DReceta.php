<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DReceta
{
    private $tabla = 'Receta';
    private $Id;
    private $Nombre;
    private $Cantidad;
    private $Id_Producto;
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
     * @param mixed $Nombre
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
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

    public function insertarReceta()
    {
        try {
            $sql = "INSERT INTO " . $this->tabla . "(Nombre, Cantidad, Id_Producto) VALUES ('$this->Nombre',$this->Cantidad,$this->Id_Producto);";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            //$this->Id = $conexion->last_id();
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


    public function modificarReceta()
    {
        try {
            $sql = "UPDATE " . $this->tabla . " SET Nombre='$this->Nombre', Cantidad=$this->Cantidad,Id_Producto=$this->Id_Producto WHERE Id=$this->Id";
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
            //$this->Id = $conexion->last_id();
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

    public function habilitarReceta()
    {
        try {

            $sql = "UPDATE Receta SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarReceta()
    {
        try {

            $sql = "UPDATE Receta SET Estado=0 WHERE Id=$this->Id";
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


    public function listadoRecetas()
    {
        try {
            $sql = "Select Receta.Id,
			Receta.Nombre,
			Producto.Nombre as Producto,
			Receta.Cantidad,
			Receta.Estado
			from Receta
			inner join Producto on Receta.Id_Producto = Producto.Id;";
            
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function recetas()
    {
        try {
            $sql = "SELECT Receta.Id,Receta.Nombre,Receta.Id_Producto,Producto.Nombre as 'Producto',Receta.Cantidad 
					FROM Receta
					inner join Producto on Receta.Id_Producto = Producto.Id
					WHERE Receta.Estado = 1";
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_receta["data"][] = $data;
            }
            echo json_encode($lista_receta);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}