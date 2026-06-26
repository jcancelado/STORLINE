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

// Obtener clientes
$query_clientes = "SELECT * FROM clientes WHERE activo = 1 ORDER BY nombre";
$result_clientes = mysqli_query($cn, $query_clientes);
$clientes = mysqli_fetch_all($result_clientes, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = (int)$_POST['cliente_id'] ?? null;
    $monto_total = (float)$_POST['monto_total'] ?? 0;
    $descripcion = mysqli_real_escape_string($cn, $_POST['descripcion'] ?? '');
    $fecha_vencimiento = !empty($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : null;

    if (!$cliente_id || $monto_total <= 0) {
        $error = "Cliente y monto son requeridos";
    } else {
        $vencimiento_sql = $fecha_vencimiento ? "'$fecha_vencimiento'" : "NULL";
        $query = "INSERT INTO deudas (tienda_id, cliente_id, monto_total, descripcion, fecha_vencimiento) 
                  VALUES ($tienda_id, $cliente_id, $monto_total, '$descripcion', $vencimiento_sql)";
        
        if (mysqli_query($cn, $query)) {
            $success = "Deuda creada exitosamente";
            $_POST = array();
        } else {
            $error = "Error al crear la deuda: " . mysqli_error($cn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Deuda - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_deudas_crear.css">
</head>
<body>
    <div class="container">
        <a href="index.php?tienda_id=<?php echo $tienda_id; ?>" class="back-link">← Volver a Deudas</a>

        <div class="form-container">
            <h1>💰 Registrar Nueva Deuda</h1>
            <p style="color: #999; margin-bottom: 2rem;">Tienda: <?php echo htmlspecialchars($tienda['nombre']); ?></p>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="cliente_id">Cliente *</label>
                    <select id="cliente_id" name="cliente_id" required>
                        <option value="">Selecciona un cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['cliente_id']; ?>" <?php echo ($_POST['cliente_id'] ?? '') == $cliente['cliente_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="monto_total">Monto Total *</label>
                        <input type="number" id="monto_total" name="monto_total" required step="0.01" min="0" value="<?php echo htmlspecialchars($_POST['monto_total'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo htmlspecialchars($_POST['fecha_vencimiento'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción / Detalles</label>
                    <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit">Registrar Deuda</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
