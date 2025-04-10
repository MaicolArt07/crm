<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DTraspaso
{
    private $tabla = 'Traspaso';
    private $Id;
    private $Id_Usuario;
    private $Id_Transporte_Origen;
    private $Id_Transporte_Destino;
    private $Fecha;


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
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id_Usuario
     */
    public function setIdTransporteOrigen($Id_Transporte_Origen)
    {
        $this->Id_Transporte_Origen = $Id_Transporte_Origen;
    }

    /**
     * @return mixed
     */
    public function getIdTransporteOrigen()
    {
        return $this->Id_Transporte_Origen;
    }


    /**
     * @param mixed
     */
    public function setIdTransporteDestino($Id_Transporte_Destino)
    {
        $this->Id_Transporte_Destino = $Id_Transporte_Destino;
    }

    /**
     * @return mixed
     */
    public function getIdTransporteDestino()
    {
        return $this->Id_Transporte_Destino;
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


    public function detalleTransporteAbiertos()
    {
        try {
            $sql = "SELECT DISTINCT
                        Transportar.Id,
						Usuario.Id AS Id_Usuario,
                        Usuario.Nombre AS Usuario
                    FROM Transportar
                    INNER JOIN Usuario ON Transportar.Id_Usuario = Usuario.Id
                    INNER JOIN Detalle_Transporte ON Detalle_Transporte.Id_Transportar = Transportar.Id
					INNER JOIN Orden_Produccion ON Detalle_Transporte.Id_Orden_Produccion=Orden_Produccion.Id
					INNER JOIN Producto ON Orden_Produccion.Id_Producto=Producto.Id
                    WHERE Transportar.Estado = 0
                    AND Detalle_Transporte.Disponible > 0
                    AND YEAR(Transportar.Fecha) = YEAR(CURDATE())
                    GROUP BY Usuario.Id";

			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function productosTransporteOrigen()
    {
        $id_usuario = $this->getIdUsuario();
        $id_transporte_origen = $this->getIdTransporteOrigen();

        try {
            $sql = "SELECT Detalle_Transporte.Id, 
                            Detalle_Transporte.Id_Transportar, 
                            Detalle_Transporte.Id_Orden_Produccion, 
                            Detalle_Transporte.Cantidad, 
                            Detalle_Transporte.Disponible, 
                            Detalle_Transporte.Id_Producto,
                            Producto.Nombre AS Producto
                    FROM Detalle_Transporte
                    INNER JOIN Producto ON Detalle_Transporte.Id_Producto=Producto.Id
                    WHERE Detalle_Transporte.Id_Transportar=$id_transporte_origen
                    AND Detalle_Transporte.Disponible > 0";

			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function transportesTranspasos()
    {
        $id_usuario = $this->getIdUsuario();
        try {
            $sql = "SELECT DISTINCT
                        Transportar.Id,
						Usuario.Id AS Id_Usuario,
                        Usuario.Nombre AS Usuario
                    FROM Transportar
                    INNER JOIN Usuario ON Transportar.Id_Usuario = Usuario.Id
                    INNER JOIN Detalle_Transporte ON Detalle_Transporte.Id_Transportar = Transportar.Id
					INNER JOIN Orden_Produccion ON Detalle_Transporte.Id_Orden_Produccion=Orden_Produccion.Id
					INNER JOIN Producto ON Orden_Produccion.Id_Producto=Producto.Id
                    WHERE Transportar.Estado = 0
                    AND Detalle_Transporte.Disponible > 0
                    AND YEAR(Transportar.Fecha) = YEAR(CURDATE())
                    AND Usuario.Id != $id_usuario";

			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function insertarTraspaso()
    {
        $id_transporte_origen = $this->getIdTransporteOrigen();
        $id_transporte_destino = $this->getIdTransporteDestino();
        $fecha = $this->getFecha();
        $usuario = $this->getIdUsuario();
        
        try {
            // Armamos el SQL de inserción
            $sqlInsert = "INSERT INTO Traspaso (Fecha, Id_Usuario, Id_Transporte_Origen, Id_Transporte_Destino, Fecha_Registro) 
                          VALUES ('$fecha', $usuario, $id_transporte_origen, $id_transporte_destino, NOW())";
        
            // Ejecutamos la consulta
            $cone = new Database();
            $insertResult = $cone->ejecutar_idu($sqlInsert);
        
            if (!$insertResult) {
                return false;
            }
        
            // Obtener el ID generado con LAST_INSERT_ID()
            $sqlId = "SELECT LAST_INSERT_ID() AS Nuevo_Id";
            $resultId = $cone->ejecutar_idu($sqlId);
        
            if ($data = $resultId->fetch_array()) {
                $this->Id = $data["Nuevo_Id"]; // Asignamos el nuevo ID a la propiedad
                $resultId->close(); // Cerrar el statement
                return true;
            }
        
        } catch (Exception $exc) {
            echo 'Verificar para poder insertar el traspaso: '. $exc->getMessage();
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