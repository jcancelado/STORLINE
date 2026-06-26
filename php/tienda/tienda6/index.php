<?php  session_start();
include("../conexion.php");
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
 <link rel="stylesheet" href="../css/style_cp.css">


<title>Consulta basica</title>
</head>
<body>



<link rel="stylesheet" href="../../../css/php_tienda_tienda6_index.css">


<!-- NAVBAR -->












<!-- vista B -->
<div class="center mt-5">
        <div class="card pt-3" >
                <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Mis pedidos</p>
                <div class="container-fluid p-2">
                        <table class="table">
                                <thead>
                                        <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Ref</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Estado</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php
$busqueda=mysqli_query($cn,"SELECT t.ref, t.estado, t.medio, t.total, t2.cantidad, t2.articulo, t2.precio, t2.total AS 'total_precio', t3.nombre 
FROM rnl.pedido_cp t
LEFT JOIN rnl.pedido_datos_cp t2 ON t.ref = t2.ref
LEFT JOIN rnl.pedido_cliente_cp t3 ON t.cliente = t3.ref
GROUP BY t.ref
"); 
                                $numero = mysqli_num_rows($busqueda); ?>
                                        <h5 class="card-tittle">Resultados (<?php echo $numero; ?>)</h5>
                                        <div class="container_card">
                                                <?php 
                                                $num = '0';
                                                while ($resultado = mysqli_fetch_assoc($busqueda)){
                                                $num++;
                                                ?>
                                                        <tr onclick="location.href='../Carrito de compra paso 7/index.php?dat=<?php echo $resultado['ref']; ?>'" style="cursor: pointer;">
                                                        <th scope="row"><?php echo $num; ?></th>
                                                        <td><?php echo $resultado["ref"]; ?></td>
                                                        <td><?php echo $resultado["nombre"]; ?></td>
                                                        <td>$<?php echo $resultado["total"]; ?></td>
                                                        <td><?php echo $resultado["estado"]; ?></td>
                                                        </tr>    

                                                <?php } ?>
                                        </div>
                                </tbody>
                        </table>
                </div>
        </div>
</div>
<!-- END vista B -->











<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>








