<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = $_GET['producto_id'] ?? null;
$error = '';
$success = '';

if (!$producto_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Obtener producto y verificar que pertenece a una tienda del usuario
$query = "SELECT p.*, t.tienda_id FROM productos p 
          JOIN tiendas t ON p.tienda_id = t.tienda_id 
          WHERE p.producto_id = $producto_id AND t.usuario_id = $usuario_id LIMIT 1";
$result = mysqli_query($cn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$producto = mysqli_fetch_assoc($result);
$tienda_id = $producto['tienda_id'];

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
    $activo = isset($_POST['activo']) ? 1 : 0;

    if (empty($nombre) || $precio <= 0) {
        $error = "Nombre y precio son requeridos";
    } else {
        $categoria_sql = $categoria_id ? $categoria_id : "NULL";
        $update_query = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', 
                        categoria_id=$categoria_sql, precio=$precio, stock=$stock, activo=$activo 
                        WHERE producto_id=$producto_id";
        
        if (mysqli_query($cn, $update_query)) {
            $success = "Producto actualizado exitosamente";
            $producto = array_merge($producto, $_POST);
            $producto['activo'] = $activo;
        } else {
            $error = "Error al actualizar: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - STORLINE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f7fa;
            padding: 2rem;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-container h1 {
            color: #333;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border-left: 4px solid #c33;
        }

        .success {
            background: #efe;
            color: #3c3;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border-left: 4px solid #3c3;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Open Sans', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
        }

        .form-group button {
            flex: 1;
            padding: 0.75rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-group button:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-delete {
            background: #e74c3c !important;
        }

        .btn-delete:hover {
            background: #c0392b !important;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php?tienda_id=<?php echo $tienda_id; ?>" class="back-link">← Volver a Productos</a>

        <div class="form-container">
            <h1>✏️ Editar Producto</h1>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <select id="categoria_id" name="categoria_id">
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['categoria_id']; ?>" <?php echo $producto['categoria_id'] == $cat['categoria_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio *</label>
                        <input type="number" id="precio" name="precio" required step="0.01" min="0" value="<?php echo htmlspecialchars($producto['precio']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" value="<?php echo htmlspecialchars($producto['stock']); ?>">
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="activo" name="activo" <?php echo $producto['activo'] ? 'checked' : ''; ?>>
                        <label for="activo" style="margin-bottom: 0;">Producto Activo</label>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="form-group">
                        <button type="submit">Guardar Cambios</button>
                    </div>
                    <div class="form-group">
                        <a href="eliminar.php?producto_id=<?php echo $producto_id; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
