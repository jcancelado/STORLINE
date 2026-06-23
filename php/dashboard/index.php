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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-left h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .header-left p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .header-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.5rem;
            border: 1px solid white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: white;
            color: #667eea;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            border-left: 4px solid #667eea;
        }

        .stat-card.clientes {
            border-left-color: #f39c12;
        }

        .stat-card.productos {
            border-left-color: #27ae60;
        }

        .stat-card.deudas {
            border-left-color: #e74c3c;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin: 0.5rem 0;
        }

        .stat-card.clientes .stat-number {
            color: #f39c12;
        }

        .stat-card.productos .stat-number {
            color: #27ae60;
        }

        .stat-card.deudas .stat-number {
            color: #e74c3c;
        }

        .stat-label {
            color: #999;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.8rem;
        }

        .btn-create {
            background: #667eea;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-create:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .tiendas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .tienda-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .tienda-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .tienda-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
        }

        .tienda-header h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .tienda-header p {
            opacity: 0.9;
            font-size: 0.85rem;
        }

        .tienda-content {
            padding: 1.5rem;
        }

        .tienda-info {
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
        }

        .tienda-info strong {
            color: #333;
        }

        .tienda-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-action {
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-products {
            background: #27ae60;
            color: white;
        }

        .btn-products:hover {
            background: #229954;
        }

        .btn-clients {
            background: #f39c12;
            color: white;
        }

        .btn-clients:hover {
            background: #e67e22;
        }

        .btn-debts {
            background: #e74c3c;
            color: white;
        }

        .btn-debts:hover {
            background: #c0392b;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: 10px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: #999;
            margin-top: 3rem;
        }
    </style>
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
