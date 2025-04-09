<?php

//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DTraspaso
{
    private $tabla = 'Transpaso';
    private $Id;
    private $Id_Usuario;
    private $Id_Transporte_Origen;
    private $Id_Transporte_Destino;
    private $Id_Producto;
    private $Id_Trasporte;
    // private $Id_Detalle_Trasporte;
    private $Cantidad_Traspaso;
    private $Fecha;
    private $Estado;


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

    // /**
    //  * @param mixed $Id_Usuario
    //  */
    // public function setIdDetalleTransporte($Id_Detalle_Trasporte)
    // {
    //     $this->Id_Detalle_Trasporte = $Id_Detalle_Trasporte;
    // }

    // /**
    //  * @return mixed
    //  */
    // public function getDetalleTransporte()
    // {
    //     return $this->Id_Detalle_Trasporte;
    // }

    
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

    
    // /**
    //  * @param mixed $Id_Usuario
    //  */
    // public function setIdDetalleCantidadTraspaso($Cantidad_Traspaso)
    // {
    //     $this->Cantidad_Traspaso = $Cantidad_Traspaso;
    // }

    // /**
    //  * @return mixed
    //  */
    // public function getDetalleCantidadTraspaso()
    // {
    //     return $this->Cantidad_Traspaso;
    // }



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

    // public function getIdProducto()
    // {
    //     return $this->Id_Producto;
    // }

    // /**
    //  * @param mixed $Id_Usuario
    //  */
    // public function setIdProducto($Id_Producto)
    // {
    //     $this->Id_Producto = $Id_Producto;
    // }

    // /**
    //  * @return mixed
    //  */
    // public function getIdTraspasoDestino()
    // {
    //     return $this->Id_Trasporte;
    // }

    // /**
    //  * @param mixed $Id_Traspaso
    //  */

    // public function setIdTrasporteDestino($Id_Trasporte)
    // {
    //     $this->Id_Trasporte = $Id_Trasporte;
    // }

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

    // /**
    //  * @return mixed
    //  */
    // public function getEstado()
    // {
    //     return $this->Estado;
    // }

    // /**
    //  * @param mixed $Estado
    //  */
    // public function setEstado($Estado)
    // {
    //     $this->Estado = $Estado;
    // }


    // public function listadoTraspasos()
    // {
    //     try {
    //         $sql = "SELECT 
    //                     detalle_transporte.Id,
    //                     usuario_origen.Nombre AS Transporte_Origen,
    //                     detalle_traspaso.Id_Traspaso,
    //                     usuario_destino.Nombre AS Transporte_Destino,
    //                     detalle_traspaso.Cantidad AS Cantidad_Traspaso
    //                 FROM detalle_traspaso
    //                 -- Relación con detalle_transporte
    //                 INNER JOIN detalle_transporte ON detalle_traspaso.Id_Detalle_Transporte = detalle_transporte.Id
    //                 -- Relación con traspaso
    //                 INNER JOIN traspaso ON detalle_traspaso.Id_Traspaso = traspaso.Id
    //                 -- relación desde traspaso
    //                 INNER JOIN transportar AS trans_destino ON trans_destino.Id = traspaso.Id_Transporte
    //                 INNER JOIN usuario AS usuario_destino ON usuario_destino.Id = trans_destino.Id_Usuario
    //                 -- relación desde detalle_transporte
    //                 INNER JOIN transportar AS trans_origen ON trans_origen.Id = detalle_transporte.Id_Transportar
    //                 INNER JOIN usuario AS usuario_origen ON usuario_origen.Id = trans_origen.Id_Usuario";

	// 		$cone =  new Database();
	// 		$tabla = $cone->get_json_rows($sql);
	// 		return '{"data":[' . $tabla . ']}';
    //     } catch (Exception $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }

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
    
    
    // public function insertarDetalleTraspaso($IdTraspaso)
    // {
    //     $id_detalle_transporte = $this->getDetalleTransporte();
    //     $cantidad_traspaso = $this->getDetalleCantidadTraspaso();
    
    //     try {
    //         // Armamos el SQL de inserción directa
    //         $sql = "INSERT INTO detalle_traspaso 
    //                 (Id_Detalle_Transporte, Id_Traspaso, Cantidad, Fecha, Estado, Fecha_Registro) 
    //                 VALUES (
    //                     $id_detalle_transporte,
    //                     $IdTraspaso,
    //                     $cantidad_traspaso,
    //                     '$this->Fecha',
    //                     0,
    //                     NOW()
    //                 )";
    
    //         // Ejecutamos la consulta
    //         $cone = new Database();
    //         $insertResult = $cone->ejecutar_idu($sql);
    
    //         if (!$insertResult) {
    //             return false;
    //         }
    
    //         $sqlId = "SELECT LAST_INSERT_ID() AS Id";
    //         $resultId = $cone->ejecutar_idu($sqlId);
    
    //         if ($data = $resultId->fetch_array()) {
    //             $Id = $data["Id"];
    //             $resultId->close();
    //             return true;
    //         }
    
    //     } catch (Exception $exc) {
    //         echo 'Error al insertar traspaso detalle: ' . $exc->getMessage();
    //     }
    // }
    
    // // Creamos una funcionalidad para buscar y modificar el detalle transporte o crear una nueva si ese producto no esta en el transporte
    // public function modificarDetalleTransporte()
    // {
    //     $id_detalle_transporte = $this->getDetalleTransporte();
    //     $cantidad_traspaso = $this->getDetalleCantidadTraspaso();
    
    //     // Crear la consulta directamente dentro de la función
    //     $sql = "SELECT 
    //                 detalle_transporte.Id,
    //                 Usuario.Id AS Id_Usuario,
    //                 Usuario.Nombre AS Usuario,
    //                 producto.Nombre AS Producto,
    //                 detalle_transporte.Cantidad,
    //                 detalle_transporte.Disponible,
    //                 producto.Id AS Id_Producto
    //             FROM transportar
    //             INNER JOIN Usuario ON transportar.Id_Usuario = Usuario.Id
    //             INNER JOIN detalle_transporte ON detalle_transporte.Id_Transportar = transportar.Id
    //             INNER JOIN orden_produccion ON detalle_transporte.Id_Orden_Produccion = orden_produccion.Id
    //             INNER JOIN producto ON orden_produccion.Id_Producto = producto.Id
    //             WHERE transportar.Estado = 0
    //             AND detalle_transporte.Disponible > 0
    //             AND YEAR(transportar.Fecha) = YEAR(CURDATE())
    //             AND detalle_transporte.Id=$id_detalle_transporte";
    
    //     try {
    //         $cone = new Database();
    //         $result = $cone->get_Row($sql); // Suponiendo que get_json_rows() retorna los resultados como JSON
    
    //         if ($result) 
    //         {

    //             // Asignamos cada valor a una variable
    //             $id_detalle = $result['Id'];
    //             $id_usuario = $result['Id_Usuario'];
    //             $usuario = $result['Usuario'];
    //             $producto = $result['Producto'];
    //             $cantidad = $result['Cantidad'];
    //             $disponible = $result['Disponible'];
    //             $id_producto = $result['Id_Producto'];

    //             if($cantidad == $disponible && $disponible == $cantidad_traspaso)
    //             {
    //                 // ! APROBACION PARA REALIZAR UN RESPECTIVO DELETE
    //                 // CUANDO EL CANTIDAD SE IGUAL AL DISPONIBLE
    //                 // CUANDO EL DISPONIBLE ES IGUAL A LA CANTIDAD QUE DESEA TRASPASAR

    //                 // SI ESTOS SE CUMPLEN ENTONCES EL ORIGINAL TIENE CERO DISPONIBLE SE PROCEDERA A ELIMINAR
    //                 // $sql_delete = "DELETE FROM detalle_transporte WHERE detalle_transporte.Id = $id_detalle_transporte";
    //                 // $delete_result = $cone->ejecutar_idu($sql_delete);
    //             }else{
    //                 $cantidad_disponible = $disponible - $cantidad_traspaso;
    //                 $cantidad_nueva = $cantidad - $cantidad_traspaso;
    //                 // Ahora, ejecutamos la actualización (esto sigue igual)
    //                 $sql_update = "UPDATE detalle_transporte SET Disponible = '$cantidad_disponible', Cantidad = '$cantidad_nueva' 
    //                                 WHERE detalle_transporte.Id = $id_detalle_transporte";
    //                 $update_result = $cone->ejecutar_idu($sql_update);
            
    //                 if ($update_result) 
    //                 {
    //                     // Una vez insertado el traspaso del detalle, empezamos a aumentar su cantidad y disponible del transporte destino
    //                     return true; // Cambio exitoso
    //                 }
    //             }
    //         }
            
    //     } catch (Exception $exc) {
    //         echo 'Error al modificar detalle de transporte: ' . $exc->getMessage();
    //     }
    
    //     return false; // En caso de error
    // }
    
    // public function actualizarDetalleTransporteDestino()
    // {   
    //     $id_trasporte_destino = $this->getIdTraspasoDestino();
    //     $id_producto = $this->getIdProducto();
    //     $cantidad_traspaso = $this->getDetalleCantidadTraspaso();
    
    //     $sql = "SELECT 
    //                 detalle_transporte.Id,
    //                 Usuario.Id AS Id_Usuario,
    //                 Usuario.Nombre AS Usuario,
    //                 producto.Nombre AS Producto,
    //                 detalle_transporte.Cantidad,
    //                 detalle_transporte.Disponible,
    //                 producto.Id AS Id_Producto
    //             FROM transportar
    //             INNER JOIN Usuario ON transportar.Id_Usuario = Usuario.Id
    //             INNER JOIN detalle_transporte ON detalle_transporte.Id_Transportar = transportar.Id
    //             INNER JOIN orden_produccion ON detalle_transporte.Id_Orden_Produccion = orden_produccion.Id
    //             INNER JOIN producto ON orden_produccion.Id_Producto = producto.Id
    //             WHERE transportar.Estado = 0
    //             AND detalle_transporte.Disponible > 0
    //             AND YEAR(transportar.Fecha) = YEAR(CURDATE())
    //             AND transportar.Id = $id_trasporte_destino
    //             AND producto.Id = $id_producto";
    
    //     try {
    //         $cone = new Database();
    //         $result = $cone->get_Row($sql);
    
    //         if ($result) {
    //             // EXISTE -> ACTUALIZAMOS
    //             $id_detalle = $result['Id'];
    //             $cantidad = $result['Cantidad'];
    //             $disponible = $result['Disponible'];
    
    //             $cantidad_disponible = $disponible + $cantidad_traspaso;
    //             $cantidad_nueva = $cantidad + $cantidad_traspaso;

    //             $sql_update = "UPDATE detalle_transporte 
    //                             SET Disponible = '$cantidad_disponible', Cantidad = '$cantidad_nueva' 
    //                             WHERE detalle_transporte.Id = $id_detalle";
    //             $update_result = $cone->ejecutar_idu($sql_update);

    //             if ($update_result) {
    //                 return true;
    //             }

    //         } else {
    //             // No existe -> Insertamos un nuevo detalle de transporte
    //             // Paso 1: Consultar el último Id_Orden_Produccion para el producto
    //             $sql_orden_produccion = "SELECT Id 
    //                                      FROM orden_produccion 
    //                                      WHERE Id_Producto = $id_producto 
    //                                      ORDER BY Id DESC LIMIT 1";
    //             $id_orden_produccion_result = $cone->get_Row($sql_orden_produccion);
                
    //             if ($id_orden_produccion_result) {
    //                 $id_orden_produccion = $id_orden_produccion_result['Id'];
            
    //                 // Paso 2: Insertar el nuevo detalle de transporte
    //                 $sql_insertar = "INSERT INTO detalle_transporte (
    //                                     Id_Transportar,
    //                                     Cantidad,
    //                                     Disponible,
    //                                     Id_Orden_Produccion
    //                                 ) VALUES (
    //                                     $id_trasporte_destino,
    //                                     $cantidad_traspaso,
    //                                     $cantidad_traspaso,
    //                                     $id_orden_produccion
    //                                 )";
    //                 $insert_result = $cone->ejecutar_idu($sql_insertar);
            
    //                 // Paso 3: Comprobar si la inserción fue exitosa
    //                 if ($insert_result) {
    //                     return true; // Inserción exitosa
    //                 }
    //             }
    //         }
    
    //     } catch (Exception $exc) {
    //         echo 'Error al modificar detalle de transporte: ' .$sql." ". $exc->getMessage();
    //     }
    
    // }
    

    public function formatDate($date)
    {
        $date_p = explode('/', $date);
        $date_u = array($date_p[2], $date_p[1], $date_p[0]);
        $date_f = implode('-', $date_u);
        return $date_f;
    }
    
}
?>