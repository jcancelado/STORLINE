<?php
require '../conexion.php';

$usuario = $_POST['NombreUsuario'];
$contraseña = $_POST['Contrasena'];

$consulta = "SELECT * FROM usuarios WHERE NombreUsuario ='$usuario'";
$resultado = mysqli_query($cn, $consulta);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);

    // Verificar la contraseña utilizando password_verify
    if (password_verify($contraseña, $fila['Contrasena'])) {
        // Contraseña válida: Iniciar sesión
        session_start();

        // Almacenar directamente el rol en la sesión
        $_SESSION['NombreUsuario'] = $usuario;
        $_SESSION['login'] = 1;
        $_SESSION['Rol'] = $fila['Rol']; // Asegúrate de tener el campo 'Rol' en tu tabla de usuarios

        // Redirigir al perfil del usuario
        header("Location: ../perfil.php");
        exit();
    }
}

// Error de autenticación
echo "<script>alert('Error de autenticación')</script>";
header("Location: inicio.php");

mysqli_free_result($resultado);
mysqli_close($cn);
?>
