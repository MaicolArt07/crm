<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DSucursal
{
    private $tabla = 'Sucursal';
    private $Id;
    private $Nombre;
    private $Direccion;
    private $Celular;
    private $Coordenadas;
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
    public function getCoordenadas()
    {
        return $this->Coordenadas;
    }

    /**
     * @param mixed $Coordenadas
     */
    public function setCoordenadas($Coordenadas)
    {
        $this->Coordenadas = $Coordenadas;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->Celular;
    }

    /**
     * @param mixed $Celular
     */
    public function setCelular($Celular)
    {
        $this->Celular = $Celular;
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


    // public function insertarTienda()
    // {
    //     try {
    //         $sql = "INSERT INTO Tienda (Id_Grupo_Tienda,Nombre,Razon_Social,Nit,Direccion,Coordenadas,Telefono,Contacto,Correo,Estado) VALUES ($this->Id_Grupo_Tienda,'$this->Nombre','$this->Razon_Social','$this->NIT','$this->Direccion','$this->Coordenadas','$this->Telefono','$this->Contacto','$this->Correo',1);";
    //         $cone =  new Database();
	// 		$statement = $cone->ejecutar_idu($sql);
    //         if (!$statement)
    //             return false;
    //         else
    //             return true;
    //     } catch (Exception $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }

    public function modificarTienda()
    {
        try {

            $sql = "UPDATE Tienda SET Id_Grupo_Tienda=$this->Id_Grupo_Tienda,Nombre='$this->Nombre',Nit='$this->NIT',Razon_Social='$this->Razon_Social',Direccion='$this->Direccion',Coordenadas='$this->Coordenadas',Telefono='$this->Telefono',Contacto='$this->Contacto',Correo='$this->Correo',Sala='$this->Sala',Localidad='$this->Localidad', Frecuencia_Visita = '$this->Frecuencia_Visita' WHERE Id=$this->Id";
			echo " sql".$sql;
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

    public function deshabilitarSucursal()
    {
        try {
            $sql = "UPDATE Sucursal SET Estado=0 WHERE Id=$this->Id";
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

    public function habilitarSucursal()
    {
        try {
            $sql = "UPDATE Sucursal SET Estado=1 WHERE Id=$this->Id";
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

    public function listadoSucursales()
    {
        try {
            $sql = "SELECT Id, Nombre, Celular, Direccion, Gps, Estado, Fecha_Registro FROM Sucursal";
            $cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			if (empty($tabla)) {
                return '{"data":[]}';
            } else {
                return '{"data":[' . $tabla . ']}';
            }
        } catch (Exception $exc) {
            return '{"data":[]}';
        }
    }
	
    // public function getTiendas()
    // {
    //     try {
    //         $sql = "SELECT * FROM FROM Tienda WHERE Estado=1 ORDER BY Nombre ASC";
    //        // $conexion = Conexion::getInstance();
    //         //$statement = $conexion->ejecutar($sql);
	// 		$cone =  new Database();
	// 		$statement = $cone->ejecutar_idu($sql);
    //         if ($statement) {

    //             return $statement;
    //         }
    //     } catch (Exception $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }

	// public function getTiendas_Reporte_Venta()
    // {
    //     try {
    //         $sql = "SELECT Id,Nombre FROM Tienda WHERE Estado=1 ORDER BY Nombre ASC";
    //         $cone =  new Database();
	// 		$statement = $cone->ejecutar_idu($sql);
    //         if ($statement) {

    //             return $statement;
    //         }
    //     } catch (Exception $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }
}