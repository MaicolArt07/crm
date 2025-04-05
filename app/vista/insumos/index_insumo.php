<?php
session_start();

echo $_SESSION['id_usuario'];
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../negocio/NInsumo.php';
require '../../negocio/NUnidad_Medida.php';

$unidad_medida = new DUnidadMedida();
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
                <h4 class="mt-0 mb-5">Insumos</h4>
                <ol class="breadcrumb mb-0">
                    <li><a href="#">Almacén</a></li>
                    <li><a href="#">Insumos</a></li>
                    <li class="active">Listado de insumos</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="widget">
                <div class="widget-heading clearfix">
                    <h3 class="widget-title pull-left">Listado de insumos</h3>
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target=".bs-modal-form-insertar"><i class="ti-plus"></i> Crear insumo
                        </button>
                    </div>
                </div>
                <div class="widget-body">


                    <div tabindex="-1" role="dialog" class="modal fade bs-modal-form-insertar text-left">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Crear insumo</h4>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input id="nombre" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción</label>
                                            <textarea id="descripcion" rows="3" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">

                                            <label for="unidad_medida">Unidad de medida</label>
                                            <select id="unidad_medida" name="unidad_medida" class="form-control">
                                            <?php
                                                $lista = $unidad_medida->getUnidadMedida();
                                                while ($row = $lista->fetch_array()):; ?>
                                                    <option value="<?php echo $row[0]; ?>">
													<?php echo $row[1];?>
													</option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="estado">Estado</label>

                                            <div>
                                                <div class="radio-custom radio-inline">
                                                    <input id="estado_habilitado" type="radio" name="estado"
                                                           value="1" checked>
                                                    <label for="estado_habilitado">Habilitado</label>
                                                </div>
                                                <div class="radio-custom radio-inline">
                                                    <input id="estado_deshabilitado" type="radio"
                                                           name="estado"
                                                           value="0">
                                                    <label for="estado_deshabilitado">Deshabilitado</label>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">
                                        Cancelar
                                    </button>
                                    <button type="button" class="btn btn-raised btn-black insertar">Guardar datos
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div tabindex="-1" role="dialog"
                         class="modal fade bs-modal-form-modificar text-left">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Modificar Insumo</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
										<label for="id_modificar">Id</label>
                                        <input id="id_insumo"  readonly class="form-control">
                                        <div class="form-group">
                                            <label for="nombre_modificar">Nombre</label>
                                            <input id="nombre_modificar" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion_modificar">Descripción</label>
                                            <textarea id="descripcion_modificar" rows="3"
                                                      class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="unidad_medida_modificar">Unidad de Medida</label>
                                            <select id="unidad_medida_modificar" name="unidad_medida_modificar"
                                                    class="form-control">
                                            <?php
                                                $lista = $unidad_medida->getUnidadMedida();
                                                while ($row = $lista->fetch_array()):; ?>
                                                    <option value="<?php echo $row[0]; ?>">
													<?php echo $row[1];?>
													</option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">
                                        Cancelar
                                    </button>
                                    <button type="button" class="btn btn-raised btn-black modificar">Modificar datos
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div tabindex="-1" role="dialog"
                         class="modal fade bs-modal-form-deshabilitar text-left">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-black">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Deshabilitar Insumo</h4>
                                </div>
                                <div class="modal-body">
									<label for="id">Id</label>
                                    <input id="id_insumo_deshabilitar" readonly class="form-control">
									<label for="nombre">Nombre</label>
									<input id="nombre_insumo_deshabilitar" readonly class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">
                                        Cancelar
                                    </button>
                                    <button type="button" class="btn btn-raised btn-black deshabilitar">Ok
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div tabindex="-1" role="dialog"
                         class="modal fade bs-modal-form-habilitar text-left">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-black">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Habilitar Insumo</h4>
                                </div>
                                <div class="modal-body">
									<label for="id">Id</label>
                                    <input id="id_insumo_habilitar" readonly class="form-control">
									<label for="nombre">Nombre</label>
									<input id="nombre_insumo_habilitar" readonly class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-raised btn-default">
                                        Cancelar
                                    </button>
                                    <button type="button" class="btn btn-raised btn-black habilitar">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="dt_insumos" cellspacing="0" width="100%"
                           class="table table-striped table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Stock</th>
                            <th>Unidad de medida</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
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

<script type="text/javascript" src="../../../public/build/js/app.js"></script>

<script type="text/javascript" src="../../../public/js/helpers.js"></script>
<script type="text/javascript" src="../../../public/js/insumo.js"></script>

</body>
</html>


