<?php
include_once 'conexion.php';

class DDetalleOrdenProduccion
{
    private $tabla = 'Detalle_Orden_Produccion';
    private $Id;
    private $Id_Orden_Produccion;
    private $Id_Insumo;
    private $Cantidad_Insumo;

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
    public function getIdOrdenProduccion()
    {
        return $this->Id_Orden_Produccion;
    }

    /**
     * @param mixed $Id_Orden_Produccion
     */
    public function setIdOrdenProduccion($Id_Orden_Produccion)
    {
        $this->Id_Orden_Produccion = $Id_Orden_Produccion;
    }

    /**
     * @return mixed
     */
    public function getIdInsumo()
    {
        return $this->Id_Insumo;
    }

    /**
     * @param mixed $Id_Insumo
     */
    public function setIdInsumo($Id_Insumo)
    {
        $this->Id_Insumo = $Id_Insumo;
    }

    /**
     * @return mixed
     */
    public function getCantidadRecetaInsumo()
    {
        return $this->Cantidad_Insumo;
    }

    /**
     * @param mixed $Cantidad_Insumo
     */
    public function setCantidadRecetaInsumo($Cantidad_Insumo)
    {
        $this->Cantidad_Insumo = $Cantidad_Insumo;
    }

    public function insertarDetalleOrdenProduccion()
    {
        try {
            $sql = "CALL Insertat_Detalle_Orden_Produccion($this->Id_Orden_Produccion,$this->Id_Insumo,$this->Cantidad_Insumo);";
			echo $sql;
            $conexion = Conexion::getInstance();
            $statement = $conexion->ejecutar($sql);
            if (!$statement) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}