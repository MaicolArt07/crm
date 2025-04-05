$(document).ready(function () {
    
	var id_transporte = $('#id_transporte').val();
	$('#dt_detalle').DataTable({
		"paging": false,
        "ordering": true,
        "info": false,
        "searching": true,
		"ajax": {
            "url": "../../negocio/NDetalle_Transporte.php?funcion=detalle",
			"type": "GET",
            "data": {id_transporte: id_transporte}
        },
        
		"columns": [
			{"data": "Aux"},
            {"data": "Id_Producto"},
            {"data": "Nombre"},
            {"data": "Inicio"},
			{"data": "Saldo"},
            {"data": "Venta"},
			{"data": "Devolucion_Reposicion"},
			{"data": "Devolucion_Cambio"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0],
                "visible": true
            }, 
			{
                "targets": 3,
                "className": "text-right"
            }, 
			{
                "targets": 4,
                "className": "text-right"
            }, 
			{
                "targets": 5,
                "className": "text-right"
            }, 
			{
                "targets": 6,
                "className": "text-right"
            }, 
			{
                "targets": 7,
                "className": "text-right"
            }
        ],
		"order": [[0, "asc"]]
    });
	$('#dt_pago').DataTable({
		"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
		"ajax": {
            "url": "../../negocio/NPago.php?funcion=listadoPagos",
			"type": "GET",
            "data": {id_transporte: id_transporte}
        },
        
		"columns": [
            {"data": "Id"},
            {"data": "Fecha"},
            {"data": "Venta"},
			{"data": "Total"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0],
                "visible": false
            }, {
                "targets": 3,
                "className": "text-right"
            }
        ],
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
				.column( 3 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Total over this page
			pageTotal = api
				.column( 3, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Update footer
			$( api.column( 3 ).footer() ).html(
				''+pageTotal +' ( '+ total +' total)'
			);
		},
		"order": [[1, "desc"]]
    });
	
	$('.finalizar').click(function () {
        var id_transporte = $('#id_transporte').val();
		$.ajax({
            type: "POST",
            url: "../../negocio/NTransportar.php?funcion=finalizar",
            data: {id_transporte: id_transporte},
            success: function (data) {
                $('.bs-modal-form-finalizar').hideModal();
				top.alert(data);
				location.href = 'index_transportes.php';
            }

        });
    });
	
	$('#dt_venta').DataTable({
		"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
		"ajax": {
            "url": "../../negocio/NVenta.php?funcion=listadoVentasTransporte",
			"type": "GET",
            "data": {id_transporte: id_transporte}
        },
        
		"columns": [
            {"data": "Id"},
            {"data": "Fecha"},
            {"data": "Venta"},
			{"data": "Total"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0],
                "visible": false
            }, {
                "targets": 3,
                "className": "text-right"
            }
        ],
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
				.column( 3 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Total over this page
			pageTotal = api
				.column( 3, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Update footer
			$( api.column( 3 ).footer() ).html(
				''+pageTotal +' ( '+ total +' total)'
			);
		},
		"order": [[1, "desc"]]
    });
	
	
});