<?php
   require('datos/gestor.php');
       
    $Id_Usuario = $_GET["Id_Usuario"];
	//$Id_Usuario = 2;
	$Id_Tienda = $_GET["Id_Tienda"];
    if(empty($Id_Usuario)){
      return '';
    }
    
    $gestor= new Gestor();
    $Obtener_Lista_Productos_A_Transportar= $gestor->Obtener_Lista_Productos_A_Transportar($Id_Usuario,$Id_Tienda);
    
    echo ($Obtener_Lista_Productos_A_Transportar);
	//echo "hola";
?>