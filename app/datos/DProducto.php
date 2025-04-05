<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DProducto
{
    private $tabla = 'Producto';
    private $Id;
    private $Nombre;
    private $Descripcion;
    private $Stock;
    private $Precio;
    private $Estado;

    /**
     * @return mixed
     */
    public function getIdProducto()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdProducto($Id)
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
    public function getPrecio()
    {
        return $this->Precio;
    }

    /**
     * @param mixed $Precio
     */
    public function setPrecio($Precio)
    {
        $this->Precio = $Precio;
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

    public function insertarProducto()
    {
        try {

            $sql = "INSERT INTO Producto(Nombre, Descripcion) VALUES ('$this->Nombre','$this->Descripcion');";
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


    public function modificarProducto(){
        try {
            $sql = "UPDATE Producto SET Nombre='$this->Nombre',Descripcion='$this->Descripcion' WHERE Id=$this->Id";
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

    public function habilitarProducto()
    {
        try {

            $sql = "UPDATE Producto SET Estado=1 WHERE Id=$this->Id";
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

    public function deshabilitarProducto()
    {
        try {

            $sql = "UPDATE Producto SET Estado=0 WHERE Id=$this->Id";
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



    public function listadoProductos(){
        try {
            $sql = "SELECT * FROM Producto;";
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_producto["data"][] = $data;
            }
            echo json_encode($lista_producto);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function getProducto()
    {
        try {
            $sql = "SELECT * FROM " . $this->tabla . " WHERE Estado = 1";
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