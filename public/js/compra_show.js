$(document).ready(function () {
    
	var id_compra = $('#id_compra').val();
	$('#dt_detalle').DataTable({
		"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
		"ajax": {
            "url": "../../negocio/NDetalle_Compra.php?funcion=detalle",
			"type": "GET",
            "data": {id_compra: id_compra}
        },
        
		"columns": [
            {"data": "Id"},
            {"data": "Id_Insumo"},
            {"data": "Insumo"},
            {"data": "Unidad_Medida"},
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
            }, {
                "targets": 5,
                "className": "text-center"
            }, {
                "targets": [6, 7],
                "className": "text-right"
            }
        ]
    });
});