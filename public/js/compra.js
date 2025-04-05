$(document).ready(function () {
    $("#dt_compras").DataTable({
        "ajax": "../../negocio/NCompra.php?funcion=listado",
        "columns": [
            {"data": "Id"},
			{"data": "Fecha"},
			{"data": "Usuario"},
            {"data": "Proveedor"},
            {"data": "Total"},
            {"data": "Estado"},
            {
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                "<a class='btn btn-outline btn-info modificar'><i class='ti-pencil'></i></a>" +
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
            "targets": 6,
            "className": "text-center",
            "orderable": false
        }, {type: 'date-eu', targets: 1}],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(5)', nRow).html('<span class="label label-warning">Pendiente</span>');

            } else {
                $('td:eq(5)', nRow).html('<span class="label label-success">Cancelado</span>');
                $('td:eq(6)', nRow).html("<div class='btn-group btn-group-sm'><a class='btn btn-outline btn-primary show'><i class='ti-eye'></i></a></div>");
            }
        },
        "order": [[1, "desc"]],
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
				.column( 4 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Total over this page
			pageTotal = api
				.column( 4, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Update footer
			$( api.column( 4 ).footer() ).html(
				''+pageTotal +' ( '+ total +' total)'
			);
		}
    });

	$('#dt_detalle').DataTable( {
        paging: false
    } );

    $('.insertar-insumo').click(function () {
		var id_insumo = $('#insumo').val();
        var insumo = $('#insumo :selected').text();
        var fecha_vencimiento = $('#fecha_vencimiento').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').val();
        if (id_insumo > 0 && cantidad > 0 && costo > 0) {
			var subtotal = $('#subtotal').val();
			var total = $('#total').val();
			var total_result = parseFloat(subtotal) + parseFloat(total);
			$('#total').val(total_result);
            $('#dt_detalle').dataTable().fnAddData([id_insumo, insumo, fecha_vencimiento, cantidad, costo, subtotal]);
            $('#insumo').prop('selectedIndex', 0);
			$('#fecha_vencimiento').val(moment().format('DD/MM/YYYY'));
            $('#subtotal').clearInput();
            $('#cantidad').clearInput();
            $('#costo').clearInput();
        }
        else {
            alert('Ingresar datos válidos en cantidad y costo y/o seleccionar un insumo');
        }
    });

    $('#cantidad, #subtotal').on('input', function () {
        var cantidad = $('#cantidad').val();
        var subtotal = $('#subtotal').val();
        //$('#costo').getCosto(subtotal, cantidad);
		$('#costo').val(subtotal/cantidad);
    });

    $('.insertar').click(function () {
        if ($('#form-compra').valid()) {
            var fecha = $('#fecha').val();
            var id_proveedor = $('#proveedor :selected').val();
			//alert id_proveedor;
			/*if(id_proveedor<=0){
				alert 'Deber seleccionar proveedor';
				return;
			}*/
            var estado = $('input[name=estado]:checked', '#form-compra').val();
            var total = $('#total').val();
            var detalle = JSON.stringify(getDetalle());
            var id_usuario = $('#id_usuario').val();
            console.log(detalle);
            $.ajax({
                type: "POST",
                url: "../../negocio/NCompra.php?funcion=insertar",
                data: {
                    fecha: fecha,
                    id_proveedor: id_proveedor,
                    estado: estado,
                    total: total,
                    id_usuario: id_usuario,
                    detalle_compra: detalle
                },
                success: function (data) {
                    location.href = 'index_compra.php';
                    alert(data);
                }

            });
        }
    });

    $('.cancelar-total').click(function () {
        var id_compra = $('#id_compra').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NCompra.php?funcion=cancelar",
            data: {id_compra: id_compra},
            success: function (data) {
                $('.bs-modal-form-enable').hide();
                location.href = 'index_compra.php';
                alert(data);
            }

        });
    });
    function getDetalle() {
        var table_array = new Array();
        $('#dt_detalle tr').each(function (row, tr) {
            table_array[row] = {
                "id_insumo": $(tr).find('td:eq(0)').text(),
                "insumo": $(tr).find('td:eq(1)').text(),
                "fecha_vencimiento": $(tr).find('td:eq(2)').text(),
                "cantidad": $(tr).find('td:eq(3)').text(),
                "costo": $(tr).find('td:eq(4)').text(),
                "subtotal": $(tr).find('td:eq(5)').text()
            }
        });
        table_array.shift();
        return table_array;
    }

    //*Listado de compras*//

    var table = $('#dt_compras').DataTable();
    var tbody = $('#dt_compras tbody');
    $(tbody).on('click', '.show', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "show_compra.php?Id=" + data.Id + "&F=" + data.Fecha + "&T=" + data.Total + "&P=" + data.Proveedor + "&E=" + data.Estado;
    });
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "modificar_compra.php?id=" + data.Id + "&f=" + data.Fecha + "&t=" + data.Total + "&p=" + data.Proveedor + "&e=" + data.Estado;
    });
    $(tbody).on('click', '.cancelar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_compra').val(data.Id);
    });

    //$('#fecha').setDateTime();
    $('#fecha_vencimiento').setDateTime();
	
	
    //**Crear compra: modificar y eliminar insumo de la tabla**//

    var table_detalle = $('#dt_detalle').DataTable();
    var row_selected = '';
    var subtotal_insumo = 0;
    $('#dt_detalle tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('.insertar-insumo').show();
            $('.modificar-insumo').hide();
            $('.eliminar-insumo').hide();
        } else {
            table_detalle.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#id_insumo').prop('disabled', 'disabled');
            $('.insertar-insumo').hide();
            $('.modificar-insumo').show();
            $('.eliminar-insumo').show();
            $.each($("#dt_detalle tr.selected"), function () {
                row_selected = table_detalle.row(this).data();
                var id_insumo_selected = row_selected[0];
                var fecha_vencimiento = row_selected[2];
                var cantidad_selected = row_selected[3];
                var costo = row_selected[4];
                var subtotal = row_selected[5];
                subtotal_insumo = subtotal;
                $('#insumo').val(id_insumo_selected);
                $('#fecha_vencimiento').val(fecha_vencimiento);
                $('#cantidad').val(cantidad_selected);
                $('#costo').val(costo);
                $('#subtotal').val(subtotal);
            });
        }
    });

    $('.modificar-insumo').click(function () {
        var id_insumo = $('#id_insumo').val();
        var insumo = $('#insumo :selected').text();
        var fecha_vencimiento = $('#fecha_vencimiento').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').val();
        var subtotal = $('#subtotal').val();
        var total = $('#total').val();
        var total_result = parseFloat(subtotal) + parseFloat(total);
        total_result = parseFloat(total_result) - parseFloat(subtotal_insumo);
        $('#total').val(total_result);
        if (cantidad > 0 && costo > 0) {
            var s;
            $.each($("#dt_detalle tr.selected"), function () {
                $(this).find('td').eq(2).text(fecha_vencimiento);
                $(this).find('td').eq(3).text(cantidad);
                $(this).find('td').eq(4).text(costo);
                $(this).find('td').eq(5).text(subtotal);

            });
            $('#id_insumo').clearInput();
            $('#insumo').clearInput();
            $('#cantidad').clearInput();
            $('#costo').clearInput();
            $('#fecha_vencimiento').val(moment().format('DD/MM/YYYY'));
            $('#subtotal').clearInput();
            table_detalle.$('tr.selected').removeClass('selected');
        } else {
            alert("Ingresar los datos requeridos");
        }
        $(".insertar-insumo").show();
        $(".modificar-insumo").hide();
        $(".eliminar-insumo").hide();

    });

    $('.eliminar-insumo').click(function () {
        $.each($("#dt_detalle tr.selected"), function () {
            row_selected = table_detalle.row(this).data();
            var total = $('#total').val();
            var total_result = parseFloat(total) - parseFloat(row_selected[5]);
            $('#total').val(total_result);
        });
        table_detalle.row('.selected').remove().draw(false);
        $(".insertar-insumo").show();
        $(".modificar-insumo").hide();
        $(".eliminar-insumo").hide();

        $('#insumo').clearInput();
        $('#fecha_vencimiento').clearInput();
        $('#cantidad').clearInput();
        $('#costo').clearInput();
        $('#subtotal').clearInput();
    });

});