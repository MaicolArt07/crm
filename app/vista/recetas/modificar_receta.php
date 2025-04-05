<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../datos/DProducto.php';
require '../../negocio/NReceta.php';

$id_receta = $_GET['id'];
$nombre_producto = $_GET['p'];
$cantidad = $_GET['c'];
$nombre = $_GET['n'];
$producto = new DProducto();
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
    <a href="index_receta.php" class="brand pull-left">
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
                <h4 class="mt-0 mb-5">Recetas</h4>
                <ol class="breadcrumb mb-0">
                    <li><a href="#">Almacén</a></li>
                    <li><a href="#">Recetas</a></li>
                    <li><a href="index_receta.php">Listado de recetas</a></li>
                    <li class="active">Modificar Receta</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="widget">
                <div class="widget-heading">
                    <h3 class="widget-title">Modificar Receta</h3>
                </div>
                <div class="widget-body">
                    <div id="modal-from-search" tabindex="-1" role="dialog"
                         class="modal fade bs-modal-form-search text-left">
                        <div role="document" class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Listado de insumos</h4>
                                </div>
                                <div class="modal-body">
                                    <table id="dt_insumos" style="width: 100%"
                                           class="table table-bordered table-search">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Unidad de medida</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-raised btn-black insumo-selected">Seleccionar
                                        insumo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="form-receta" method="post" novalidate="novalidate">
                        <div class="row">
							<div class="col-md-1">
                                <div class="form-group">
                                    <label for="nombre">Id</label>
									<input id="id_receta" type="text" name="nombre" data-rule-required="true"
                                           class="form-control" readonly value="<?php echo $id_receta ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
									<label for="nombre">Nombre</label>
                                    <input id="nombre" type="text" name="nombre" data-rule-required="true"
                                           class="form-control" value="<?php echo $nombre ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="producto">Producto</label>
                                    <select id="producto" name="producto" data-rule-required="true"
                                            class="form-control">
                                        <?php
                                        $lista = $producto->getProducto();
                                        while ($row = $lista->fetch_array()):;
                                            if ($row[1] == $nombre_producto) { ?>
                                                <option selected="selected"
                                                        value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                            <?php }endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input id="cantidad" type="number" name="cantidad" data-rule-required="true"
                                           value="<?php echo $cantidad ?>"
                                           minlength="0"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="widget-heading">
							 <label for="insumo">Insumos de Receta</label>
						</div>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="insumo">Buscar</label>
                                    <button type="button" data-toggle="modal" data-target=".bs-modal-form-search"
                                            class="btn btn-default btn-block search">
                                        <i class="ti-search m5"></i> 
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="insumo">Insumo</label>
                                    <input id="id_detalle" class="form-control hidden">
                                    <input id="id_insumo" class="form-control hidden">
                                    <input id="insumo" readonly type="text" class="form-control">
                                    <input id="unidad_medida_insumo" type="text" class="form-control hidden">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="cantidad_insumo">Cantidad</label>
                                    <input id="cantidad_insumo" type="number" minlength="0" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="insumo">Adicionar</label>
                                <button type="button" class="btn btn-outline btn-primary btn-block insertar-insumo">
                                    <i class="ti-plus m5"></i>
                                </button>
                                <button type="button" class="btn btn-success modificar-insumo" style="display: none;"><i
                                            class="ti-reload mr-5"></i></button>
                                <button type="button" class="btn btn-danger eliminar-insumo" style="display: none;"><i
                                            class="ti-close mr-5"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="dt_detalle" class="table nowrap table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Id</th>
                                        <th>Insumo</th>
                                        <th>Unidad de medida</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row ">
                        <div class="col-md-12">
                            <label id="label-delete" value="0" hidden="true"></label>
                            <button class="btn btn-raised btn-black pull-right modificar">Modificar datos
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

<script type="text/javascript" src="../../../public/js/receta_modificar.js"></script>

</body>
</html>


