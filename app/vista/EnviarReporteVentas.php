<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_log("Prueba: Este es un mensaje de error personalizado. EnviarReporteVentas.php", 0);

// Recibe los datos de la  

if (isset($_POST['tabla'])) {
    $tablaData = json_decode($_POST['tabla'], true);
    $emailPara = $_POST['emailPara'];
    $emailCopia = $_POST['emailCopia'];
    $emailAsunto = $_POST['emailAsunto'];
    $emailDetalle = $_POST['emailDetalle'];

    // Crear archivo Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados
    $headers = ["Numero_Factura", "NIT", "Razon_Social", "Codigo_Control", "Fecha", "Total", "Descuento", "SubTotal", "Estado"];
    $sheet->fromArray($headers, null, 'A1');

    // Contenido de la tabla
    $row = 2;
    foreach ($tablaData as $record) {
        $sheet->fromArray(array_values($record), null, "A$row");
        $row++;
    }

    // Guardar el archivo temporal
    $filePath = sys_get_temp_dir() . '/ReporteVentas.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Cambia por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'facturas@breadking.shop'; // Tu correo
        $mail->Password = 'Oscarcuba1Breadking.'; // Tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('facturas@breadking.shop', 'BreadKing');
        $mail->addAddress($emailPara); // Destinatario del correo
        if (!empty($emailCopia)) {                           // Verifica si hay un correo en copia
            $mail->addCC($emailCopia);                       // Agrega el correo en copia (CC)
        }

        $mail->isHTML(true);
        $mail->Subject = $emailAsunto;
        $mail->Body = $emailDetalle;

        // Adjuntar el archivo Excel
        $mail->addAttachment($filePath, 'ReporteVentas.xlsx');

        // Enviar correo
        $mail->send();

        // Eliminar archivo temporal
        unlink($filePath);

        echo "Correo enviado exitosamente.";
    } catch (Exception $e) {
        echo "Error al enviar correo: " . $mail->ErrorInfo;
    }

} else {
    echo "No se recibieron datos de la tabla.";
}
