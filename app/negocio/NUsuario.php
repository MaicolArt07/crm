<?php
session_start();
require '../datos/DUsuario.php';


if (isset($_REQUEST['funcion'])) {
    $usuario = new NUsuario();
    switch ($_REQUEST['funcion']) {
        case "login":
            $login = $_POST['login'];
            $clave = $_POST['clave'];
            $usuario->getDataUsuario($login, $clave);
            break;
		case "insertar":
            $nombre = $_POST['nombre'];
            $login = $_POST['login'];
            $clave = $_POST['clave'];
            $tipo = $_POST['tipo'];
            $usuario->insertarUsuario($nombre, $login, $clave, $tipo);
            break;
        case "modificar":
            $id_usuario = $_POST['id_usuario'];
            $nombre = $_POST['nombre'];
            $login = $_POST['login'];
            $clave = $_POST['clave'];
            $tipo = $_POST['tipo'];
            $usuario->modificarUsuario($id_usuario, $nombre, $login, $clave, $tipo);
            break;
        case "habilitar":
            $id_usuario = $_POST['id_usuario'];
            $usuario->habilitarUsuario($id_usuario);
            break;
        case "deshabilitar":
            $id_usuario = $_POST['id_usuario'];
            $usuario->deshabilitarUsuario($id_usuario);
			break;
		case "listado":
            $usuario->listadoUsuarios();
            break;
    }
}

class NUsuario
{

    public function getDataUsuario($login, $clave)
    {
        $usuario = new DUsuario();
        $usuario->setLogin($login);
        $usuario->setClave($clave);
        $result = $usuario->getDataUsuario();
        if ($result != null) {
            //$json = json_decode($result, true);
            $_SESSION['id_usuario'] = $result['Id'];
            $_SESSION['nombre'] = $result['Nombre'];
            echo 1;
        } else {
            echo 0;
        }
    }

	public function insertarUsuario($nombre, $login, $clave, $tipo)
    {
        $usuario = new DUsuario();
        $usuario->setNombre($nombre);
        $usuario->setLogin($login);
        $usuario->setClave($clave);
        $usuario->setTipo($tipo);
        $result = $usuario->insertarUsuario();
        if ($result) {
            echo 'Usuarios guardado satisfactoriamente';
        } else {
            echo 'Error al guardar los datos ' + $result;
        }

    }

    public function modificarUsuario($id_usuario, $nombre, $login, $clave, $tipo)
    {
        $usuario = new DUsuario();
        $usuario->setId($id_usuario);
        $usuario->setNombre($nombre);
        $usuario->setLogin($login);
        $usuario->setClave($clave);
        $usuario->setTipo($tipo);
        $result = $usuario->modificarUsuario();
        if ($result) {
            echo 'Usuarios modificado satisfactoriamente';
        } else {
            echo 'Error en la modificación de datos ' + $result;
        }
    }

    public function habilitarUsuario($id_usuario)
    {
        $usuario = new DUsuario();
        $usuario->setId($id_usuario);
        $result = $usuario->habilitarUsuario();
        if ($result) {
            echo 'Usuarios habilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function deshabilitarUsuario($id_usuario)
    {
        $usuario = new DUsuario();
        $usuario->setId($id_usuario);
        $result = $usuario->deshabilitarUsuario();
        if ($result) {
            echo 'Usuarios deshabilitado satisfactoriamente';
        } else {
            echo 'Error';
        }
    }

    public function listadoUsuarios()
    {
        $usuario = new DUsuario();
        $lista = $usuario->listadoUsuarios();
        echo $lista;
    }
}
