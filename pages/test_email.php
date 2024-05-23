<?php
require '../config/db_connection.php'; // Ajusta la ruta según tu estructura de carpetas
require '../vendor/autoload.php'; // Ajusta la ruta según tu estructura de carpetas

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuración del servidor de correo
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Cambia esto por tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'esteban.gonzalez@f2x.com.co'; // Cambia esto por tu email
    $mail->Password = 'Soporte2018'; // Cambia esto por tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // O 'ssl' si tu servidor requiere SSL
    $mail->Port = 587; // Cambia esto si es necesario (587 para TLS, 465 para SSL)

    // Configuración del correo
    $mail->setFrom('esteban.gonzalez@f2x.com.co', 'Sistema de Prueba');
    $mail->addAddress('esteban.gonzalez@f2x.com.co'); // Cambia esto por la dirección de correo del destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Prueba de Envío de Correo';
    $mail->Body    = 'Este es un correo de prueba para verificar la configuración de PHPMailer.';

    $mail->send();
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>
