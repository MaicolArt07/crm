$(document).ready(function () {
    $("#dt_tiendas").DataTable({
        "ajax": "../../negocio/NTienda.php?funcion=listado",
        "columns": [
            {"data": "Id"},
			{"data": "Grupo_Tienda"},
            {"data": "Nombre"},
            {"data": "Razon_Social"},
            {"data": "NIT"},
            {"data": "Correo"},
            {"data": "Direccion"},
            {"data": "Telefono"},
            {"data": "Contacto"},
			{"data": "Frecuencia_Visita"},
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
            "targets": 8,
            "className": "text-center",
            "orderable": false
        }
        ],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(9)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(9)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(10)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");
            }
        },
        "order": [[1, "desc"]]
    });

    $(".insertar").click(function () {
		var Id_Grupo_Tienda = $('select[name=Grupo_Tienda]').val();
        var nombre = $('#nombre').val();
		var razon_social = $('#razon_social').val();
        var nit = $('#nit').val();
        var coordenadas = $('#Coordenadas').val();
        var telefono = $('#telefono').val();
        var contacto = $('#contacto').val();
        var direccion = $('#direccion').val();

        $.ajax({
            type: "POST",
            url: "../../negocio/NTienda.php?funcion=insertar",
            data: {
				Id_Grupo_Tienda: Id_Grupo_Tienda,
                nombre: nombre,
              razon_social: razon_social,
                nit: nit,
                telefono: telefono,
                contacto: contacto,
                coordenadas: coordenadas,
                direccion: direccion
            },
            success: function (data) {
                location.href = 'index_tienda.php';
                alert(data);

            }
        });
    });

    $(".modificar").click(function () {
		
        var id_tienda = $('#id_tienda').val();
		var Id_Grupo_Tienda = $('select[name=Grupo_Tienda]').val();
        var nombre = $('#nombre_m').val();
        var razon_social = $('#razon_social_m').val();
        var nit = $('#nit_m').val();
        var coordenadas = $('#Coordenadas_m').val();
        var correo = $('#correo_m').val();
        var sala = $('#sala_m').val();
        var localidad = $('#localidad_m').val();
        var telefono = $('#telefono_m').val();
        var contacto = $('#contacto_m').val();
        var direccion = $('#direccion_m').val();
		var Frecuencia_Visita = $('#frecuencia_visita_m').val();
//alert ('correo'+correo);
        $.ajax({
            type: "POST",
            url: "../../negocio/NTienda.php?funcion=modificar",
            data: {
                id_tienda: id_tienda,
				Id_Grupo_Tienda: Id_Grupo_Tienda,
                nombre: nombre,
                razon_social: razon_social,
                nit: nit,
                telefono: telefono,
                contacto: contacto,
                correo: correo,
                sala: sala,
                localidad: localidad,
                coordenadas: coordenadas,
                direccion: direccion,
				Frecuencia_Visita : Frecuencia_Visita
            },
            success: function (data) {
                location.href = 'index_tienda.php';
            }

        });
    });

    $(".deshabilitar").click(function () {
        var id_tienda = $('#id_tienda_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NTienda.php?funcion=deshabilitar",
            data: {id_tienda: id_tienda},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
				top.alert(data);
                location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_tienda = $('#id_tienda_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NTienda.php?funcion=habilitar",
            data: {id_tienda: id_tienda},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
				top.alert(data);
                location.reload();
            }

        });
    });

    var table = $('#dt_tiendas').DataTable();
    var tbody = $('#dt_tiendas tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
		
        location.href = "modificar_tienda.php?Id=" + data.Id + "&G=" + data.Grupo_Tienda + "&N=" + data.Nombre + "&I=" + data.NIT + "&R=" + data.Razon_Social + "&D=" + data.Direccion + "&C=" + data.Coordenadas + "&T=" + data.Telefono + "&A=" + data.Contacto+ "&F=" + data.Frecuencia_Visita+ "&Co=" + data.Correo
        + "&Sa=" + data.Sala+ "&Lo=" + data.Localidad;
    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_tienda_habilitar').val(data.Id);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_tienda_deshabilitar').val(data.Id);
    });
});
