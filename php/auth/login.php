<?php
require_once "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($cn, $_POST['email']);
    $password = $_POST['password'];

    // Buscar el usuario
    $query = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($cn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verificar contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_auth_login.css">
</head>
<body>
    <div class="login-container">
        <a href="../../index.php" class="back-link">← REGRESAR</a>
        
        <div class="login-header">
             <a href="../../index.php">
            <img src="../../img/logo.png" alt="STORLINE Logo" class="logo-img">
        </a>
            <h1>STORLINE</h1>
            <p>Iniciar sesión en tu cuenta</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="form-group">
                <button type="submit">Iniciar Sesión</button>
            </div>
        </form>

        <div class="register-link">
            ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>
