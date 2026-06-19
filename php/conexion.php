<?php
	$servidor="localhost";
	$usuario="root";
	$clave="";
	$base="rainanectar";

	$cn=mysqli_connect($servidor, $usuario, $clave, $base);

	if (!$cn) {
		echo "error en la conexión";
	}else{
		/* echo "conexión exitosa"; */
	}
	
?>