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


    public function listaDetalleTraspaso()
    {
            try {
                // $sql = "SELECT  
                //             Detalle_Traspaso.Id,
                //             Usuario_Origen.Nombre AS Transporte_Origen,
                //             Usuario_Destino.Nombre AS Transporte_Destino,
                //             Detalle_Traspaso.Cantidad AS Cantidad_Traspaso
                //         FROM Detalle_Traspaso

                //         -- Origen
                //         INNER JOIN Detalle_Transporte AS DT_Origen 
                //             ON Detalle_Traspaso.Id_Detalle_Transporte_Origen = DT_Origen.Id
                //         INNER JOIN Transportar AS T_Origen 
                //             ON DT_Origen.Id_Transportar = T_Origen.Id
                //         INNER JOIN Usuario AS Usuario_Origen 
                //             ON T_Origen.Id_Usuario = Usuario_Origen.Id

                //         -- Destino
                //         INNER JOIN Detalle_Transporte AS DT_Destino 
                //             ON Detalle_Traspaso.Id_Detalle_Transporte_Destino = DT_Destino.Id
                //         INNER JOIN Transportar AS T_Destino 
                //             ON DT_Destino.Id_Transportar = T_Destino.Id
                //         INNER JOIN Usuario AS Usuario_Destino 
                //             ON T_Destino.Id_Usuario = Usuario_Destino.Id

                //         ORDER BY Detalle_Traspaso.Id ASC";

                $sql = 'SELECT  
                            Detalle_Traspaso.Id,
                            Usuario.Nombre AS Transporte_Destino,
                            Producto.Nombre AS Producto,
                            Detalle_Traspaso.Cantidad AS Cantidad_Traspaso
                        FROM Detalle_Traspaso
                        INNER JOIN Detalle_Transporte ON Detalle_Traspaso.Id_Detalle_Transporte_Destino = Detalle_Transporte.Id
                        INNER JOIN Transportar ON Detalle_Transporte.Id_Transportar = Transportar.Id
                        INNER JOIN Usuario ON Transportar.Id_Usuario = Usuario.Id
                        INNER JOIN Producto ON Detalle_Transporte.Id_Producto=Producto.Id
                        ORDER BY Detalle_Traspaso.Id ASC';

                $cone =  new Database();
                $tabla = $cone->get_json_rows($sql);
                return '{"data":[' . $tabla . ']}';
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
    }   

    public function insertarDetalleTranporteDestino($id_transporte_destino)
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
            $id_orden_produccion = $result['Id_Orden_Produccion'];
            $id_producto = $result['Id_Producto'];
        }
        
            // Obtemos la cantidad del traspaso
            $cantidad_traspaso = $this->getCantidad();

        try {
            // Armamos el SQL de inserción directa
            $sql = "INSERT INTO Detalle_Transporte 
                    (Id_Transportar, Id_Orden_Produccion, Cantidad, Disponible, Id_Producto) 
                    VALUES (
                        $id_transporte_destino, 
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
                // si se necesita
                $Id = $data["Id"];
                $result_id->close();
                return true;
            }
        
        } catch (Exception $exc) {
            echo 'Error al insertar detalle traspaso: ' . $exc->getMessage();
        }  
    }

    public function actualizarDetalleTransporte()
    {
        $id_detalle_origen = $this->getIdDetalleTraspasoOrigen();
        $cantidad_traspaso = $this->getCantidad();

        // Buscamos el detalle para asegurarnos los valores de cantidad y su disponible y disminuir por la cantidad a retirar
        $sql = "SELECT Id_Transportar, Id_Transportar, 
                Cantidad, Disponible, Id_Producto 
                FROM Detalle_Transporte
                WHERE Id = $id_detalle_origen";
    
        try {
            $cone = new Database();
            $result = $cone->get_Row($sql);
    
            if ($result) 
            {
                // EXISTE -> ACTUALIZAMOS
                $cantidad = $result['Cantidad'];
                $disponible = $result['Disponible'];
    
                $cantidad_disponible = $disponible - $cantidad_traspaso;
                $cantidad_nueva = $cantidad - $cantidad_traspaso;

                // Si la cantidad es cero y la nueva tambien entonces eliminamos el detalle
                if($cantidad_disponible == 0 && $cantidad_nueva == 0)
                {
                    $sql_delete = "DELETE FROM Detalle_Transporte WHERE Detalle_Transporte.Id = $id_detalle_origen";
                    $respuesta = $cone->ejecutar_idu($sql_delete);
                }else{
                    $sql_update = "UPDATE Detalle_Transporte 
                                    SET Disponible = '$cantidad_disponible', Cantidad = '$cantidad_nueva' 
                                    WHERE Detalle_Transporte.Id = $id_detalle_origen";
                    $respuesta = $cone->ejecutar_idu($sql_update);
                }

                // echo $sql;
                if ($respuesta) {
                    return true;
                }
            }
        } catch (Exception $exc) {
            echo 'Error al insertar detalle traspaso: ' . $exc->getMessage();
        } 
    }
}
?>