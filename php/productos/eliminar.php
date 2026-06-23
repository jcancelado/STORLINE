<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = $_GET['producto_id'] ?? null;

if (!$producto_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Obtener producto y tienda
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

// Eliminar producto
$delete_query = "DELETE FROM productos WHERE producto_id = $producto_id";

if (mysqli_query($cn, $delete_query)) {
    header("Location: index.php?tienda_id=$tienda_id");
    exit();
} else {
    echo "Error al eliminar: " . mysqli_error($cn);
}
?>
