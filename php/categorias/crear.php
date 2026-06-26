<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$tienda_id = $_GET['tienda_id'] ?? null;
$origen = $_GET['origen'] ?? null; // puede usarse para redirigir
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre'] ?? '');

    if (empty($nombre)) {
        $error = "El nombre de la categoría es obligatorio.";
    } else {
        $query = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        if (mysqli_query($cn, $query)) {
            $success = "Categoría creada correctamente.";
            // Redirigir de vuelta al formulario de producto si viene desde allí
            if ($origen == 'producto' && $tienda_id) {
                header("Location: ../productos/crear.php?tienda_id=$tienda_id");
                exit();
            }
            $_POST = array();
        } else {
            $error = "Error al crear la categoría: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_categorias_crear.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <a class="back" href="javascript:history.back()">← REGRESAR</a>

            <h2>Crear Categoría</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre de la categoría *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <button type="submit">Crear Categoría</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
