<?php

class Impuesto_Online {
    
    private $Id;
    private $NIT;
    private $CAFC_CompraVenta;
    private $CAFC_ServicioBasico;
    private $RazonSocial;
    private $Municipio;
    private $Telefono;
    private $Direccion;
    private $ActividadEconomica;
    private $ProductoSIN;
    private $UnidadMedida;
    private $Sucursal;
    private $TokenApi;
    private $CodigoAmbiente;
    private $CodigoModalidad;
    private $CodigoSistema;
    private $LlavePrivada;
    private $ServicioBasicoSIN;
    private $UnidadMedidaServicio;
    private $PuntoVenta;

    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getNIT() {
        return $this->NIT;
    }

    public function setNIT($NIT) {
        $this->NIT = $NIT;
    }

    public function getCAFC_CompraVenta() {
        return $this->CAFC_CompraVenta;
    }

    public function setCAFC_CompraVenta($CAFC_CompraVenta) {
        $this->CAFC_CompraVenta = $CAFC_CompraVenta;
    }

    public function getCAFC_ServicioBasico() {
        return $this->CAFC_ServicioBasico;
    }

    public function setCAFC_ServicioBasico($CAFC_ServicioBasico) {
        $this->CAFC_ServicioBasico = $CAFC_ServicioBasico;
    }

    public function getRazonSocial() {
        return $this->RazonSocial;
    }

    public function setRazonSocial($RazonSocial) {
        $this->RazonSocial = $RazonSocial;
    }

    public function getMunicipio() {
        return $this->Municipio;
    }

    public function setMunicipio($Municipio) {
        $this->Municipio = $Municipio;
    }

    public function getTelefono() {
        return $this->Telefono;
    }

    public function setTelefono($Telefono) {
        $this->Telefono = $Telefono;
    }

    public function getDireccion() {
        return $this->Direccion;
    }

    public function setDireccion($Direccion) {
        $this->Direccion = $Direccion;
    }

    public function getActividadEconomica() {
        return $this->ActividadEconomica;
    }

    public function setActividadEconomica($ActividadEconomica) {
        $this->ActividadEconomica = $ActividadEconomica;
    }

    public function getProductoSIN() {
        return $this->ProductoSIN;
    }

    public function setProductoSIN($ProductoSIN) {
        $this->ProductoSIN = $ProductoSIN;
    }

    public function getUnidadMedida() {
        return $this->UnidadMedida;
    }

    public function setUnidadMedida($UnidadMedida) {
        $this->UnidadMedida = $UnidadMedida;
    }

    public function getSucursal() {
        return $this->Sucursal;
    }

    public function setSucursal($Sucursal) {
        $this->Sucursal = $Sucursal;
    }

    public function getTokenApi() {
        return $this->TokenApi;
    }

    public function setTokenApi($TokenApi) {
        $this->TokenApi = $TokenApi;
    }

    public function getCodigoAmbiente() {
        return $this->CodigoAmbiente;
    }

    public function setCodigoAmbiente($CodigoAmbiente) {
        $this->CodigoAmbiente = $CodigoAmbiente;
    }

    public function getCodigoSistema() {
        return $this->CodigoSistema;
    }

    public function setCodigoSistema($CodigoSistema) {
        $this->CodigoSistema = $CodigoSistema;
    }

    public function getLlavePrivada() {
        return $this->LlavePrivada;
    }

    public function setLlavePrivada($LlavePrivada) {
        $this->LlavePrivada = $LlavePrivada;
    }

    public function getServicioBasicoSIN() {
        return $this->ServicioBasicoSIN;
    }

    public function setServicioBasicoSIN($ServicioBasicoSIN) {
        $this->ServicioBasicoSIN = $ServicioBasicoSIN;
    }

    public function getUnidadMedidaServicio() {
        return $this->UnidadMedidaServicio;
    }

    public function setUnidadMedidaServicio($UnidadMedidaServicio) {
        $this->UnidadMedidaServicio = $UnidadMedidaServicio;
    }

    public function getPuntoVenta() {
        return $this->PuntoVenta;
    }

    public function setPuntoVenta($PuntoVenta) {
        $this->PuntoVenta = $PuntoVenta;
    }

    public function Obtener_Datos_impuestos_online() {
        $g = new Gestor();
        $g->Obtener_Datos_impuestos_online($this);
    }

    public function Obtener_Datos_impuestos_online_conexionbd_tomcat($g) {
        $g->Obtener_Datos_impuestos_online_conexionbd_Tomcat($this);
    }
}
?>
