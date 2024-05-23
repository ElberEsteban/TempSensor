<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir la conexión a la base de datos
    include('../config/db_connection.php');

    // Obtener los datos del formulario
    $id = $_POST['id'];
    $role = $_POST['role'];

    // Verificar si se proporcionó una nueva contraseña
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']); // Recuerda cifrar la contraseña si es necesario
        // Consulta SQL para actualizar la contraseña y el rol del usuario
        $sql = "UPDATE users SET password='$password', role='$role' WHERE id=$id";
    } else {
        // Consulta SQL para actualizar solo el rol del usuario
        $sql = "UPDATE users SET role='$role' WHERE id=$id";
    }

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // Si la actualización fue exitosa, redirigir a admin_users.php con un mensaje de éxito
        session_start();
        $_SESSION['success_message'] = "Cambios guardados correctamente.";
        header("Location: admin_users.php");
        exit();
    } else {
        // Si hubo un error en la actualización, redirigir a admin_users.php con un mensaje de error
        session_start();
        $_SESSION['error_message'] = "Error al guardar los cambios: " . $conn->error;
        header("Location: admin_users.php");
        exit();
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se recibieron los datos del formulario, redirigir a admin_users.php con un mensaje de error
    session_start();
    $_SESSION['error_message'] = "No se recibieron los datos del formulario.";
    header("Location: admin_users.php");
    exit();
}
?>