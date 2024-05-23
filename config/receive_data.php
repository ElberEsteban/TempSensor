<?php
include('db_connection.php');

// Verificar si se han enviado los parámetros 'temperature' y 'timestamp'
if (isset($_GET['temperature']) && isset($_GET['timestamp'])) {
    $temperature = $_GET['temperature'];
    $timestamp = $_GET['timestamp'];

    // Consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO temperature_data (temperature, timestamp) VALUES ('$temperature', '$timestamp')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Datos insertados correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "No se recibieron los parámetros necesarios.";
}
?>
