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






<!-- NAVBAR -->
<?php 

include("../tienda1/nav_cart.php"); 
include("../tienda1/modal_cart.php");

?>















<!-- vista C -->
<div class="center mt-5">
    <div class="card pt-3" >
            <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Modificar mi pedido</p>
        <div class="container-fluid p-2">
<table class="table">
<thead>
<tr class="tabla2">
<th scope="col">#</th>
<th scope="col">Imagen</th>
<th scope="col">Cantidad</th>
<th scope="col">Artículo</th>
<th scope="col">Precio</th>
<th scope="col">Total</th>
<th scope="col">Borrar</th>
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
<td style="vertical-align: middle;">
<form id="form2" name="form1" method="post" action="cart.php">
          <input name="id" type="hidden" id="id" value="<?php print $i;   ?>" class="align-middle" />
          <input  name="cantidad" type="text" id="cantidad" style="width:50px;" class="align-middle text-center"   value="<?php print $carrito_mio[$i]['cantidad'];   ?>" size="1" maxlength="4"  />
          <input  type="image" name="imageField3" src="../Carrito de compra paso 1/img/actualiza.png" value="" class="btn btn-sm btn-primary btn-rounded" />
          </form>   
</td>



<td style="vertical-align: middle;"><?php echo $carrito_mio[$i]['titulo'] ?></td>
<td style="vertical-align: middle;">$<?php echo $carrito_mio[$i]['precio'] ?></td>
<td style="vertical-align: middle;">$<?php echo $carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']; ?></td>
<td style="vertical-align: middle;">
<form id="form3" name="form2" method="post" action="cart.php">
          <input name="id2" type="hidden" id="id2" value="<?php print $i;   ?>" />
          <button type="image" name="imageField3"class="btn-lg bg-danger text-white " style="border:0px;" data-toggle="tooltip" data-placement="top"
                title="Remove item"><i class="fas fa-trash-alt"></i> Borrar
              </button>
        </form>
</td>
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
							<span  style="text-align: left; color: #000000;"><strong>Total (COP)</strong></span>
							<strong  style="text-align: left; color: #000000;">$ <?php
							if(isset($_SESSION['carrito'])){
							$total=0;
							for($i=0;$i<=count($carrito_mio)-1;$i ++){
                                if(isset($carrito_mio[$i])){
							if($carrito_mio[$i]!=NULL){ 
							$total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
                            }
							}}}
                            if(!isset($total)){$total = '0';}else{ $total = $total;}
							 echo number_format($total, 2, ',', '.'); ?> </strong>
							</li>



            </div>
        </div>

        <a type="button" class="btn btn-success my-4" href="../tienda4/index.php">Continuar pedido</a>

    </div>
</div>
<!-- END vista C -->













<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>








