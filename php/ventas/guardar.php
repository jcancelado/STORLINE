<?php
require_once "../conexion.php";


// Verificar sesión

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$tienda_id = intval($_POST['tienda_id'] ?? 0);

$venta_json = $_POST['venta_json'] ?? "";

// Verificar tienda


$query = "SELECT tienda_id
          FROM tiendas
          WHERE tienda_id = $tienda_id
          AND usuario_id = $usuario_id
          LIMIT 1";

$resultado = mysqli_query($cn, $query);

if (mysqli_num_rows($resultado) == 0) {

    exit("La tienda no pertenece al usuario.");

}


// Decodificar venta


$data = json_decode($venta_json, true);

if (!$data) {

    exit("Datos inválidos.");

}

$monto_pagado = floatval($data["monto_pagado"] ?? 0);

$venta = $data["productos"] ?? [];

if (count($venta) == 0) {

    exit("La venta está vacía.");

}   


// Iniciar transacción


mysqli_begin_transaction($cn);

try {

    // Insertar venta


   $queryVenta = "
    INSERT INTO ventas
    (
        tienda_id,
        cliente_id,
        usuario_id,
        subtotal,
        total,
        monto_pagado,
        estado_pago
    )
    VALUES
    (
        $tienda_id,
        NULL,
        $usuario_id,
        0,
        0,
        0,
        'PAGADA'
    )
";

    if (!mysqli_query($cn, $queryVenta)) {

        throw new Exception(mysqli_error($cn));

    }

    $venta_id = mysqli_insert_id($cn);


// Procesar productos


$subtotalVenta = 0;

foreach ($venta as $item) {

    $producto_id = intval($item["producto_id"]);
    $cantidad = intval($item["cantidad"]);

    if ($cantidad <= 0) {
        throw new Exception("Cantidad inválida.");
    }

    // Verificar que el producto pertenece a la tienda
    $queryProducto = "
        SELECT
            producto_id,
            precio,
            stock
        FROM productos
        WHERE producto_id = $producto_id
        AND tienda_id = $tienda_id
        LIMIT 1
    ";

    $resultadoProducto = mysqli_query($cn, $queryProducto);

    if (mysqli_num_rows($resultadoProducto) == 0) {

        throw new Exception("Producto no encontrado.");

    }

    $producto = mysqli_fetch_assoc($resultadoProducto);

    if ($producto["stock"] < $cantidad) {

        throw new Exception("Stock insuficiente.");

    }

    $precio = $producto["precio"];

    $subtotal = $precio * $cantidad;

    $subtotalVenta += $subtotal;

    // Insertar detalle
    $queryDetalle = "
        INSERT INTO detalle_venta
        (
            venta_id,
            producto_id,
            cantidad,
            precio_unitario,
            subtotal
        )
        VALUES
        (
            $venta_id,
            $producto_id,
            $cantidad,
            $precio,
            $subtotal
        )
    ";

    if (!mysqli_query($cn, $queryDetalle)) {

        throw new Exception(mysqli_error($cn));

    }

    // Descontar inventario
    $queryStock = "
        UPDATE productos
        SET stock = stock - $cantidad
        WHERE producto_id = $producto_id
        AND tienda_id = $tienda_id  
    ";

    if (!mysqli_query($cn, $queryStock)) {

        throw new Exception(mysqli_error($cn));

    }

}

$estado_pago = "PAGADA";

if ($monto_pagado < $subtotalVenta) {

    $estado_pago = "PARCIAL";

}

if ($monto_pagado == 0) {

    $estado_pago = "PENDIENTE";

}



// Actualizar total


$queryActualizar = "
    UPDATE ventas
    SET
        subtotal = $subtotalVenta,
        total = $subtotalVenta,
        monto_pagado = $monto_pagado,
        estado_pago = '$estado_pago'
    WHERE venta_id = $venta_id
";

if (!mysqli_query($cn, $queryActualizar)) {

    throw new Exception(mysqli_error($cn));

}


// Confirmar


mysqli_commit($cn);

header("Location: ver.php?venta_id=" . $venta_id);
exit();

} catch (Exception $e) {

    mysqli_rollback($cn);

    echo "
    <script>

        alert('".$e->getMessage()."');

        history.back();

    </script>
    ";

}