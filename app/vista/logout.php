<?php

session_start();
unset($_SESSION['id_usuario']);
unset($_SESSION['usuario']);
if (session_destroy()) {
    header("Location: index.php");
}
header("Location: index.php");

?>
