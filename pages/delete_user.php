<?php
// Verificar si se proporcionó un user_id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Incluir la conexión a la base de datos
    include('../config/db_connection.php');

    // Obtener el ID del usuario a deshabilitar
    $id = $_GET['id'];

    // Verificar si el usuario a deshabilitar no es el administrador
    if ($id !== "1") { // Cambia "1" al ID del usuario administrador
        // Consulta SQL para deshabilitar el usuario
        $sql = "UPDATE users SET status = FALSE WHERE id = $id";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            // Redirigir a admin_users.php después de deshabilitar el usuario
            header("Location: admin_users.php");
            exit();
        } else {
            // Si hay un error al deshabilitar, mostrar un mensaje de error
            echo "Error al deshabilitar el usuario: " . $conn->error;
        }
    } else {
        // Si se intenta deshabilitar al administrador, mostrar un mensaje de error
        echo "No se puede deshabilitar al usuario administrador.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se proporcionó un ID de usuario válido, mostrar un mensaje de error
    echo "ID de usuario no válido.";
}
?>