<?php
   require('datos/gestor.php');
       
	//$Id_Usuario = 2;
	$Id_Tienda = $_GET["Id_Tienda"];
    
    $gestor= new Gestor();
    $Obtener_Lista_Productos_Activos= $gestor->Obtener_Lista_Productos_Activos($Id_Tienda);
    
    echo ($Obtener_Lista_Productos_Activos);
?>