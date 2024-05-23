<?php
include('db_connection.php');

// Obtener los parámetros de filtro
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$temperatura = isset($_GET['temperatura']) ? $_GET['temperatura'] : '';

// Construir la consulta SQL con los filtros
$sql = "SELECT * FROM temperature_data WHERE 1=1";

if (!empty($fecha)) {
    $sql .= " AND DATE(timestamp) = '$fecha'";
}

if (!empty($temperatura)) {
    $sql .= " AND temperature = $temperatura";
}

$result = $conn->query($sql);

// Generar el HTML para la tabla de resultados
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Fecha y Hora</th><th>Temperatura (°C)</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["timestamp"] . "</td><td>" . $row["temperature"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron datos de temperatura.";
}

// Cerrar la conexión
$conn->close();
?>
