<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../img/ran__1_-removebg-preview.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/acd7670049.js" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="../../css/inicio-registro/registro.css">
  <title>Registro</title>
  <?php 
    include("../conexion.php");
    ?>
</head>
<body>
    <div id="loader"class="hidden">
    <img src="../../img/vectores/hojas.png" alt="Loading...">
      </div> 
      <a href="../index.php" class="logo">
        <img class="logo" src="../../img/ran__1_-removebg-preview.png" alt="Logo">
      </a>
    <section>
        <div class="form-box">
            <div class="form-value">
            <form method="POST" action="registro.php" class= "formulario">
                    <h2 class="titu">Registro</h2>
                    <div class="inputbox">
                        <img src="../img/id-card.png" alt="">

                        <input type="name" name="Nombres" required>
                        <label for="">Nombres</label>
                    </div>
                    <div class="inputbox">

                        <input type="name" name="Apellidos" required>
                        <label for="">Apellidos</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="Correo" required>
                        <label for="">Correo</label>
                    </div>
                    <div class="inputbox">
                       <img src="../img/user.png" alt="">
                 <input type="name" name="NombreUsuario" required>
                        <label for="">Usuario</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="Contrasena" required>
                        <label for="">Contraseña</label>
                    </div>
                    <div class="inputbox">
                    <label for="" id="tipo">Tipo de documento</label>
                    <select
        className="form-control"
        name="TipoDocumento"
    >
        <option>Ingrese el tipo de documento</option>
        <option value="1">Cédula de Ciudadanía</option>
        <option value="2">Tarjeta de Identidad</option>
    </select>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="text" name="Documento" required>
                        <label for="">Documento</label>
                    </div>
                    
                    
                    <button class="titu" name="insert" type="submit" value="Registrarse">Crear cuenta</button>
                    <div class="register">
                        <p>¿Ya tiene cuenta? <a href="inicio.php">Iniciar sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        // Ocultamos la pantalla de carga después de un cierto período de tiempo
        window.addEventListener('load', function(){
            const loader = document.getElementById('loader');
            setTimeout(function(){
                loader.classList.add('fadeOut');
            }, 2000); // 2 segundos de tiempo de carga
        });
    </script>
    <?php

// Incluir el archivo de conexión a la base de datos
require '../conexion.php';

// Comprobar si se ha enviado el formulario de registro
if (isset($_POST['insert'])) {
    // Recuperar los datos del formulario
    $nombre = $_POST['Nombres'];
    $apellido = $_POST['Apellidos'];
    $correo = $_POST['Correo'];
    $usuario = $_POST['NombreUsuario'];
    $contraseña = $_POST['Contrasena'];
    $tipodocumento = $_POST['TipoDocumento'];
    $documento = $_POST['Documento'];


    // Encriptar la contraseña utilizando password_hash
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe en la base de datos
    $consulta_existencia_correo = "SELECT * FROM usuarios WHERE Correo='$correo'";
    $consulta_existencia_usuario = "SELECT * FROM usuarios WHERE NombreUsuario='$usuario'";
    $resultado_existencia_correo = mysqli_query($cn, $consulta_existencia_correo);
    $resultado_existencia_usuario = mysqli_query($cn, $consulta_existencia_usuario);

    if (mysqli_num_rows($resultado_existencia_correo) > 0) {
        // Ya existe una cuenta con este correo. Por favor, utiliza otro correo.
        echo "<script>alert('Ya existe una cuenta con este correo. Por favor, utiliza otro correo.');</script>";
    } elseif (mysqli_num_rows($resultado_existencia_usuario) > 0) {
        // Ya existe una cuenta con este nombre de usuario. Por favor, elige otro nombre de usuario.
        echo "<script>alert('Ya existe una cuenta con este nombre de usuario. Por favor, elige otro nombre de usuario.');</script>";
    } else {
        // No existe un registro con el mismo correo ni nombre de usuario, se puede insertar
        $insertar = "INSERT INTO usuarios (Nombres, Apellidos, Correo, NombreUsuario, Contrasena, TipoDocumento, Documento, Rol) VALUES ('$nombre','$apellido', '$correo', '$usuario', '$contraseña_encriptada', '$tipodocumento','$documento', 1)";
        $ejecutar = mysqli_query($cn, $insertar);

        if ($ejecutar) {
            // Registro exitoso
            echo "<script>alert('Registro exitoso.');</script>";
            header("Location: inicio.php");
            exit();
        } else {
            echo "<script>alert('Registro fallido.');</script>";

            // Error en la consulta
            echo "Error en la consulta: " . mysqli_error($cn);
        }
    }
}
?>
<?php
// Cerrar la conexión a la base de datos
mysqli_close($cn);
?>

</body>
</html>