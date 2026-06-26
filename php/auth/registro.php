<?php
require_once "../conexion.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $email = mysqli_real_escape_string($cn, $_POST['email']);
    $telefono = mysqli_real_escape_string($cn, $_POST['telefono'] ?? '');
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validaciones
    if (empty($nombre) || empty($email) || empty($password)) {
        $error = "Todos los campos son requeridos";
    } elseif ($password !== $password_confirm) {
        $error = "Las contraseñas no coinciden";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres";
    } else {
        // Verificar si el email ya existe
        $check_query = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $check_result = mysqli_query($cn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "El correo electrónico ya está registrado";
        } else {
            // Encriptar contraseña
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Insertar usuario
            $insert_query = "INSERT INTO usuarios (nombre, email, telefono, password) VALUES ('$nombre', '$email', '$telefono', '$password_hash')";
            
            if (mysqli_query($cn, $insert_query)) {
                $success = "Cuenta creada exitosamente. Redirigiendo...";
                header("refresh:2;url=login.php");
            } else {
                $error = "Error al crear la cuenta: " . mysqli_error($cn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_auth_registro.css">
</head>
<body>
    <div class="register-container">
        <a href="../../index.php" class="back-link">← REGRESAR</a>
        
        <div class="register-header">
             <a href="../../index.php">
            <img src="../../img/logo.png" alt="STORLINE Logo" class="logo-img">
        </a>            <h1>STORLINE</h1>
            <p>Crea tu cuenta de propietario</p>
        </div>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono (Opcional)</label>
                <input type="tel" id="telefono" name="telefono" placeholder="+57 300 123 4567">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="••••••••" minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmar Contraseña</label>
                <input type="password" id="password_confirm" name="password_confirm" required placeholder="••••••••" minlength="6">
            </div>

            <div class="form-group">
                <button type="submit">Crear Cuenta</button>
            </div>
        </form>

        <div class="login-link">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
    </div>
</body>
</html>
