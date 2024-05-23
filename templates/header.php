<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Monitoreo CPD</title>
    <link rel="stylesheet" href="../public/css/header_style.css"> <!-- Enlaza tu archivo CSS para el header -->
</head>
<body>
    <nav>
        <ul>
			<img src="../public/img/logo2.png" alt="Logo de mi sitio" id="logo" />
            <li><a href="history.php">Historial de Registros</a></li>
            <?php
            session_start();
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo '<li><a href="register.php">Registrar Usuario</a></li>';
                echo '<li><a href="admin_users.php">Administrar Usuarios</a></li>';
            }
            if (isset($_SESSION['username'])) {
                echo '<li><a href="logout.php">Logout (' . $_SESSION['username'] . ')</a></li>';
            } else {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </nav>
</body>
</html>


