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
$query_tienda = "SELECT * FROM tiendas WHERE tienda_id = $tienda_id AND usuario_id = $usuario_id LIMIT 1";
$result_tienda = mysqli_query($cn, $query_tienda);

if (mysqli_num_rows($result_tienda) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$tienda = mysqli_fetch_assoc($result_tienda);

// Obtener deudas
$query_deudas = "SELECT d.*, c.nombre as cliente_nombre FROM deudas d 
                 JOIN clientes c ON d.cliente_id = c.cliente_id 
                 WHERE d.tienda_id = $tienda_id 
                 ORDER BY d.fecha_vencimiento DESC";
$result_deudas = mysqli_query($cn, $query_deudas);
$deudas = mysqli_fetch_all($result_deudas, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deudas - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_deudas_index.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <h1>Deudas</h1>
            <p>Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>
        </div>
    </header>

    <div class="container">
        <a href="../dashboard/index.php" class="back-link">← REGRESAR</a>

        <div class="section-header">
            <h2>Gestión de Deudas</h2>
            <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">+ Nueva Deuda</a>
        </div>

        <?php if (count($deudas) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto Total</th>
                        <th>Pagado</th>
                        <th>Pendiente</th>
                        <th>Estado</th>
                        <th>Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deudas as $deuda): 
                        $pendiente = $deuda['monto_total'] - $deuda['monto_pagado'];
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($deuda['cliente_nombre']); ?></strong></td>
                            <td>$<?php echo number_format($deuda['monto_total'], 2); ?></td>
                            <td>$<?php echo number_format($deuda['monto_pagado'], 2); ?></td>
                            <td><strong>$<?php echo number_format($pendiente, 2); ?></strong></td>
                            <td><span class="status-<?php echo $deuda['estado']; ?>"><?php echo ucfirst($deuda['estado']); ?></span></td>
                            <td><?php echo htmlspecialchars($deuda['fecha_vencimiento'] ?? '---'); ?></td>
                            <td>
                                <a href="editar.php?deuda_id=<?php echo $deuda['deuda_id']; ?>" class="btn-action btn-edit">Editar</a>
                                <a href="eliminar.php?deuda_id=<?php echo $deuda['deuda_id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <h3>No hay deudas registradas</h3>
                <p>Crea una nueva deuda para comenzar a gestionar.</p>
                <br>
                <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">Crear Primera Deuda</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
