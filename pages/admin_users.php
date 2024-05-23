<?php
include('../config/db_connection.php');
include('../templates/header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Consulta SQL para obtener la lista de usuarios
$sql = "SELECT * FROM users WHERE status = true";
$result = $conn->query($sql);

// Verificar si se encontraron resultados
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../public/css/admin_style.css"> <!-- Enlace al archivo CSS para administración de usuarios -->
</head>
<body>
    <div class="main-container">
        <h2>Usuarios Registrados</h2>
        <?php
        if ($result->num_rows > 0) {
            // Inicializar la variable $users como un array para almacenar los datos de los usuarios
            $users = array();

            // Iterar sobre los resultados y almacenar cada usuario en el array $users
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }

            // Mostrar la lista de usuarios en una tabla
            echo "<table>";
            echo "<tr><th>Nombre de Usuario</th><th>Perfil</th><th>Acciones</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                // No mostrar el ID del usuario en la tabla, pero pasarlo como parámetro en los enlaces de edición y eliminación
                echo "<td>" . $user["username"] . "</td>";
                echo "<td>" . $user["role"] . "</td>";
                // Verificar si el nombre de usuario no es "admin" para mostrar la opción de eliminar
                if ($user["username"] !== "admin") {
                    echo "<td><a href='edit_user.php?id=" . $user["id"] . "'>Editar</a> | <a href='delete_user.php?id=" . $user["id"] . "' class='delete-link'>Eliminar</a></td>";
                } else {
                    echo "<td><a href='edit_user.php?id=" . $user["id"] . "'>Editar</a></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron usuarios registrados.</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>

<?php include('../templates/footer.php'); ?>
