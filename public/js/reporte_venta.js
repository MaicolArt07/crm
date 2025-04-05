$(document).ready(function () {

	// Función para exportar datos de la tabla dt_ventas_exportar a JSON
	function exportarTablaJSON() {
	    let tableData = $("#dt_ventas_exportar").DataTable().data().toArray();
	    return JSON.stringify(tableData);
	}

	// Función para enviar la tabla dt_ventas_exportar por correo
	function enviarTablaPorCorreo() {
		//alert("enviarTablaPorCorreo");
	    let data = exportarTablaJSON();

		// Capturar los valores de los campos del modal
        var emailPara = $('#emailPara').val();
        var emailCopia = $('#emailCopia').val();
        var emailAsunto = $('#emailAsunto').val();
        var emailDetalle = $('#emailDetalle').val();

        // Validar que el campo "Para" y "Asunto" no estén vacíos
        if (!emailPara || !emailAsunto) {
            Swal.fire({
				icon: 'error',
				title: 'Error al enviar el correo',
				text: 'Hubo un problema al enviar el correo. Por favor, inténtalo de nuevo.',
				confirmButtonText: 'Aceptar'
			});
			console.error("Error al enviar correo:", error);
            return;
        }
	    
	    $.ajax({
	        url: "../../vista/EnviarReporteVentas.php", // Ruta al archivo PHP para envío de correo
	        type: "POST",
	        data: { 
				tabla: data,
				emailPara: emailPara,
                emailCopia: emailCopia,
                emailAsunto: emailAsunto,
                emailDetalle: emailDetalle 
			},
	        success: function(response) {
	            Swal.fire({
					icon: 'success',
					title: 'Correo Enviado',
					text: response, // Usamos 'response' para mostrar la respuesta del servidor
					confirmButtonText: 'Aceptar'
				}).then(() => {
					$('#enviarCorreoModal').modal('hide'); // Cerrar el modal al confirmar
				});
                
	        },
	        error: function(xhr, status, error) {
	            Swal.fire({
					icon: 'error',
					title: 'Error al enviar el correo',
					text: 'Hubo un problema al enviar el correo. Por favor, inténtalo de nuevo.',
					confirmButtonText: 'Aceptar'
				});
				console.error("Error al enviar correo:", error);
	        }
	    });
	}

	ingreso = false;
    $('.consultar').click(function () {
		//ingreso =  true;
		var FechaI = $('#fecha_inicio').val();
		//alert 'Consultar:'.FechaI;
		var FechaF = $('#fecha_fin').val();
		var Tienda = $('#tienda').val();
		var Usuario = $('#usuario').val();
		var Estado = $('#estado').val();
		var Estado_factura = $('#estado_factura').val();
		var Grupo_Tienda = $('#Grupo_Tienda').val();
		
		location.href = "index_reporte_venta.php?FechaI=" + FechaI 
		+ "&FechaF=" + FechaF
		+ "&Usuario=" + Usuario
		+ "&Tienda=" + Tienda
		+ "&Estado=" + Estado
		+ "&Estado_factura=" + Estado_factura
		+ "&Grupo_Tienda=" + Grupo_Tienda;
		
		
    });
	if(ingreso==false){
		var FechaI = $('#fecha_inicio').val();
		var FechaF = $('#fecha_fin').val();
		var FechaI = FechaI.split("/").reverse().join("/");
		var FechaF = FechaF.split("/").reverse().join("/");
		var Tienda = $('#tienda').val();
		var Usuario = $('#usuario').val();
		var Estado = $('#estado').val();
		var Estado_factura = $('#estado_factura').val();
		var Grupo_Tienda = $('#Grupo_Tienda').val(); 
		$("#dt_ventas").DataTable({
			"ajax": {
				type: "POST",
				url: "../../negocio/NVenta.php?funcion=Ventas_Reporte_Venta",
				data: {
					FechaI: FechaI,
					FechaF: FechaF,
					Tienda: Tienda,
					Usuario: Usuario,
					Estado: Estado
				}
			},
			
			"columns": [
				{
					"defaultContent": "<div class='btn-group btn-group-sm'>" +
					"<a class='btn btn-outline btn-primary show'><i class='ti-eye'></i></a>"  +
					"</div>"
				},
				{"data": "Id"},
				{"data": "Tienda"},
				{"data": "Usuario"},
				{"data": "Fecha"},
				{"data": "Estado"},
				{
					"data": "Total",
					"className": "text-right",
					"render": function(data, type, row) {
						return parseFloat(data).toFixed(2);
					}
				},
				{"data": "Numero_Factura"},
				{"data": "Codigo_Control"},

			],
			"pageLength": 10,
			"language": {
				"url": "../../../public/plugins/datatables.net/Spanish.json"
			},
			"columnDefs": [
				{
					"targets": 0,
					"visible": true,
					"className": "text-center",
					 "width": "100px"
				}, 
				{
					"targets": 7,
					"className": "text-right",
					"orderable": false
				}, 
				{
					"targets": 5,
					"className": "text-center",
					"orderable": true
				},
				{
					"targets": 8,
					"visible": false,
				},
				{type: 'date-eu', targets: 1},
				{type: 'date-eu', targets: 0}
			],
			"responsive": true,
			"fnRowCallback": function (nRow, aData, iDisplayIndex) {
				if (aData['Estado'] == 0) {
					$('td:eq(5)', nRow).html('<span class="label label-warning">Por Pagar</span>');

				} else {
					if (aData['Estado'] == 1) {
						$('td:eq(5)', nRow).html('<span class="label label-success">Cancelada</span>');
					}else{
						$('td:eq(5)', nRow).html('<span class="label label-default">Anulada</span>');
					}
				}
				
			},
			"order": [[4, "desc"]],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};
	 
				// Total over all pages
				total = api
					.column( 6 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Total over this page
				pageTotal = api
					.column( 6, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Update footer
				$( api.column( 6 ).footer() ).html(
					''+ total.toFixed(2) +' - '+ pageTotal.toFixed(2) 
				);
			}
		});

		$("#dt_ventas_exportar").DataTable({
			"ajax": {
				type: "POST",
				url: "../../negocio/NVenta.php?funcion=Ventas_Reporte_Venta_Exportar",
				data: {
					FechaI: FechaI,
					FechaF: FechaF,
					Tienda: Tienda,
					Usuario: Usuario,
					Estado: Estado,
					Estado_factura: Estado_factura,
					Grupo_Tienda: Grupo_Tienda
				}
			},
			
			"columns": [
				
				{"data": "Numero_Factura"},
				{"data": "NIT"},
				{"data": "Razon_Social"},
				{"data": "Codigo_Control"},
				{"data": "Fecha"},
				{"data": "Total"},
				{"data": "Descuento"},
				{"data": "SubTotal"},
				{"data": "Estado"},

			],
			
			"pageLength": 10,
			"language": {
				"url": "../../../public/plugins/datatables.net/Spanish.json"
			},
			
			"dom": 'Blfrtip',"buttons": ['copy', 'csv', 'excel', 'pdf', 'print',],
			"responsive": false,
  			"scrollX": true,
			"order": [[4, "desc"]]
		});
	}
	

    var table = $('#dt_ventas').DataTable();
	
	
	$('#dt_ventas tbody').on('click', '.show', function () {
		var data = table.row($(this).parents('tr')).data();
		
        location.href = "show_reporte_ventas.php?Id=" + data.Id + "&F=" + data.Fecha + "&To=" + data.Total + "&U=" + data.Usuario+ "&Ti=" + data.Tienda+ "&E=" + data.Estado+ "&CC=" + data.Codigo_Control;
    });
	
	
   $('#fecha_inicio').datetimepicker({format: 'd/m/Y'});
   $('#fecha_fin').datetimepicker({format: 'd/m/Y'});
	
	// Agregar evento al botón de enviar por correo
	$('.enviar_reporte_correo').click(function () {
	    enviarTablaPorCorreo();
	});
	
});


