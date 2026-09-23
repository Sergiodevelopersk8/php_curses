<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        $phpmailer = new PHPMailer();



        try {


            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 587;
            $phpmailer->Username = '740ea467c00249';
            $phpmailer->Password = '2bb91c0ae93923';
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $phpmailer->setFrom('no-reply@tudominio.com', 'Mi sitio');
            $phpmailer->addAddress($this->email);

            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->Subject = 'Confirmación de cuenta';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";
            $phpmailer->Body = $contenido;

            $phpmailer->send();
           
        } catch (Exception $e) {
           // echo "Error al enviar: {$phpmailer->ErrorInfo}";
        }
    }
}
