$(document).ready(function () {
    $("#dt_usuarios").DataTable({
        "ajax": "../../negocio/NUsuario.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Login"},
            {"data": "Tipo"},
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
        "columnDefs": [
            {
                "targets": 0,
                "visible": true
            },
            {
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
        var login = $('#login').val();
        var clave = $('#clave').val();
        var tipo = $('#tipo').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUsuario.php?funcion=insertar",
            data: {nombre: nombre, login: login, clave: clave, tipo: tipo},
            success: function (data) {

                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();

            }

        });
    });

    $(".modificar").click(function () {
        var id_usuario = $('#id_usuario').val();
        var nombre = $('#nombre_modificar').val();
        var login = $('#login_modificar').val();
        var clave = $('#clave_modificar').val();
        var tipo = $('#tipo_modificar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUsuario.php?funcion=modificar",
            data: {
                id_usuario: id_usuario,
                nombre: nombre, login: login, clave: clave, tipo: tipo
            },
            success: function (data) {
                $('.bs-modal-form-modificar').hideModal();
                alert(data);
				location.reload();

            }

        });
    });

    $(".deshabilitar").click(function () {
        var id_usuario = $('#id_usuario_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUsuario.php?funcion=deshabilitar",
            data: {id_usuario: id_usuario},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_usuario = $('#id_usuario_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NUsuario.php?funcion=habilitar",
            data: {id_usuario: id_usuario},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    /***/
    var table = $('#dt_usuarios').DataTable();
    var tbody = $('#dt_usuarios tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
		var tipo = data.Tipo;
        $('#id_usuario').val(data.Id);
        $('#nombre_modificar').val(data.Nombre);
        $('#login_modificar').val(data.Login);
        $('#clave_modificar').val(data.Clave);
		$("#tipo_modificar option").filter(function () {
            return this.text == tipo
        }).attr('selected', true);

    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_usuario_habilitar').val(data.Id);
		$('#nombre_usuario_habilitar').val(data.Nombre);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_usuario_deshabilitar').val(data.Id);
		$('#nombre_usuario_deshabilitar').val(data.Nombre);
    });
});
