<?php
require_once "../conexion.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];

// Obtener todas las tiendas del usuario
$query_tiendas = "SELECT * FROM tiendas WHERE usuario_id = $usuario_id ORDER BY fecha_creacion DESC";
$result_tiendas = mysqli_query($cn, $query_tiendas);
$tiendas = mysqli_fetch_all($result_tiendas, MYSQLI_ASSOC);
$total_tiendas = count($tiendas);

// Obtener estadísticas
$stats = array('productos' => 0, 'clientes' => 0, 'deudas' => 0);

if ($total_tiendas > 0) {
    $tienda_ids = implode(',', array_column($tiendas, 'tienda_id'));
    
    // Total de productos
    $query_productos = "SELECT COUNT(*) as total FROM productos WHERE tienda_id IN ($tienda_ids)";
    $result_productos = mysqli_query($cn, $query_productos);
    $stats['productos'] = mysqli_fetch_assoc($result_productos)['total'];
    
    // Total de clientes
    $query_clientes = "SELECT COUNT(DISTINCT cliente_id) as total FROM deudas WHERE tienda_id IN ($tienda_ids)";
    $result_clientes = mysqli_query($cn, $query_clientes);
    $stats['clientes'] = mysqli_fetch_assoc($result_clientes)['total'];
    
    // Total de deudas pendientes
    $query_deudas = "SELECT SUM(monto_total - monto_pagado) as total FROM deudas WHERE tienda_id IN ($tienda_ids) AND estado != 'pagada'";
    $result_deudas = mysqli_query($cn, $query_deudas);
    $stats['deudas'] = mysqli_fetch_assoc($result_deudas)['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_dashboard_index.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <h1>🏪 STORLINE</h1>
            <p>Bienvenido, <?php echo htmlspecialchars($nombre); ?></p>
        </div>
        <div class="header-right">
            <a href="../auth/logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <!-- Container -->
    <div class="container">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Tiendas</div>
                <div class="stat-number"><?php echo $total_tiendas; ?></div>
            </div>
            <div class="stat-card productos">
                <div class="stat-label">Productos</div>
                <div class="stat-number"><?php echo $stats['productos']; ?></div>
            </div>
            <div class="stat-card clientes">
                <div class="stat-label">Clientes Únicos</div>
                <div class="stat-number"><?php echo $stats['clientes']; ?></div>
            </div>
            <div class="stat-card deudas">
                <div class="stat-label">Deudas Pendientes</div>
                <div class="stat-number">$<?php echo number_format($stats['deudas'], 0); ?></div>
            </div>
        </div>

        <!-- Section: Tiendas -->
        <div class="section-header">
            <h2>Mis Tiendas</h2>
            <a href="../tienda/crear.php" class="btn-create">+ Nueva Tienda</a>
        </div>

        <?php if ($total_tiendas > 0): ?>
            <div class="tiendas-grid">
                <?php foreach ($tiendas as $tienda): ?>
                    <div class="tienda-card">
                        <div class="tienda-header">
                            <h3><?php echo htmlspecialchars($tienda['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($tienda['ciudad'] ?? 'Sin ciudad'); ?></p>
                        </div>
                        <div class="tienda-content">
                            <div class="tienda-info">
                                <strong>Dirección:</strong> <?php echo htmlspecialchars($tienda['direccion'] ?? 'No especificada'); ?>
                            </div>
                            <div class="tienda-info">
                                <strong>Teléfono:</strong> <?php echo htmlspecialchars($tienda['telefono'] ?? 'No especificado'); ?>
                            </div>
                            <div class="tienda-info">
                                <strong>Estado:</strong> <?php echo $tienda['activa'] ? 'Activa' : 'Inactiva'; ?>
                            </div>

                            <div class="tienda-actions">
                                <a href="../productos/index.php?tienda_id=<?php echo $tienda['tienda_id']; ?>" class="btn-action btn-products">📦 Productos</a>
                                <a href="../clientes/index.php?tienda_id=<?php echo $tienda['tienda_id']; ?>" class="btn-action btn-clients">👥 Clientes</a>
                                <a href="../deudas/index.php?tienda_id=<?php echo $tienda['tienda_id']; ?>" class="btn-action btn-debts">💰 Deudas</a>
                                <a href="../tienda/editar.php?tienda_id=<?php echo $tienda['tienda_id']; ?>" class="btn-action btn-edit">✏️ Editar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🏢</div>
                <h3>Aún no tienes tiendas</h3>
                <p>Crea tu primera tienda para comenzar a gestionar productos y clientes.</p>
                <br>
                <a href="../tienda/crear.php" class="btn-create">Crear mi Primera Tienda</a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2026 STORLINE. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
