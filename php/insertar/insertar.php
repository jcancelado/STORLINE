<?php
include("../conexion.php");

if ($_REQUEST["dato"] == 'insertar') {
    // Insertamos los datos
    $titulo = $_POST["NombreProducto"];
    $descripcion = $_POST["Descripcion"];
    $precio = $_POST["Precio"];
    $imagen = file_get_contents($_FILES["Imagen"]["tmp_name"]);
    $imagen = mysqli_real_escape_string($cn, $imagen);    $disponibilidad = $_POST["Stock"];
    $query = "INSERT INTO Productos (NombreProducto, Descripcion, Precio, Imagen, Stock)
              VALUES ('$titulo', '$descripcion', '$precio', '$imagen', '$disponibilidad')";
    $result = mysqli_query($cn, $query) or die(mysqli_error());

    // Verificamos si la inserción fue exitosa
    if ($result) {
        // Redireccionamos a index.php si la inserción fue exitosa
        header("Location: index.php?insert=ok");
        exit; // Importante: detenemos la ejecución del script después de la redirección
    }
}
?>
