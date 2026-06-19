<?php

// Cierra la sesión
//session_destroy();
//session_cache_expire();
// Redirige al usuario al index
//$_SESSION
//header('Location: ../../index.php');
//exit();
session_start();

$_SESSION['login'] = 0;
    header('Location: ../../index.php');
    exit();


?>
