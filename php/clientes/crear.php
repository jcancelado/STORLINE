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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $email = mysqli_real_escape_string($cn, $_POST['email'] ?? '');
    $telefono = mysqli_real_escape_string($cn, $_POST['telefono'] ?? '');
    $ciudad = mysqli_real_escape_string($cn, $_POST['ciudad'] ?? '');
    $direccion = mysqli_real_escape_string($cn, $_POST['direccion'] ?? '');

    if (empty($nombre)) {
        $error = "El nombre del cliente es requerido";
    } else {
        // Asegurar que la columna tienda_id existe antes de insertar
        $column_check = mysqli_query($cn, "SHOW COLUMNS FROM clientes LIKE 'tienda_id'");
        if (mysqli_num_rows($column_check) == 0) {
            mysqli_query($cn, "ALTER TABLE clientes ADD COLUMN tienda_id int(11) DEFAULT NULL");
        }

        $query = "INSERT INTO clientes (nombre, email, telefono, ciudad, direccion, tienda_id) 
                  VALUES ('$nombre', '$email', '$telefono', '$ciudad', '$direccion', $tienda_id)";
        
        if (mysqli_query($cn, $query)) {
            $success = "Cliente creado exitosamente";
            $_POST = array();
        } else {
            $error = "Error al crear el cliente: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_clientes_crear.css">
</head>
<body>
    <div class="container">
        <a href="index.php?tienda_id=<?php echo $tienda_id; ?>" class="back-link">← Volver a Clientes</a>

        <div class="form-container">
            <h1>👥 Crear Nuevo Cliente</h1>
            <p style="color: #999; margin-bottom: 2rem;">Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del Cliente *</label>
                    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($_POST['ciudad'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($_POST['direccion'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit">Crear Cliente</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
