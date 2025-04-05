<?php
   require('datos/gestor.php');
       
    $Clave = $_REQUEST["Clave"];
    $Login = $_REQUEST["Login"];
	
    if(empty($Login) || empty($Clave)){
      return '';
    }
    
    $gestor= new Gestor();
    $fila = $gestor->login($Login,$Clave);
    echo ($fila);
?>