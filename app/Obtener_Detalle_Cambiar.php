<?php
   require('datos/gestor.php');
       
    $Id_Venta = $_REQUEST["Id_Venta"];
    if(empty($Id_Venta)){
      return '';
    }
    
    $gestor= new Gestor();
    $Obtener_Detalle_Cambiar= $gestor->Obtener_Detalle_Cambiar($Id_Venta);
    echo ($Obtener_Detalle_Cambiar);
?>