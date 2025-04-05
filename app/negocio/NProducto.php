<?php
require $_SERVER['DOCUMENT_ROOT'].'/app/datos/DProducto.php';
//require '/../datos/producto.php';

if (isset($_REQUEST['funcion'])) {
    $producto = new NProducto();
    switch ($_REQUEST['funcion']) {
        case "insertar":
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $producto->insertarProducto($nombre, $descripcion);
            break;
        case "modificar":
            $Id = $_POST['Id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $producto->modificarProducto($Id, $nombre, $descripcion);
            break;
        case "habilitar":
            $Id = $_POST['Id'];
            $producto->habilitarProducto($Id);
            break;
        case "deshabilitar":
            $Id = $_POST['Id'];
            $producto->deshabilitarProducto($Id);
            break;
        case "listado":
            $producto->listadoProductos();
            break;

    }
}

class NProducto
{
    public function insertarProducto($nombre, $descripcion)
    {
        $producto = new DProducto();
        $producto->setNombre($nombre);
        $producto->setDescripcion($descripcion);
        $result = $producto->insertarProducto();
        if ($result) {
            echo 'Producto guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }
    }

    public function modificarProducto($Id, $nombre, $descripcion)
    {
        $producto = new DProducto();
        $producto->setIdProducto($Id);
        $producto->setNombre($nombre);
        $producto->setDescripcion($descripcion);
        $result = $producto->modificarProducto();
        if ($result) {
            echo 'Producto modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarProducto($Id)
    {
        $producto = new DProducto();
        $producto->setIdProducto($Id);
        $result = $producto->habilitarProducto();
        if ($result) {
            echo 'Producto habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarProducto($Id)
    {
        $producto = new DProducto();
        $producto->setIdProducto($Id);
        $result = $producto->deshabilitarProducto();
        if ($result) {
            echo 'Producto deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoProductos()
    {
        $producto = new DProducto();
        $lista = $producto->listadoProductos();
        echo $lista;
    }


}