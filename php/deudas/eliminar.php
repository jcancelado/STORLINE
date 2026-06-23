<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$deuda_id = $_GET['deuda_id'] ?? null;

if (!$deuda_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Obtener deuda y verificar permisos
$query = "SELECT d.*, t.tienda_id FROM deudas d 
          JOIN tiendas t ON d.tienda_id = t.tienda_id 
          WHERE d.deuda_id = $deuda_id AND t.usuario_id = $usuario_id LIMIT 1";
$result = mysqli_query($cn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

$deuda = mysqli_fetch_assoc($result);
$tienda_id = $deuda['tienda_id'];

// Eliminar deuda
$delete_query = "DELETE FROM deudas WHERE deuda_id = $deuda_id";

if (mysqli_query($cn, $delete_query)) {
    header("Location: index.php?tienda_id=$tienda_id");
    exit();
} else {
    echo "Error al eliminar: " . mysqli_error($cn);
}
?>
