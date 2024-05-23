<?php
require_once '../config/db_connection.php';

// Generar temperatura aleatoria entre 0 y 100
$temperature = rand(0, 100);

// Obtener la fecha y hora actual
$currentDateTime = date('Y-m-d H:i:s');

// Consulta SQL para insertar los datos en la tabla temperature_data
$sql = "INSERT INTO temperature_data (temperature, date_time) VALUES ('$temperature', '$currentDateTime')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Datos de temperatura insertados correctamente.";
} else {
    echo "Error al insertar datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
