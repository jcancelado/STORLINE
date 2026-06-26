<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($cn, $_POST['descripcion'] ?? '');
    $telefono = mysqli_real_escape_string($cn, $_POST['telefono'] ?? '');
    $ciudad = mysqli_real_escape_string($cn, $_POST['ciudad'] ?? '');
    $direccion = mysqli_real_escape_string($cn, $_POST['direccion'] ?? '');

    if (empty($nombre)) {
        $error = "El nombre de la tienda es requerido";
    } else {
        $query = "INSERT INTO tiendas (usuario_id, nombre, descripcion, telefono, ciudad, direccion) 
                  VALUES ($usuario_id, '$nombre', '$descripcion', '$telefono', '$ciudad', '$direccion')";
        
        if (mysqli_query($cn, $query)) {
            $success = "Tienda creada exitosamente";
            $_POST = array();
        } else {
            $error = "Error al crear la tienda: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tienda - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_tienda_crear.css">
</head>
<body>
    <div class="container">
        <a href="../../php/dashboard/index.php" class="back-link">← Volver al Dashboard</a>

        <div class="form-container">
            <h1>🏪 Crear Nueva Tienda</h1>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre de la Tienda *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($_POST['ciudad'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($_POST['direccion'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <button type="submit">Crear Tienda</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
