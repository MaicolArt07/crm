<?php
// sendMailInBackground.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'MailSender.php';

// Recoger los datos enviados a través de argumentos de línea de comandos

$Hostmail = $argv[1];
$username = $argv[2];
$password = $argv[3];

$Empresa = $argv[4]; 
$to = $argv[5];
$toName = $argv[6];
$subject = $argv[7];
$body = $argv[8];
$archivo_adjunto_xml = $argv[9];
//$archivo_adjunto_xml = 'FacturasXMLOnline/facturaElectronicaCompraVenta1911.xml';


$mailSender = new MailSender($Hostmail,$username, $password);
$result = $mailSender->sendMail($Empresa,$to, $toName, $subject,$archivo_adjunto_xml, $body);

echo $result;
