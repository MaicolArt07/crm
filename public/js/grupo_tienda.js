$(document).ready(function () {
    $("#dt_grupo_tienda").DataTable({
        "ajax": "../../negocio/NGrupo_Tienda.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Cobrar_desde_App"},
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
        }, 
        {
            "targets": 3,
            "className": "text-center",
            "orderable": false
        }],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(2)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(2)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(3)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");
            }

            if (aData['Cobrar_desde_App'] == 1) {
                $('td:eq(1)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(1)', nRow).html('<span class="label label-default">Deshabilitado</span>');
            }
        },
        "order": [[1, "asc"]]
    });

    $(".insertar").click(function () {
        var Nombre = $('#Nombre').val();
        var PermitirCobrar = $('#PermitirCobrar').is(':checked') ? 1 : 0;
        
        $.ajax({
            type: "POST",
            url: "../../negocio/NGrupo_Tienda.php?funcion=insertar",
            data: {
                Nombre: Nombre,
                PermitirCobrar: PermitirCobrar,
            },
            success: function (data) {
                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".modificar").click(function () {
        var Id = $('#Id').val();
        var Nombre = $('#Nombre_modificar').val();
        var PermitirCobrar = $('#PermitirCobrar_modificar').is(':checked') ? 1 : 0;

        $.ajax({
            type: "POST",
            url: "../../negocio/NGrupo_Tienda.php?funcion=modificar",
            data: {
                Id: Id,
                Nombre: Nombre,
                PermitirCobrar: PermitirCobrar,
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
            url: "../../negocio/NGrupo_Tienda.php?funcion=deshabilitar",
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
            url: "../../negocio/NGrupo_Tienda.php?funcion=habilitar",
            data: {Id: Id},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    /***/
    var table = $('#dt_grupo_tienda').DataTable();
    var tbody = $('#dt_grupo_tienda tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        
        $('#Id').val(data.Id);
        $('#Nombre_modificar').val(data.Nombre);

        if (data.Cobrar_desde_App==1) {
            $('#PermitirCobrar_modificar').prop('checked', true);
        } else {
            $('#PermitirCobrar_modificar').prop('checked', false);
        }
        
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
