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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f7fa;
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
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .header-left p {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.8rem;
        }

        .btn-create {
            background: #e74c3c;
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
            background: #c0392b;
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #667eea;
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .btn-action {
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .status-pendiente {
            color: #e74c3c;
            font-weight: 600;
        }

        .status-parcial {
            color: #f39c12;
            font-weight: 600;
        }

        .status-pagada {
            color: #27ae60;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <h1>💰 Deudas</h1>
            <p>Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>
        </div>
    </header>

    <div class="container">
        <a href="../dashboard/index.php" class="back-link">← Volver al Dashboard</a>

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
                <div class="empty-state-icon">💰</div>
                <h3>No hay deudas registradas</h3>
                <p>Crea una nueva deuda para comenzar a gestionar.</p>
                <br>
                <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">Crear Primera Deuda</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
