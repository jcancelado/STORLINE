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

// Obtener datos de la tienda
$query = "SELECT * FROM tiendas WHERE tienda_id = $tienda_id AND usuario_id = $usuario_id LIMIT 1";
$result = mysqli_query($cn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$tienda = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($cn, $_POST['descripcion'] ?? '');
    $telefono = mysqli_real_escape_string($cn, $_POST['telefono'] ?? '');
    $ciudad = mysqli_real_escape_string($cn, $_POST['ciudad'] ?? '');
    $direccion = mysqli_real_escape_string($cn, $_POST['direccion'] ?? '');
    $activa = isset($_POST['activa']) ? 1 : 0;

    if (empty($nombre)) {
        $error = "El nombre de la tienda es requerido";
    } else {
        $update_query = "UPDATE tiendas SET nombre='$nombre', descripcion='$descripcion', 
                        telefono='$telefono', ciudad='$ciudad', direccion='$direccion', activa=$activa 
                        WHERE tienda_id=$tienda_id AND usuario_id=$usuario_id";
        
        if (mysqli_query($cn, $update_query)) {
            $success = "Tienda actualizada exitosamente";
            $tienda = array_merge($tienda, $_POST);
            $tienda['activa'] = $activa;
        } else {
            $error = "Error al actualizar la tienda: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tienda - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_tienda_editar.css">
</head>
<body>
    <div class="container">
        <a href="../../php/dashboard/index.php" class="back-link">← Volver al Dashboard</a>

        <div class="form-container">
            <h1>✏️ Editar Tienda</h1>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre de la Tienda *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($tienda['nombre']); ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($tienda['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($tienda['ciudad'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($tienda['telefono'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($tienda['direccion'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="activa" name="activa" <?php echo $tienda['activa'] ? 'checked' : ''; ?>>
                        <label for="activa" style="margin-bottom: 0;">Tienda Activa</label>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="form-group">
                        <button type="submit">Guardar Cambios</button>
                    </div>
                    <div class="form-group">
                        <a href="eliminar.php?tienda_id=<?php echo $tienda_id; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tienda?');">Eliminar Tienda</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
