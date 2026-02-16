<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../datos/DGrupo_Tienda.php';
$Grupo_Tienda = new DGrupo_Tienda();

$Id = $_GET['Id'];
$Nombre_Grupo_Tienda = $_GET['G'];
$Nombre = $_GET['N'];
$NIT = $_GET['I'];
$Razon_Social = $_GET['R'];
$Direccion = $_GET['D'];
$Coordenadas = $_GET['C'];
$Telefono = $_GET['T'];
$Contacto = $_GET['A'];
$Frecuencia_Visita = $_GET['F'];
$Correo = $_GET['Co'];
$Sala = $_GET['Sa'];
$Localidad = $_GET['Lo'];
$array_coordenadas = explode(";", $Coordenadas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Alternativas en otros formatos -->
    <link rel="icon" href="../../../public/images/icon.png" type="image/png">
    <title>Bread King</title>
    <!-- PACE-->
    <link rel="stylesheet" type="text/css" href="../../../public/plugins/PACE/themes/blue/pace-theme-flash.css">
    <script type="text/javascript" src="../../../public/plugins/PACE/pace.min.js"></script>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="../../../public/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="../../../public/plugins/themify-icons/themify-icons.css">
    <!-- Malihu Scrollbar-->
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css">
    <!-- Animo.js-->
    <link rel="stylesheet" type="text/css" href="../../../public/plugins/animo.js/animate-animo.min.css">

    <!-- Bootstrap Progressbar-->
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
    <!-- Toastr-->
    <link rel="stylesheet" type="text/css" href="../../../public/plugins/toastr/toastr.min.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="../../../public/build/css/second-layout.css">
    <!-- DataTables-->
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-colreorder-bs/css/colReorder.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../../../public/build/css/style.css">
</head>
<body data-sidebar-color="sidebar-light" class="sidebar-light">
<!-- Header start-->
<header>
    <a href="index_tienda.php" class="brand pull-left">
        <h2>BREAD KING</h2></a><a href="javascript:;" role="button"
                                  class="hamburger-menu pull-left visible-xs"><span></span></a>

    <ul class="notification-bar list-inline pull-right">
        <li class="visible-xs"><a href="javascript:;" role="button" class="header-icon search-bar-toggle"><i
                        class="ti-search"></i></a></li>
        <li class="visible-lg"><a href="javascript:;" role="button" class="header-icon fullscreen-toggle"><i
                        class="ti-fullscreen"></i></a></li>

        <li><a href="login.html" role="button" class="header-icon"><i class="ti-power-off"></i></a></li>
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
        <?php include("../menu.html"); ?>
    </aside>
    <!-- Main Sidebar end-->
    <div class="page-container">
        <div class="page-header clearfix">
            <div class="pull-left">
                <h4 class="mt-0 mb-5">Tiendas</h4>
                <ol class="breadcrumb mb-0">
                    <li><a href="#">Transporte</a></li>
                    <li><a href="#">Tiendas</a></li>
                    <li><a href="index_tienda.php">Listado de tiendas</a></li>
                    <li class="active">Modificar tienda</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="widget">
                        <div class="widget-heading">
                            <h3 class="widget-title">Modificar tienda</h3>
                        </div>
                        <div class="widget-body">
                            <form id="form-receta" method="post" novalidate="novalidate">
                                <div class="row">
									<div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_tienda">Id </label>
                                            <input id="id_tienda"  value="<?php echo $Id ?>" type="text" name="id_tienda" data-rule-required="true"
											minlength="0" readonly 
                                                   class="form-control">
                                        </div>
                                    </div>
									<div class="col-md-8">
                                        <div class="form-group">
                                            <label for="nombre_m">Nombre </label>
                                            <input id="nombre_m"  value="<?php echo $Nombre ?>" type="text" name="nombre_m" data-rule-required="true"
                                                   class="form-control">
                                        </div>
                                    </div>
									<div class="col-md-4">
                                <div class="form-group">
                                    <label for="Grupo_Tienda">Grupo Tienda</label>
                                    <select id="Grupo_Tienda" name="Grupo_Tienda" data-rule-required="true"
                                            class="form-control">
                                        <?php
                                        $lista = $Grupo_Tienda->getGrupo_Tiendas();
                                        while ($row = $lista->fetch_array()):;
                                            if ($row[1] == $Nombre_Grupo_Tienda) { ?>
                                                <option selected="selected"
                                                        value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                            <?php }endwhile; ?>
                                    </select>
                                </div>
                            </div>
                                </div>
								
                              
                              <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="razon_social_m">Razon Social</label>
                                            <input id="razon_social_m" value="<?php echo $Razon_Social ?>" type="text" name="razon_social_m" data-rule-required="true"
                                                   class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nit_m">NIT</label>
                                            <input id="nit_m" type="text" name="nit_m" data-rule-required="true"
                                                   minlength="0" value="<?php echo $NIT ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono_m">Teléfono</label>
                                            <input id="telefono_m" value="<?php echo $Telefono ?>" type="text"
                                                   class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contacto_m">Contacto</label>
                                            <input id="contacto_m" type="text" minlength="0"
                                                   value="<?php echo $Contacto ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="correo_m">Correo</label>
                                            <input id="correo_m" type="text" minlength="0"
                                                   value="<?php echo $Correo ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sala_m">Sala</label>
                                            <input id="sala_m" type="text" minlength="0"
                                                   value="<?php echo $Sala ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localidad_m">Localidad</label>
                                            <input id="localidad_m" type="text" minlength="0"
                                                   value="<?php echo $Localidad ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="form-group">
                                            <label for="frecuencia_visita_m">Frecuencia de Visita</label>
                                            <input id="frecuencia_visita_m" type="text" minlength="0"
                                                   value="<?php echo $Frecuencia_Visita ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="direccion">Dirección
                                                <span id="latitud" class="label label-primary"></span>&nbsp;
                                                <span id="longitud" class="label label-primary"></span>
                                            </label>
                                            <input id="direccion_m" value="<?php echo $Direccion ?>" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                             <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Coordenadas_m">Coordenadas </label>
                                            <input id="Coordenadas_m" value="<?php echo $Coordenadas ?>" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row ">
                                <div class="col-md-12">
                                    <button class="btn btn-raised btn-black pull-right modificar">Modificar datos
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div id="map" style="height: 305px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>

<!-- jQuery-->
<script type="text/javascript" src="../../../public/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap JavaScript-->
<script type="text/javascript" src="../../../public/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Malihu Scrollbar-->
<script type="text/javascript"
        src="../../../public/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Animo.js-->
<script type="text/javascript" src="../../../public/plugins/animo.js/animo.min.js"></script>
<!-- Bootstrap Progressbar-->
<script type="text/javascript"
        src="../../../public/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- Toastr-->
<script type="text/javascript" src="../../../public/plugins/toastr/toastr.min.js"></script>
<!-- DataTables-->
<script type="text/javascript" src="../../../public/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../../public/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript"
        src="../../../public/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
        src="../../../public/plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="../../../public/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script type="text/javascript" src="../../../public/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript"
        src="../../../public/plugins/datatables.net-colreorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript"
        src="../../../public/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript"
        src="../../../public/plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIz7O5Q3-L3KYbgxDj8Oth3QZDz7JXMkY&libraries=places&language=es&callback=initialize"
        async defer></script>
<script type="text/javascript" src="../../../public/js/tienda_modificar.js"></script>
<!-- jQuery Validation-->
<script type="text/javascript" src="../../../public/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="../../../public/plugins/jquery-validation/src/localization/messages_es.js"></script>

<script type="text/javascript" src="../../../public/build/js/app.js"></script>
<script type="text/javascript" src="../../../public/js/helpers.js"></script>

<script type="text/javascript" src="../../../public/js/tienda.js"></script>

</body>
</html>


