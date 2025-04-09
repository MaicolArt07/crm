<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/datos/DDetalle_Transporte.php';

class DDetalleTraspaso
{
    private $tabla = 'Detalle_Traspaso';
    private $Id;
    private $Id_Traspaso;
    private $Id_Detalle_Transporte_Origen;
    private $Id_Detalle_Transporte_Destino;
    private $Cantidad;


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
     * @param mixed $Id
     */
    public function setCantidad($Cantidad)
    {
        $this->Cantidad = $Cantidad;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->Cantidad;
    }

    /**
     * @return mixed
     */
    public function getIdDetalleTraspasoOrigen()
    {
        return $this->Id_Detalle_Transporte_Origen;
    }

    /**
     * @param mixed
     */
    public function setIdDetalleTraspasoOrigen($Id_Detalle_Transporte_Origen)
    {
        $this->Id_Detalle_Transporte_Origen = $Id_Detalle_Transporte_Origen;
    }

    /**
     * @return mixed
     */
    public function getIdDetalleTraspasoDestino()
    {
        return $this->Id_Detalle_Transporte_Destino;
    }

    /**
     * @param mixed
     */
    public function setIdDetalleTraspasoDestino($Id_Detalle_Transporte_Destino)
    {
        $this->Id_Detalle_Transporte_Destino = $Id_Detalle_Transporte_Destino;
    }

        /**
     * @return mixed
     */
    public function getIdTraspaso()
    {
        return $this->Id_Traspaso;
    }

    /**
     * @param mixed
     */
    public function setIdTraspaso($Id_Traspaso)
    {
        $this->Id_Traspaso = $Id_Traspaso;
    }

    public function insertarDetalleTranporteDestino()
    {
        $id_detalle_origen = $this->getIdDetalleTraspasoOrigen();
        // obtenemos los valores del detalle de transporte origen
        $sql_detalle_origen = "SELECT Id, Id_Transportar, 
                                Id_Orden_Produccion, Cantidad, 
                                Disponible, Id_Producto 
                                FROM Detalle_Transporte
                                WHERE Id=$id_detalle_origen";

        $cone = new Database();
        $result = $cone->get_Row($sql_detalle_origen); // Suponiendo que get_json_rows() retorna los resultados como JSON

        if ($result) 
        {
            // Asignamos cada valor a una variable
            $id_transportar = $result['Id_Transportar'];
            $id_orden_produccion = $result['Id_Orden_Produccion'];
            $cantidad = $result['Cantidad'];
            $id_producto = $result['Id_Producto'];
        }
            $cantidad_traspaso = $this->getCantidad();

        try {
            // Armamos el SQL de inserción directa
            $sql = "INSERT INTO Detalle_Transporte 
                    (Id_Transportar, Id_Orden_Produccion, Cantidad, Disponible, Id_Producto) 
                    VALUES (
                        $id_transportar, 
                        $id_orden_produccion, 
                        $cantidad_traspaso, 
                        $cantidad_traspaso, 
                        $id_producto
                    )";
        
            // Ejecutamos la consulta
            $cone = new Database();
            $insertResult = $cone->ejecutar_idu($sql);
        
            if (!$insertResult) {
                return false;
            }
        
            // Obtener el ID generado con LAST_INSERT_ID()
            $sqlId = "SELECT LAST_INSERT_ID() AS Id";
            $resultId = $cone->ejecutar_idu($sqlId);
        
            if ($data = $resultId->fetch_array()) {
                $this->Id_Detalle_Transporte_Destino = $data["Id"];
                $resultId->close();
                return true;
            }
        } catch (Exception $exc) {
            echo 'Error al insertar detalle de transporte: ' . $exc->getMessage();
        }
    }

    public function insertarDetalleTraspaso($id_traspaso, $fecha)
    {
        $id_detalle_destino = $this->getIdDetalleTraspasoDestino();
        $id_detalle_origen = $this->getIdDetalleTraspasoOrigen();
        $cantidad_traspaso = $this->getCantidad();
        try {
            // Armamos el SQL de inserción
            $sql_insertar = "INSERT INTO Detalle_Traspaso 
                          (Id_Traspaso, Id_Detalle_Transporte_Origen, Id_Detalle_Transporte_Destino, Cantidad, Fecha, Fecha_Registro) 
                          VALUES (
                              $id_traspaso, 
                              $id_detalle_origen, 
                              $id_detalle_destino, 
                              $cantidad_traspaso, 
                              '$fecha', 
                              NOW()
                          )";
        
            // Ejecutamos la consulta
            $cone = new Database();
            $insert_reesult = $cone->ejecutar_idu($sql_insertar);
        
            if (!$insert_reesult) {
                return false;
            }
        
            // Obtener el ID generado con LAST_INSERT_ID()
            $sql_id = "SELECT LAST_INSERT_ID() AS Id";
            $result_id = $cone->ejecutar_idu($sql_id);
        
            if ($data = $result_id->fetch_array()) {
                $Id = $data["Id"];
                $result_id->close();
                return true;
            }
        
        } catch (Exception $exc) {
            echo 'Error al insertar detalle traspaso: ' . $exc->getMessage();
        }
        
    }
}
?>