$(document).ready(function () {
    $("#dt_gastos").DataTable({
        "ajax": "../../negocio/NGasto.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Descripcion"},
			{"data": "Tipo_Gasto"},
			{"data": "Fecha"},
			{"data": "Total"},
            {"data": "Estado"},
            {
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                "<a data-toggle='modal' data-target='.bs-modal-form-modificar' class='modificar btn btn-outline btn-info'>" +
                "<i class='ti-pencil'></i></a>" +
                "<a data-toggle='modal' data-target='.bs-modal-form-deshabilitar' class='deshabilitar btn btn-danger btn-outline'>" +
                "<i class='ti-close'></i></a>" +
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
            "targets": 6,
            "className": "text-center",
            "orderable": false
        }],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(6)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(6)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(7)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");
            }
        },
        "order": [[1, "asc"]],
		
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

	
	$('#fecha').setDateTime();
	$('#fecha_modificar').setDateTime();
	
    $(".insertar").click(function () {
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        var id_tipo_gasto = $('select[name=tipo_gasto]').val();
		var fecha = $('#fecha').val();
		var total = $('#total').val();
		
		//
		$.ajax({
            type: "POST",
            url: "../../negocio/NGasto.php?funcion=insertar",
            data: {
				nombre: nombre, 
				descripcion: descripcion, 
				id_tipo_gasto: id_tipo_gasto, 
				fecha: fecha, 
				total:total
			},
			beforeSend: function () {
                        //alert('enviando');
                },
            success: function (data) {
                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();
            }
        });
        
    });

    $(".modificar").click(function () {
        var id_gasto = $('#id_gasto').val();
        var nombre = $('#nombre_modificar').val();
        var descripcion = $('#descripcion_modificar').val();
        var id_tipo_gasto = $('select[name=tipo_gasto_modificar]').val();
        var fecha = $('#fecha_modificar').val();
		var total = $('#total_modificar').val();
		//alert("id_gasto:"+id_gasto+" nombre:"+nombre+" descripcion:"+ descripcion+" tipo_gasto:"+id_tipo_gasto+" fecha:"+fecha+" total:"+total);
        $.ajax({
            type: "POST",
            url: "../../negocio/NGasto.php?funcion=modificar",
            data: {
                id_gasto: id_gasto,
                nombre: nombre,
                descripcion: descripcion,
                id_tipo_gasto: id_tipo_gasto,
                fecha: fecha, 
				total:total
            },
            success: function (data) {
                $('.bs-modal-form-modificar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".deshabilitar").click(function () {
        var id_gasto = $('#id_gasto_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NGasto.php?funcion=deshabilitar",
            data: {id_gasto: id_gasto},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
				top.alert(data);
				location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_gasto = $('#id_gasto_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NGasto.php?funcion=habilitar",
            data: {id_gasto: id_gasto},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                top.alert(data);
				location.reload();
            }

        });
    });

	 
    /***/
    var table = $('#dt_gastos').DataTable();
    var tbody = $('#dt_gastos tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        var tipo_gasto = data.Tipo_Gasto;
        $('#id_gasto').val(data.Id);
        $('#nombre_modificar').val(data.Nombre);
        $('#descripcion_modificar').val(data.Descripcion);
        $("#tipo_gasto_modificar option").filter(function () {
            return this.text == tipo_gasto
        }).attr('selected', true);
		$('#fecha_modificar').val(data.Fecha);
		$('#total_modificar').val(data.Total);
    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_gasto_habilitar').val(data.Id);
		$('#nombre_gasto_habilitar').val(data.Nombre);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_gasto_deshabilitar').val(data.Id);
		$('#nombre_gasto_deshabilitar').val(data.Nombre);
    });
});
