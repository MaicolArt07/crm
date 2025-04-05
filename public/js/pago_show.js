$(document).ready(function () {
    
	var id_pago = $('#id_pago').val();
    //alert ("id pago "+id_pago);
	$('#dt_detalle_pago').DataTable({
		"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
		"ajax": {
            "url": "../../negocio/NPago.php?funcion=detalle_pago_Web",
			"type": "GET",
            "data": {id_pago: id_pago},
            "dataSrc": function (json) {
                console.log(json); // Verificar la estructura de la respuesta
                return json.data;  // Asegúrate de que json.data contenga los datos correctos
            }
        },
        
		"columns": [
            {"data": "Venta"},
            {"data": "Tienda"},
            {"data": "NIT"},
            {"data": "Factura"},
            {"data": "Fecha"},
            {"data": "Pago"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0, 1],
                "visible": true
            }, {
                "targets": 5,
                "className": "text-center"
            }
        ]
    });
});