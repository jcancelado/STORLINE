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


<link rel="stylesheet" href="../../../css/php_tienda_tienda5_index.css">


<!-- NAVBAR -->
<?php 
 
include("../tienda1/nav_cart.php"); 
include("../tienda1/modal_cart.php");

?>








<!-- vista D -->
<div class="center mt-5">
    <div class="card pt-3" >
            <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Sumamos el IVA</p>
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

<tr>
<th scope="row" style="vertical-align: middle;"><?php echo $i; ?></th>
<td>
            <?php if ($carrito_mio[$i]['ref'] == 'portes'){ ?>
            <img src="../tienda1/img/th.jpg" alt="" width="100px">
            <?php }else{ ?>
            <img src="../Insertar_articulo/articulos/<?php echo $carrito_mio[$i]['ref']; ?>.jpg" alt="" width="100px">
            <?php } ?>
</td>
<td style="vertical-align: middle;"><?php echo $carrito_mio[$i]['cantidad'] ?></td>
<td style="vertical-align: middle;"><?php echo $carrito_mio[$i]['titulo'] ?></td>
<td style="vertical-align: middle;">$<?php echo $carrito_mio[$i]['precio'] ?></td>
<td style="vertical-align: middle;">$<?php echo $carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']; ?></td>
</tr>    

<?php
							$total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
							}
                            }
							}
							}
							?>

</tbody>
</table>

<!-- mas iva -->

                <li class="list-group-item d-flex justify-content-between">
                <span  style="text-align: left; color: #000000;"><strong>Total (COP)</strong></span>
                $ <?php
                if(isset($_SESSION['carrito'])){
                $total=0;
                for($i=0;$i<=count($carrito_mio)-1;$i ++){
                if(isset($carrito_mio[$i])){
                if($carrito_mio[$i]!=NULL){ 
                $total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
                }
                }}}
                if(!isset($total)){$total = '0';}else{ $total = $total;}
                echo number_format($total, 2, ',', '.');  ?> 
                </li>


                <li class="list-group-item d-flex justify-content-between">
                <span  style="text-align: left; color: #000000;"><strong>I.V.A. (COP)</strong></span>
                <span class="grey-text font-weight-bold" style="font-size:14px;">
                $ <?php $masiva = $total / 1.21; 
                $totaliva = $total - $masiva; 
                echo number_format($totaliva, 2, '.', '.');
                ?>
                </span>
                </li>


                <li class="list-group-item d-flex justify-content-between">
                <span  style="text-align: left; color: #000000;"><strong>Total + I.V.A. (COP)</strong></span>
                <span class="grey-text font-weight-bold" style="font-size:14px;">
                <strong  style="text-align: left; color: #000000;">
                $ <?php $totalfinal = $total + $totaliva; 
                echo number_format($totalfinal, 2, '.', '.');
                ?>
                </strong>
                </span>
                </li>



            </div>
        </div>




<hr>

<?php
    $busqueda=mysqli_query($cn,"SELECT * FROM rainanectar.usuarios ORDER BY RAND() LIMIT 1");
    if ($resultado = mysqli_fetch_assoc($busqueda)){}
?>




<!-- datos cliente -->
<div class="container p-5">
<form class="row g-3 needs-validation" action="pagar.php" method="POST" novalidate>

<p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Datos de envío</p>

<input type="hidden" name="dato" value="insertar" >
  <div class="col-md-6">
    <label for="validationCustom01" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="validationCustom01" name="nombre" value="<?php echo $resultado["nombre"]; ?>"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte su nombre.
      </div>
  </div>
  <div class="col-md-6">
    <label for="validationCustom02" class="form-label">Apellidos</label>
    <input type="text" class="form-control" id="validationCustom02" name="apellidos" value="<?php echo $resultado["apellidos"]; ?>"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte sus apellidos.
      </div>
  </div>
  <div class="col-md-6">
    <label for="validationCustom04" class="form-label">Teléfono</label>
    <input type="text" class="form-control" id="validationCustom04" name="telefono" value="<?php echo $resultado["telefono"]; ?>"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte su teléfono.
      </div>
  </div>

  <div class="col-md-6">
    <label for="validationCustom03" class="form-label">Dirección</label>
    <input type="text" class="form-control" id="validationCustom03" name="direccion" value="<?php echo $resultado["direccion"]; ?>"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte su dirección.
      </div>
  </div>
  


  <button  class="btn btn-success mb-4" type="submit">Pagar y finalizar</button>





</form>
</div>









     

    </div>
</div>
<!-- END vista D -->











<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>








