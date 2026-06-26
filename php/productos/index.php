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

// Obtener productos
$query_productos = "SELECT * FROM productos WHERE tienda_id = $tienda_id ORDER BY fecha_creacion DESC";
$result_productos = mysqli_query($cn, $query_productos);
$productos = mysqli_fetch_all($result_productos, MYSQLI_ASSOC);

// Obtener categorías
$query_categorias = "SELECT * FROM categorias";
$result_categorias = mysqli_query($cn, $query_categorias);
$categorias = mysqli_fetch_all($result_categorias, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_productos_index.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <h3>PRODUCTOS</h3>
            <p>Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>
        </div>
    </header>

    <div class="container">
        <a href="../dashboard/index.php" class="back-link">← REGRESAR</a>

        <div class="section-header">
            <h2>Gestión de Productos</h2>
            <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">+ Nuevo Producto</a>
        </div>

        <?php if (count($productos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($producto['categoria_id'] ? 'ID: ' . $producto['categoria_id'] : 'Sin categoría'); ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><?php echo $producto['stock']; ?> unidades</td>
                            <td><?php echo $producto['activo'] ? '<span style="color:green;">✓ Activo</span>' : '<span style="color:red;">✗ Inactivo</span>'; ?></td>
                            <td>
                                <a href="editar.php?producto_id=<?php echo $producto['producto_id']; ?>" class="btn-action btn-edit">Editar</a>
                                <a href="eliminar.php?producto_id=<?php echo $producto['producto_id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
               
                <h3>No hay productos</h3>
                <p>Crea tu primer producto para comenzar.</p>
                <br>
                <a href="crear.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-create">Crear Primer Producto</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
