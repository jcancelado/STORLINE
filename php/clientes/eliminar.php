<?php
require_once "../conexion.php";

$cliente_id = $_GET['cliente_id'] ?? null;

if (!$cliente_id) {
    header("Location: ../dashboard/index.php");
    exit();
}

// Eliminar cliente (cascada elimina deudas asociadas)
$delete_query = "DELETE FROM clientes WHERE cliente_id = $cliente_id";

if (mysqli_query($cn, $delete_query)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error al eliminar: " . mysqli_error($cn);
}
?>
