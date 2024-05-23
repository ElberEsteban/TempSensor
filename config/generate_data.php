<?php
require_once '../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la temperatura del formulario
    $temperature = $_POST['temperature'];

    // Obtener la fecha y hora actual
    date_default_timezone_set('America/Bogota');
    $currentDateTime = date('Y-m-d H:i:s');

    // Consulta SQL para insertar los datos en la tabla temperature_data
    $sql = "INSERT INTO temperature_data (temperature, timestamp) VALUES ('$temperature', '$currentDateTime')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Datos de temperatura insertados correctamente.";
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
?>

<!DOCTYPE html>
<html>
<body>

<h2>Formulario de temperatura</h2>

<form method="post">
  <label for="temperature">Temperatura:</label><br>
  <input type="number" id="temperature" name="temperature" min="0" max="100"><br>
  <input type="submit" value="Submit">
</form> 

</body>
</html>

<?php
}
?>