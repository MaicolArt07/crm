$(document).ready(function () {
    

	
    $('#grupotienda').on('input', function () {
        
        
        var id_grupotienda = $(this).val();
        if(id_grupotienda!="0"){
            var nombre_grupotienda = $(this).find('option:selected').text();
            $('#Tienda_Grupo_Tienda').val(nombre_grupotienda);
            $('#tienda').val("0");
            Listar_Ventas_Pendiente_Pago();
            $('#totalpagar').val("");
        }
        
    });

    $('#tienda').on('input', function () {
        
        var id_tienda = $(this).val();
        if(id_tienda!="0"){
            var nombre_tienda = $(this).find('option:selected').text();
            $('#Tienda_Grupo_Tienda').val(nombre_tienda);
            $('#grupotienda').val("0");
            Listar_Ventas_Pendiente_Pago();
            $('#totalpagar').val("");
        }
    });

    $('#totalpagar').on('input', function () {
        var totalpagar = parseFloat($(this).val()) || 0; // Total a pagar ingresado
        var sumaTotal = 0; // Acumulador de los totales seleccionados
    
        // Obtener todas las filas (incluso las no visibles) y desmarcar sus checkboxes
        var rows = $('#dt_ventas').DataTable().rows().nodes(); // Todas las filas del DataTable
    
        $(rows).each(function () {
            var checkbox = $(this).find('.venta-checkbox');
            checkbox.prop('checked', false).removeClass('venta-completa venta-incompleta'); // Desmarcar
            $(this).find('.monto-a-pagar').text('0.00'); // Reiniciar monto a pagar
        });
    
        // Recorrer las filas en orden ascendente por Id_Venta para seleccionar las que cumplan el total
        $(rows).each(function () {
            var checkbox = $(this).find('.venta-checkbox');
            var totalVenta = parseFloat($(this).find('td:eq(6)').text()) || 0;
            var montoPagarSpan = $(this).find('.monto-a-pagar'); // Elemento para mostrar el monto a pagar
    
            // Si el total restante es suficiente para cubrir la venta completa
            if (sumaTotal + totalVenta <= totalpagar) {
                checkbox.prop('checked', true).addClass('venta-completa'); // Marcar y aplicar clase verde
                montoPagarSpan.text(totalVenta.toFixed(2)); // Mostrar el total de la venta como pagado
                sumaTotal += totalVenta; // Actualizar el acumulador
            } else {
                // Si no alcanza para la venta completa, poner lo que sobra
                var restante = totalpagar - sumaTotal;
                if (restante > 0) {
                    checkbox.prop('checked', true).addClass('venta-incompleta'); // Marcar y aplicar clase naranja
                    montoPagarSpan.text(restante.toFixed(2)); // Mostrar el monto restante como pagado
                    sumaTotal += restante; // Actualizar el acumulador
                }
                return false; // Salir del bucle una vez que se agote el total disponible
            }
        });
    
        // Mostrar la suma total seleccionada en la consola (opcional)
        console.log('Total pagado: ' + sumaTotal.toFixed(2));
    });

    function Listar_Ventas_Pendiente_Pago(){
        var id_grupotienda = $('#grupotienda').val();
        var id_tienda = $('#tienda').val();

        if ($.fn.DataTable.isDataTable('#dt_ventas')) {
            $('#dt_ventas').DataTable().clear().destroy();
        }
        //alert("Listando ventas GT: "+id_grupotienda+" T:"+id_tienda);
        $("#dt_ventas").DataTable({
            "ajax": {
                "url": "../../negocio/NVenta.php?funcion=Listar_Ventas_Pendiente_Pago",
                "type": "POST",
                "data": {
                    id_grupotienda: id_grupotienda,
                    id_tienda: id_tienda
                },
            },
            "columns": [
                { "data": "Id_Venta" },
                { "data": "Tienda" },
                { "data": "NIT" },
                { "data": "Factura" },
                { "data": "Fecha" },
				{
                    "data": "Total",
					"className": "text-right",
					"render": function(data, type, row) {
						return parseFloat(data).toFixed(2);
					}
				},
                { 
                    "data": "MontoPorPagar",
                    "className": "text-right",
					"render": function(data, type, row) {
						return parseFloat(data).toFixed(2);
					}
                },
                { 
                    "data": null, 
                    "render": function (data, type, row) {
                        return '<input type="checkbox" class="venta-checkbox" data-total="' + row.MontoPorPagar + '" >';
                    },
                    "orderable": false
                },
                { 
                    "data": null, 
                    "className": "text-right",
                    "render": function () {
                        return '<span class="monto-a-pagar">0.00</span>';
                    },
                    "orderable": false
                }
            ],
            "pageLength": 10,
            "language": {
                "url": "../../../public/plugins/datatables.net/Spanish.json"
            },
            "columnDefs": [{
                "targets": 0,
                "visible": true
            }, 
             
            {type: 'date-eu', targets: 1}],
            
            "order": [[0, "asc"]],
            "footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};
	 
				// Total over all pages
				total = api
					.column( 5 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Total over this page
				pageTotal = api
					.column( 5, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
                    let totalFormateado = total.toLocaleString('en-US', { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    });

                    let pageTotalFormateado = pageTotal.toLocaleString('en-US', { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    });
				// Update footer
				$( api.column( 5 ).footer() ).html(
					''+ totalFormateado +' - '+ pageTotalFormateado 
				);
			}
            
        });
    }

    function actualizarTotalPagar() {
        let totalPagar = 0;

        // Iterar sobre todas las filas, incluso las no visibles
        let rows = $('#dt_ventas').DataTable().rows().nodes();

        $(rows).each(function () {
            let checkbox = $(this).find('.venta-checkbox:checked');
            if (checkbox.length) {
                let total = parseFloat(checkbox.data('total')) || 0;
                totalPagar += total;
            }
        });

        // Actualizar el campo totalpagar
        $('#totalpagar').val(totalPagar.toFixed(2));
    }

    $(document).on('click', '.venta-checkbox', function () {
        let checkbox = $(this);
        let total = parseFloat(checkbox.data('total')) || 0;
        let montoPagarSpan = checkbox.closest('tr').find('.monto-a-pagar');

        if (checkbox.is(':checked')) {
            // Mostrar el total y verificar si el monto pagado es completo
            montoPagarSpan.text(total.toFixed(2));

            if (parseFloat(montoPagarSpan.text()) === total) {
                montoPagarSpan.css('color', 'green');
                checkbox.removeClass('venta-incompleta').addClass('venta-completa');
            } else {
                montoPagarSpan.css('color', 'orange');
                checkbox.removeClass('venta-completa').addClass('venta-incompleta');
            }
        } else {
            // Si se deselecciona, poner el valor en 0 y remover las clases
            montoPagarSpan.text('0.00');
            montoPagarSpan.css('color', 'black');
            checkbox.removeClass('venta-completa venta-incompleta');
        }

        // Actualizar el total a pagar
        actualizarTotalPagar();
    });

    $('.insertar').click(function () {
        //alert('insertar pago');
        if ($('#form-pago').valid()) {
            //alert('insertar pago');
			var id_usuario = $('#id_usuario').val();
            var tienda_grupo_tienda = $('#Tienda_Grupo_Tienda').val();
            var totalpagar = $('#totalpagar').val();
            var codigo_documento = $('#codigo_documento').val();
            var metodoPago = $('#metodoPago').val();
			var ventas_a_pagar= JSON.stringify(getVentas_Seleccionadas());
            if(ventas_a_pagar!="[]"){
                //alert(id_usuario+" "+fecha+" "+totalpagar+" "+codigo_documento+" "+metodoPago+" ");
                $.ajax({
                    type: "POST",
                    url: "../../negocio/NPago.php?funcion=guardar_pago_masivo",
                    data: {
                        id_usuario: id_usuario,
                        tienda_grupo_tienda,tienda_grupo_tienda,
                        metodoPago: metodoPago,
                        codigo_documento:codigo_documento,
                        totalpagar: totalpagar,
                        ventas_a_pagar: ventas_a_pagar
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pago Registrado',
                            text: data,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.href = 'index_pago.php';
                        });
                        
                    }

                });
            }
            else{
                Swal.fire({
                    icon: 'warning', // Cambia a warning
                    title: 'Advertencia',
                    text: "Debe seleccionar al menos una venta para pagar", // Mostrar el mensaje recibido del servidor
                    confirmButtonText: 'Aceptar'
                });
            }
			
        }
    });

	function getVentas_Seleccionadas() {
        var ventas_array = [];
        var table = $('#dt_ventas').DataTable(); // Obtiene la instancia de DataTable
    
        // Recorremos todas las filas del DataTable, incluidas las que no están visibles
        table.rows().nodes().each(function (row, index) {
            var checkbox = $(row).find('.venta-checkbox:checked'); // Verifica si está seleccionado
    
            if (checkbox.length > 0) { // Si está marcado
                var id_venta = $(row).find('td:eq(0)').text(); // Obtén el Id_Venta
                var monto = $(row).find('.monto-a-pagar').text(); // Obtén el monto a pagar
    
                ventas_array.push({
                    venta: id_venta,
                    monto: parseFloat(monto) || 0
                });
            }
        });
    
        return ventas_array; // Retorna las ventas seleccionadas
    }

    $('#fecha').setDateTime();
});