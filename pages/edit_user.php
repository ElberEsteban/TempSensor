<?php
include('../config/db_connection.php');
include('../templates/header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se proporcionó un user_id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obtener los datos del usuario
    $sql = "SELECT * FROM users WHERE id = $id";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $user = $result->fetch_assoc();
        
        // Mostrar el formulario para editar el usuario
?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Usuario</title>
            <link rel="stylesheet" type="text/css" href="../public/css/edit_style.css"> <!-- Enlace al archivo CSS para editar usuario -->
        </head>
        <body>
            <div class="main-container"> <!-- Contenedor principal -->
                <div class="edit-container"> <!-- Contenedor para el formulario de edición -->
                    <h2>Editar Usuario</h2>
                    <form method="POST" action="process_edit_user.php">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <div class="form-group">
                            <label for="username">Usuario:</label>
                            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="role">Rol:</label>
                            <select id="role" name="role">
                                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Usuario</option>
                                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Guardar Cambios">
                        </div>
                    </form>
                </div>
            </div>
        </body>
        </html>
<?php
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "ID de usuario no válido.";
}

include('../templates/footer.php');
?>
