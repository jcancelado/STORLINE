<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$cliente_id = $_GET['cliente_id'] ?? null;
$error = '';
$success = '';

if (!$cliente_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Obtener cliente
$query = "SELECT * FROM clientes WHERE cliente_id = $cliente_id LIMIT 1";
$result = mysqli_query($cn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$cliente = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $email = mysqli_real_escape_string($cn, $_POST['email'] ?? '');
    $telefono = mysqli_real_escape_string($cn, $_POST['telefono'] ?? '');
    $ciudad = mysqli_real_escape_string($cn, $_POST['ciudad'] ?? '');
    $direccion = mysqli_real_escape_string($cn, $_POST['direccion'] ?? '');
    $activo = isset($_POST['activo']) ? 1 : 0;

    if (empty($nombre)) {
        $error = "El nombre del cliente es requerido";
    } else {
        $update_query = "UPDATE clientes SET nombre='$nombre', email='$email', 
                        telefono='$telefono', ciudad='$ciudad', direccion='$direccion', activo=$activo 
                        WHERE cliente_id=$cliente_id";
        
        if (mysqli_query($cn, $update_query)) {
            $success = "Cliente actualizado exitosamente";
            $cliente = array_merge($cliente, $_POST);
            $cliente['activo'] = $activo;
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
    <title>Editar Cliente - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_clientes_editar.css">
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Volver a Clientes</a>

        <div class="form-container">
            <h1>✏️ Editar Cliente</h1>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del Cliente *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($cliente['nombre']); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($cliente['ciudad'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="activo" name="activo" <?php echo $cliente['activo'] ? 'checked' : ''; ?>>
                        <label for="activo" style="margin-bottom: 0;">Cliente Activo</label>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="form-group">
                        <button type="submit">Guardar Cambios</button>
                    </div>
                    <div class="form-group">
                        <a href="eliminar.php?cliente_id=<?php echo $cliente_id; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
