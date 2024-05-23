<?php
include('../config/db_connection.php');
include('../templates/header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Temperaturas Registradas</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../public/css/history_style.css"> <!-- Enlace al archivo CSS para el historial -->
</head>
<body>
    <div class="main-container"> <!-- Contenedor principal -->
        <h2>Historial de Temperaturas Registradas</h2>

        <!-- Formulario para filtrar por fecha y temperatura -->
        <form id="filtro-form">
            <div class="form-group">
                <label for="fecha">Filtrar por Fecha:</label>
                <input type="date" id="fecha" name="fecha">
            </div>
            <div class="form-group">
                <label for="temperatura">Filtrar por Temperatura:</label>
                <input type="number" id="temperatura" name="temperatura">
            </div>
            <div class="buttons-group">
                <input type="submit" value="Filtrar">
                <button type="button" id="reset-filtro">Borrar Filtro</button>
            </div>
        </form>

        <!-- Contenedor donde se mostrará la tabla de temperaturas -->
        <div id="tabla-temperaturas"></div>
    </div>

    <!-- Script para actualizar la tabla utilizando AJAX -->
    <script>
    function actualizarTabla() {
        var fecha = $('#fecha').val();
        var temperatura = $('#temperatura').val();

        $.ajax({
            url: '../config/obtain_data.php',
            type: 'GET',
            data: {
                fecha: fecha,
                temperatura: temperatura
            },
            success: function(data) {
                $('#tabla-temperaturas').html(data);
            }
        });
    }

    // Actualizar la tabla al cargar la página
    $(document).ready(function() {
        actualizarTabla(); // Cargar los datos al inicio
        // Comenta la siguiente línea si no deseas actualizar automáticamente cada 10 segundos
        setInterval(actualizarTabla, 10000); // Actualizar cada 10 segundos

        $('#filtro-form').submit(function(event) {
            event.preventDefault();
            actualizarTabla();
        });

        $('#reset-filtro').click(function() {
            $('#fecha').val('');
            $('#temperatura').val('');
            actualizarTabla();
        });
    });
    </script>
</body>
</html>

<?php include('../templates/footer.php'); ?>
