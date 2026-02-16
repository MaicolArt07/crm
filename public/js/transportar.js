$(document).ready(function () {
	var id_transporte = $('#id_transporte').val();
	//alert(id_transporte);
	if(id_transporte!=null)
    {
		$('#dt_detalle').DataTable({
		"paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
		"ajax": {
            "url": "../../negocio/NDetalle_Transporte.php?funcion=detalle_modificar",
			"type": "GET",
            "data": {id_transporte: id_transporte}
        },
        
		"columns": [
			{"data": "Id_Detalle_Transporte"},
            {"data": "id_producto"},
            {"data": "Nombre"},
            {"data": "Saldo"},
			{"data": "Cantidad"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0],
				"orderable": false,
				"visible": true
            }, {
                "targets": 3,
                "className": "text-right"
            }
        ]
		});
	}

       // OBTENEMOS TODOS LOS PRODUCTOS DETALLE DE ESE TRANSPORTE QUE ESTA TODAVIA ABIERTO PARA COLOCARLO EN TABLA DEL TRANSPORTE

       $('#transportes_abiertos').on('change', function () {
        var id_transporte = $(this).val();
        if (id_transporte !== '') {
            var table = $('#dt_detalle').DataTable({
                "destroy": true,
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
                "ajax": {
                    "url": "../../negocio/NDetalle_Transporte.php?funcion=detalle",
                    "type": "GET",
                    "data": { id_transporte: id_transporte },
                    "dataSrc": function (json) {
                        // Filtrar los datos para asegurarse de que la cantidad disponible sea mayor a 0
                        var filteredData = json.data.filter(function(item) {
                            return item.Saldo > 0;  // Validación de que el saldo (cantidad disponible) es mayor a 0
                        });
                        // Convertir objetos a arrays y devolver los datos filtrados
                        return filteredData.map(function (item) {
                            return [0, item.Id_Producto, item.Nombre, item.Saldo, item.Saldo];
                        });
                    }
                },
                "columns": [
                    { title: "", "visible": false },   // Primera columna oculta
                    { title: "Id" },                   // id_producto
                    { title: "Producto" },             // Nombre
                    { title: "Cantidad Disponible" },  // Saldo
                    { title: "Cantidad" }              // Inicio
                ],
                "language": {
                    "url": "../../../public/plugins/datatables.net/Spanish.json"
                },
                "columnDefs": [
                    {
                        "targets": 0,
                        "orderable": false,
                        "visible": false  // Hacer la primera columna invisible
                    },
                    {
                        "targets": [3],
                        "className": "text-right" // Alinear "Saldo" a la derecha
                    }
                ],
                "drawCallback": function (settings) {
                    var api = this.api();
                    api.rows().every(function (rowIdx, tableLoop, rowLoop) {
                        var row = this.node();
                        var data = this.data();
    
                        // Aquí puedes añadir una clase para deshabilitar toda la fila
                        // Por ejemplo, una clase llamada 'disabled-row'
                        $(row).addClass('disabled-row');
    
                        data[0] = rowIdx + 1; // Columna Aux = número de fila
                        this.data(data);
                    });
                }
            });
        }
    });
    
    

	
	$("#dt_transportes").DataTable({
        "ajax": "../../negocio/NTransportar.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Fecha"},
            {"data": "Usuario"},
            {"data": "Estado"},
            {
                 "defaultContent": "<div class='btn-group btn-group-sm'>" +
                 
                 "<a class='btn btn-outline btn-primary show'><i class='ti-eye'></i></a>"  +
				 "<a class='btn btn-outline btn-info modificar'><i class='ti-pencil'></i></a>"+
                 "</div>"
            },

        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": 0,
            "visible": false
        },
            {
                "targets": 3,
                "className": "text-center",
                "orderable": true,
            },
			{
                "targets": 4,
                "className": "text-center",
                "orderable": false,
            }
        ],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 0) {
                $('td:eq(2)', nRow).html('<span class="label label-warning">Pendiente</span>');
            }
			if (aData['Estado'] == -1) {
                $('td:eq(2)', nRow).html('<span class="label label-default">Anulada</span>');
            }
			if (aData['Estado'] == 1) {
                $('td:eq(2)', nRow).html('<span class="label label-success">Transportada</span>');
            }
        },
        "order": [[0, "desc"]],
        "initComplete": function(settings, json) {
            console.log(json); // Muestra el JSON en la consola
        }
    });
	

 

	/*$("#dt_transportes").DataTable({
        "ajax": "../../negocio/NTransportar.php?funcion=listado",
        "columns": [
            {"data": "Id"},
            {"data": "Fecha"},
            {"data": "Usuario"},
            {"data": "Estado"},
            {
                 "defaultContent": "<div class='btn-group btn-group-sm'>" +
                 
                 "<a class='btn btn-outline btn-primary show'><i class='ti-eye'></i></a>"  +
				 "<a class='btn btn-outline btn-info modificar'><i class='ti-pencil'></i></a>"+
                 "</div>"
            },

        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": 0,
            "visible": false
        },
            {
                "targets": 3,
                "className": "text-center",
                "orderable": true,
            },
			{
                "targets": 4,
                "className": "text-center",
                "orderable": false,
            }
        ],
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 0) {
                $('td:eq(2)', nRow).html('<span class="label label-warning">Pendiente</span>');
            }
			if (aData['Estado'] == -1) {
                $('td:eq(2)', nRow).html('<span class="label label-default">Anulada</span>');
            }
			if (aData['Estado'] == 1) {
                $('td:eq(2)', nRow).html('<span class="label label-success">Transportada</span>');
            }
        },
        "order": [[0, "desc"]]
    });*/
	
	
	
    $("#dt_ordenproduccion").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
		"ajax": "../../negocio/NOrden_Produccion.php?funcion=detalle",
        "columns": [
            {"data": "Id_Producto"},
            {"data": "Nombre"},
            {"data": "Cantidad_Disponible"},
            {"data": "Orden"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": [3],
            "visible": false
        }],
        "order": [[3, "asc"]]
    });
	$('#dt_detalle').DataTable( {
        paging: false,
		"columnDefs": [{
            "targets": [0],
            "visible": false
        }],
		
    } );
	
	$('.insertar-producto').click(function () {
        var id_producto = $('#id_producto').val();
        var nombre = $('#producto').val();
		var cantidad_disponible = parseInt($('#cantidad_disponible').val());
        var cantidad = parseInt($('#cantidad_transporte').val());
		if(!Existe_Producto(id_producto))
		{
			if (id_producto != "" && cantidad != "") {
				if(cantidad>0){
					if(cantidad <= cantidad_disponible){
						$('#dt_detalle').dataTable().fnAddData([0,id_producto, nombre,cantidad_disponible,cantidad]);
						
						$('#id_producto').clearInput();
						$('#producto').clearInput();
						$('#cantidad_disponible').clearInput();
						$('#cantidad_transporte').val(1);
					}else{
						alert("La Cantidad a transportar debe ser menor o igual a la cantidad disponible");
					}
				}else{
					alert("La Cantidad a transportar debe ser Mayor a 0");
				}
			} else {
				alert("Ingresar los datos requeridos");
			}

		}else{
			alert("el producto ya está en la orden de transporte, si quiere adicionar mas cantidad modifique el detalle");
		}
    });
	
	//*Listado de compras*//

    var table = $('#dt_transportes').DataTable();
    var tbody = $('#dt_transportes tbody');
    $(tbody).on('click', '.show', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "show_transporte.php?Id=" + data.Id + "&F=" + data.Fecha + "&U=" + data.Usuario + "&E=" + data.Estado;
    });
    $(tbody).on('click', '.modificar', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = "modificar_transporte.php?id=" + data.Id + "&F=" + data.Fecha + "&U=" + data.Usuario + "&E=" + data.Estado;
    });
    $(tbody).on('click', '.cancelar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#id_compra').val(data.Id);
    });
	
	// $('#fecha').setDateTime();

	//**Crear compra: modificar y eliminar producto de la tabla**//

    var table_detalle = $('#dt_detalle').DataTable();
    var row_selected = '';
    //var subtotal_producto = 0;
    $('#dt_detalle tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('.insertar-producto').show();
            $('.modificar-producto').hide();
            $('.eliminar-producto').hide();
        } else {
            table_detalle.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#id_producto').prop('disabled', 'disabled');
            $('.insertar-producto').hide();
            $('.modificar-producto').show();
            $('.eliminar-producto').show();
            $.each($("#dt_detalle tr.selected"), function () {
                row_selected = table_detalle.row(this).data();
                var id_producto = row_selected[1];
				var producto = row_selected[2];
                var cantidad_disponible = row_selected[3];
                var cantidad_transporte = row_selected[4];
				console.log(row_selected);
				$('#id_producto').val(id_producto);
				$('#producto').val(producto);
				$('#cantidad_disponible').val(cantidad_disponible);
				$('#cantidad_transporte').val(cantidad_transporte);
                
            });
        }
    });
	
	$('.modificar-producto').click(function () {
		var id_producto = $('#id_producto').val();
        var nombre = $('#producto').val();
		var cantidad_disponible = $('#cantidad_disponible').val();
        var cantidad = $('#cantidad_transporte').val();
		
		if (id_producto != "" && cantidad != "") {
			if(cantidad>0){
				if(cantidad<=cantidad_disponible){
					$.each($("#dt_detalle tr.selected"), function () {
						$(this).find('td').eq(0).text(id_producto);
						$(this).find('td').eq(1).text(nombre);
						$(this).find('td').eq(2).text(cantidad_disponible);
						$(this).find('td').eq(3).text(cantidad);
					});
					$('#id_producto').clearInput();
					$('#producto').clearInput();
					$('#cantidad_disponible').clearInput();
					$('#cantidad_transporte').val(1);
					table_detalle.$('tr.selected').removeClass('selected');
					
					$(".insertar-producto").show();
					$(".modificar-producto").hide();
					$(".eliminar-producto").hide();
				}else{
					alert("La Cantidad a transportar debe ser menor o igual a la cantidad disponible");
				}
			}else{
				alert("La Cantidad a transportar debe ser Mayor a 0");
			}
        } else {
            alert("Ingresar los datos requeridos");
        }
    });
	
	$('.eliminar-producto').click(function () {
        
        table_detalle.row('.selected').remove().draw(false);
        $(".insertar-producto").show();
        $(".modificar-producto").hide();
        $(".eliminar-producto").hide();

        $('#id_producto').clearInput();
		$('#producto').clearInput();
		$('#cantidad_disponible').clearInput();
		$('#cantidad_transporte').clearInput();
    });
	
    var table_op = $('#dt_ordenproduccion').DataTable();
    $("#dt_ordenproduccion tbody").on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_op.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('.seleccionar').click(function () {
        var row_selected, id_producto, producto, cantidad_disponible;
        $.each($("#dt_ordenproduccion tr.selected"), function () {
            row_selected = table_op.row(this).data();
            id_producto = row_selected['Id_Producto'];
            producto = row_selected['Nombre'];
            cantidad_disponible = row_selected['Cantidad_Disponible'];
        });
        $('#id_producto').val(id_producto);
        $('#producto').val(producto);
        $('#cantidad_disponible').val(cantidad_disponible);
        $('#modal-from-search').hideModal();
    });


    $('.insertar').click(function () {
        if ($('#form-trasnporte').valid()) {
            //alert('insertar transporte');
			var id_usuario = $('#usuario :selected').val();
			var fecha = $('#fecha').val();
			var detalle = JSON.stringify(getDetalle());
            var id_transporte = $('#transportes_abiertos').val();

            if (id_transporte && id_transporte !== '') 
            {
                // Hacemos la petición para finalizar el transporte
                $.ajax({
                    type: "POST",
                    url: "../../negocio/NTransportar.php?funcion=finalizar",
                    data: { id_transporte: id_transporte },
                    success: function (data2) {
                        top.alert(data2); // Mostrar alerta final
                        location.href = 'index_transportes.php';
                    },
                    error: function () {
                        alert("Error al finalizar el transporte.");
                    }
                });
            }
            
			//alert('transportar');
            $.ajax({
                type: "POST",
                url: "../../negocio/NTransportar.php?funcion=insertar",
                data: {
                    id_usuario: id_usuario,
					fecha: fecha,
					detalle_transporte: detalle
                },
                success: function (data) {
                    console.log(data);
                    alert(data);
					location.href = 'index_transportes.php';
                    // Si existe algo dentro de el id transporte abiertos finalizamos ese transporte
                }
            });
        }
    });

	function getDetalle() {
        var table_array = new Array();
        $('#dt_detalle tr').each(function (row, tr) {
            table_array[row] = {
                "p": $(tr).find('td:eq(0)').text(),
                "c": $(tr).find('td:eq(3)').text()
            }
        });
        table_array.shift();
        return table_array;
    }
    
	function Existe_Producto(Id_Producto){
		Existe = false;
        $('#dt_detalle tr').each(function (row, tr) {
            if(($(tr).find('td:eq(0)').text())==Id_Producto)
			{
				Existe = true;
			}
        });
		return Existe;
	}
	
});
