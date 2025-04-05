<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DCompra
{
    private $tabla = 'Compra';
    private $Id;
    private $Fecha;
    private $Total;
    private $Estao;
    private $Id_Proveedor;
    private $Id_Usuario;

    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setIdCompra($Id)
    {
        $this->Id = $Id;
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
    public function getIdProveedor()
    {
        return $this->Id_Proveedor;
    }

    /**
     * @param mixed $Id_Proveedor
     */
    public function setIdProveedor($Id_Proveedor)
    {
        $this->Id_Proveedor = $Id_Proveedor;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->Id_Usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($Id_Usuario)
    {
        $this->Id_Usuario = $Id_Usuario;
    }

    public function insertarCompra()
    {
        try {
            $sql = "CALL Insertar_Compra($this->Id_Proveedor,$this->Id_Usuario,'$this->Fecha',$this->Total,$this->Estado);";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement) {
                return false;
            } else {
				$lista = $statement;
				while ($data = $lista->fetch_array()) {
					$this->Id = $data["Id"];
				}
				return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function modificarCompra()
    {
        try {
            $sql = "UPDATE Compra SET Fecha='$this->Fecha',Total=$this->Total,Estado=$this->Estado,Id_Proveedor=$this->Id_Proveedor,Id_Usuario=$this->Id_Usuario WHERE Id=$this->Id";
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

    public function cancelarCompra()
    {
        try {
            $sql = "UPDATE Compra SET Estado=0 WHERE Id=$this->Id";
			$cone =  new Database();
			$statement = $cone->ejecutar_idu($sql);
            if (!$statement) {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return true;
    }

    function listadoCompras()
    {
        try {
            $sql = "SELECT Compra.Id,
					DATE_FORMAT(Compra.Fecha,\"%d/%m/%Y\") as Fecha,
					Usuario.Nombre as Usuario,
					Proveedor.Nombre as Proveedor, 
					Compra.Total, 
					Compra.Estado as Estado 
					FROM Compra
					inner join Usuario on Compra.Id_Usuario = Usuario.Id
					inner join Proveedor on Compra.Id_Proveedor = Proveedor.Id";
            
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

    public function formatDatePicker($date)
    {
        $date_p = explode('-', $date);
        $date_u = array($date_p[2], $date_p[1], $date_p[0]);
        $date_f = implode('/', $date_u);
        return $date_f;
    }

}