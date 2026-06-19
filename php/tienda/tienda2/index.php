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
<link rel="stylesheet" href="../../css/estilos_carro/carro2.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
<link rel="shortcut icon" href="../../../img/ran__1_-removebg-preview.png" type="image/x-icon">

<script src="../Alert/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="../Alert/sweetalert.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

 <!-- ESTILO CURSOS DE PROGRAMACION -->
 <link rel="stylesheet" href="../../../css/estilos_carro/carro1.css">


<title>Carrito paso 2</title>
</head>
<body>



<!-- NAVBAR -->
<?php 

include("../tienda1/nav_cart.php"); 
include("../tienda1/modal_cart.php");

?>















<!-- vista B -->
<div class="center mt-5">
    <div class="card pt-3" >
            <p class="mipedido2">Mi pedido</p>
        <div class="container-fluid p-2">
<table class="table">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Imagen</th>
<th scope="col">Cantidad</th>
<th scope="col">Artículo</th>
<th scope="col">Precio</th>
<th scope="col">Total</th>
</tr>
</thead>
<tbody>
    




<div class="container_card">
 
 <?php
 if(isset($_SESSION['carrito'])){
 $total=0;
 for($i=0;$i<=count($carrito_mio)-1;$i ++){
 if(isset($carrito_mio[$i])){
 if($carrito_mio[$i]!=NULL){
  
 ?>
<?php if ($carrito_mio[$i]['ref'] != 'portes'){ ?>
<tr>
<th scope="row" style="vertical-align: middle;"><?php echo $i; ?></th>
<td>
 <img src="../Insertar_articulo/articulos/<?php echo $carrito_mio[$i]['ref']; ?>.jpg" alt="" width="100px">
</td>
<td style="vertical-align: middle;"><?php echo $carrito_mio[$i]['cantidad'] ?></td>
<td style="vertical-align: middle;"><?php echo $carrito_mio[$i]['titulo'] ?></td>
<td style="vertical-align: middle;">$ <?php echo $carrito_mio[$i]['precio'] ?></td>
<td style="vertical-align: middle;">$ <?php echo $carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad'];
 ?></td>
</tr>    
<?php } ?>
<?php
                 $total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
                 }
                 }
                 }
                 }
                 ?>

</tbody>
</table>


<li class="list-group-item d-flex justify-content-between">
                 <span  class="totalcop"><strong>Total (COP)</strong></span>
                 <strong  class="totalc">$ <?php
                 if(isset($_SESSION['carrito'])){
                 $total=0;
                 for($i=0;$i<=count($carrito_mio)-1;$i ++){
                     if(isset($carrito_mio[$i])){
                 if($carrito_mio[$i]!=NULL){ 
                 $total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
                 }
                 }}}
                 if(!isset($total)){$total = '0';}else{ $total = $total;}
                 echo number_format($total, 2, ',', '.');  ?> </strong>
                 </li>




 </div>
</div>
<a type="button" class="btn btn-success my-4" href="../tienda3/index.php">Continuar pedido</a>
</div>
</div>
<!-- END vista B -->











<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>








