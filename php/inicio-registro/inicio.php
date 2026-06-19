
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../css/inicio-registro/inicio-sesion.css">
    <link rel="shortcut icon" href="../img/ran__1_-removebg-preview.png" type="image/x-icon">

    <title>Iniciar sesión</title>
    <?php 
    include("../conexion.php");
    ?>
</head>
<body>
    
    <div id="loader"class="hidden">
        <img src="../../img/vectores/hojas.png" alt="Loading...">
      </div> <!-- Agregamos un div para la pantalla de carga -->
      <a href="../../index.php" class="logo">
        <img class="logo" src="../../img/ran__1_-removebg-preview.png" alt="Logo">
      </a>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form  method="POST" action="validar.php" class= "formulario">
                    <h2 class="titu">Iniciar sesión</h2>
                    <div class="inputbox">
                    <img src="../../img/iconos/user.png" alt="">
                        <input type="name" name="NombreUsuario" required>
                        <label for="">Usuario</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="Contrasena" required>
                        <label for="">Contraseña</label>
                    </div>
                    
                    <button class="titu">Ingresar</button>
                    <div class="register">
                        <p>¿No tienes cuenta? <a href="registro.php">Registrate</a></p>
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
</body>
</html>