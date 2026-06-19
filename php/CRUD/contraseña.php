<?php
$password = $_POST['contrasena'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo json_encode(['hash' => $hashedPassword]);
?>
