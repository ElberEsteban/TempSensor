<?php
include('../config/db_connection.php');
include('../templates/header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Aquí estás usando md5 para hashear la contraseña. Considera utilizar métodos más seguros como password_hash().
    $role = $_POST['role'];

    // Verificar si el nombre de usuario ya está en uso
    $sql_check_username = "SELECT * FROM users WHERE username='$username'";
    $result_check_username = $conn->query($sql_check_username);

    if ($result_check_username->num_rows > 0) {
        echo "El usuario ya está registrado. Por favor verificar";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql_insert_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

        if ($conn->query($sql_insert_user) === TRUE) {
            echo "Usuario registrado exitosamente";
        } else {
            echo "Error al registrar el usuario: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" type="text/css" href="../public/css/register_style.css"> <!-- Enlace al archivo CSS para registro -->
</head>
<body>
    <div class="register-container"> <!-- Contenedor para el formulario de registro -->
        <h2>Registrar Nuevo Usuario</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Perfil:</label>
                <select id="role" name="role">
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Registrar">
            </div>
        </form>
    </div>

    <?php include('../templates/footer.php'); ?>
</body>
</html>
