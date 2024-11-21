<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';


if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {

    $email_template = 'template-notipw.html';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output value(SMTP::DEBUG_SERVER)
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.brudifarma.com.mx';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'catalogo@brudifarma.com.mx';                     //SMTP username
        $mail->Password   = "<k4t4J0,3#i={28";                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` ||465

        //Recipients
        $mail->setFrom('catalogo@brudifarma.com.mx', 'Brudifarma'); //desde donde se envia
        $mail->addAddress($correo, 'Brudifarma');     //donde llega

        //Attachments
        // $mail->addAttachment();

        // unlink($directorio.$nombreArchvio);
        //Content
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Restablecer contraseña - Brudifarma|Catalogo';
        $ms = file_get_contents($email_template);
        $ms = str_replace('%correo%', $correo, $ms);
        $mail->msgHTML($ms);
        $mail->AltBody = 'En cualquier navegador pega el siguiente enlace para poder restablecer tu contraseña /src/resetpw.php?mail=' . $correo . '';

        $mail->send();
        // echo json_encode('exito');
        echo "1";
    } catch (Exception $e) {
        // echo "Error {$mail->ErrorInfo}";
        // echo json_encode('error');
        echo "2";
    }
} else {
    echo "2";
}
?>