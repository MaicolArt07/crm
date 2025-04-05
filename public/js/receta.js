$(document).ready(function () {

    $('#dt_detalle').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        }
    });
    $("#dt_insumos").DataTable({
        "ajax": "../../negocio/NInsumo.php?funcion=search",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Descripcion"},
            {"data": "Unidad_Medida"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        }
    });
    $("#dt_recetas").DataTable({
        "ajax": "../../negocio/NReceta.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Nombre"},
            {"data": "Producto"},
            {"data": "Cantidad"},
            {"data": "Estado"},
            {
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                "<a class='btn btn-outline btn-info modificar'><i class='ti-pencil'></i></a>" +
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
        },
        "order": [[1, "asc"]]
    });


    var table_insumo = $('#dt_insumos').DataTable();
    var table = $('#dt_recetas').DataTable();
    $("#dt_insumos tbody").on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_insumo.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('.insumo-selected').click(function () {
        var id_insumo, insumo, unidad_medida, stock;
        $.each($("#dt_insumos tr.selected"), function () {
            id_insumo = $(this).find('td').eq(0).text();
            insumo = $(this).find('td').eq(1).text();
            unidad_medida = $(this).find('td').eq(3).text();
            stock = $(this).find('td').eq(4).text();
        });
        $('#id_insumo').val(id_insumo);
        $('#insumo').val(insumo);
        $('#unidad_medida_insumo').val(unidad_medida);
        $('#stock').val(stock);
        $('#modal-from-search').hideModal();
    });

    $('.insertar-insumo').click(function () {
        var id_insumo = $('#id_insumo').val();
        var nombre = $('#insumo').val();
        var unidad_medida = $('#unidad_medida_insumo').val();
        var cantidad = $('#cantidad_insumo').val();

        if (id_insumo != "" && cantidad != "") {
            $('#dt_detalle').dataTable().fnAddData([id_insumo, nombre, unidad_medida, cantidad]);
            
			$('#id_insumo').clearInput();
            $('#insumo').clearInput();
            $('#unidad_medida_insumo').clearInput();
            $('#stock').clearInput();
            $('#cantidad_insumo').clearInput();
        } else {
            alert("Ingresar los datos requeridos");
        }

    });
    $('.insertar').click(function () {
        if ($('#form-receta').valid()) {
            var nombre = $('#nombre').val();
            var id_producto = $('select[name=producto]').val();
            var cantidad = $('#cantidad').val();

            var detalle = JSON.stringify(getDetalle());
            $.ajax({
                type: "POST",
                url: "../../negocio/NReceta.php?funcion=insertar",
                data: {
                    nombre: nombre,
                    id_producto: id_producto,
                    cantidad: cantidad,
                    detalle: detalle
                },
                success: function (data) {
                    location.href = 'index_receta.php';
                    alert(data);
                }

            });
        }

    });

    $('#dt_recetas tbody').on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "modificar_receta.php?id=" + data.Id + "&p=" + data.Producto + "&c=" + data.Cantidad + "&n=" + data.Nombre;
    });

    function getDetalle() {
        var table_array = new Array();

        $('#dt_detalle tr').each(function (row, tr) {
            table_array[row] = {
                "id_insumo": $(tr).find('td:eq(0)').text(),
                "cantidad": $(tr).find('td:eq(3)').text()
            }
        });
        table_array.shift();
        return table_array;
    }

    $("#producto_modificar option").filter(function () {
        return this.text == unidad_medida
    }).attr('selected', true);

    $(".deshabilitar").click(function () {
        var id_receta = $('#id_receta_deshabilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NReceta.php?funcion=deshabilitar",
            data: {id_receta: id_receta},
            success: function (data) {
                $('.bs-modal-form-deshabilitar').hideModal();
				alert(data);
                location.reload();
            }

        });
    });

    $(".habilitar").click(function () {
        var id_receta = $('#id_receta_habilitar').val();
        $.ajax({
            type: "POST",
            url: "../../negocio/NReceta.php?funcion=habilitar",
            data: {id_receta: id_receta},
            success: function (data) {
                $('.bs-modal-form-habilitar').hideModal();
                alert(data);
				location.reload();
            }

        });
    });

    var tbody = $('#dt_recetas tbody');
    $(tbody).on('click', '.habilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_receta_habilitar').val(data.Id);
		$('#nombre_receta_habilitar').val(data.Nombre);
    });
    $(tbody).on('click', '.deshabilitar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_receta_deshabilitar').val(data.Id);
		$('#nombre_receta_deshabilitar').val(data.Nombre);
    });
});


