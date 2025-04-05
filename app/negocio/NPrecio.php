<?php
//require '/../datos/precio.php';
//prueba2
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DPrecio.php';
	
if (isset($_REQUEST['funcion'])) {
    $Precio = new NPrecio();
    switch ($_REQUEST['funcion']) {
        case "insertar":
			
			$Id_Grupo_Tienda = $_POST['Id_Grupo_Tienda'];
            $Id_Producto = $_POST['Id_Producto'];
            $Monto = $_POST['Monto'];
			
            $Precio->insertarPrecio($Id_Grupo_Tienda,$Id_Producto,$Monto);
            break;
        case "modificar":
            $Id = $_POST['Id'];
			$Id_Grupo_Tienda = $_POST['Id_Grupo_Tienda'];
            $Id_Producto = $_POST['Id_Producto'];
            $Monto = $_POST['Monto'];
            $Precio->modificarPrecio($Id,$Id_Grupo_Tienda,$Id_Producto,$Monto);
            break;
        case "habilitar":
            $Id = $_POST['Id'];
            $Precio->habilitarPrecio($Id);
            break;
        case "deshabilitar":
            $Id = $_POST['Id'];
            $Precio->deshabilitarPrecio($Id);
            break;
        case "listado":
            $Precio->listadoPrecio();
            break;
    }
}

class NPrecio
{
    public function insertarPrecio($Id_Grupo_Tienda,$Id_Producto,$Monto)
    {
		$Precio = new DPrecio();
		$Precio->setIdGrupo_Tienda($Id_Grupo_Tienda);
        $Precio->setIdProducto($Id_Producto);
       $Precio->setMonto($Monto);
        $result = $Precio->insertarPrecio();
        if ($result) {
            echo 'Precio guardada satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }
    }

    public function modificarPrecio($Id,$Id_Grupo_Tienda,$Id_Producto,$Monto)
    {
        $Precio = new DPrecio();
        $Precio->setId($Id);
		$Precio->setIdGrupo_Tienda($Id_Grupo_Tienda);
        $Precio->setIdProducto($Id_Producto);
        $Precio->setMonto($Monto);
        $result = $Precio->modificarPrecio();
        if ($result) {
            echo 'Precio modificada satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }
    }

    public function habilitarPrecio($Id)
    {
        $Precio = new DPrecio();
        $Precio->setId($Id);
        $result = $Precio->habilitarPrecio();
        if ($result) {
            echo 'Precio habilitada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function deshabilitarPrecio($Id)
    {
        $Precio = new DPrecio();
        $Precio->setId($Id);
        $result = $Precio->deshabilitarPrecio();
        if ($result) {
            echo 'Precio deshabilitada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }


    public function listadoPrecio()
    {
        $Precio = new DPrecio();
        $lista = $Precio->listadoPrecio();
        echo $lista;
    }
}