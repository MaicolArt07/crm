$(document).ready(function () {
    var table = $("#dt_insumos").DataTable({
        "ajax": "../../negocio/NInsumo.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Descripcion"},
			{"data": "Stock"},
			{"data": "Unidad_Medida"},
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
            "targets": 6,
            "className": "text-center",
            "orderable": false
        }],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(5)', nRow).html('<span class="label label-success">Habilitado</span>');

            } else {
                $('td:eq(5)', nRow).html('<span class="label label-default">Deshabilitado</span>');
                $('td:eq(6)', nRow).html("<a data-toggle='modal' data-target='.bs-modal-form-habilitar' class='habilitar btn btn-sm btn-black btn-outline'>" +
                    "<i class='ti-check'></i></a>");

            }
            
        },
        "order": [[1, "asc"]]
    });

    table.on('responsive-display', function (e, datatable, row, showHide, update) {
        if (showHide) {
            // La fila secundaria se está mostrando
            var filaSecundaria = table.row(row.child()).node();
            // Acceder a la segunda celda de la fila secundaria y aplicar estilos
            //$(filaSecundaria).find('td:eq(1)').addClass('mi-estilo-responsivo');
            console.log("prueba1");
            console.log(row.child().firstChild);

            $('td:eq(1)', filaSecundaria).html('<span class="label label-success">Habilitado</span>');
            /*if (aData['Estado'] == 1) {
                

            } else {
                $('td:eq(1)', filaSecundaria).html('<span class="label label-default">Deshabilitado</span>');
                
            }*/
        } else {
            // La fila secundaria se está ocultando
            // Puedes realizar acciones adicionales si es necesario
        }
    });

    $(".insertar").click(function () {
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        var id_unidad_medida = $('select[name=unidad_medida]').val();
        var estado = $('input[name=estado]:checked').val()

        $.ajax({
            type: "POST",
            url: "../../negocio/NInsumo.php?funcion=insertar",
            data: {nombre: nombre, descripcion: descripcion, id_unidad_medida: id_unidad_medida, estado: estado},
            success: function (data) {
                $('.bs-modal-form-insertar').hideModal();
                alert(data);
				location.reload();
            }
        });
    });

    $(".modificar").click(function () {
        var id_insumo = $('#id_insumo').val();
        var nombre = $('#nombre_modificar').val();
        var descripcion = $('#descripcion_modificar').val();
        var id_unidad_medida = $('select[name=unidad_medida_modificar]').val();
        var estado = $('input[name=estado_modificar]:checked').val()

        $.ajax({
            type: "POST",
            url: "../../negocio/NInsumo.php?funcion=modificar",
            data: {
                id_insumo: id_insumo,
                nombre: nombre,
                descripcion: descripcion,
                id_unidad_medida: id_unidad_medida,
                estado: estado
            },
            success: function (data) {
                $('.bs-modal-form-modificar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    $(".deshabilitar").click(function () {
        var id_insumo = $('#id_insumo_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NInsumo.php?funcion=deshabilitar",
            data: {id_insumo: id_insumo},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
				top.alert(data);
				location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_insumo = $('#id_insumo_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NInsumo.php?funcion=habilitar",
            data: {id_insumo: id_insumo},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                top.alert(data);
				location.reload();
            }

        });
    });

    /***/
    var table = $('#dt_insumos').DataTable();
    var tbody = $('#dt_insumos tbody');
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        var unidad_medida = data.Unidad_Medida;
        $('#id_insumo').val(data.Id);
        $('#nombre_modificar').val(data.Nombre);
        $('#descripcion_modificar').val(data.Descripcion);
        $("#unidad_medida_modificar option").filter(function () {
            return this.text == unidad_medida
        }).attr('selected', true);
    });
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_insumo_habilitar').val(data.Id);
		$('#nombre_insumo_habilitar').val(data.Nombre);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_insumo_deshabilitar').val(data.Id);
		$('#nombre_insumo_deshabilitar').val(data.Nombre);
    });
});
