<?php
require_once "../conexion.php";


// Verificar sesión

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tienda_id = $_GET['tienda_id'] ?? null;

if (!$tienda_id) {
    header("Location: ../dashboard/index.php");
    exit();
}


// Verificar que la tienda pertenece al usuario

$query_tienda = "SELECT * FROM tiendas
                 WHERE tienda_id = $tienda_id
                 AND usuario_id = $usuario_id
                 LIMIT 1";

$result_tienda = mysqli_query($cn, $query_tienda);

if (mysqli_num_rows($result_tienda) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$tienda = mysqli_fetch_assoc($result_tienda);


// Obtener productos activos

$query_productos = "SELECT
    producto_id,
    nombre,
    precio,
    stock
FROM productos
WHERE tienda_id = $tienda_id
AND activo = 1
ORDER BY nombre ASC";

$result_productos = mysqli_query($cn, $query_productos);
$productos = mysqli_fetch_all($result_productos, MYSQLI_ASSOC);




?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Nueva Venta - STORLINE</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="../../css/php_ventas_crear.css">

</head>

<body>

<header>

    <h2>NUEVA VENTA</h2>

    <p>
        Tienda:
        <strong>
            <?php echo htmlspecialchars($tienda['nombre']); ?>
        </strong>
    </p>

</header>

<div class="container">

    <a class="back-link"
       href="../dashboard/index.php">

        ← Regresar

    </a>

    <div class="buscador">

    <label>

        Buscar producto

    </label>

    <input
        type="text"
        id="buscar_producto"
        placeholder="Escriba el nombre del producto...">

    <div id="resultados_busqueda" class="resultados-busqueda"></div>

</div>

    <div class="tabla-productos">

        <table>

            <thead>

                <tr>

                    <th>Producto</th>

                    <th>Precio</th>

                    <th>Cantidad</th>

                    <th>Subtotal</th>

                    <th>Acción</th>

                </tr>

            </thead>

            <tbody id="detalle_venta">

                <tr>

                    <td colspan="5">

                        No hay productos agregados.

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <form id="form_venta"
      action="guardar.php"
      method="POST">

    <input
        type="hidden"
        name="tienda_id"
        value="<?php echo $tienda_id; ?>">

    <input
        type="hidden"
        id="venta_json"
        name="venta_json">

    <div class="totales">

    <h3>

        Total:
        <span id="total">
            $0.00
        </span>

    </h3>

</div>

<div class="pago-section">

    <h3>Pago del cliente</h3>

    <input
        type="number"
        id="monto_pagado"
        min="0"
        step="0.01"
        placeholder="Monto recibido">

    <button
        type="button"
        id="btn_pago_exacto">

        Pago exacto

    </button>

</div>

<button class="btn-registrar">

    Registrar Venta

</button>

</form>

    <div class="acciones-venta">

    <button
        type="button"
        class="btn-vaciar"
        onclick="vaciarVenta()">

        Vaciar Venta

    </button>



</div>

</div>

<script>

const productos = <?php echo json_encode($productos); ?>;

</script>

<script src="../../js/ventas_crear.js?v=2"></script>
</html>
