<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tienda_id = $_GET['tienda_id'] ?? null;
$error = '';
$success = '';

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

// Obtener categorías
$query_categorias = "SELECT * FROM categorias ORDER BY nombre";
$result_categorias = mysqli_query($cn, $query_categorias);
$categorias = mysqli_fetch_all($result_categorias, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($cn, $_POST['descripcion'] ?? '');
    $categoria_id = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $precio = (float)$_POST['precio'] ?? 0;
    $stock = (int)$_POST['stock'] ?? 0;

    if (empty($nombre) || $precio <= 0) {
        $error = "Nombre y precio son requeridos";
    } else {
        $categoria_sql = $categoria_id ? $categoria_id : "NULL";
        $query = "INSERT INTO productos (tienda_id, nombre, descripcion, categoria_id, precio, stock) 
                  VALUES ($tienda_id, '$nombre', '$descripcion', $categoria_sql, $precio, $stock)";
        
        if (mysqli_query($cn, $query)) {
            $success = "Producto creado exitosamente";
            $_POST = array();
        } else {
            $error = "Error al crear el producto: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_productos_crear.css">
</head>
<body>
    <div class="container">
        <a href="index.php?tienda_id=<?php echo $tienda_id; ?>" class="back-link">← Volver a Productos</a>

        <div class="form-container">
            <h1>📦 Crear Nuevo Producto</h1>
            <p style="color: #999; margin-bottom: 2rem;">Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <div style="display:flex;gap:8px;align-items:center;">
                        <select id="categoria_id" name="categoria_id">
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['categoria_id']; ?>" <?php echo ($_POST['categoria_id'] ?? '') == $cat['categoria_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="../categorias/crear.php?tienda_id=<?php echo $tienda_id; ?>&origen=producto" style="font-size:0.9rem;color:#667eea;text-decoration:none;font-weight:600;">+ Crear categoría</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio *</label>
                        <input type="number" id="precio" name="precio" required step="0.01" min="0" value="<?php echo htmlspecialchars($_POST['precio'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="stock">Stock Inicial</label>
                    <input type="number" id="stock" name="stock" min="0" value="<?php echo htmlspecialchars($_POST['stock'] ?? '0'); ?>">
                </div>

                <div class="form-group">
                    <button type="submit">Crear Producto</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
