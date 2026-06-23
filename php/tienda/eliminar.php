<?php
require_once "../conexion.php";

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tienda_id = $_GET['tienda_id'] ?? null;

if (!$tienda_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Verificar que la tienda pertenece al usuario
$query = "SELECT * FROM tiendas WHERE tienda_id = $tienda_id AND usuario_id = $usuario_id LIMIT 1";
$result = mysqli_query($cn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Eliminar la tienda (esto también eliminará sus productos y deudas por la relación de claves foráneas)
$delete_query = "DELETE FROM tiendas WHERE tienda_id = $tienda_id AND usuario_id = $usuario_id";

if (mysqli_query($cn, $delete_query)) {
    header("Location: ../dashboard/index.php");
    exit();
} else {
    echo "Error al eliminar la tienda: " . mysqli_error($cn);
}
?>
