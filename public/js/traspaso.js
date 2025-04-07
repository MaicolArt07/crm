$(document).ready(function () {
    
	var id_transporte = $('#id_transporte').val();


	$('#dt_detalle').DataTable({
        "columnDefs": [
            {
                "targets": [1,2,8],  // Índice de la columna que quieres ocultar (0 basado, o sea la segunda columna)
                "visible": false // Ocultar columna
            }
        ]
    });
	
    $("#dt_traspasos").DataTable({
        "paging": true,
        "ordering": false,
        "info": false,
        "searching": true,
        "ajax": {
            "url": "../../negocio/NTraspaso.php?funcion=listadoTraspasos",
            "error": function (xhr, error, thrown) {
                console.log("❌ Error al cargar los datos del DataTable");
                console.log("xhr:", xhr);
                console.log("error:", error);
                console.log("thrown:", thrown);
                alert("Error al cargar los datos. Revisa la consola (F12).");
            }
        },
        "columns": [
            {"data": "Id"},
            {"data": "Transporte_Origen"},
            {"data": "Transporte_Destino"},
            {"data": "Cantidad_Traspaso"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        }
    });

    $("#traspaso_origen").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
        "ajax": "../../negocio/NTraspaso.php?funcion=detalleTransporteAbiertos",
        "columns": [
            {"data": "Id"},
            {"data": "Usuario"},
            {"data": "Producto"},
            {"data": "Cantidad"},
            {"data": "Disponible"},
            {"data": "Id_Usuario"},
            {"data": "Id_Producto"}
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": [5,6],
            "visible": false
        }],
        "order": [[3, "asc"]]
    });

    $("#traspaso_destino").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
        ajax: {
            url: "../../negocio/NTraspaso.php?funcion=trasportesAbiertos",
            data: function (d) {
                d.id_usuario = $("#id_usuario_transporte").val();
                d.id_producto = $('#id_producto').val();
            },
            type: "GET"
        },
        "columns": [
            {"data": "Id"},
            {"data": "Usuario"},
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
    

	// $('#dt_detalle').DataTable( {
    //     paging: false,
	// 	"columnDefs": [{
    //         "targets": [0],
    //         "visible": false
    //     }],
		
    // } );
	
	$('.insertar-traspaso').click(function () 
    {
        var id_usuario_transporte = $('#id_usuario_transporte').val();
        var usuario = $('#usuario').val();
        var id_producto = $('#id_producto').val();
        var cantidad_disponible = parseFloat($('#cantidad_disponible').val());
        var producto_origen = $('#producto_origen').val();

        var id_transporte = $('#id_transporte').val();
        var usuario_destino = $('#usuario_destino').val();
        var cantidad = parseFloat($('#cantidad_traspaso').val());
        var id_detalle = $('#id_detalle').val();

		if(id_usuario_transporte != "")
		{
			if (id_usuario_transporte != "" && id_transporte != "") {
				if(cantidad>0){
                    console.log(cantidad_disponible);
                    console.log(cantidad);
					if(cantidad <= cantidad_disponible)
                    {
						$('#dt_detalle').dataTable().fnAddData([id_detalle,id_transporte, id_usuario_transporte,cantidad_disponible,usuario,producto_origen,cantidad,usuario_destino, id_producto]);
						
						$('#id_usuario_transporte').clearInput();
						$('#id_detalle').clearInput();
						$('#id_producto').clearInput();
						$('#producto_origen').clearInput();
						$('#usuario').clearInput();
						$('#id_transporte').clearInput();
						$('#cantidad_disponible').clearInput();
						$('#usuario_destino').clearInput();
						$('#cantidad_traspaso').val(1);
					}else{
						alert("La Cantidad a transportar debe ser menor o igual a la cantidad disponible");
						$('#cantidad_traspaso').val(1);
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
    })
	
	//*Listado de compras*//

    // var table = $('#dt_transportes').DataTable();
    // var tbody = $('#dt_transportes tbody');
    // $(tbody).on('click', '.show', function () {
    //     var data = table.row($(this).parents('tr')).data();
    //     location.href = "show_transporte.php?Id=" + data.Id + "&F=" + data.Fecha + "&U=" + data.Usuario + "&E=" + data.Estado;
    // });
    // $(tbody).on('click', '.modificar', function () {
    //     var data = table.row($(this).parents('tr')).data();
    //     location.href = "modificar_transporte.php?id=" + data.Id + "&F=" + data.Fecha + "&U=" + data.Usuario + "&E=" + data.Estado;
    // });
    // $(tbody).on('click', '.cancelar', function () {
    //     var data = table.row($(this).parents('tr')).data();
    //     $('#id_compra').val(data.Id);
    // });
	
	$('#fecha').setDateTime();

	//**Crear compra: modificar y eliminar producto de la tabla**//
    var table_detalle = $('#dt_detalle').DataTable();
    $('#dt_detalle tbody').on('click', 'tr', function () {
        // Verificamos si la fila ya está seleccionada
        if ($(this).hasClass('selected')) {
            // Si ya está seleccionada, la deseleccionamos
            $(this).removeClass('selected');
            $('.insertar-traspaso').show();
            $('.modificar-traspaso').hide();
            $('.eliminar-traspaso').hide();

            clearInput();
        } else {
            // Si no está seleccionada, seleccionamos esta fila
            console.log("Entró por aquí en el detalle");
            // Desmarcar cualquier fila previamente seleccionada
            table_detalle.$('tr.selected').removeClass('selected');
            // Marcar la fila que se acaba de hacer clic
            $(this).addClass('selected');
            
            // Mostrar/ocultar los botones
            $('.insertar-traspaso').hide();
            $('.modificar-traspaso').show();
            $('.eliminar-traspaso').show();
    
            // Obtener los datos de la fila seleccionada
            var row_selected = table_detalle.row(this).data();
            console.log(row_selected);
    
            if (row_selected) {
                // Asignamos los valores obtenidos de la fila a las variables
                var id_detalle = row_selected[0];
                var id_transporte = row_selected[1];
                var id_usuario_transporte = row_selected[2];
                var disponible = row_selected[3];
                var usuario = row_selected[4];
                var producto = row_selected[5];
                var cantidad = row_selected[6];
                var usuario_destino = row_selected[7];
                var id_producto = row_selected[8];

                // var id_producto = row_selected['Id_Producto'];
    
                // Mostrar en consola los valores de cantidad y disponible
                console.log(cantidad);
                console.log(disponible);
    
                // Asignamos los valores a los campos de entrada en el formulario
                $('#id_detalle').val(id_detalle);
                $('#id_transporte').val(id_transporte);
                $('#cantidad_disponible').val(disponible);
                $('#usuario').val(usuario);
                $('#producto_origen').val(producto);
                $('#cantidad_traspaso').val(cantidad);
                $('#usuario_destino').val(usuario_destino);
                $('#id_usuario_transporte').val(id_usuario_transporte);
                $('#id_producto').val(id_producto);


                // $('#id_usuario_').val(id_usuario);
                // $('#id_producto').val(id_producto);
            } else {
                console.log("No se pudo obtener la fila seleccionada.");
            }
        }
    });
	
    $('.modificar-traspaso').click(function () {
        var id_detalle = $('#id_detalle').val();
        var id_transporte = $('#id_transporte').val();
        var cantidad_disponible = parseFloat($('#cantidad_disponible').val());
        var cantidad_traspaso = parseFloat($('#cantidad_traspaso').val());
        var producto_origen = $('#producto_origen').val();
        var usuario_destino = $('#usuario_destino').val();
        var usuario = $('#usuario').val();
        var id_producto = $('#id_producto').val();

        var id_usuario_transporte = $('#id_usuario_transporte').val();
    
        // Verificamos si los campos necesarios están llenos
        if (id_detalle != "" && cantidad_traspaso != "") {
            if (cantidad_traspaso > 0) {
                if (cantidad_traspaso <= cantidad_disponible) {
                    // Recorremos la fila seleccionada en el DataTable para actualizar los valores
                    $.each($("#dt_detalle tr.selected"), function () {
                        // Obtenemos la fila seleccionada en el DataTable
                        var row = table_detalle.row(this); 
    
                        // Actualizamos los datos de la fila en el DataTable
                        var rowData = row.data();
                        rowData[0] = id_detalle; // Id_detalle
                        rowData[1] = id_transporte; // Id_transporte
                        rowData[2] = id_usuario_transporte; // Id_usuario_transporte
                        rowData[3] = cantidad_disponible; // Cantidad_disponible
                        rowData[4] = usuario; // Usuario_destino
                        rowData[5] = producto_origen; // Producto_origen
                        rowData[6] = cantidad_traspaso; // Cantidad_traspaso
                        rowData[7] = usuario_destino; // Usuario_destino
                        rowData[8] = id_producto; // Id Producto
    
                        // Actualizamos los datos de la fila en DataTable
                        row.invalidate().draw(); 
                    });
    
                    // Limpiamos los campos de entrada del formulario
                    clearInput();
    
                    // Desmarcamos la fila seleccionada
                    table_detalle.$('tr.selected').removeClass('selected');
    
                    // Mostramos/ocultamos los botones
                    $(".insertar-traspaso").show();
                    $(".modificar-traspaso").hide();
                    $(".eliminar-traspaso").hide();
                } else {
                    alert("La cantidad a traspasar debe ser menor o igual a la cantidad disponible.");
                }
            } else {
                alert("La cantidad a traspasar debe ser mayor a 0.");
            }
        } else {
            alert("Por favor, ingrese todos los datos requeridos.");
        }
    });
    

	
	$('.eliminar-traspaso').click(function () {
        
        table_detalle.row('.selected').remove().draw(false);
        $(".insertar-traspaso").show();
        $(".modificar-traspaso").hide();
        $(".eliminar-traspaso").hide();

        // Limpiamos los campos de entrada del formulario

        clearInput();
        // $('#id_producto').clearInput();
		// $('#producto').clearInput();
		// $('#cantidad_disponible').clearInput();
		// $('#cantidad_transporte').clearInput();
    });
	
	
    // ESTO SE OCUPO
    var table_op = $('#traspaso_origen').DataTable();
    $("#traspaso_origen tbody").on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_op.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('.seleccionar').click(function () {
        var row_selected, id_detalle, usuario, cantidad, id_usuario, id_producto, disponible, producto;
        $.each($("#traspaso_origen tr.selected"), function () {
            row_selected = table_op.row(this).data();
            id_detalle = row_selected['Id'];
            id_usuario = row_selected['Id_Usuario'];
            id_producto = row_selected['Id_Producto'];
            usuario = row_selected['Usuario'];
            cantidad = row_selected['Cantidad'];
            disponible = row_selected['Disponible'];
            producto = row_selected['Producto'];

        });
        $('#id_usuario_transporte').val(id_usuario);
        $('#id_detalle').val(id_detalle);
        $('#usuario').val(usuario);
        $('#id_producto').val(id_producto);
        $('#cantidad_disponible').val(disponible);
        $('#producto_origen').val(producto);

        $('#modal-from-search').hideModal();

        $("#traspaso_destino").DataTable().ajax.reload();
    });


    var table_destino = $('#traspaso_destino').DataTable();
    $("#traspaso_destino tbody").on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_destino.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('.seleccionar-destino').click(function () {
        var row_selected, id_trasporte, usuario;
        $.each($("#traspaso_destino tr.selected"), function () {
            row_selected = table_destino.row(this).data();
            id_trasporte = row_selected['Id'];
            usuario = row_selected['Usuario'];
        });
        $('#id_transporte').val(id_trasporte);
        $('#usuario_destino').val(usuario);
        $('#modal-traspaso-destino').hideModal();

        $("#traspaso_destino").DataTable().ajax.reload();
    });

    // FIN DE LO QUE SE OCUPO

    $('.insertar').click(function () 
    {
        if ($('#form-trasnporte').valid()) 
        {
            //alert('insertar transporte');
			var id_usuario = $('#id_usuario_transporte').val();
			var fecha = $('#fecha').val();
			var cantidad_traspaso = $('#cantidad_traspaso').val();
			var id_transporte = $('#id_transporte').val();
            var id_detalle = $('#id_detalle').val();
            var detalle = JSON.stringify(getDetalle());
			//alert('transportar');
            $.ajax({
                type: "POST",
                url: "../../negocio/NTraspaso.php?funcion=insertar",
                data: {
                    id_usuario: id_usuario,
					fecha: fecha,
					detalle: detalle
                },
                success: function (data) {
                    alert(data);
                    $('#dt_detalle').DataTable().clear().draw();
                    $('#traspaso_origen').DataTable().ajax.reload();
                    $('#traspaso_destino').DataTable().ajax.reload();
                    clearInput();
					// location.href = 'index_traspaso.php';
                }
            });
        }
    });

    function getDetalle() 
    {
        var table_array = [];
        var table = $('#dt_detalle').DataTable();
    
        table.rows().every(function () {
            var data = this.data();
    
            var idDetalle = data[0];
            var idTransporte = data[1];
            var cantidad = data[6];
            var IdProducto = data[8];

            if (idDetalle && idTransporte && cantidad) {
                table_array.push({
                    "idDetalle": idDetalle,
                    "idTransporte": idTransporte,
                    "cantidad": cantidad,
                    "idProducto": IdProducto
                });
            }
        });
        console.log(table_array);
        return table_array;
    }
    
    function clearInput()
    {
        $('#id_detalle').val('');
        $('#id_transporte').val('');
        $('#id_producto').val('');
        $('#cantidad_disponible').val('');
        $('#producto_origen').val('');
        $('#cantidad_traspaso').val(1);
        $('#usuario_destino').val('');
        $('#usuario').val('');
        $('#id_usuario_transporte').val('');
    }
    
	// function Existe_Producto(Id_Producto){
	// 	Existe = false;
    //     $('#dt_detalle tr').each(function (row, tr) {
    //         if(($(tr).find('td:eq(0)').text())==Id_Producto)
	// 		{
	// 			Existe = true;
	// 		}
    //     });
	// 	return Existe;
	// }
	
});
