$(document).ready(function () {
    $('#fecha').setDateTime();
    $('#fecha_vencimiento').setDateTime();

    var lista_delete = [];
    var id_compra = $('#id_compra').val();
    var subtotal_insumo = 0;
    $('#dt_detalle').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        "ajax": {
            "url": '../../negocio/NDetalle_Compra.php?funcion=detalle',
            "type": "GET",
            "data": {id_compra: id_compra}
        },
        "columns": [
            {"data": "Id"},
            {"data": "Id_Insumo"},
            {"data": "Insumo"},
            {"data": "Fecha_Vencimiento"},
            {"data": "Cantidad"},
            {"data": "Costo"},
            {"data": "Total"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0, 1],
                "visible": false
            }
        ],
    });

    $('#cantidad, #subtotal').on('input', function () {
        var cantidad = $('#cantidad').val();
        var subtotal = $('#subtotal').val();
        $('#costo').getCosto(subtotal, cantidad);
    });

    var table = $('#dt_detalle').DataTable();
    var row_selected = '';
    $('#dt_detalle tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('.insertar-insumo').show();
            $('.modificar-insumo').hide();
            $('.eliminar-insumo').hide();
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#id_insumo').prop("disabled", true);
            $('.insertar-insumo').hide();
            $('.modificar-insumo').show();
            $('.eliminar-insumo').show();
            $.each($("#dt_detalle tr.selected"), function () {
                row_selected = table.row(this).data();

                var id_detalle_compra_selected = row_selected['Id'];
                var id_insumo_selected = row_selected['Id_Insumo'];
                var fecha_vencimiento = row_selected['Fecha_Vencimiento'];
                var cantidad_selected = row_selected['Cantidad'];
                var costo = row_selected['Costo'];
                var subtotal = row_selected['Total'];
                subtotal_insumo = subtotal;
                $('#id_detalle_compra').val(id_detalle_compra_selected);
                $('#insumo').val(id_insumo_selected);
                $('#fecha_vencimiento').val(fecha_vencimiento);
                $('#cantidad').val(cantidad_selected);
                $('#costo').val(costo);
                $('#subtotal').val(subtotal);
            });
        }
    });

    $('.insertar-insumo').click(function () {
        var id_insumo = $('#insumo').val();
        var insumo = $('#insumo :selected').text();
        var fecha_vencimiento = $('#fecha_vencimiento').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').val();
        var subtotal = $('#subtotal').val();
        var total = $('#total').val();
        var total_result = parseFloat(subtotal) + parseFloat(total);
        $('#total').val(total_result);
        if (id_insumo > 0 && cantidad > 0 && costo > 0) {
            table.row.add({
                "Id": "",
                "Id_Insumo": id_insumo,
                "Insumo": insumo,
                "Fecha_Vencimiento": fecha_vencimiento,
                "Cantidad": cantidad,
                "Costo": costo,
                "Total": subtotal
            }).draw();
            $('#insumo').prop('selectedIndex', 0);
            $('#fecha_vencimiento').clearInput();
            $('#subtotal').clearInput();
            $('#cantidad').clearInput();
            $('#costo').clearInput();
        }
        else {
            alert('Ingresar datos válidos en cantidad y costo y/o seleccionar un insumo');
        }
    });

    $('.modificar-insumo').click(function () {
        var id_insumo = $('#id_insumo').val();
        var insumo = $('#insumo :selected').text();
        var fecha_vencimiento = $('#fecha_vencimiento').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').val();
        var subtotal = $('#subtotal').val();
        var total = $('#total').val();
        var total_result = parseFloat(subtotal) + parseFloat(total);
        total_result = parseFloat(total_result) - parseFloat(subtotal_insumo);
        $('#total').val(total_result);
        if (cantidad > 0 && costo > 0) {
            var s;
            $.each($("#dt_detalle tr.selected"), function () {
                $(this).find('td').eq(1).text(fecha_vencimiento);
                $(this).find('td').eq(2).text(cantidad);
                $(this).find('td').eq(3).text(costo);
                $(this).find('td').eq(4).text(subtotal);

            });
            $('#id_insumo').clearInput();
            $('#insumo').clearInput();
            $('#cantidad').clearInput();
            $('#costo').clearInput();
            $('#fecha_vencimiento').clearInput();
            $('#subtotal').clearInput();
            table.$('tr.selected').removeClass('selected');
        } else {
            alert("Ingresar los datos requeridos");
        }
        $(".insertar-insumo").show();
        $(".modificar-insumo").hide();
        $(".eliminar-insumo").hide();

    });

    $('.eliminar-insumo').click(function () {
        $.each($("#dt_detalle tr.selected"), function () {
            row_selected = table.row(this).data();
            var total = $('#total').val();
            var total_result = parseFloat(total) - parseFloat(row_selected.Total);
            $('#total').val(total_result);
            lista_delete.push(row_selected.Id);
            $('#label-delete').val(lista_delete);
        });
        table.row('.selected').remove().draw(false);
        $(".insertar-insumo").show();
        $(".modificar-insumo").hide();
        $(".eliminar-insumo").hide();

        $('#id_insumo').clearInput();
        $('#insumo').clearInput();
        $('#fecha_vencimiento').clearInput();
        $('#cantidad').clearInput();
        $('#costo').clearInput();
        $('#subtotal').clearInput();
    });

    $('.modificar').click(function () {
        if ($('#form-compra').valid()) {
            var id_compra = $('#id_compra').val();
            var fecha = $('#fecha').val();
            var id_proveedor = $('#proveedor :selected').val();
            var estado = $('input[name=estado]:checked', '#form-compra').val()
            var total = $('#total').val();
            var detalle = JSON.stringify(getDetalle());
            var id_usuario = $('#id_usuario').val();
            var array_delete = $('#label-delete').val();
            $.ajax({
                type: "POST",
                url: "../../negocio/NCompra.php?funcion=modificar",
                data: {
                    id_compra: id_compra,
                    fecha: fecha,
                    id_proveedor: id_proveedor,
                    estado: estado,
                    total: total,
                    id_usuario: id_usuario,
                    detalle_compra: detalle,
                    array_delete: array_delete,
                },
                success: function (data) {
                    location.href = 'index_compra.php';
                    alert(data);
                }
            });
        }
    });

    function getDetalle() {
		var table = $('#dt_detalle').DataTable();
		table.column(0).visible(true);
		table.column(1).visible(true);
		
		var table_array = new Array();
        $('#dt_detalle tr').each(function (row, tr) {
            table_array[row] = {
				"id_detalle_compra": $(tr).find('td:eq(0)').text(),
                "id_insumo": $(tr).find('td:eq(1)').text(),
                "insumo": $(tr).find('td:eq(2)').text(),
                "fecha_vencimiento": $(tr).find('td:eq(3)').text(),
                "cantidad": $(tr).find('td:eq(4)').text(),
                "costo": $(tr).find('td:eq(5)').text(),
                "subtotal": $(tr).find('td:eq(6)').text()
            }
        });
        table_array.shift();
        return table_array;
    }
});