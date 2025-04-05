<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../negocio/NCompra.php';
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
    <a href="index.php" class="brand pull-left">
        <h2>BREAD KING</h2></a><a href="javascript:;" role="button"
                                  class="hamburger-menu pull-left visible-xs"><span></span></a>

    <ul class="notification-bar list-inline pull-right">
        <li class="visible-xs"><a href="javascript:;" role="button" class="header-icon search-bar-toggle"><i
                        class="ti-search"></i></a></li>
        <li class="visible-lg"><a href="javascript:;" role="button" class="header-icon fullscreen-toggle"><i
                        class="ti-fullscreen"></i></a></li>

        <li><a href="../logout.php" role="button" class="header-icon"><i class="ti-power-off"></i></a></li>
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
                <h4 class="mt-0 mb-5">Pagos</h4>
                <ol class="breadcrumb mb-0">
                    <li><a href="#">Pago</a></li>
                    <li class="active">Listado de pagos</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="widget">
                <div class="widget-heading clearfix">
                    <h3 class="widget-title pull-left">Listado de Pagos</h3>
                    <div class="pull-right">
                        <a href="crear_pago.php" class="btn btn-primary"><i class="ti-plus"></i> Registrar Pago</a>
                    </div>
                </div>
                <div class="widget-body">

                    <div tabindex="-1" role="dialog"
                         class="modal fade bs-modal-form-cancelar text-left">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-black">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Anular pago</h4>
                                </div>
                                <div class="modal-body">
                                    <input id="id_compra" type="hidden" class="form-control">
                                    <p>Desea anular el pago?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">
                                        Cancelar
                                    </button>
                                    <button type="button" class="btn btn-raised btn-black cancelar-total">Cancelar total
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="dt_pagos" cellspacing="0" width="100%"
                           class="table table-striped table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Método de Pago</th>
                            <th>Código Método de Pago</th>
                            <th>Total (Bs.)</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
						<tfoot>
							<tr> 
								<th colspan="5" style="text-align:right">Total:</th> 
								<th></th>
							</tr> 
						</tfoot>
                    </table>
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
<script type="text/javascript" src="../../../public/plugins/datatables.net/js/date-eu.js"></script>
<script type="text/javascript" src="../../../public/build/js/app.js"></script>

<script type="text/javascript" src="../../../public/js/helpers.js"></script>
<script type="text/javascript" src="../../../public/js/pago.js"></script>

</body>
</html>


