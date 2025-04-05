$(document).ready(function () {
    $("#dt_pagos").DataTable({
        "ajax": "../../negocio/NPago.php?funcion=listadoPagosWeb",
        "columns": [
            {"data": "Id"},
			{"data": "Fecha"},
			{"data": "Usuario"},
            {"data": "Tienda_Grupo_Tienda"},
            {"data": "Metodo_Pago"},
            {"data": "Codigo_Metodo_Pago"},
            {
                "data": "Total",
                "className": "text-right",
                "render": function(data, type, row) {
                    return parseFloat(data).toFixed(2);
                }
            },
            {"data": "Estado"},
            {
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                
                "<a class='btn btn-outline btn-primary show'><i class='ti-eye'></i></a>" +
                "<a data-toggle='modal' data-target='.bs-modal-form-cancelar' class='cancelar btn btn-danger btn-outline'>" +
                "<i class='ti-close'></i></a>" +
                "</div>"
            },

        ],
		"pageLength": 100,
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": 0,
            "visible": true
        }, {
            "targets": 7,
            "className": "text-center",
            "orderable": false
        }, {type: 'date-eu', targets: 1}
    ],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(7)', nRow).html('<span class="label label-success">Valido</span>');
 
            } else {
                $('td:eq(6)', nRow).html('<span class="label label-warning">Anulado</span>');
                $('td:eq(8)', nRow).html("<div class='btn-group btn-group-sm'><a class='btn btn-outline btn-primary show'><i class='ti-eye'></i></a></div>");
            }
        },
        "order": [[0, "desc"]],
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


    /*$('#grupotienda').on('input', function () {
        
        
        var id_grupotienda = $(this).val();
        var nombre_grupotienda = $(this).find('option:selected').text();
        alert("Grupo Tienda: " + nombre_grupotienda + " (ID: " + id_grupotienda + ")");
    });

    $('#tienda').on('input', function () {
        
        var id_tienda = $(this).val();
        var nombre_tienda = $(this).find('option:selected').text();
        alert ("tienda "+ id_tienda+ " "+nombre_tienda);
    });*/

    
    

    //*Listado de compras*//

    var table = $('#dt_pagos').DataTable();
    var tbody = $('#dt_pagos tbody');
    $(tbody).on('click', '.show', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "show_pago.php?Id=" + data.Id + 
        "&F=" + data.Fecha + 
        "&T=" + data.Total + 
        "&C=" + data.Tienda_Grupo_Tienda + 
        "&M=" + data.Metodo_Pago + 
        "&C=" + data.Codigo_Metodo_Pago + 
        "&E=" + data.Estado;
    });

    $(tbody).on('click', '.cancelar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_compra').val(data.Id);
    });

    


});