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

// Asegurar que existe la columna tienda_id para asociar clientes a tiendas
$column_check = mysqli_query($cn, "SHOW COLUMNS FROM clientes LIKE 'tienda_id'");
if (mysqli_num_rows($column_check) == 0) {
    mysqli_query($cn, "ALTER TABLE clientes ADD COLUMN tienda_id int(11) DEFAULT NULL");
}

// Obtener solo clientes asignados a la tienda actual
$query_clientes = "SELECT DISTINCT c.* FROM clientes c 
                   WHERE c.tienda_id = $tienda_id 
                      OR (c.tienda_id IS NULL AND EXISTS (
                          SELECT 1 FROM deudas d 
                          WHERE d.cliente_id = c.cliente_id
                            AND d.tienda_id = $tienda_id
                      ))
                   ORDER BY c.nombre";
$result_clientes = mysqli_query($cn, $query_clientes);
$clientes = mysqli_fetch_all($result_clientes, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_clientes_index.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <h1>Clientes</h1>
            <p>Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>
        </div>
    </header>

    <div class="container">
        <a href="../dashboard/index.php" class="back-link">← REGRESAR</a>

        <div class="section-header">
            <h2>Gestión de Clientes</h2>
            <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">+ Nuevo Cliente</a>
        </div>

        <?php if (count($clientes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Ciudad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($cliente['email'] ?? '---'); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefono'] ?? '---'); ?></td>
                            <td><?php echo htmlspecialchars($cliente['ciudad'] ?? '---'); ?></td>
                            <td><?php echo $cliente['activo'] ? '<span style="color:green;">✓ Activo</span>' : '<span style="color:red;">✗ Inactivo</span>'; ?></td>
                            <td>
                                <a href="editar.php?cliente_id=<?php echo $cliente['cliente_id']; ?>&tienda_id=<?php echo $tienda_id; ?>" class="btn-action btn-edit">Editar</a>
                                <a href="../deudas/index.php?tienda_id=<?php echo $tienda_id; ?>&cliente_id=<?php echo $cliente['cliente_id']; ?>" class="btn-action btn-debts">Deudas</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <h3>No hay clientes con deudas</h3>
                <p>Crea tu primer cliente para comenzar a gestionar deudas.</p>
                <br>
                <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">Crear Primer Cliente</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
