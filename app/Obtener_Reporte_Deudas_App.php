<meta charset=”UTF-8″>
<?php
  
   require('datos/gestor.php');
     $Id_Tienda = $_GET["Id_Tienda"];
    //echo $Id_Usuario;
    $gestor= new Gestor();
    $Obtener_Reporte_Ventas_App = $gestor->Obtener_Reporte_Deudas_App($Id_Tienda);

    echo ($Obtener_Reporte_Ventas_App);
?>