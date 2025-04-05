<?php
   require('datos/gestor.php');
       
    $Clave = $_GET["Clave"];
    $Login = $_GET["Login"];
	
    if(empty($Login) || empty($Clave)){
      return '';
    }
    
    $gestor= new Gestor();
    $fila = $gestor->login($Login,$Clave);
    echo ($fila);
?>