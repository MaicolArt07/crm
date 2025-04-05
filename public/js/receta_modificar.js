$(document).ready(function () {
    var id_receta = $("#id_receta").val();
    var lista = [];
    $("#dt_detalle").DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        "ajax": {
            "url": "../../negocio/NDetalle_Receta.php?funcion=listado",
            "type": "GET",
            "data": {id_receta: id_receta}
        },
        "columns": [
            {"data": "Id"},
            {"data": "Id_Insumo"},
            {"data": "Insumo"},
            {"data": "Unidad_Medida"},
            {"data": "Cantidad"}
        ],
        "columnDefs": [
            {
                "targets": [0],
                "visible": false
            }
        ],
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

    var table_insumo = $('#dt_insumos').DataTable();
    var table = $('#dt_recetas').DataTable();
    var table_detalle = $('#dt_detalle').DataTable();
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
            table_detalle.row.add({
                "Id": "",
                "Id_Insumo": id_insumo,
                "Insumo": nombre,
                "Unidad_Medida": unidad_medida,
                "Cantidad": cantidad
            }).draw();
            $('#id_insumo').clearInput();
            $('#insumo').clearInput();
            $('#unidad_medida_insumo').clearInput();
            $('#Stock_Insumo').clearInput();
            $('#cantidad_insumo').clearInput();
        } else {
            alert("Ingresar los datos requeridos");
        }
    });

    var row_selected = "";
    $('#dt_detalle tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_detalle.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('.insertar-insumo').hide();
            $('.modificar-insumo').show();
            $('.eliminar-insumo').show();
            $.each($("#dt_detalle tr.selected"), function () {
                row_selected = table_detalle.row(this).data();

                var id_selected = row_selected['Id'];
                var id_insumo_selected = row_selected['Id_Insumo'];
                var insumo_selected = row_selected['Insumo'];
                var cantidad_selected = row_selected['Cantidad'];
                $('#id_detalle').val(id_selected);
                $('#id_insumo').val(id_insumo_selected);
                $('#insumo').val(insumo_selected);
                $('#cantidad_insumo').val(cantidad_selected);

                $('.search').prop('disabled', true);
            });
        }
    });
    $('.eliminar-insumo').click(function () {
        $.each($("#dt_detalle tr.selected"), function () {
            var id_insumo_selected = table_detalle.row(this).data()['Id'];
            lista.push(id_insumo_selected);
            $('#label-delete').val(lista);

        });
        table_detalle.row('.selected').remove().draw(false);
        $(".insertar-insumo").show();
        $(".modificar-insumo").hide();
        $(".eliminar-insumo").hide();
        $(".search").prop('disabled', false);

        $('#id_insumo').clearInput();
        $('#insumo').clearInput();
        $('#cantidad_insumo').clearInput()
    });
    $('.modificar-insumo').click(function () {
        var id_insumo = $('#id_insumo').val();
        var cantidad = $('#cantidad_insumo').val();
        if (id_insumo != "" && cantidad != "") {
            $.each($("#dt_detalle tr.selected"), function () {

                $(this).find('td').eq(3).text(cantidad);
            });
            $('#id_insumo').clearInput();
            $('#insumo').clearInput();
            $('#cantidad_insumo').clearInput()
        } else {
            alert("Ingresar los datos requeridos");
        }
        $(".insertar-insumo").show();
        $(".modificar-insumo").hide();
        $(".eliminar-insumo").hide();
        $(".search").prop('disabled', false);
    });

    $('.modificar').click(function () {
        var id_receta = $('#id_receta').val();
        var nombre = $('#nombre').val();
        var id_producto = $('select[name=producto]').val();
        var cantidad = $('#cantidad').val();
        var array_delete = $('#label-delete').val();

        var arrayToJSON = getDetalleReceta();
        var dataTableDetalle = JSON.stringify(arrayToJSON);
        console.log('as' + dataTableDetalle + 'delete' + array_delete);

        $.ajax({
            type: "POST",
            url: "../../negocio/NReceta.php?funcion=modificar",
            data: {
                id_receta: id_receta,
                nombre: nombre,
                id_producto: id_producto,
                cantidad: cantidad,
                detalle: dataTableDetalle,
                lista: array_delete
            },
            success: function (data) {
                alert(data);
                location.href = 'index_receta.php';
            }

        });
    });
});


function getDetalleReceta() {
    var tableData = new Array();
    var table = $('#dt_detalle').DataTable();
    table.column(0).visible(true);
    $('#dt_detalle tr').each(function (row, tr) {
        tableData[row] = {
            "Id": $(tr).find('td:eq(0)').text(),
            "Id_Insumo": $(tr).find('td:eq(1)').text(),
            "Cantidad": $(tr).find('td:eq(4)').text()

        }
    });
    tableData.shift();
    return tableData;
}