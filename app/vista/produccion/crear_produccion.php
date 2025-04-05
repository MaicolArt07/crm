<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../negocio/NOrden_Produccion.php';
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
    <!-- Bootstrap DateTimePicker-->
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
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

        <li><a href="../login.php" role="button" class="header-icon"><i class="ti-power-off"></i></a></li>
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
                <h4 class="mt-0 mb-5">Órden de producción</h4>
                <ol class="breadcrumb mb-0">
                    <li><a href="#">Producción</a></li>
                    <li><a href="#">Órden de producción</a></li>
                    <li><a href="index_produccion.php">Listado de órdenes de producción</a></li>
                    <li class="active">Crear órden de producción</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="widget">
                <div class="widget-body">
                    <form id="form-compra" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input id="id_usuario" type="hidden" value="<?php echo $_SESSION['id_usuario'] ?>">
                                    <div data-format="dd/mm/yyyy" class="input-group">
                                        <input id="fecha" type="text" name="fecha"
                                               data-rule-required="true"
											   value="<?php echo date("d/m/Y"); ?>"
                                               class="form-control"><span class="input-group-addon"><i
                                                    class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="receta">Receta</label>
                                    <div class="input-group">
                                        <input type="text" name="id_receta" id="id_receta" hidden>
                                        <input type="text" placeholder="Buscar..." class="form-control" id="receta"
                                               name="receta" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-outline btn-default"
                                                    data-toggle="modal" data-target=".bs-modal-form-receta"><i
                                                        class="ti ti-search"></i></button></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="producto">Producto</label>
                                    <input id="id_producto" type="text" class="form-control hidden">
                                    <input id="producto" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad Estimada</label>
                                    <input id="cantidad" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cantidad_disponible">Cantidad Producida</label>
                                    <input id="cantidad_disponible" min="0" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_vencimiento">Fecha de vencimiento</label>
                                    <div data-format="dd/mm/yyyy" class="input-group">
                                        <input id="fecha_vencimiento" type="text" name="fecha_vencimiento"
                                               data-rule-required="true"
											   value="<?php echo date("d/m/Y"); ?>"
                                               class="form-control"><span class="input-group-addon"><i
                                                    class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row detalle" style="display: none;">
                            <div class="col-md-12">
                                <p class="pl-10 pr-10 pt-5 pb-5 bg-black">Detalle de insumos</p>
                                <table class="table nowrap table-condensed">
                                    <thead>
                                    <tr>
                                        <th class="hidden">#</th>
                                        <th>Insumo</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Stock disponible</th>
                                        <th class="text-center">Cant. receta</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dt_detalle">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row ">
                        <div class="col-md-12">
                            <button class="btn btn-raised btn-black pull-right insertar">Guardar datos
                            </button>
                        </div>
                    </div>

                </div>
                <div tabindex="-1" role="dialog" class="modal fade bs-modal-form-receta text-left">
                    <div role="document" class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                            aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Listado de recetas</h4>
                            </div>
                            <div class="modal-body">
                                <table id="dt_receta" style="width: 100%"
                                       class="table table-striped table-bordered dt-responsive table-condensed">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Receta</th>
                                        <th></th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">Cancelar
                                </button>
                                <button type="submit" class="btn btn-raised btn-black seleccionar">Seleccionar receta
                                </button>
                            </div>
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
<!-- MomentJS-->
<script type="text/javascript" src="../../../public/plugins/moment/min/moment.min.js"></script>
<script src="../../../public/plugins/moment/locale/es.js" type="text/javascript"></script>

<!-- Bootstrap Datetime Picker-->
<script type="text/javascript"
        src="../../../public/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="../../../public/plugins/input-mask/jquery.inputmask.js"></script>
<script type="text/javascript" src="../../../public/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
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

<!-- jQuery Validation-->
<script type="text/javascript" src="../../../public/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="../../../public/plugins/jquery-validation/src/localization/messages_es.js"></script>

<script type="text/javascript" src="../../../public/build/js/app.js"></script>
<script type="text/javascript" src="../../../public/js/helpers.js"></script>

<script type="text/javascript" src="../../../public/js/produccion.js"></script>

</body>
</html>


