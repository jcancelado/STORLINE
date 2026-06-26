<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$deuda_id = $_GET['deuda_id'] ?? null;
$error = '';
$success = '';

if (!$deuda_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Obtener deuda y verificar que pertenece a una tienda del usuario
$query = "SELECT d.*, c.nombre as cliente_nombre, t.tienda_id FROM deudas d 
          JOIN clientes c ON d.cliente_id = c.cliente_id 
          JOIN tiendas t ON d.tienda_id = t.tienda_id 
          WHERE d.deuda_id = $deuda_id AND t.usuario_id = $usuario_id LIMIT 1";
$result = mysqli_query($cn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$deuda = mysqli_fetch_assoc($result);
$tienda_id = $deuda['tienda_id'];
$pendiente = $deuda['monto_total'] - $deuda['monto_pagado'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    if ($accion == 'registrar_pago') {
        $pago = (float)$_POST['monto_pago'] ?? 0;
        
        if ($pago <= 0 || $pago > $pendiente) {
            $error = "Monto de pago inválido. Máximo: $" . number_format($pendiente, 2);
        } else {
            $nuevo_pagado = $deuda['monto_pagado'] + $pago;
            $nuevo_estado = $nuevo_pagado >= $deuda['monto_total'] ? 'pagada' : 'parcial';
            
            $update_query = "UPDATE deudas SET monto_pagado=$nuevo_pagado, estado='$nuevo_estado' 
                           WHERE deuda_id=$deuda_id";
            
            if (mysqli_query($cn, $update_query)) {
                $success = "Pago registrado exitosamente";
                $deuda['monto_pagado'] = $nuevo_pagado;
                $deuda['estado'] = $nuevo_estado;
                $pendiente = $deuda['monto_total'] - $deuda['monto_pagado'];
            } else {
                $error = "Error al registrar pago: " . mysqli_error($cn);
            }
        }
    } else {
        // Actualizar deuda
        $descripcion = mysqli_real_escape_string($cn, $_POST['descripcion'] ?? '');
        $fecha_vencimiento = !empty($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : null;
        
        $vencimiento_sql = $fecha_vencimiento ? "'$fecha_vencimiento'" : "NULL";
        $update_query = "UPDATE deudas SET descripcion='$descripcion', fecha_vencimiento=$vencimiento_sql 
                       WHERE deuda_id=$deuda_id";
        
        if (mysqli_query($cn, $update_query)) {
            $success = "Deuda actualizada exitosamente";
            $deuda['descripcion'] = $descripcion;
            $deuda['fecha_vencimiento'] = $fecha_vencimiento;
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
    <title>Editar Deuda - STORLINE</title>
    <link rel="stylesheet" href="../../css/php_deudas_editar.css">
</head>
<body>
    <div class="container">

        <div class="form-container">
                    <a href="index.php?tienda_id=<?php echo $tienda_id; ?>" class="back-link">← REGRESAR</a>

            <h1>GESTIONAR DEUDA</h1>

            <div class="deuda-info">
                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($deuda['cliente_nombre']); ?></p>
                <p><strong>Monto Total:</strong> $<?php echo number_format($deuda['monto_total'], 2); ?></p>
                <p><strong>Pagado:</strong> $<?php echo number_format($deuda['monto_pagado'], 2); ?></p>
                <p><strong>Pendiente:</strong> $<?php echo number_format($pendiente, 2); ?></p>
                <p><strong>Estado:</strong> <span style="color: <?php echo $deuda['estado'] == 'pendiente' ? '#e74c3c' : ($deuda['estado'] == 'parcial' ? '#f39c12' : '#27ae60'); ?>;">
                    <?php echo ucfirst($deuda['estado']); ?>
                </span></p>
            </div>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('pago')">Registrar Pago</button>
                <button class="tab-btn" onclick="switchTab('editar')">Editar Deuda</button>
                <button class="tab-btn" onclick="switchTab('eliminar')">Eliminar</button>
            </div>

            <!-- Tab: Registrar Pago -->
            <div id="pago" class="tab-content active">
                <form method="POST">
                    <input type="hidden" name="accion" value="registrar_pago">
                    
                    <div class="form-group">
                        <label for="monto_pago">Monto a Pagar (Máximo: $<?php echo number_format($pendiente, 2); ?>) *</label>
                        <input type="number" id="monto_pago" name="monto_pago" required step="0.01" min="0" max="<?php echo $pendiente; ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-pagar">Registrar Pago</button>
                    </div>
                </form>
            </div>

            <!-- Tab: Editar Deuda -->
            <div id="editar" class="tab-content">
                <form method="POST">
                    <input type="hidden" name="accion" value="actualizar">
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción / Detalles</label>
                        <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($deuda['descripcion'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo htmlspecialchars($deuda['fecha_vencimiento'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit">Actualizar Deuda</button>
                    </div>
                </form>
            </div>

            <!-- Tab: Eliminar -->
            <div id="eliminar" class="tab-content">
                <p style="color: #666; margin-bottom: 1.5rem;">¿Estás seguro de que deseas eliminar esta deuda?</p>
                <div class="form-actions">
                    <a href="eliminar.php?deuda_id=<?php echo $deuda_id; ?>" class="btn-delete" style="flex:1; text-align:center; padding:0.75rem; border-radius:5px; text-decoration:none;" onclick="return confirm('¿Estás completamente seguro?');">Eliminar Deuda</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            // Mostrar el tab seleccionado
            document.getElementById(tab).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
