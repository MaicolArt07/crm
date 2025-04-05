$(document).ready(function () {
	$("#dt_precio").DataTable({
		"ajax": "../../negocio/NPrecio.php?funcion=listado",
        "columns": [
            {"data": "Id"},
			{"data": "Grupo_Tienda"},
			{"data": "Producto"},
			{"data": "Monto"},
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
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": 0,
            "visible": false
        }, {
            "targets": 5,
            "className": "text-center",
            "orderable": false
        }
        ],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(3)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(3)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(4)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");
            }
        },
        "order": [[2, "desc"]]
    });

    $(".insertar").click(function () {
		var Id_Grupo_Tienda = $('select[name=Grupo_Tienda]').val();
		var Id_Producto = $('select[name=Producto]').val();
        var Monto = $('#Monto').val();

        $.ajax({
            type: "POST",
            url: "../../negocio/NPrecio.php?funcion=insertar",
            data: {
				Id_Grupo_Tienda: Id_Grupo_Tienda,
                Id_Producto: Id_Producto,
				Monto: Monto
            },
            success: function (data) {
                alert(data);
				location.href = 'index_precio.php';
            }
        });
    });

    $(".modificar").click(function () {
        var Id = $('#Id').val();
		var Id_Grupo_Tienda = $('select[name=Grupo_Tienda]').val();
		var Id_Producto = $('select[name=Producto]').val();
        var Monto = $('#Monto_m').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NPrecio.php?funcion=modificar",
            data: {
                Id: Id,
				Id_Grupo_Tienda: Id_Grupo_Tienda,
				Id_Producto: Id_Producto,
                Monto: Monto
            },
            success: function (data) {
				alert(data);
                location.href = 'index_precio.php';
            }

        });
    });

    $(".deshabilitar").click(function () {
        var Id = $('#Id_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NPrecio.php?funcion=deshabilitar",
            data: {Id: Id},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var Id = $('#Id_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NPrecio.php?funcion=habilitar",
            data: {Id: Id},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
				alert(data);
                location.reload();
            }

        });
    });

    var table = $('#dt_precio').DataTable();
    var tbody = $('#dt_precio tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "modificar_precio.php?Id=" + data.Id + "&G=" + data.Grupo_Tienda + "&P=" + data.Producto + "&M=" + data.Monto;
    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#Id_habilitar').val(data.Id);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#Id_deshabilitar').val(data.Id);
    });
});
