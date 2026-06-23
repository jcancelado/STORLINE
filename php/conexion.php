<?php
	$servidor="localhost";
	$usuario="root";
	$clave="";
	$base="storline";

	$cn=mysqli_connect($servidor, $usuario, $clave, $base);

	if (!$cn) {
		echo "error en la conexión";
		exit();
	}else{
		/* echo "conexión exitosa"; */
	}

	// Iniciar sesión si no está iniciada
	if(session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	
?>