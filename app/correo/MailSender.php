<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailSender {
    private $mail;

    public function __construct($Host,$username, $password) {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = $Host;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
    }

    public function sendMail($Empresa,$to, $toName, $subject, $archivo_adjunto, $body, $altBody = '') {
        try {
            $archivo_adjunto = trim($archivo_adjunto);
            $this->mail->setFrom($this->mail->Username, $Empresa);
            $this->mail->addAddress($to, $toName);
            $this->mail->addBCC('facturas@breadking.shop', 'Nombre Copia Oculta');
            
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody;
            $this->mail->addAttachment($archivo_adjunto);
            //$archivo_adjunto_pdf = str_replace(".xml","",$archivo_adjunto_xm)

            $this->mail->send();
            return 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            return "El mensaje no pudo ser enviado. Error de PHPMailer: {$this->mail->ErrorInfo}";
        }
    }

    public function sendMail_v2($Empresa,$to, $toName, $subject, $body, $altBody = '') {
        try {
            $this->mail->setFrom($this->mail->Username, $Empresa);
            $this->mail->addAddress($to, $toName);
            $this->mail->addBCC('facturas@breadking.shop', 'Nombre Copia Oculta');
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody;

            $this->mail->send();
            return 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            return "El mensaje no pudo ser enviado. Error de PHPMailer: {$this->mail->ErrorInfo}";
        }
    }
}
