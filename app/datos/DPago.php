<?php
//include_once 'conexion.php';
include_once 'ConexionMySqli.php';

class DPago
{
    //private $tabla = 'Pago';
    private $Id;
	private $Id_Venta;
    private $Id_Usuario;
	private $Id_Transportar;
    private $Fecha;
    private $Total;
    private $cone = null;

    function listadoPagos($Id_Transportar)
    {
        try {
            $sql = "SELECT Pago.Id,Pago.fecha AS Fecha,Pago.Id_Venta as Venta, Pago.total as Total
FROM Pago WHERE Pago.Id_Transportar=".$Id_Transportar;
			
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
	
    function detalle_pago_Web($id_pago)
    {
        try {
            $sql = "select 
	Venta.Id as Venta,
	Tienda.Nombre as Tienda,
	ifnull(Factura.NIT,'') as NIT,
	ifnull(Factura.Numero_Factura,'') as Factura,
	DetallePago.Fecha,
	DetallePago.Total as Pago
	 from DetallePago
	 inner join Venta on Venta.Id = DetallePago.Id_Venta
	 inner join Tienda on Tienda.Id = Venta.Id_Tienda
	 left join Factura on Venta.Id = Factura.Id_Venta
	where DetallePago.Id_Pago=".$id_pago;
			
			$cone =  new Database();
			$tabla = $cone->get_json_rows($sql);
			return '{"data":[' . $tabla . ']}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

	function listadoPagosWeb()
    {
        try {
            $sql = "SELECT 
            Pago.Id,
            Pago.Fecha AS Fecha,
            Usuario.Nombre as Usuario, 
            Pago.Tienda_Grupo_Tienda as Tienda_Grupo_Tienda, 
            Pago.Metodo_Pago as Metodo_Pago,
            Pago.Codigo_Metodo_Pago as Codigo_Metodo_Pago,
            Pago.Total as Total,
            Pago.Estado as Estado
FROM Pago inner join Usuario ON
Pago.Id_Usuario = Usuario.Id";
			//console.log('Listado de Pagos:', $sql);
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

    public function Abrir_Conexion(){
		if($this->$cone==null){
		   $this->$cone =  new Database();
           //echo "abrio conexion";
	   }
	}

    public function DesHabilitar_AutoCommit(){
        if($this->$cone!=null){
            //echo 'Habilitando Commit';
            $this->$cone->DesHabilitar_Commit();
       }else{
           echo 'no pudo deshabilitar commit:'.$this->cone;
       }
        
    }

    public function Commit(){
        if($this->$cone!=null){
            //echo 'Habilitando Commit';
          $this->$cone->Commit();
       }else{
           echo 'no pudo hacer commit:'.$cone;
       }
        
    }
    
    public function rollback(){
        if($this->$cone==null){
          $this->$cone->rollback();
      }
       
   }

   public function __construct() {
        $this->cone = null;
    }

   public function Agregar_Pago($id_usuario,$tienda_grupo_tienda,$metodoPago,$codigo_documento,$totalpagar){
        $sql = "call Agregar_Pago_Web(".$id_usuario.", '".$tienda_grupo_tienda."', '".$metodoPago."', '".$codigo_documento."', ".$totalpagar.")";
        //echo $sql;
        if($this->$cone==null){
            $this->$cone =  new Database();
            //echo "abriendo conexion";
        }
        $tabla = $this->$cone->get_json_row_v1($sql);
        return $tabla;
  }

  public function Anular_Pago_Web($id_pago){
    $sql = "call Anular_Pago_Web(".$id_pago.")";
    //echo $sql;
    if($this->$cone==null){
        $this->$cone =  new Database();
        //echo "abriendo conexion";
    }
    $tabla = $this->$cone->get_json_row_v1($sql);
    return $tabla;
}

    public function Agregar_Detalle_Pago($id_usuario,$id_pago, $id_venta, $monto){
        $sql = "call Agregar_Detalle_Pago(".$id_usuario.",".$id_pago.", ".$id_venta.", ".$monto.")";
        //echo $sql;
        if($this->$cone==null){
            $this->$cone =  new Database();
            //echo "abriendo conexion";
        }
        $tabla = $this->$cone->get_json_row_v1($sql);
        return $tabla;
    }

}