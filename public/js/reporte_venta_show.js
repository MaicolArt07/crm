$(document).ready(function () {
	var id_venta = $('#id_venta').val();
	$('#dt_detalle').DataTable({
		"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
		"ajax": {
            "url": "../../negocio/NDetalle_Venta.php?funcion=detalle",
			"type": "GET",
            "data": {id_venta: id_venta},
        },
        
		"columns": [
            {"data": "Id"},
            {"data": "Producto"},
			{"data": "Precio"},
            {"data": "Cantidad"},
            {"data": "Total"},
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0],
                "visible": false
            }, {
                "targets": 3,
                "className": "text-center"
            }, {
                "targets": [2, 4],
                "className": "text-right"
            }
        ],
    });

    $('.Pagar_Venta').click(function () {
        var Id_Venta = $('#id_venta').val();
        var Id_Usuario = $('#id_usuario').val(); // Asegúrate de tener este campo en tu HTML
        //alert ("Id_Venta"+Id_Venta);

        // Enviar los datos directamente sin JSON.stringify, ya que se están enviando como parámetros POST
        $.ajax({
            url: 'https://crm.breadking.shop/App/Agregar_Pago.php',
            type: 'POST',
            data: {
                Id_Venta: Id_Venta,
                Id_Usuario: Id_Usuario
            },
            success: function(response) {
                try {
                    // Verificar si la respuesta ya está en formato JSON
                    if (typeof response === 'string') {
                        var jsonResponse = JSON.parse(response);
                    } else {
                        var jsonResponse = response;
                    }
                    console.log(jsonResponse);
                    alert(jsonResponse.Respuesta);
                    // Redirigir si la respuesta contiene "Venta Anulada"
                    if (jsonResponse.Respuesta.includes("GUARDADO OK")) {
                        window.location.href = 'https://crm.breadking.shop/app/vista/reporte_venta/index_reporte_venta.php';
                    }
                } catch (e) {
                    console.error('Error al parsear la respuesta JSON: ', e);
                    alert('Error al pagar la venta. La respuesta no es un JSON válido.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error al pagar la venta: ' + error);
            }
        });
    });

    $('.Anular_Venta').click(function () {
        var Id = $('#id_venta').val();
        var Codigo_Control = $('#Codigo_Control').val(); // Asegúrate de tener este campo en tu HTML

        var JSON_venta = JSON.stringify({
            "Id": Id,
            "Factura": {
                "Codigo_Control": Codigo_Control
            }
        });

        $.ajax({
            url: 'https://crm.breadking.shop/App/Anular_Venta_Reponer_Cambiar_JSON_v1.php',
            type: 'POST',
            data: {JSON_venta: JSON_venta},
            success: function(response) {
                try {
                    // Verificar si la respuesta ya está en formato JSON
                    if (typeof response === 'string') {
                        var jsonResponse = JSON.parse(response);
                    } else {
                        var jsonResponse = response;
                    }
                    console.log(jsonResponse);
                    alert(jsonResponse.Respuesta);
                    // Redirigir si la respuesta contiene "Venta Anulada"
                    if (jsonResponse.Respuesta.includes("Venta Anulada")) {
                        window.location.href = 'https://crm.breadking.shop/app/vista/reporte_venta/index_reporte_venta.php';
                    }
                } catch (e) {
                    console.error('Error al parsear la respuesta JSON: ', e);
                    alert('Error al anular la venta. La respuesta no es un JSON válido.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error al anular la venta.');
            }
        });
    });
});