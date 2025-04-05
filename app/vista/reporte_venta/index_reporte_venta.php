<?php

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
}
require '../../datos/DTienda.php';
require '../../datos/DUsuario.php';
require '../../datos/DGrupo_Tienda.php';

$usuario =new DUsuario();
$tienda = new DTienda();
$grupotienda = new DGrupo_Tienda();

/*$id_venta = $_GET['Id'];
$fecha = $_GET['F'];
$total = $_GET['To'];
$nombre_usuario = $_GET['U'];
$nombre_tienda = $_GET['Ti'];
$estado = $_GET['E'];*/

$FechaI = $_GET['FechaI'];
$FechaF = $_GET['FechaF'];
$Tienda = $_GET['Tienda'];
$Usuario = $_GET['Usuario'];
$Estado = $_GET['Estado'];
$Estado_factura = $_GET['Estado_factura'];
$Grupo_Tienda = $_GET['Grupo_Tienda'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.min.css" />
     <!-- DataTables-->
     <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-colreorder-bs/css/colReorder.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">
    
    


    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-colreorder-bs/css/colReorder.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="../../../public/plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../../../public/build/css/style.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
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
                <h4 class="mt-0 mb-5">Ventas<?php 
                
                if($Estado==null || $Estado=="")
                {
                    
                    $Estado = -1;
                }
                 ?></h4>
                <ol class="breadcrumb mb-0">
                    <li><a href="#">reporte_venta</a></li>
                    <li><a href="index_reporte_venta.php">Reporte de Ventas</a></li>
                    <li class="active">Reporte de Ventas</li>
                </ol>
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="widget">
                <div class="widget-body">
                    <form id="form-compra" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha Inicio</label>
									
                                    <div data-format="dd/mm/yyyy" class="input-group">
                                        <input id="fecha_inicio" type="text" name="fecha_inicio"
                                               data-rule-required="true"
											   value="<?php 
											   if($FechaI==null){
												   echo date("d/m/Y"); 
											   }else
											   {
												   echo $FechaI;
											   }
											   ?>"
                                               class="form-control"><span class="input-group-addon"><i
                                                    class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha Fin</label>
                                    <div data-format="dd/mm/yyyy" class="input-group">
                                        <input id="fecha_fin" type="text" name="fecha_fin"
                                               data-rule-required="true"
											   value="<?php 
											   if($FechaF==null){
												   echo date("d/m/Y"); 
											   }else
											   {
												   echo $FechaF;
											   }
											   ?>"
                                               class="form-control"><span class="input-group-addon"><i
                                                    class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tienda">Tienda</label>
                                    <select id="tienda" name="tienda" data-rule-required="true"
                                            class="form-control">
                                        <option value="0">Todas</option>
                                        <?php
                                        $lista = $tienda->getTiendas_Reporte_Venta();
                                        while ($row = $lista->fetch_array()):;?> 
										<?php
											if($row[0]==$Tienda)
											{
												?>
												<option selected='selected' value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
												<?php
											}else
											{	
												?>
												<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
												<?php
											}											
										endwhile; 
											
										?>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <select id="usuario" name="usuario" data-rule-required="true"
                                            class="form-control">
                                        <option value="0">Todos</option>
                                        <?php
                                        $lista = $usuario->getUsuarios_Reporte_Venta();
                                        while ($row = $lista->fetch_array()):;?> 
										<?php
											if($row[0]==$Usuario)
											{
												?>
												<option selected='selected' value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
												<?php
											}else
											{	
												?>
												<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
												<?php
											}											
										endwhile; 
											
										?>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select id="estado" name="estado" data-rule-required="true"
                                            class="form-control">
                                        <option 
										<?php 
                                            
											if($Estado==-1){ ?>
												selected='selected'
												<?php
											}
										?>
										value="-1">Todas</option>
										<option 
										<?php 
											if($Estado==0){ ?>
												selected='selected'
												<?php
											}
										?>
										value="0">Por Pagar</option>
										<option 
										<?php 
											if($Estado==1){ ?>
												selected='selected'
												<?php
											}
										?>
										value="1">Cancelada</option>
										<option 
										<?php 
											if($Estado==2){ ?>
												selected='selected'
												<?php
											}
										?>
										value="2">Anuladas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_factura">Estado Factura (PROGRAMACION)</label>
                                    <select id="estado_factura" name="estado_factura" data-rule-required="true"
                                            class="form-control">
                                        <option 
										<?php 
                                            
											if($Estado_factura==-1){ ?>
												selected='selected'
												<?php
											}
										?>
										value="-1">Todas</option>
										<option 
										<?php 
											if($Estado_factura==1){ ?>
												selected='selected'
												<?php
											}
										?>
										value="1">VALIDA</option>
										<option 
										<?php 
											if($Estado_factura==2){ ?>
												selected='selected'
												<?php
											}
										?>
										value="2">ANULADA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Grupo_Tienda">Grupo de Tiendas (PROGRAMACION)</label>
                                    <select id="Grupo_Tienda" name="Grupo_Tienda" data-rule-required="true"
                                            class="form-control">
                                        <option value="0">Seleccione un Grupo de Tienda
										</option>
                                        <?php
                                        $lista = $grupotienda->getGrupo_Tiendas();
                                         while ($row = $lista->fetch_array()):; ?>
                                         <?php
											if($row[0]==$Grupo_Tienda)
											{
												?>
												<option selected='selected' value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
												<?php
											}else
											{	
												?>   
                                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                            <?php
											}	
                                         endwhile; ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row pull-center">
                                    <button type="button"
                                            class="btn btn-raised btn-black pull-center consultar">Consultar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="dt_ventas" cellspacing="0" width="100%"
								class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Acciones</th>
										<th>Id</th>
                                        <th>Tienda</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
										<th>Total</th>
                                        <th>Factura</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
									<tfoot>
										<tr> 
											<th colspan="6" style="text-align:right">Total:</th> 
											<th></th>
										</tr> 
									</tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <br><br>
                                    <label style="font-weight: bold;">FACTURAS PARA EXPORTAR</label>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row pull-center">
                                <button type="button" class="btn btn-raised btn-black pull-center " data-toggle="modal" data-target="#enviarCorreoModal">Enviar por Correo</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="dt_ventas_exportar" cellspacing="0" width="100%"
								class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
										<th>N FACTURA</th>
                                        <th>NIT</th>
                                        <th>RAZON SOCIAL</th>
                                        <th>CODIGO CONTROL</th>
										<th>FECHA</th>
                                        <th>IMPORTE FACTURA</th>
                                        <th>DIFERENCIA</th>
                                        <th>SALDO</th>
                                        <th>ESTADO</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <br>

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

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>




<!-- datetime-picker-->
<script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/build/jquery.datetimepicker.full.min.js"></script>

<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>


<script type="text/javascript"
        src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
        <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.dataTables.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>

        <!-- DataTables Buttons -->
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="../../../public/js/helpers.js"></script>
<script type="text/javascript" src="../../../public/js/reporte_venta.js"></script>

<!-- Modal -->
<div class="modal fade" id="enviarCorreoModal" tabindex="-1" role="dialog" aria-labelledby="enviarCorreoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enviarCorreoModalLabel">Enviar Programación por Correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEnviarCorreo">
                    <div class="form-group">
                        <label for="emailPara">Correo Para</label>
                        <input type="email" class="form-control" id="emailPara" placeholder="Introduce el correo destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="emailCopia">Correo Copia</label>
                        <input type="email" class="form-control" id="emailCopia" placeholder="Introduce el correo en copia">
                    </div>
                    <div class="form-group">
                        <label for="emailAsunto">Asunto</label>
                        <input type="text" class="form-control" id="emailAsunto" placeholder="Introduce el asunto del correo" required>
                    </div>
                    <div class="form-group">
                        <label for="emailDetalle">Detalle</label>
                        <textarea class="form-control" id="emailDetalle" rows="3" placeholder="Introduce el detalle del correo"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-raised btn-black pull-center enviar_reporte_correo" data-toggle="modal" data-target="#enviarCorreoModal">Enviar por Correo</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>


