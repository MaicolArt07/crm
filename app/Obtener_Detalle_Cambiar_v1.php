<?php
   require('datos/gestor.php');
       
    $Id_Cambiar = $_REQUEST["Id_Cambiar"];
    if(empty($Id_Cambiar)){
      return '';
    }
    
    $gestor= new Gestor();
    $Obtener_Detalle_Cambiar= $gestor->Obtener_Detalle_Cambiar_v1($Id_Cambiar);
    echo ($Obtener_Detalle_Cambiar);
?>