$(document).ready(function () {
    $("#dt_sucursales").DataTable({
        "ajax": {
            "url": "../../negocio/NSucursal.php?funcion=listadoSucursales",
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
            {"data": "Nombre"},
            {"data": "Celular"},
            {"data": "Direccion"},
            {"data": "Gps"},
            { "data": null }, // Columna "Estado", pero la llenamos con `fnRowCallback`
            {
                "defaultContent": "<div class='btn-group btn-group-sm'>" +
                    "<a data-toggle='modal' data-target='.bs-modal-form-modificar' class='modificar btn btn-outline btn-info'>" +
                    "<i class='ti-pencil'></i></a>" +
                    "<a class='deshabilitar btn btn-danger btn-outline'>" +
                    "<i class='ti-close'></i></a>" +
                    "</div>"
            }
        ],
        "language": {
            "url": "../../../public/plugins/datatables.net/Spanish.json"
        },
        "responsive": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (aData['Estado'] == 1) {
                $('td:eq(5)', nRow).html("<a href='#' class='label label-success deshabilitar'>Habilitar</a>");
            } else {
                // Cambiar "Deshabilitado" para que sea un enlace con la clase "deshabilitar" 
                $('td:eq(5)', nRow).html(
                    "<a href='#' class='label label-default habilitar'>Deshabilitar</a>"
                );
            }
        },
        "order": [[1, "desc"]]
    });
    

//     $(".insertar").click(function () {
// 		var Id_Grupo_Tienda = $('select[name=Grupo_Tienda]').val();
//         var nombre = $('#nombre').val();
// 		var razon_social = $('#razon_social').val();
//         var nit = $('#nit').val();
//         var coordenadas = $('#Coordenadas').val();
//         var telefono = $('#telefono').val();
//         var contacto = $('#contacto').val();
//         var direccion = $('#direccion').val();

//         $.ajax({
//             type: "POST",
//             url: "../../negocio/NTienda.php?funcion=insertar",
//             data: {
// 				Id_Grupo_Tienda: Id_Grupo_Tienda,
//                 nombre: nombre,
//               razon_social: razon_social,
//                 nit: nit,
//                 telefono: telefono,
//                 contacto: contacto,
//                 coordenadas: coordenadas,
//                 direccion: direccion
//             },
//             success: function (data) {
//                 location.href = 'index_tienda.php';
//                 alert(data);

//             }
//         });
//     });

//     $(".modificar").click(function () {
		
//         var id_tienda = $('#id_tienda').val();
// 		var Id_Grupo_Tienda = $('select[name=Grupo_Tienda]').val();
//         var nombre = $('#nombre_m').val();
//         var razon_social = $('#razon_social_m').val();
//         var nit = $('#nit_m').val();
//         var coordenadas = $('#Coordenadas_m').val();
//         var correo = $('#correo_m').val();
//         var sala = $('#sala_m').val();
//         var localidad = $('#localidad_m').val();
//         var telefono = $('#telefono_m').val();
//         var contacto = $('#contacto_m').val();
//         var direccion = $('#direccion_m').val();
// 		var Frecuencia_Visita = $('#frecuencia_visita_m').val();
// //alert ('correo'+correo);
//         $.ajax({
//             type: "POST",
//             url: "../../negocio/NTienda.php?funcion=modificar",
//             data: {
//                 id_tienda: id_tienda,
// 				Id_Grupo_Tienda: Id_Grupo_Tienda,
//                 nombre: nombre,
//                 razon_social: razon_social,
//                 nit: nit,
//                 telefono: telefono,
//                 contacto: contacto,
//                 correo: correo,
//                 sala: sala,
//                 localidad: localidad,
//                 coordenadas: coordenadas,
//                 direccion: direccion,
// 				Frecuencia_Visita : Frecuencia_Visita
//             },
//             success: function (data) {
//                 location.href = 'index_tienda.php';
//             }

//         });
$('#dt_sucursales tbody').on('click', '.deshabilitar', function () {
    var table = $('#dt_sucursales').DataTable();
    var data = table.row($(this).parents('tr')).data(); 

    $('#id_sucursal_deshabilitar').val(data.Id);

    $('.bs-modal-form-deshabilitar').modal('show');
});

$('#btn-confirmar-deshabilitar').on('click', function () {
    var id = $('#id_sucursal_deshabilitar').val(); // Obtener el ID desde el input oculto

    if (!id) {
        alert("⚠️ No se encontró la sucursal para deshabilitar.");
        return;
    }

    $.ajax({
        type: "POST",
        url: "../../negocio/NSucursal.php?funcion=deshabilitar",
        data: { id_sucursal: id },
        success: function (response) {
            $('.bs-modal-form-deshabilitar').modal('hide'); // Cerrar el modal
            alert("Sucursal deshabilitada correctamente.");
            location.reload(); // Recargar la página para actualizar el estado
        },
        error: function () {
            alert("❌ Error al intentar deshabilitar la sucursal.");
        }
    });
});


$('#dt_sucursales tbody').on('click', '.habilitar', function () {
    var table = $('#dt_sucursales').DataTable();
    var data = table.row($(this).parents('tr')).data(); // Obtiene los datos de la fila
    $('#id_sucursal_habilitar').val(data.Id);

    // Mostrar el modal de deshabilitar
    $('.bs-modal-form-habilitar').modal('show');
});

$('#btn-confirmar-habilitar').on('click', function () {
    var id = $('#id_sucursal_habilitar').val(); // Obtener el ID desde el input oculto

    if (!id) {
        alert("⚠️ No se encontró la sucursal para deshabilitar.");
        return;
    }

    $.ajax({
        type: "POST",
        url: "../../negocio/NSucursal.php?funcion=habilitar",
        data: { id_sucursal: id },
        success: function (response) {
            $('.bs-modal-form-habilitar').modal('hide'); // Cerrar el modal
            location.reload(); // Recargar la página para actualizar el estado
        },
        error: function () {
            alert("❌ Error al intentar deshabilitar la sucursal.");
        }
    });
});

let map, marker;

function initialize() {
    const defaultPosition = { lat: -17.7833, lng: -63.1821 }; // Santa Cruz de la Sierra por defecto

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: defaultPosition,
    });

    marker = new google.maps.Marker({
        position: defaultPosition,
        map: map,
        draggable: true
    });

    google.maps.event.addListener(marker, 'dragend', function (event) {
        document.getElementById("latitud").innerText = event.latLng.lat();
        document.getElementById("longitud").innerText = event.latLng.lng();
        document.getElementById("Coordenadas").value = event.latLng.lat() + "," + event.latLng.lng();
    });

    // Autocompletado de dirección
    const input = document.getElementById('direccion');
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
            alert("No se encontraron coordenadas para esta dirección.");
            return;
        }

        map.setCenter(place.geometry.location);
        marker.setPosition(place.geometry.location);

        const lat = place.geometry.location.lat();
        const lng = place.geometry.location.lng();

        document.getElementById("latitud").innerText = lat;
        document.getElementById("longitud").innerText = lng;
        document.getElementById("Coordenadas").value = lat + "," + lng;
    });
}


    // $(".habilitar").click(function () {
    //     var id_tienda = $('#id_tienda_habilitar').val();
    //     $.ajax({
    //         type: "POST",
    //         url: "../../negocio/NTienda.php?funcion=habilitar",
    //         data: {id_tienda: id_tienda},
    //         success: function (data) {
    //             $('.bs-modal-form-habilitar').hideModal();
	// 			top.alert(data);
    //             location.reload();
    //         }

    //     });
    // });

    // var table = $('#dt_tiendas').DataTable();
    // var tbody = $('#dt_tiendas tbody');
    // $(tbody).on('click', '.modificar', function () {
    //     var data = table.row($(this).parents('tr')).data();
		
    //     location.href = "modificar_tienda.php?Id=" + data.Id + "&G=" + data.Grupo_Tienda + "&N=" + data.Nombre + "&I=" + data.NIT + "&R=" + data.Razon_Social + "&D=" + data.Direccion + "&C=" + data.Coordenadas + "&T=" + data.Telefono + "&A=" + data.Contacto+ "&F=" + data.Frecuencia_Visita+ "&Co=" + data.Correo
    //     + "&Sa=" + data.Sala+ "&Lo=" + data.Localidad;
    // });
    // $(tbody).on('click', '.habilitar', function () {
    //     var data = table.row($(this).parents('tr')).data();
    //     $('#id_tienda_habilitar').val(data.Id);
    // });
});
