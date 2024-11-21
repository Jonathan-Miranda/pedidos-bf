<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output value(SMTP::DEBUG_SERVER)
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.farmaciasgi.com.mx';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'aprende_gi@farmaciasgi.com.mx';                     //SMTP username
    $mail->Password   = "f&2y{%*))}Q,";                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` ||465

    //Recipients
    $mail->setFrom('aprende_gi@farmaciasgi.com.mx', 'Farmacias Gi');//desde donde se envia
    //donde llega
    $mail->addAddress('jonathan.miranda@brudifarma.com.mx','Biblioteca FGi');
    // $mail->addAddress('rcoronel@farmaciasgi.com','Biblioteca FGi');
    // $mail->addAddress('sandra.ruiz@brudifarma.com.mx','Biblioteca FGi');

    //Attachments
    $mail->addAttachment($directorio.$nombreArchvio);
    //Content
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Datos del nuevo usuario : '.$name;
    $mail->Body    = $name.' '.$lastmane.
                    '<br>Correo electronico: '.$email.'<br>
                    Sucursal: '.$sucursal.'<br>
                    Estado: '.$edo;

    $mail->send();
    // echo json_encode('exito');
    echo "ok";
} catch (Exception $e) {
    // echo "Error {$mail->ErrorInfo}";
    // echo json_encode('error');
    echo "error";
}

?>