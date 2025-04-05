<meta charset=”UTF-8″>
<?php
  
   require('datos/gestor.php');
     $Id_Usuario = $_GET["Id_Usuario"];
    //echo $Id_Usuario;
    $gestor= new Gestor();
    $Obtener_Reporte_Ventas_App = $gestor->Obtener_Reporte_Accion_Vender_Reponer_Cambiar_App($Id_Usuario);
    

    echo ($Obtener_Reporte_Ventas_App);
?>