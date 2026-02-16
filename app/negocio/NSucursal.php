<?php
//require '/../datos/tienda.php';
//prueba2
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DSucursal.php';
if (isset($_REQUEST['funcion'])) {
    $sucursal = new NSucursal();
    switch ($_REQUEST['funcion']) {
        // case "insertar":
		// 	$Id_Grupo_Tienda = $_POST['Id_Grupo_Tienda'];
        //     $nombre = $_POST['nombre'];
        //     $razon_social = $_POST['razon_social'];
        //     $nit = $_POST['nit'];
        //     $direccion = $_POST['direccion'];
        //     $coordenadas = $_POST['coordenadas'];
        //     $telefono = $_POST['telefono'];
        //     $contacto = $_POST['contacto'];
        //     $tienda->insertarTienda($Id_Grupo_Tienda,$nombre,$razon_social, $nit, $direccion, $coordenadas, $telefono, $contacto);
        //     break;
        // case "modificar":
        //     $id_tienda = $_POST['id_tienda'];
		// 	$Id_Grupo_Tienda = $_POST['Id_Grupo_Tienda'];
        //     $nombre = $_POST['nombre'];
		// 	$razon_social = $_POST['razon_social'];
        //     $nit = $_POST['nit'];
        //     $direccion = $_POST['direccion'];
        //     $coordenadas = $_POST['coordenadas'];
        //     $telefono = $_POST['telefono'];
        //     $contacto = $_POST['contacto'];
        //     $correo = $_POST['correo'];
        //     $sala = $_POST['sala'];listado
        //     $localidad = $_POST['localidad'];
		// 	$Frecuencia_Visita = $_POST['Frecuencia_Visita'];
        //     $tienda->modificarTienda($id_tienda,$Id_Grupo_Tienda, $nombre,$razon_social, $nit, $direccion, $coordenadas, $telefono, $contacto,$Frecuencia_Visita,$correo,$sala,$localidad);
        //     break;
        case "habilitar":
            $id_sucursal = $_POST['id_sucursal'];
            $sucursal->habilitarSucursal($id_sucursal);
            break;
        case "deshabilitar":
            $id_sucursal = $_POST['id_sucursal'];
            $sucursal->deshabilitarSucursal($id_sucursal);
            break;
        case "listadoSucursales":
            $sucursal->listadoSucursales();
            break;
    }
}

class NSucursal
{
    // public function insertarTienda($Id_Grupo_Tienda,$nombre, $razon_social, $nit, $direccion, $coordenadas, $telefono, $contacto)
    // {
    //     $tienda = new DTienda();
	// 	$tienda->setId_Grupo_Tienda($Id_Grupo_Tienda);
    //     $tienda->setNombre($nombre);
    //    $tienda->setRazon_Social($razon_social);
    //     $tienda->setNIT($nit);
    //     $tienda->setDireccion($direccion);
    //     $tienda->setCoordenadas($coordenadas);
    //     $tienda->setTelefono($telefono);
    //     $tienda->setContacto($contacto);
    //     $result = $tienda->insertarTienda();
    //     if ($result) {
    //         echo 'Tienda guardada satisfactoriamente';
    //     } else {
    //         echo 'Error al guardar los datos ' + $result;
    //     }
    // }

    // public function modificarTienda($id_tienda,$Id_Grupo_Tienda, $nombre, $razon_social, $nit, $direccion, $coordenadas, 
    // $telefono, $contacto,$Frecuencia_Visita,$correo,$sala,$localidad)
    // {
    //     $tienda = new DTienda();
    //     $tienda->setId($id_tienda);
	// 	$tienda->setId_Grupo_Tienda($Id_Grupo_Tienda);
    //     $tienda->setNombre($nombre);
    //     $tienda->setNIT($nit);
	// 	$tienda->setRazon_Social($razon_social);
    //     $tienda->setDireccion($direccion);
    //     $tienda->setCoordenadas($coordenadas);
    //     $tienda->setCorreo($correo);
    //     $tienda->setTelefono($telefono);
    //     $tienda->setContacto($contacto); 
    //     $tienda->setSala($sala);
    //     $tienda->setLocalidad($localidad);
	// 	$tienda->setFrecuencia_Visita($Frecuencia_Visita);
    //     $result = $tienda->modificarTienda();
    //     if ($result) {
    //         echo 'Tienda modificada satisfactoriamente';
    //     } else {
    //         echo 'Error al guardar los datos ' + $result;
    //     }
    // }

    public function habilitarSucursal($id_sucursal)
    {
        $sucursal = new DSucursal();
        $sucursal->setId($id_sucursal);
        $result = $sucursal->habilitarSucursal();
        if ($result) {
            echo 'Sucursal deshabilitada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }

    public function deshabilitarSucursal($id_sucursal)
    {
        $sucursal = new DSucursal();
        $sucursal->setId($id_sucursal);
        $result = $sucursal->deshabilitarSucursal();
        if ($result) {
            echo 'Sucursal deshabilitada satisfactoriamente';
        } else {
            echo 'Error ' + $result;
        }
    }


    public function listadoSucursales()
    {
        $sucursal = new DSucursal();
        $lista = $sucursal->listadoSucursales();
        echo $lista;
    }
}