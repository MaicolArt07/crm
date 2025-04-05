$(document).ready(function () {
    $("#dt_productos").DataTable({
        "ajax": "../../negocio/NProducto.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Descripcion"},
            {"data": "Stock"},
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
		"pageLength": 100,
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": 0,
            "visible": true
        }, {
            "targets": 5,
            "className": "text-center",
            "orderable": false
        }],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(4)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(4)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(5)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");
            }
        }, "order": [[1, "asc"]]
    });

    $(".insertar").click(function () {
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProducto.php?funcion=insertar",
            data: {nombre: nombre, descripcion: descripcion},
            success: function (data) {
                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".modificar").click(function () {
        var Id = $('#Id').val();
        var nombre = $('#nombre_modificar').val();
        var descripcion = $('#descripcion_modificar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProducto.php?funcion=modificar",
            data: {
                Id: Id,
                nombre: nombre,
                descripcion: descripcion
            },
            success: function (data) {
                $('.bs-modal-form-modificar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".deshabilitar").click(function () {
        var Id = $('#Id_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProducto.php?funcion=deshabilitar",
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
            url: "../../negocio/NProducto.php?funcion=habilitar",
            data: {Id: Id},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    /***/
    var table = $('#dt_productos').DataTable();
    var tbody = $('#dt_productos tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#Id').val(data.Id);
        $('#nombre_modificar').val(data.Nombre);
        $('#descripcion_modificar').val(data.Descripcion);
    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#Id_habilitar').val(data.Id);
		$('#Nombre_habilitar').val(data.Nombre);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#Id_deshabilitar').val(data.Id);
		$('#Nombre_deshabilitar').val(data.Nombre);
    });
});
