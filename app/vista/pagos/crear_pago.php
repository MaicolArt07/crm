<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../datos/DTienda.php';
require '../../datos/DGrupo_Tienda.php';

$tienda = new DTienda();
$grupotienda = new DGrupo_Tienda();
$id_usuario = $_SESSION['id_usuario'];
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
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
        .venta-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            appearance: none; /* Eliminar estilo nativo del checkbox */
            -webkit-appearance: none;
            -moz-appearance: none;
            outline: none;
            border: 2px solid gray;
            border-radius: 4px;
        }

        .venta-checkbox:checked {
            background-color: green;
            border-color: green;
        }

        .venta-incompleta:checked {
            background-color: orange;
            border-color: orange;
        }
    </style>
</head>
<body data-sidebar-color="sidebar-light" class="sidebar-light">
<!-- Header start-->
<header>
    <a href="index_pago.php" class="brand pull-left">
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
                    <li><a href="index_pago.php">Listado de pagos</a></li>
                    <li class="active">Registrar Pago</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="widget">
                <div class="widget-body">
                    <form id="form-pago" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    
                                    <div data-format="dd/mm/yyyy" class="input-group">
                                        <input id="fecha" type="text" name="fecha"
                                               data-rule-required="true"
											   value="<?php echo date("d/m/Y"); ?>"
                                               class="form-control">
                                               <span class="input-group-addon">
                                                <i class="ti-calendar"></i>
                                                </span>
                                    </div>
                                    <input id="id_usuario" type="hidden" value="<?php echo $_SESSION['id_usuario'] ?>">
                                    <input id="Tienda_Grupo_Tienda" type="hidden" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="grupotienda">Grupo de Tiendas</label>
                                    <select id="grupotienda" name="grupotienda" data-rule-required="true"
                                            class="form-control">
                                        <option value="0">Seleccione un Grupo de Tienda
										</option>
                                        <?php
                                        $lista = $grupotienda->getGrupo_Tiendas();
                                         while ($row = $lista->fetch_array()):; ?>
                                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tienda">Tiendas</label>
                                    <select id="tienda" name="tienda" data-rule-required="true"
                                            class="form-control">
                                        <option value="0">Seleccione una Tienda
										</option>
                                        <?php
                                        $lista = $tienda->getTiendas_Reporte_Venta();
                                         while ($row = $lista->fetch_array()):; ?>
                                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="metodoPago">Método de Pago</label>
                                <select id="metodoPago" name="metodoPago" class="form-control" data-rule-required="true">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="qr">QR</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo_documento">Código de Documento</label>
                                    <div class="input-group">
                                    <input id="codigo_documento" type="text" name="codigo_documento" data-rule-required="false"
                                    class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="totalpagar">Total a Pagar</label>
                                    <div class="input-group">
                                        <input id="totalpagar" type="text" name="totalpagar"  value="0"
                                               data-rule-required="true"
                                               class="form-control"><span class="input-group-addon">Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        

                        <div class="row">
                            <div class="col-md-12">
                                <table id="dt_ventas" class="table nowrap table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Venta</th>
                                        <th>Tienda</th>
                                        <th>NIT</th>
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Por Pagar</th>
                                        <th>Pagar</th>
                                        <th>Total a Pagar</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
										<tr> 
											<th colspan="5" style="text-align:right">Total:</th> 
											<th></th>
										</tr> 
									</tfoot>
                                    <tbody>

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
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="../../../public/js/registrar_pago.js"></script>

</body>
</html>


