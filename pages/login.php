<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Monitoreo CPD</title>
    <link rel="stylesheet" type="text/css" href="../public/css/login_style.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
<img src="../public/img/logo.png" alt="Logo de mi sitio" id="logo" />
    <?php
    include('../config/db_connection.php');

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND status = true";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: history.php");
        } else {
            echo "Usuario o contraseña incorrectos";
        }
    }

    $conn->close();
    ?>
	
    <div class="header">
        <h1>Sistema de Monitoreo para Temperatura en CPD</h1> <!-- Título grande -->
    </div>
	
    <div class="login-container"> <!-- Contenedor para el formulario -->
        <h2>Iniciar Sesión</h2>
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
                <input type="submit" value="Ingresar">
            </div>
        </form>
    </div>
</body>
</html>
