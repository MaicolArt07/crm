$(document).ready(function () {
    $("#dt_receta").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
        "ajax": "../../negocio/NReceta.php?funcion=recetas",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Id_Producto"},
            {"data": "Producto"},
            {"data": "Cantidad"},

        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": [0, 2],
            "visible": false
        }],
        "responsive": true,
        "order": [[1, "asc"]]
    });
    $("#dt_produccion").DataTable({
        "ajax": "../../negocio/NOrden_Produccion.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Fecha"},
            {"data": "Receta"},
            {"data": "Producto"},
            {"data": "Cantidad"},
            {"data": "Cantidad_Produccion"},
            {"data": "Estado"},
			{
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                
                "<a data-toggle='modal' data-target='.bs-modal-form-confirmar' class='confirmar btn btn-sm btn-black btn-outline'>" +
                "<i class='ti-check'></i></a>" +
                "</div>"
            },
        ],
		"pageLength": 10,
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
        }],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(6)', nRow).html('<span class="label label-warning">Por confirmar</span>');
                $('td:eq(7)', nRow).html("<div class='btn-group btn-group-sm'><a data-toggle='modal' data-target='.bs-modal-form-confirmar' class='confirmar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a></div>");
            } else {
                $('td:eq(6)', nRow).html('<span class="label label-success">Confirmado</span>');
            }
        },
        "order": [[6, "desc"],[1, "asc"]],
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
				.column( 5 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Total over this page
			pageTotal = api
				.column( 5, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Update footer
			$( api.column( 5 ).footer() ).html(
				''+pageTotal +' ( '+ total +' total)'
			);
		}
    });


    var table = $('#dt_produccion').DataTable();
    var tbody = $('#dt_produccion tbody');
    $(tbody).on('click', '.confirmar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#fecha').text(data.Fecha);
        $('#receta').text(data.Receta);
        $('#producto').text(data.Producto);
        $('#id_orden_produccion').val(data.Id);
        $('#cantidad_produccion').val(data.Cantidad_Produccion);
        var id_orden_produccion = data.Id;
        $.ajax({
            type: "POST",
            url: "../../negocio/NOrden_Produccion.php?funcion=detalle_modal",
            data: {id_orden_produccion: id_orden_produccion},
			success:  function (data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
				//alert(data);
				var data = JSON.parse(data);
                var tableBody = '';
                for (var i = 0; i < data.length; i++) {
                    var id_insumo = data[i]['Id'];
                    var nombre = data[i]['Nombre'];
                    var descripcion = data[i]['Descripcion'];
                    var cantidad = data[i]['Cantidad_Insumo'];
                    tableBody += "<tr><td class='hide'>" + id_insumo + "</td><td>" + nombre + "</td><td>" + descripcion + "</td><td class='text-center'>" + cantidad + "</td></tr>";
                }
				//alert(tableBody);
                $('#dt_detalle_modal').html(tableBody);
            }
        });
    });

    $('.confirmar-cantidad').click(function () {
        var id_orden_produccion = $('#id_orden_produccion').val();
        var cantidad_produccion = $('#cantidad_produccion').val();
        var cantidad = parseInt(cantidad_produccion);
        if (cantidad > 0) {
            $.ajax({
                type: "POST",
                url: "../../negocio/NOrden_Produccion.php?funcion=confirmar",
                data: {id_orden_produccion: id_orden_produccion, cantidad_produccion: cantidad_produccion},
                success: function (data) {
                    $('.bs-modal-form-enable').hideModal();
                    alert(data);
					location.reload();
                }

            });
        } else {
            alert("La cantidad introducida, debe ser mayor que 0");
        }
    });


    var table_receta = $('#dt_receta').DataTable();
    var row_selected = "";
    $("#dt_receta tbody").on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_receta.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        row_selected = table_receta.row(this).data();
    });

    $('.seleccionar').click(function () {
        var id_receta, receta, id_producto, producto, cantidad;
        $.each($("#dt_receta tr.selected"), function () {
            id_receta = row_selected['Id'];
            receta = row_selected['Nombre'];
            id_producto = row_selected['Id_Producto'];
            producto = row_selected['Producto'];
            cantidad = row_selected['Cantidad'];
        });
        $('#id_receta').val(id_receta);
        $('#receta').val(receta);
        $('#id_producto').val(id_producto);
        $('#producto').val(producto);
        $('#cantidad').val(cantidad);
        $('#cantidad_disponible').val(cantidad);

        $('.bs-modal-form-receta').hideModal();

        $.ajax({
            type: "POST",
            url: "../../negocio/NDetalle_Receta.php?funcion=detalle",
            data: {id_receta: id_receta},
            success: function (data) {
                var data = JSON.parse(data);
                var tableBody = '';
                for (var i = 0; i < data.length; i++) {
                    var id_insumo = data[i]['Id'];
                    var nombre = data[i]['Nombre'];
                    var descripcion = data[i]['Descripcion'];
                    var stock = data[i]['Stock'];
                    var cantidad = data[i]['Cantidad'];
                    tableBody += "<tr><td class='hidden'>" + id_insumo + "</td><td>" + nombre + "</td><td>" + descripcion + "</td><td class='text-center'>" + stock + "</td><td class='text-center'>" + cantidad + "</td></tr>";

                }
                $('.detalle').show();
                $('#dt_detalle').html(tableBody);
            }

        });
    });

    $('.insertar').click(function () {
        var fecha = $('#fecha').val();
        var cantidad = $('#cantidad').val();
        var cantidad_disponible = $('#cantidad_disponible').val();
        var fecha_vencimiento = $('#fecha_vencimiento').val();
        var id_receta = $('#id_receta').val();
        var id_producto = $('#id_producto').val();
        var id_usuario = $('#id_usuario').val();
		//alert 'Insertar';
		
        $.ajax({
            type: "POST",
            url: "../../negocio/NOrden_Produccion.php?funcion=insertar",
            data: {
                fecha: fecha,
                cantidad: cantidad,
                cantidad_disponible: cantidad_disponible,
                fecha_vencimiento: fecha_vencimiento,
                id_receta: id_receta,
                id_producto: id_producto,
                id_usuario: id_usuario
            },
            success: function (data) {
                location.href = 'index_produccion.php';
                alert(data);
            }

        });
    });

    $('#fecha').setDateTime();
    $('#fecha_vencimiento').setDateTime();
});