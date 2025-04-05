$(document).ready(function () {
    $("#dt_unidades").DataTable({
        "ajax": "../../negocio/NUnidad_Medida.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
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
            "targets": 3,
            "className": "text-center",
            "orderable": false
        }],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(1)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(1)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(2)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");
            }
        },
        "order": [[1, "asc"]]
    });

    $(".insertar").click(function () {
        var nombre = $('#nombre').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUnidad_Medida.php?funcion=insertar",
            data: {nombre: nombre},
            success: function (data) {
                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".modificar").click(function () {
        var id_unidad_medida = $('#id_unidad_medida').val();
        var nombre = $('#nombre_modificar').val();

        $.ajax({
            type: "POST",
            url: "../../negocio/NUnidad_Medida.php?funcion=modificar",
            data: {
                id_unidad_medida: id_unidad_medida,
                nombre: nombre,
            },
            success: function (data) {
                $('.bs-modal-form-modificar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".deshabilitar").click(function () {
        var id_unidad_medida = $('#Id_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUnidad_Medida.php?funcion=deshabilitar",
            data: {id_unidad_medida: id_unidad_medida},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_unidad_medida = $('#id_unidad_medida_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUnidad_Medida.php?funcion=habilitar",
            data: {id_unidad_medida: id_unidad_medida},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    /***/
    var table = $('#dt_unidades').DataTable();
    var tbody = $('#dt_unidades tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_unidad_medida').val(data.Id);
        $('#nombre_modificar').val(data.Nombre);
    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_unidad_medida_habilitar').val(data.Id);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#Id_deshabilitar').val(data.Id);
    });
});
