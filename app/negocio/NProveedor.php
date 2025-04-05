<?php
//require '/../datos/proveedor.php';

require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DProveedor.php';

if (isset($_REQUEST['funcion'])) {
    $proveedor = new NProveedor();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $nombre = $_POST['nombre'];
            $nit = $_POST['nit'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $proveedor->insertarProveedor($nombre, $nit, $direccion, $telefono, $correo);
            break;
        case "modificar":
            $id_proveedor = $_POST['id_proveedor'];
            $nombre = $_POST['nombre'];
            $nit = $_POST['nit'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $proveedor->modificarProveedor($id_proveedor, $nombre, $nit, $direccion, $telefono, $correo);
            break;
        case "habilitar":
            $id_proveedor = $_POST['id_proveedor'];
            $proveedor->habilitarProveedor($id_proveedor);
            break;
        case "deshabilitar":
            $id_proveedor = $_POST['id_proveedor'];
            $proveedor->deshabilitarProveedor($id_proveedor);
            break;
        case "listado":
            $proveedor->listadoProveedores();
            break;
    }
}

class NProveedor
{
    public function insertarProveedor($nombre, $nit, $direccion, $telefono, $correo)
    {
        $proveedor = new DProveedor();
        $proveedor->setNombre($nombre);
        $proveedor->setNit($nit);
        $proveedor->setDireccion($direccion);
        $proveedor->setTelefono($telefono);
        $proveedor->setCorreo($correo);
        $result = $proveedor->insertarProveedor();
        if ($result) {
            echo 'Proveedor guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }

    }

    public function modificarProveedor($id_proveedor, $nombre, $nit, $direccion, $telefono, $correo)
    {
        $proveedor = new DProveedor();
        $proveedor->setIdProveedor($id_proveedor);
        $proveedor->setNombre($nombre);
        $proveedor->setNit($nit);
        $proveedor->setDireccion($direccion);
        $proveedor->setTelefono($telefono);
        $proveedor->setCorreo($correo);
        $result = $proveedor->modificarProveedor();
        if ($result) {
            echo 'Proveedor modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarProveedor($id_proveedor)
    {
        $proveedor = new DProveedor();
        $proveedor->setIdProveedor($id_proveedor);
        $result = $proveedor->habilitarProveedor();
        if ($result) {
            echo 'Proveedor habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarProveedor($id_proveedor)
    {
        $proveedor = new DProveedor();
        $proveedor->setIdProveedor($id_proveedor);
        $result = $proveedor->deshabilitarProveedor();
        if ($result) {
            echo 'Proveedor deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoProveedores()
    {
        $proveedor = new DProveedor();
        $lista = $proveedor->listadoProveedores();
        echo $lista;
    }

}