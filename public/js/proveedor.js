$(document).ready(function () {
    $("#dt_proveedores").DataTable({
        "ajax": "../../negocio/NProveedor.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Nit"},
            {"data": "Direccion"},
            {"data": "Telefono"},
            {"data": "Correo"},
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
                "targets": 7,
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
        }, "order": [[1, "asc"]]
    });

    $(".insertar").click(function () {
        var nombre = $('#nombre').val();
        var nit = $('#nit').val();
        var direccion = $('#direccion').val();
        var telefono = $('#telefono').val();
        var correo = $('#correo').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProveedor.php?funcion=insertar",
            data: {nombre: nombre, nit: nit, direccion: direccion, telefono: telefono, correo: correo},
            success: function (data) {

                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();

            }

        });
    });

    $(".modificar").click(function () {
        var id_proveedor = $('#id_proveedor').val();
        var nombre = $('#nombre_modificar').val();
        var nit = $('#nit_modificar').val();
        var direccion = $('#direccion_modificar').val();
        var telefono = $('#telefono_modificar').val();
        var correo = $('#correo_modificar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProveedor.php?funcion=modificar",
            data: {
                id_proveedor: id_proveedor,
                nombre: nombre, nit: nit, direccion: direccion, telefono: telefono, correo: correo
            },
            success: function (data) {
                $('.bs-modal-form-modificar').hideModal();
                alert(data);
				location.reload();

            }

        });
    });

    $(".deshabilitar").click(function () {
        var id_proveedor = $('#id_proveedor_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProveedor.php?funcion=deshabilitar",
            data: {id_proveedor: id_proveedor},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_proveedor = $('#id_proveedor_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NProveedor.php?funcion=habilitar",
            data: {id_proveedor: id_proveedor},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    /***/
    var table = $('#dt_proveedores').DataTable();
    var tbody = $('#dt_proveedores tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_proveedor').val(data.Id);
        $('#nombre_modificar').val(data.Nombre);
        $('#nit_modificar').val(data.Nit);
        $('#direccion_modificar').val(data.Direccion);
        $('#telefono_modificar').val(data.Telefono);
        $('#correo_modificar').val(data.Correo);

    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_proveedor_habilitar').val(data.Id);
		$('#nombre_proveedor_habilitar').val(data.Nombre);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_proveedor_deshabilitar').val(data.Id);
		$('#nombre_proveedor_deshabilitar').val(data.Nombre);
    });
});
