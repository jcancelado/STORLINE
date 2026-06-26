<?php  session_start();
include("../../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Cosmpatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
<link rel="shortcut icon" href="../../../img/ran__1_-removebg-preview.png" type="image/x-icon">

<script src="../Alert/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="../Alert/sweetalert.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

 <!-- ESTILO CURSOS DE PROGRAMACION -->
 <link rel="stylesheet" href="../../../css/estilos_carro/carro1.css">


<title>Consulta basica</title>
</head>
<body>


<link rel="stylesheet" href="../../../css/php_tienda_tienda4_index.css">


<!-- NAVBAR -->
<?php 

include("../tienda1/nav_cart.php"); 
include("../tienda1/modal_cart.php");

?>





















<!-- vista E -->
<div class="center mt-5">
    <div class="card pt-3" >
            <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Como quieres recibir tu obra</p>
        <div class="container-fluid p-2">
          
          
            <div class="container_card">
            
                        <form id="formulario" name="formulario" method="post" action="cart.php">
                        <div class="blog-post ">
                        <img src="../tienda1/img/interr.jpg" alt="Man">
                        <a target="_blank" class="category">
                        $ 20.000,00
                        </a>
                        <div class="text-content">
                        <input name="ref" type="hidden" id="ref" value="portes" />                           
                        <input name="precio" type="hidden" id="precio" value="20" />
                        <input name="titulo" type="hidden" id="titulo" value="Porter de envio: Empresa 001" />
                        <input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2" />
                        <div class="card-body">
                        <h5 class="card-title">Inter Rapidisimo</h5>
                        <p>24h.</p>
                        <button class="btn btn-primary" type="submit" ><i class="fas fa-shopping-cart"></i> Seleccionar envio</button>
                        </div>
                        </div>
                        </div>
                        </form>



                        <form id="formulario" name="formulario" method="post" action="cart.php">
                        <div class="blog-post ">
                        <img src="../tienda1/img/ENVIA.jpg" alt="Man">
                        <a target="_blank" class="category">
                        $ 10.000,00
                        </a>
                        <div class="text-content">
                        <input name="ref" type="hidden" id="ref" value="portes" />                           
                        <input name="precio" type="hidden" id="precio" value="10" />
                        <input name="titulo" type="hidden" id="titulo" value="Porter de envio: Empresa 002" />
                        <input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2" />
                        <div class="card-body">
                        <h5 class="card-title">Envia</h5>
                        <p>48h.</p>
                        <button class="btn btn-primary" type="submit" ><i class="fas fa-shopping-cart"></i> Seleccionar envio</button>
                        </div>
                        </div>
                        </div>
                        </form>



                        <form id="formulario" name="formulario" method="post" action="cart.php">
                        <div class="blog-post ">
                        <img src="../tienda1/img/servi.jpeg" alt="Man">
                        <a target="_blank" class="category">
                        GRATIS
                        </a>
                        <div class="text-content">
                        <input name="ref" type="hidden" id="ref" value="portes" />                           
                        <input name="precio" type="hidden" id="precio" value="0" />
                        <input name="titulo" type="hidden" id="titulo" value="Porter de envio: Empresa 003" />
                        <input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2" />
                        <div class="card-body">
                        <h5 class="card-title">Servientrega</h5>
                        <p>72h.</p>
                        <button class="btn btn-primary" type="submit" ><i class="fas fa-shopping-cart"></i> Seleccionar envio</button>
                        </div>
                        </div>
                        </div>
                        </form>
               
            </div>
        </div>

      
    </div>
     
    
</div>
<!-- END vista E -->





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>








