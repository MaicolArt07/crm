<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DTransportar
{
    private $tabla = 'Transportar';
    private $Id;
    private $Id_Usuario;
    private $Fecha;
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
    public function getIdUsuario()
    {
        return $this->Id_Usuario;
    }

    /**
     * @param mixed $Id_Usuario
     */
    public function setIdUsuario($Id_Usuario)
    {
        $this->Id_Usuario = $Id_Usuario;
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


    public function insertarTransporte()
    {
        try {

			$sql = "call Insertar_Transportar($this->Id_Usuario,'$this->Fecha');";
			//echo $sql;
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
			if (!$statement) {
                return false;
            } else {
                $rows = array();
				$lista = $statement;
				while ($data = $lista->fetch_array()) {
					if ($data["Resultado"]<1){
						echo 'No se puede guardar la orden de Transporte, el usuario tiene la orden '.$data["Id"].' pendiente de Transportar de Fecha '.$data["Fecha"];
						return false;
					}
					$this->Id = $data["Id"];
					//echo ' Id de Transporte:'+ $this->Id;
				}
				return true;
            }
		} catch (Exception $exc) {
            echo ' error al leer id insertar transporte '.$exc->getTraceAsString();
        }
		return true;
    }

	public function EliminarTransporte()
    {
        try {

			$sql = "call Eliminar_Transportar($this->Id);";
			//echo $sql;
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement){
				//echo ' cancelando transaccion insertar transporte ';
				return false;
			}
			//$conexion->close();
		} catch (Exception $exc) {
			return false;
            echo $exc->getTraceAsString();
        }
		return true;
    }
	
	public function Finalizar()
    {
        try {

			$sql = "call Finalizar_Transporte($this->Id);";
			//echo $sql;
            //$conexion = Conexion::getInstance();
            //$statement = $conexion->ejecutar($sql);
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement){
				//echo ' cancelando transaccion insertar transporte ';
				return 'Problema al finalizar Transporte';
			}
			//$conexion->close();
		} catch (Exception $exc) {
			return false;
            echo $exc->getTraceAsString();
        }
		return 'Transporte Finalizado';
    }

    public function listadoTransportes()
    {
        try {
            $sql = "select Transportar.Id,DATE_FORMAT(Transportar.Fecha,\"%d/%m/%Y\") as Fecha,Usuario.Nombre as Usuario,Transportar.Estado 
			from Transportar
			inner join Usuario on Transportar.Id_Usuario=Usuario.id  order by Transportar.Fecha desc";
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_compra["data"][] = $data;
            }
            echo json_encode($lista_compra);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function listadoTransportePendiente()
    {
        try {
            $sql = "select Transportar.Id,DATE_FORMAT(Transportar.Fecha,\"%d/%m/%Y\") as Fecha,Usuario.Nombre as Usuario,Transportar.Estado 
			from Transportar
			inner join Usuario on Transportar.Id_Usuario=Usuario.id where Estado=0  order by Transportar.Fecha desc";
            /*$conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            while ($data = mysql_fetch_assoc($statement)) {
                $lista_compra["data"][] = $data;
            }
            echo json_encode($lista_compra);*/
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
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

}
?>