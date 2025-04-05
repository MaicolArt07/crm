<?php

//$enviar_factura = new EnviarFactura();
//$enviar_factura->enviar_v2('dd');

class AnularFactura {
	

    function anular($value){        
		$data = "{
        \"Llave\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJTVE9SRVNSTCIsImNvZGlnb1Npc3RlbWEiOiI3NzJEOUNCOEFENzgyMTNFRjk1MzYzNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETXhzREF5TXpRd01nUUFwX2dVUEFrQUFBQT0iLCJpZCI6MzAxNTgyMSwiZXhwIjoxNzE2NDIyNDAwLCJpYXQiOjE2ODQ5NDM1NTQsIm5pdERlbGVnYWRvIjo0MDgyNjEwMjEsInN1YnNpc3RlbWEiOiJTRkUifQ.pn1qTy4H_WhB5f8XYdBU4nk2YxNa0NMPQZuUafPRgkbjE6KBNE6dqQIqZd_6FKzqGf62hn4h3Osm0tlmzLkbpQ\",
        \"Tipo_Pago\":\"Efectivo\",
        \"Fecha\":\"2022-10-28\",
        \"SubTotal\":15,
        \"Descuento\":0,
        \"Total\":15,
        \"Numero_Factura\":590,
        \"NIT\":\"6374102\",
        \"Razon_Social\":\"SN\",
        \"Correo\":\"\",
        \"Total_Literal\":\"Quince 00/100\",
        \"Tipo_Documento\":5,
        \"Complemento\":\"\",
        \"Usuario\":\"Cajero 1\",
        \"Lista_detalle_factura\":[{\"Id_Producto\":5,\"Nombre_Producto\":\"Producto 1\",\"Cantidad\":3,\"Total\":15}]
        }";

        $data ="{\"Llave\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIzMTY4MTYwMjdBYSIsImNvZGlnb1Npc3RlbWEiOiI3NzU0MjEzNTNBNTlEQkNDOEEyNEM1RSIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTJOTE13TkRNd01nY0FWNHp2b3drQUFBQT0iLCJpZCI6NTE5NzYzLCJleHAiOjE3MjM1OTM2MDAsImlhdCI6MTY5MjEzMTU1OSwibml0RGVsZWdhZG8iOjMxNjgxNjAyNywic3Vic2lzdGVtYSI6IlNGRSJ9.FPCX9XY1ZsqC_ZQF7A1x_pn6AwtFSstQvcHiA5zHF3ygx1ssggiwIQ7a6r3_nA6N4MD9C8wdQ8N6kf5_JA4F6Q\",\"Tipo_Pago\":\"Efectivo\",\"Fecha\":\"2022-10-28\",\"SubTotal\":54,\"Descuento\":0,\"Total\":54,\"Numero_Factura\":\"661\",\"NIT\":\"317118023\",\"Razon_Social\":\"SOPHIES
        S.R.L.\",\"Correo\":\"\",\"Total_Literal\":\"cincuenta y
        cuatro\",\"Tipo_Documento\":1,\"Complemento\":\"\",\"Usuario\":\"Cajero\",\"Lista_detalle_factura\":[{\"Id_Producto\":\"21\",\"Nombre_Producto\":\"EMPANADA
        INTEGRAL CON QUESO\",\"Cantidad\":2,\"Total\":16},{\"Id_Producto\":\"24\",\"Nombre_Producto\":\"CUNAPE
        ABIZCOCHADO\",\"Cantidad\":3,\"Total\":30},{\"Id_Producto\":\"23\",\"Nombre_Producto\":\"GALLETA DE AVENA CON
        ALMENDRA\",\"Cantidad\":1,\"Total\":8}]}";

        //echo $data;
        $url = 'https://impuestos.serviciotecnologico.xyz/webserviceimpuestos_anular_factura.php'; // URL del servicio web
        //$url = 'https://impuestos.breadking.shop/webserviceimpuestos_anular_factura.php'; // URL del servicio web


        $data = "{\"Llave\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIzMTY4MTYwMjdBYSIsImNvZGlnb1Npc3RlbWEiOiI3NzU0MjEzNTNBNTlEQkNDOEEyNEM1RSIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTJOTE13TkRNd01nY0FWNHp2b3drQUFBQT0iLCJpZCI6NTE5NzYzLCJleHAiOjE3MjM1OTM2MDAsImlhdCI6MTY5MjEzMTU1OSwibml0RGVsZWdhZG8iOjMxNjgxNjAyNywic3Vic2lzdGVtYSI6IlNGRSJ9.FPCX9XY1ZsqC_ZQF7A1x_pn6AwtFSstQvcHiA5zHF3ygx1ssggiwIQ7a6r3_nA6N4MD9C8wdQ8N6kf5_JA4F6Q\",
            \"Tipo_Pago\":\"Efectivo\",
            \"Fecha\":\"2022-10-28\",
            \"SubTotal\":54,
            \"Descuento\":0,
            \"montoTotal\":54,
            \"Numero_Factura\":\"662\",
            \"NIT\":\"317118023\",
            \"Total_Literal\":\"cincuenta y cuatro\",
            \"Razon_Social\":\"SOPHIES S.R.L.\",
            \"Correo\":\"\",
            \"Tipo_Documento\":5,
            \"Complemento\":\"\",
            \"Usuario\":\"Cajero\",
            \"Lista_detalle_factura\":[{\"Id_Producto\":\"21\",\"Nombre_Producto\":\"EMPANADA INTEGRAL CON QUESO\",\"Cantidad\":2,\"Total\":16},{\"Id_Producto\":\"24\",\"Nombre_Producto\":\"CUNAPE ABIZCOCHADO\",\"Cantidad\":3,\"Total\":30},{\"Id_Producto\":\"23\",\"Nombre_Producto\":\"GALLETA DE AVENA CON ALMENDRA\",\"Cantidad\":1,\"Total\":8}]}";
        
        $data = $value;
        $data =str_replace("NIT","Numero_Documento",$data);
        $data =str_replace("Descuento","descuentoAdicional",$data);
        //$data =str_replace("\"Total\"","\"montoTotal\"",$data);
        $data =str_replace("\"Usuario\"","\"usuario\"",$data);
        //$data =str_replace("Lista_detalle_factura","montoTotal",$data);
        // Encapsular los datos en un array con la clave 'JSON_factura'
        $dataArray = array('JSON_factura' => $data);

        // Iniciar cURL
        $ch = curl_init($url);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataArray));

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'Error en cURL: ' . curl_error($ch);
        } else {
            // Imprimir la respuesta
            //echo $response;
            return $response;
        }

        // Cerrar el recurso cURL
        curl_close($ch);
        //echo "json ".$obj_res['json'];
       // print($obj_res);
    }
}

