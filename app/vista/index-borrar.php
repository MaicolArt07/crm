<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bread King</title>
    <!-- PACE-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/PACE/themes/blue/pace-theme-flash.css">
    <script type="text/javascript" src="../../public/plugins/PACE/pace.min.js"></script>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/themify-icons/themify-icons.css">
    <!-- Malihu Scrollbar-->
    <link rel="stylesheet" type="text/css"
          href="../../public/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css">
    <!-- Animo.js-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/animo.js/animate-animo.min.css">
    <!-- Bootstrap Progressbar-->
    <link rel="stylesheet" type="text/css"
          href="../../public/plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="../../public/build/css/second-layout.css">

</head>
<body data-sidebar-color="sidebar-light" class="sidebar-light">
<!-- Header start-->
<header>
    <a href="index.php" class="brand pull-left">
        <h2>BREAD KING</h2></a><a href="javascript:;" role="button"
                                  class="hamburger-menu pull-left visible-xs"><span></span></a>

    <ul class="notification-bar list-inline pull-right">
        <li class="visible-xs"><a href="javascript:;" role="button" class="header-icon search-bar-toggle"><i
                        class="ti-search"></i></a></li>
        <li class="visible-lg"><a href="javascript:;" role="button" class="header-icon fullscreen-toggle"><i
                        class="ti-fullscreen"></i></a></li>

        <li><a href="logout.php" role="button" class="header-icon"><i class="ti-power-off"></i></a></li>
    </ul>
</header>
<!-- Header end-->
<div class="main-container">
    <!-- Main Sidebar start-->
    <aside data-mcs-theme="minimal-dark" class="main-sidebar mCustomScrollbar">
        <div class="user">

            <h4 class="fs-14 text-muted mt-15 mb-5 fw-300"><?php echo $_SESSION['nombre'] ?></h4>
            <p class="fs-13 mb-0 text-muted"></p>
        </div>
        <ul class="list-unstyled navigation mb-0">
            <li class="panel"><a role="button" data-toggle="collapse" data-parent=".navigation" href="#collapse1"
                                 aria-expanded="false" aria-controls="collapse1" class="collapsed"><i
                            class="ti-home"></i> Almacén</a>
                <ul id="collapse1" class="list-unstyled collapse">
                    <li><a href="insumos/index.php">Insumos</a></li>
                    <li><a href="recetas/index.php">Recetas</a></li>
                    <li><a href="productos/index.php">Productos</a></li>
                </ul>
            </li>
            <li class="panel"><a role="button" data-toggle="collapse" data-parent=".navigation" href="#collapse2"
                                 aria-expanded="false" aria-controls="collapse2" class="collapsed"><i
                            class="ti-shopping-cart"></i> Compra</a>
                <ul id="collapse2" class="list-unstyled collapse">
                    <li><a href="proveedores/index.php">Proveedores</a></li>
                    <li><a href="compras/index.php">Compras</a></li>
                </ul>
            </li>
            <li class="panel"><a role="button" data-toggle="collapse" data-parent=".navigation" href="#collapse3"
                                 aria-expanded="false" aria-controls="collapse3" class="collapsed"><i
                            class="ti-bar-chart-alt"></i> Producción</a>
                <ul id="collapse3" class="list-unstyled collapse">
                    <li><a href="produccion/index.php">Orden de producción</a></li>
                </ul>
            </li>
            <li class="panel"><a role="button" data-toggle="collapse" data-parent=".navigation" href="#collapse4"
                                 aria-expanded="false" aria-controls="collapse4" class="collapsed"><i
                            class="ti-truck"></i> Transporte</a>
                <ul id="collapse4" class="list-unstyled collapse">
                    <li><a href="tiendas/index.php">Tiendas</a></li>
                    <li><a href="transportes/index.php">Transportes</a></li>
                </ul>
            </li>
            <li class="panel"><a role="button" data-toggle="collapse" data-parent=".navigation" href="#collapse5"
                                 aria-expanded="false" aria-controls="collapse5" class="collapsed"><i
                            class="ti-settings"></i> Configuración</a>
                <ul id="collapse5" class="list-unstyled collapse">
                    <li><a href="unidades/index.php">Unidades de medida</a></li>
                </ul>
            </li>
        </ul>

    </aside>
    <!-- Main Sidebar end-->
    <div class="page-container">
        <div class="page-header clearfix">
            <div class="pull-left">
                <h4 class="mt-0 mb-5">Bienvenido</h4>
                <ol class="breadcrumb mb-0">
                    <p class="text-muted mb-0">Bread King</p>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">

        </div>
    </div>


</div>

<!-- jQuery-->
<script type="text/javascript" src="../../public/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap JavaScript-->
<script type="text/javascript" src="../../public/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Malihu Scrollbar-->
<script type="text/javascript"
        src="../../public/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Animo.js-->
<script type="text/javascript" src="../../public/plugins/animo.js/animo.min.js"></script>
<!-- Bootstrap Progressbar-->
<script type="text/javascript" src="../../public/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<script type="text/javascript" src="../../public/build/js/app.js"></script>
</body>
</html>


