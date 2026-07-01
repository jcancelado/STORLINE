<?php
require_once "../conexion.php";

// Verificar sesión


if (!isset($_SESSION['usuario_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

$usuario_id = $_SESSION["usuario_id"];

$venta_id = intval($_GET["venta_id"] ?? 0);

if ($venta_id <= 0) {

    exit("Venta inválida.");

}


// Verificar que la venta pertenece al usuario


$queryVenta = "
SELECT
    ventas.venta_id,
    ventas.tienda_id,
    ventas.estado
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




if ($venta["estado"] == "ANULADA") {

    echo "
    <script>
        alert('La venta ya fue anulada.');
        window.location='index.php?tienda_id=".$venta["tienda_id"]."';
    </script>
    ";

    exit();

}


// Iniciar transacción


mysqli_begin_transaction($cn);

try {


    // Obtener detalle


    $queryDetalle = "
    SELECT
        producto_id,
        cantidad
    FROM detalle_venta
    WHERE venta_id = $venta_id
    ";

    $resultDetalle = mysqli_query($cn, $queryDetalle);

    while($detalle = mysqli_fetch_assoc($resultDetalle)){

        $producto_id = intval($detalle["producto_id"]);
        $cantidad = intval($detalle["cantidad"]);

        $queryStock = "
        UPDATE productos
        SET stock = stock + $cantidad
        WHERE producto_id = $producto_id
        AND tienda_id = ".$venta["tienda_id"];

        if(!mysqli_query($cn,$queryStock)){

            throw new Exception(mysqli_error($cn));

        }

    }


    // Marcar venta anulada


    $queryActualizar = "
    UPDATE ventas
    SET estado='ANULADA'
    WHERE venta_id = $venta_id
    ";

    if(!mysqli_query($cn,$queryActualizar)){

        throw new Exception(mysqli_error($cn));

    }

    mysqli_commit($cn);

    header("Location: index.php?tienda_id=".$venta["tienda_id"]);
    exit();

}

catch(Exception $e){

    mysqli_rollback($cn);

    echo "<h2>Error</h2>";

    echo "<p>".htmlspecialchars($e->getMessage())."</p>";

}