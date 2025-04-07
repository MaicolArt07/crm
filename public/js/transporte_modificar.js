$(document).ready(function () {
	var id_transporte = $('#id_transporte').val();
	//alert(id_transporte);
	if(id_transporte!=null){
		$('#dt_detalle_ant').DataTable({
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
			{"data": "Cantidad"},
            {
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                                        "<a class='btn btn-outline btn-info modificarCantidad'><i class='ti-pencil'></i></a>"+
                                    "</div>"
           },
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [
            {
                "targets": [0],
				"orderable": false,
				"visible": true
            },
            {
                "targets": 5,
                "className": "text-center"
            }
        ]
		});
	}
	
	
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
        "order": [[0, "desc"]]
    });
	
	
	
    $("#dt_ordenproduccion").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
		"ajax": "../../negocio/NOrden_Produccion.php?funcion=detalle",
        "columns": [
            {"data": "Id_Producto"},
            {"data": "Nombre"},
            {"data": "Cantidad_Disponible"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": [0],
            "visible": false
        }],
        "order": [[1, "asc"]]
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
	
    $('#dt_detalle_ant').on('click', '.modificarCantidad', function() {
        var row = $(this).closest('tr');
        var id_detalle = row.find('td').eq(0).text(); // Obtener el ID de detalle de la fila
        var cantidad_actual = parseInt(row.find('td').eq(4).text()); // Obtener la cantidad actual
        var cantidad_disponible = parseInt(row.find('td').eq(3).text()); // Obtener la cantidad disponible
    
        // if(cantidad_actual == cantidad_disponible)
        // {
            //     if(confirm("Las cantidades son iguales, ¿Deseas eliminar el detalle?"))
            //     {
            //         $.ajax({
            //             url: '../../negocio/NDetalle_Transporte.php?funcion=eliminar_detalle_transporte', // Asegúrate de tener esta función en tu PHP
            //             type: 'POST',
            //             data: {
            //                 id_detalle: id_detalle,
            //             },
            //             success: function(response) 
            //             {
            //                 console.log(response);
            //                 if(response) {
            //                     $('#dt_detalle_ant').DataTable().ajax.reload();
            //                     // Cerrar el modal
            //                     $('#modal_edit_cantidad').modal('hide');
            //                 } else {
            //                     alert('Error al actualizar la cantidad');
            //                 }
            //             }
            //         });
            //     }
            // }else{
            if (cantidad_disponible > 0) 
            {
                // Llenar el campo del modal con la cantidad actual y disponible
                $('#edit_cantidad')
                    .val(cantidad_actual)
                    .data('cantidad-original', cantidad_actual); // Guardar la cantidad original en un atributo data
        
                $('#edit_cantidad_disponible')
                    .val(cantidad_disponible)
                    .data('cantidad-disponible-original', cantidad_disponible); // Guardar la cantidad disponible original
        
                $('#btn_update_cantidad').data('id_detalle', id_detalle); // Guardar el ID de detalle para actualizarlo
        
                // Abrir el modal
                $('#modal_edit_cantidad').modal('show');
            } else {
                alert("No tienes una cantidad disponible");
            }
        // }


    });
    
    $('#modal_edit_cantidad').on('show.bs.modal', function () {
        cantidadOriginal = parseInt($('#edit_cantidad').val()) || 0;
        cantidadDisponibleOriginal = parseInt($('#edit_cantidad_disponible').val()) || 0;
    
        // También puedes guardarlos en data-atributos si prefieres
        $('#edit_cantidad').data('cantidad-original', cantidadOriginal);
        $('#edit_cantidad_disponible').data('cantidad-disponible-original', cantidadDisponibleOriginal);
    });

// Validar la cantidad a retirar
$('#cantidad_retirar').on('input', function () {
    let retirar = parseInt($(this).val()) || 0;

    if (retirar > cantidadDisponibleOriginal) {
        alert(`No puedes retirar más de lo disponible (${cantidadDisponibleOriginal}).`);
        
        // Restaurar valores
        $('#edit_cantidad').val(cantidadOriginal);
        $('#edit_cantidad_disponible').val(cantidadDisponibleOriginal);
        $(this).val('');
        return;
    }

    // Calcular nuevos valores
    let nuevaCantidad = cantidadOriginal - retirar;
    let nuevoDisponible = cantidadDisponibleOriginal - retirar;

    if (nuevaCantidad < 0 || nuevoDisponible < 0) {
        alert('La cantidad a retirar no puede dejar cantidades negativas.');
        $('#edit_cantidad').val(cantidadOriginal);
        $('#edit_cantidad_disponible').val(cantidadDisponibleOriginal);
        $(this).val('');
        return;
    }

    // Actualizar los campos
    $('#edit_cantidad').val(nuevaCantidad);
    $('#edit_cantidad_disponible').val(nuevoDisponible);
});

// Guardar
$('#btn_update_cantidad').on('click', function () {
    let nueva_cantidad = $('#edit_cantidad').val();
    let cantidad_disponible = $('#edit_cantidad_disponible').val();
    let id_detalle = $(this).data('id_detalle');
    let cantidad_retirar = $('#cantidad_retirar').val();
    if (nueva_cantidad && id_detalle && cantidad_retirar) {
        if (parseInt(cantidad_disponible) < 0) {
            alert('La cantidad disponible no puede ser menor a cero.');
            return;
        }

        $.ajax({
            url: '../../negocio/NDetalle_Transporte.php?funcion=actualizar_detalle_transporte',
            type: 'POST',
            data: {
                id_detalle: id_detalle,
                cantidad: nueva_cantidad,
                disponible: cantidad_disponible
            },
            success: function (response) {
                if (response) {
                    $('#dt_detalle_ant').DataTable().ajax.reload();
                    $('#modal_edit_cantidad').modal('hide');
                    $('#cantidad_retirar').val('');
                } else {
                    alert('Error al actualizar la cantidad.');
                }
            }
        });
    } else {
        alert('Por favor ingrese una cantidad válida.');
    }
});

    // Funcionalidad para modificar la cantidad del transporte


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
	
	$('#fecha').setDateTime();

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
                var id_producto = row_selected[0];
				var producto = row_selected[1];
                var cantidad_disponible = row_selected[2];
                var cantidad_transporte = row_selected[3];
				
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
			let id_transporte = $('#id_transporte').val();
			var id_usuario = $('#usuario :selected').val();
			var fecha = $('#fecha').val();
			var detalle = JSON.stringify(getDetalle());
			//alert('transportar'+ detalle+ ' '+id_transporte);
            $.ajax({
                type: "POST",
                url: "../../negocio/NTransportar.php?funcion=agregar_producto",
                data: {
                    id_usuario: id_usuario,
					id_transporte: id_transporte,
					detalle_transporte: detalle
                },
                success: function (data) {
                    alert(data);
					location.href = 'index_transportes.php';
                    
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
