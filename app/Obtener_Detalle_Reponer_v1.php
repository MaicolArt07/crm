<?php
   require('datos/gestor.php');
       
    $Id_Reponer = $_REQUEST["Id_Reponer"];
    if(empty($Id_Reponer)){
      return '';
    }
    
    $gestor= new Gestor();
    $Obtener_Detalle_Reponer= $gestor->Obtener_Detalle_Reponer_v1($Id_Reponer);
    echo ($Obtener_Detalle_Reponer);
?>