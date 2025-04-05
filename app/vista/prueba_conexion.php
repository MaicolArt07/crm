<?php 
include_once '../datos/ConexionMySqli.php';

$url = 'http://icanhazip.com';
$ipPublica = file_get_contents($url);
echo "Tu IP pública es: " . $ipPublica." fin";

try {
    $sql = "SELECT * FROM Usuario WHERE Login='eder' and Clave='12345678'";
    
    $cone =  new Database();
    $row = $cone->get_Row($sql);
    echo $row['Clave'];
    /*if ($row['Clave'] == $this->Clave) {
        return (array('Id' => $row['Id'], 'Nombre' => $row['Nombre']));
    } else {
        return null;
    }*/
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
return null;
echo "hola";

?>