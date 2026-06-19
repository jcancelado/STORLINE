<?php  session_start();
include("../../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>

<script src="../Alert/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="../Alert/sweetalert.css">
  <link rel="stylesheet" href="../../css/estilos_carro/carro1.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

 <!-- ESTILO CURSOS DE PROGRAMACION -->


<title>GALERÍA</title>
</head>
<body>



<style>
    
</style>


<!-- NAVBAR -->
<?php 

include("nav_cart.php"); 
include("modal_cart.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


?>

<!-- vista A -->
<div class="center mt-5">
    <div class="card pt-3" >
            <p class="tituloc">GALERÍA</p>
        <div class="container-fluid p-2" style="background-color: ghostwhite;">

            <?php $busqueda=mysqli_query($cn,"SELECT * FROM productos "); 
            $numero = mysqli_num_rows($busqueda); ?>

            <h5 class="card-tittle">Resultados (<?php echo $numero; ?>)</h5>
            <div class="container_card">
              
              <?php while ($resultado = mysqli_fetch_assoc($busqueda)){ 
            
                    ?>

                    <form id="formulario" name="formulario" method="post" action="cart.php">
                        <div class="blog-post ">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($resultado["Imagen"]); ?>" alt="Imagen del producto">
                            <a class="category">
                                $ <?php echo $resultado["Precio"]; ?>
                            </a>
                                <div class="text-content">
                                    <input name="Ref" type="hidden" id="Ref" value="<?php echo $resultado["Ref"]; ?>" />                           
                                    <input name="Precio" type="hidden" id="Precio" value="<?php echo $resultado["Precio"]; ?>" />
                                    <input name="NombreProducto" type="hidden" id="NombreProducto" value="<?php echo $resultado["NombreProducto"]; ?>" />
                                    <input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2" />
                                        <div class="card-body">
                                                <h5 class="card-title2"><?php echo $resultado["NombreProducto"]; ?></h5>
                                                <p class="descrip"><?php echo $resultado["Descripcion"]; ?></p>

                                                <button class="btn btn-primary" type="submit" style="background:#c87fff;"><i class="fas fa-shopping-cart"></i> <h3 class="anadirc">Añadir al carrito<h3></button>
                                        </div>
                                </div>
                        </div>
                    </form>
                    <?php } ?>
            </div>
        </div>
    </div>
                
</div>
<!-- END vista A -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>




