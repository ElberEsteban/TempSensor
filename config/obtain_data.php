<?php
include('db_connection.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Función para enviar la notificación por correo
function sendEmailNotification($temperature) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambia esto por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'correo_aquí'; // Cambia esto por tu email
        $mail->Password = 'contraseña_correo'; // Cambia esto por tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // O 'ssl' si tu servidor requiere SSL
        $mail->Port = 587; // Cambia esto si es necesario (587 para TLS, 465 para SSL)

        // Remitente y destinatarios
        $mail->setFrom('esteban.gonzalez@f2x.com.co', 'Notificador de Temperatura en CPD');  // Cambia esto por tu correo y nombre
        $mail->addAddress('esteban.gonzalez@f2x.com.co');  // Cambia esto por el correo del destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Alerta de temperatura alta en CPD';
        $mail->Body    = 'La última temperatura registrada en el CPD es de ' . $temperature . ' grados, que supera el límite permitido.';

        $mail->send();
        echo 'Notificación enviada';
    } catch (Exception $e) {
        echo "No se pudo enviar la notificación. Error: {$mail->ErrorInfo}";
    }
}

// Obtener los valores de filtro (si están presentes)
$fecha = $_GET['fecha'] ?? '';
$temperatura = $_GET['temperatura'] ?? '';

// Construir la consulta SQL base
$sql = "SELECT * FROM temperature_data WHERE 1";

// Agregar condiciones de filtro si se especificaron
if (!empty($fecha)) {
    $sql .= " AND DATE(timestamp) = '$fecha'";
}
if (!empty($temperatura)) {
    $sql .= " AND temperature = $temperatura";
}

// Ejecutar la consulta SQL
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar todos los registros de temperatura en una tabla
    echo "<table>";
    echo "<tr><th>Fecha y Hora</th><th>Temperatura (°C)</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["timestamp"] . "</td><td>" . $row["temperature"] . "</td></tr>";
    }
    echo "</table>";

    // Obtener la última temperatura y fecha
    $result->data_seek($result->num_rows - 1);
    $latestRow = $result->fetch_assoc();
    $latestTemperature = $latestRow['temperature'];
    $latestTimestamp = $latestRow['timestamp'];

    // Obtener el estado actual de la notificación
    $notificationStatusQuery = "SELECT temperature, timestamp, notification_sent FROM notification_status ORDER BY timestamp DESC LIMIT 1";
    $notificationStatusResult = $conn->query($notificationStatusQuery);

    if ($notificationStatusResult->num_rows > 0) {
        $notificationRow = $notificationStatusResult->fetch_assoc();
        $lastNotificationTemperature = $notificationRow['temperature'];
        $lastNotificationTimestamp = $notificationRow['timestamp'];
        $notificationSent = $notificationRow['notification_sent'];

        // Verificar si la fecha de la última temperatura es más reciente que la última notificación
        if ($latestTimestamp > $lastNotificationTimestamp) {
            // Enviar notificación si la temperatura es superior a 50 grados
            if ($latestTemperature > 50) {
                sendEmailNotification($latestTemperature);
                $notificationSent = 'true';
            } else {
                $notificationSent = 'false';
            }

            // Actualizar notification_status con la nueva temperatura, fecha y estado de notificación
            $updateNotificationSql = "UPDATE notification_status SET temperature = $latestTemperature, timestamp = '$latestTimestamp', notification_sent = $notificationSent";
            $conn->query($updateNotificationSql);
        }
    } else {
        // En caso de que no haya registros en notification_status, insertar un registro inicial
        $initialNotificationSent = ($latestTemperature > 50) ? 'true' : 'false';
        $updateNotificationSql = "INSERT INTO notification_status (temperature, timestamp, notification_sent) VALUES ($latestTemperature, '$latestTimestamp', $initialNotificationSent)";
        $conn->query($updateNotificationSql);
    }
} else {
    echo "No se encontraron datos de temperatura en la base de datos.";
}

// Cerrar la conexión
$conn->close();
?>
