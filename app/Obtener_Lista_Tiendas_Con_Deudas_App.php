<meta charset=”UTF-8″>
<?php
  
   require('datos/gestor.php');
     
    
    $gestor= new Gestor();
    $Obtener_Lista_Tiendas_Con_Deudas_App = $gestor->Obtener_Lista_Tiendas_Con_Deudas_App();
    

    echo ($Obtener_Lista_Tiendas_Con_Deudas_App);
?>