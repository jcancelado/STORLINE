<?php
require_once "../conexion.php";

// Verificar sesión


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$venta_id = intval($_GET["venta_id"] ?? 0);

if ($venta_id <= 0) {
    exit("Venta inválida.");
}

// Obtener venta


$queryVenta = "
SELECT
    ventas.*,
    tiendas.nombre AS tienda
FROM ventas
INNER JOIN tiendas
    ON ventas.tienda_id = tiendas.tienda_id
WHERE ventas.venta_id = $venta_id
AND tiendas.usuario_id = $usuario_id
LIMIT 1
";

$resultVenta = mysqli_query($cn, $queryVenta);

if (mysqli_num_rows($resultVenta) == 0) {
    exit("La venta no existe.");
}

$venta = mysqli_fetch_assoc($resultVenta);


// Obtener detalle


$queryDetalle = "
SELECT
    detalle_venta.*,
    productos.nombre
FROM detalle_venta
INNER JOIN productos
    ON detalle_venta.producto_id = productos.producto_id
WHERE detalle_venta.venta_id = $venta_id
";

$resultDetalle = mysqli_query($cn, $queryDetalle);

$detalle = mysqli_fetch_all($resultDetalle, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Factura</title>

</head>

<body>

<h2>FACTURA</h2>

<p><strong>Tienda:</strong> <?php echo htmlspecialchars($venta["tienda"]); ?></p>

<p><strong>Venta:</strong> <?php echo $venta["venta_id"]; ?></p>

<p><strong>Fecha:</strong> <?php echo $venta["fecha_creacion"]; ?></p>

<hr>

<table border="1" cellpadding="8" cellspacing="0">

<tr>

<th>Producto</th>

<th>Cantidad</th>

<th>Precio</th>

<th>Subtotal</th>

</tr>

<?php foreach($detalle as $item){ ?>

<tr>

<td><?php echo htmlspecialchars($item["nombre"]); ?></td>

<td><?php echo $item["cantidad"]; ?></td>

<td>$<?php echo number_format($item["precio_unitario"],2); ?></td>

<td>$<?php echo number_format($item["subtotal"],2); ?></td>

</tr>

<?php } ?>

</table>

<h3>

Total:
$<?php echo number_format($venta["total"],2); ?>

</h3>

<p>

<strong>Monto pagado:</strong>

$<?php echo number_format($venta["monto_pagado"],2); ?>

</p>

<p>

<strong>Estado del pago:</strong>

<?php echo htmlspecialchars($venta["estado_pago"]); ?>

</p>

<p>

<strong>Saldo pendiente:</strong>

$<?php echo number_format($venta["total"] - $venta["monto_pagado"],2); ?>

</p>

<p>

<a href="index.php?tienda_id=<?php echo $venta["tienda_id"]; ?>">

← Historial de ventas

</a>

|

<a href="crear.php?tienda_id=<?php echo $venta["tienda_id"]; ?>">

← Nueva venta

</a>

</p>

</body>

</html>