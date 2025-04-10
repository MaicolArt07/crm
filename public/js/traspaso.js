$(document).ready(function () {

    var id_transporte = $('#id_transporte').val();


    $('#dt_detalle').DataTable({
        "columnDefs": [
            {
                "targets": [1,2,3,4,10],  // Índice de la columna que quieres ocultar (0 basado, o sea la segunda columna)
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
            "url": "../../negocio/NTraspaso.php?funcion=listaDetalleTraspaso",
            "error": function (xhr, error, thrown) {
                console.log("❌ Error al cargar los datos del DataTable");
                console.log("xhr:", xhr);
                console.log("error:", error);
                console.log("thrown:", thrown);
                alert("Error al cargar los datos. Revisa la consola (F12).");
            }
        },
        "columns": [
            { "data": "Id" },
            { "data": "Transporte_Destino" },
            { "data": "Producto" },
            { "data": "Cantidad_Traspaso" }
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
            { "data": "Id" },
            { "data": "Id_Usuario" },
            { "data": "Usuario" },
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": [1],
            "visible": false
        }],
        "order": [[1, "asc"]]
    }); 

    $("#traspaso_destino").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
        ajax: {
            url: "../../negocio/NTraspaso.php?funcion=transportesTranspasos",
            data: function (d) {
                d.id_usuario = $("#id_usuario_transporte").val();
            },
            type: "GET",
            error: function (xhr, error, thrown) {
                console.log("Error en el DataTable AJAX:");
                console.log("Estado: ", xhr.status);
                console.log("Respuesta: ", xhr.responseText);
                console.log("Error: ", error);
            }
        },
        "columns": [
            { "data": "Id" },
            { "data": "Id_Usuario" },
            { "data": "Usuario" },
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "columnDefs": [{
            "targets": [1],
            "visible": false
        }],
        "order": [[1, "asc"]]
    });
    

    $("#producto-transporte").DataTable({
        "paging": true,
        "ordering": true,
        "info": false,
        "searching": true,
        ajax: {
            url: "../../negocio/NTraspaso.php?funcion=productosTransporteOrigen",
            data: function (d) {
                d.id_usuario = $("#id_usuario_transporte").val();
                d.id_transporte = $('#id_transporte_origen').val();
            },
            type: "GET"
        },
        "columns": [
            { "data": "Id" },
            { "data": "Id_Transportar" },
            { "data": "Id_Producto" },
            { "data": "Id_Orden_Produccion" },
            { "data": "Producto" },
            { "data": "Cantidad" },
            { "data": "Disponible" },
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

    $('.insertar-traspaso').click(function () {
        var id_usuario_transporte = $('#id_usuario_transporte').val();
        var usuario = $('#usuario').val();
        var id_transporte_origen = $('#id_transporte_origen').val();
        
        var id_producto = $('#id_producto').val();
        var producto = $('#producto').val();

        var cantidad_disponible = parseFloat($('#cantidad_disponible').val());
        var cantidad_traspaso = parseFloat($('#cantidad_traspaso').val());

        
        var id_transporte_destino = $('#id_transporte_destino').val();
        var transporte_destino = $('#transporte_destino').val();
        var id_usuario_destino = $('#id_usuario_destino').val();
        var id_detalle = $('#id_detalle').val();

        if (id_usuario_transporte != "") {
            if (id_usuario_transporte != "" && id_transporte_origen != ""   ) {
                if (cantidad_traspaso > 0) {
                    // console.log(cantidad_disponible);
                    // console.log(cantidad);
                    if (cantidad_traspaso <= cantidad_disponible) {
                        $('#dt_detalle').dataTable().fnAddData([id_detalle, id_transporte_origen, id_transporte_destino, id_usuario_transporte, id_usuario_destino, producto, usuario,cantidad_disponible, transporte_destino, cantidad_traspaso, id_producto]);
                        clearInput();

                    } else {
                        alert("La Cantidad a transportar debe ser menor o igual a la cantidad disponible");
                        $('#cantidad_traspaso').val(1);
                    }
                } else {
                    alert("La Cantidad a transportar debe ser Mayor a 0");
                }
            } else {
                alert("Ingresar los datos requeridos");
            }

        } else {
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
                var id_transporte_origen = row_selected[1];
                var id_transporte_destino = row_selected[2];
                var id_usuario_transporte = row_selected[3];
                var id_usuario_destino = row_selected[4];
                var producto = row_selected[5];
                var transporte_origen = row_selected[6];
                var cantidad = row_selected[7];
                var transporte_destino = row_selected[8];
                var cantidad_traspaso = row_selected[9];
                var id_producto = row_selected[10];
                
                // Mostrar en consola los valores de cantidad y disponible
                // console.log(cantidad);
                // console.log(disponible);

                // Asignamos los valores a los campos de entrada en el formulario
                $('#id_usuario_transporte').val(id_usuario_transporte);
                $('#usuario').val(transporte_origen);
                $('#id_transporte_origen').val(id_transporte_origen);
                
                $('#id_producto').val(id_producto);
                $('#producto').val(producto);
        
                $('#cantidad_disponible').val(cantidad);
                $('#cantidad_traspaso').val(cantidad_traspaso);
                
                $('#id_transporte_destino').val(id_transporte_destino);
                $('#transporte_destino').val(transporte_destino);
                $('#id_usuario_destino').val(id_usuario_destino);
                $('#id_detalle').val(id_detalle);

                // $('#id_usuario_').val(id_usuario);
                // $('#id_producto').val(id_producto);
            } else {
                console.log("No se pudo obtener la fila seleccionada.");
            }
        }
    });

    $('.modificar-traspaso').click(function () {
        var id_usuario_transporte = $('#id_usuario_transporte').val();
        var usuario = $('#usuario').val();
        var id_transporte_origen = $('#id_transporte_origen').val();
        
        var id_producto = $('#id_producto').val();
        var producto = $('#producto').val();
        
        var cantidad_disponible = parseInt($('#cantidad_disponible').val());
        var cantidad_traspaso = parseInt($('#cantidad_traspaso').val());
        
        var id_transporte_destino = $('#id_transporte_destino').val();
        var transporte_destino = $('#transporte_destino').val();
        
        var id_usuario_destino = $('#id_usuario_destino').val();
        var id_detalle = $('#id_detalle').val();
        
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
                        rowData[0] = id_detalle;
                        rowData[1] = id_transporte_origen;
                        rowData[2] = id_transporte_destino;
                        rowData[3] = id_usuario_transporte;
                        rowData[4] = id_usuario_destino;
                        rowData[5] = producto;
                        rowData[6] = usuario;
                        rowData[7] = cantidad_disponible;
                        rowData[8] = transporte_destino;
                        rowData[9] = cantidad_traspaso;
                        rowData[10] = id_producto;


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

    $('.seleccionar').click(function () 
    {
        var row_selected, usuario, id_usuario;
        $.each($("#traspaso_origen tr.selected"), function () {
            row_selected = table_op.row(this).data();
            id_transporte = row_selected['Id'];
            id_usuario = row_selected['Id_Usuario'];
            usuario = row_selected['Usuario'];
        });

        $('#id_usuario_transporte').val(id_usuario);
        $('#usuario').val(usuario);
        $('#id_transporte_origen').val(id_transporte);

        $('#modal-from-search').hideModal();

        $("#producto-transporte").DataTable().ajax.reload();
        $("#traspaso_destino").DataTable().ajax.reload();
    });

    // Funcionalidad de productos
    var table_producto = $('#producto-transporte').DataTable();
    $("#producto-transporte tbody").on('click', 'tr', function () 
    {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table_producto.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('.seleccionar-producto').click(function () 
    {
        var row_selected, id_producto, producto, cantidad, id_detalle, disponible;
        $.each($("#producto-transporte tr.selected"), function () {
            row_selected = table_producto.row(this).data();
            id_detalle = row_selected['Id'];
            id_producto = row_selected['Id_Producto'];
            producto = row_selected['Producto'];
            cantidad = row_selected['Cantidad'];
            disponible = row_selected['Disponible'];
        });
        
        $('#id_producto').val(id_producto);
        $('#id_detalle').val(id_detalle);
        $('#producto').val(producto);
        $('#cantidad_disponible').val(disponible);
        $('#modal-producto-transporte').hideModal();
        $("#producto-transporte").DataTable().ajax.reload();
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
        var row_selected, id_trasporte, usuario, id_usuario_destino;
        $.each($("#traspaso_destino tr.selected"), function () {
            row_selected = table_destino.row(this).data();
            id_trasporte = row_selected['Id'];
            usuario = row_selected['Usuario'];
            id_usuario_destino = row_selected['Id_Usuario'];

        });
        $('#id_transporte_destino').val(id_trasporte);
        $('#transporte_destino').val(usuario);
        $('#id_usuario_destino').val(id_usuario_destino);
        $('#modal-traspaso-destino').hideModal();

        $("#traspaso_destino").DataTable().ajax.reload();
    });

    // FIN DE LO QUE SE OCUPO

    $('.insertar').click(function () {
        if ($('#form-trasnporte').valid()) {
            //alert('insertar transporte');
            var fecha = $('#fecha').val();
            var detalle = JSON.stringify(getDetalle());
            console.log(detalle);
            //alert('transportar');
            $.ajax({
                type: "POST",
                url: "../../negocio/NTraspaso.php?funcion=insertar",
                data: {
                    fecha: fecha,
                    detalle: detalle
                },
                success: function (data) {
                    alert(data);
                    $('#dt_detalle').DataTable().clear().draw();
                    $('#traspaso_origen').DataTable().ajax.reload();
                    $('#traspaso_destino').DataTable().ajax.reload();
                    $('#producto-transporte').DataTable().ajax.reload();
                    clearInput();
                    // location.href = 'index_traspaso.php';
                }
            });
        }
    });

    function getDetalle() {
        var table_array = [];
        var table = $('#dt_detalle').DataTable();
        var id_usuario = $('#id_usuario').val();
    
        table.rows().every(function () {
            var data = this.data();
    
            var id_detalle = data[0];
            var id_transporte_origen = data[1];
            var id_transporte_destino = data[2];
            var id_usuario_transporte = data[3];
            var id_usuario_destino = data[4];
            var producto = data[5];
            var usuario = data[6];
            var cantidad_disponible = data[7];
            var transporte_destino = data[8];
            var cantidad_traspaso = data[9];
            var id_producto = data[10];
    
            // Agregar al array solo si hay datos mínimos (puedes ajustar la condición si deseas)
            if (id_detalle && id_producto && cantidad_traspaso) {
                table_array.push({
                    "id_detalle": id_detalle,
                    "id_transporte_origen": id_transporte_origen,
                    "id_transporte_destino": id_transporte_destino,
                    "id_usuario_transporte": id_usuario_transporte,
                    "id_usuario_destino": id_usuario_destino,
                    "producto": producto,
                    "usuario": usuario,
                    "cantidad_disponible": cantidad_disponible,
                    "transporte_destino": transporte_destino,
                    "cantidad_traspaso": cantidad_traspaso,
                    "id_producto": id_producto,
                    "id_usuario": id_usuario
                });
            }
        });
    
        console.log(table_array);
        return table_array;
    }
    

    function clearInput() {
        $('#id_usuario_transporte').val('');
        $('#usuario').val('');
        $('#id_transporte_origen').val('');
        
        $('#id_producto').val('');
        $('#producto').val('');
        
        $('#cantidad_disponible').val('');
        //  A cada accion colocamos uno de valor
        $('#cantidad_traspaso').val('1');
        
        $('#id_transporte_destino').val('');
        $('#transporte_destino').val('');
        $('#id_usuario_destino').val('');
        $('#id_detalle').val('');

        // Restablecemos la busqueda de las otras tablas
        $('#traspaso_destino').DataTable().ajax.reload();
        $('#traspaso_origen').DataTable().ajax.reload();
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
