<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RAN</title>
    <script src="https://kit.fontawesome.com/acd7670049.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/ran__1_-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="../../css/seccion/orquidea.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet"> 
</head>

<body>
    <div id="loader"class="hidden">
        <img src="img/girauwu.png" alt="Loading...">
      </div>
    <header>
        <a href="index.php" class="logo">
            <img class="logo" src="img/ran__1_-removebg-preview.png" alt="Logo">
          </a>
        <nav class="head_titu">
        
           
            <a href="" class="incioh">INICIO</a>
            <a href="#sobreno">ACERCA DE</a>
            <a href="php/inicio.php">INICIAR SESIÓN</a>
            <a href="#portafolio">SERVICIOS</a>
            <a href="#footer">CONTACTO</a>
            <a href="#footer" style="color:transparent;">ola</a>

        </nav>
        <button id="toggle-nav" class="toggle-nav-btn">☰</button>

        <section class="textos-header">
            <h1 style='--content: "ORQUIDEA"; --star-color: #8210f47a; --end-color: #e50bb9da; --delay: 0s;'>ORQUIDEA</h1>

        </section>
        <div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
         </div>
    </header>
    <main>
        <section class="contenedor sobre-nosotros" id="sobreno"> 
            <h2 class="titulo">¿QUIENES SOMOS?</h2>
            <div class="contenedor-sobre-nosotros">
                <img src="img/orquidea.png" alt="" class="imagen-about-us">
                <div class="contenido-textos">
                    <h3><span>1</span>MISIÓN</h3>
                    <p class="parrafo">Crear en las nuevas generaciones una  mas cultura ambiental por medio de aplicativos digitales con el fin de recalcar la importancia de la naturaleza.

                    </p>
                    <h3><span>2</span>VISIÓN</h3>
                    <p class="parrafo">RAN se ve como una de las empresas mas influyentes en la industria de la naturaleza y software llegando a ser una de las empresas mas exitosas en este ámbito. </p>
                </div>
            </div>
        </section>
        <script>
    // Ocultamos la pantalla de carga después de un cierto período de tiempo
    window.addEventListener('load', function(){
        const loader = document.getElementById('loader');
        setTimeout(function(){
            loader.classList.add('fadeOut');
        }, 2000); // 2 segundos de tiempo de carga
    });
</script>
        </html>