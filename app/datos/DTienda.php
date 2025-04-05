<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DTienda
{
    private $tabla = 'Tienda';
    private $Id;
	private $Id_Grupo_Tienda;
    private $Nombre;
	private $Razon_Social;
    private $NIT;
    private $Direccion;
    private $Coordenadas;
    private $Telefono;
    private $Contacto;
    private $Correo;
    private $Sala;
    private $Localidad;
    private $Estado;
	private $Frecuencia_Visita;

	/**
     * @return mixed
     */
    public function getFrecuencia_Visita()
    {
        return $this->Frecuencia_Visita;
    }

    /**
     * @param mixed $Frecuencia_Visita
     */
    public function setFrecuencia_Visita($Frecuencia_Visita)
    {
        $this->Frecuencia_Visita = $Frecuencia_Visita;
    }
	
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
    public function getId_Grupo_Tienda()
    {
        return $this->Id_Grupo_Tienda;
    }

    /**
     * @param mixed $Id_Grupo_Tienda
     */
    public function setId_Grupo_Tienda($Id_Grupo_Tienda)
    {
        $this->Id_Grupo_Tienda = $Id_Grupo_Tienda;
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
    public function getRazon_Social()
    {
        return $this->Razon_Social;
    }

    /**
     * @param mixed $Razon_Social
     */
    public function setRazon_Social($Razon_Social)
    {
        $this->Razon_Social = $Razon_Social;
    }
  
    /**
     * @return mixed
     */
    public function getNIT()
    {
        return $this->NIT;
    }

    /**
     * @param mixed $NIT
     */
    public function setNIT($NIT)
    {
        $this->NIT = $NIT;
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
    public function getContacto()
    {
        return $this->Contacto;
    }

    /**
     * @param mixed $Contacto
     */
    public function setContacto($Contacto)
    {
        $this->Contacto = $Contacto;
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
     * @param mixed $Sala
     */
    public function setSala($Sala)
    {
        $this->Sala = $Sala;
    }

    /**
     * @return mixed
     */
    public function getSala()
    {
        return $this->Sala;
    }

    /**
     * @param mixed $Localidad
     */
    public function setLocalidad($Localidad)
    {
        $this->Localidad = $Localidad;
    }

    /**
     * @return mixed
     */
    public function getLocalidad()
    {
        return $this->Localidad;
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


    public function insertarTienda()
    {
        try {
            $sql = "INSERT INTO Tienda (Id_Grupo_Tienda,Nombre,Razon_Social,Nit,Direccion,Coordenadas,Telefono,Contacto,Correo,Estado) VALUES ($this->Id_Grupo_Tienda,'$this->Nombre','$this->Razon_Social','$this->NIT','$this->Direccion','$this->Coordenadas','$this->Telefono','$this->Contacto','$this->Correo',1);";
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

    public function deshabilitarTienda()
    {
        try {
            $sql = "UPDATE Tienda SET Estado=0 WHERE Id=$this->Id";
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

    public function habilitarTienda()
    {
        try {
            $sql = "UPDATE Tienda SET Estado=1 WHERE Id=$this->Id";
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

    public function listadoTiendas()
    {
        try {
            $sql = "SELECT Tienda.Id,Grupo_Tienda.Nombre as Grupo_Tienda,Tienda.Nombre, Razon_Social,NIT,Correo,Sala,Localidad,Direccion,Coordenadas,Telefono,Contacto,Tienda.Frecuencia_Visita,Tienda.Estado 
				FROM Tienda inner join Grupo_Tienda on Tienda.Id_Grupo_Tienda = Grupo_Tienda.Id";
			
            
            $cone =  new Database();
			$tabla = $cone->get_json_rows_utf($sql);
			return '{"data":' . $tabla . '}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
	
    public function getTiendas()
    {
        try {
            $sql = "SELECT * FROM FROM Tienda WHERE Estado=1 ORDER BY Nombre ASC";
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

	public function getTiendas_Reporte_Venta()
    {
        try {
            $sql = "SELECT Id,Nombre FROM Tienda WHERE Estado=1 ORDER BY Nombre ASC";
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