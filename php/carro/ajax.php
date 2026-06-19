<?php
require_once "../conexion.php";
if (isset($_POST)) {
    if ($_POST['action'] == 'buscar') {
        $array['datos'] = array();
        $total = 0;
        for ($i=0; $i < count($_POST['data']); $i++) { 
            $id = $_POST['data'][$i]['id'];
            $query = mysqli_query($cn, "SELECT * FROM productos WHERE ProductoID = $id");
            $result = mysqli_fetch_assoc($query);
            $data['id'] = $result['ProductoID'];
            $data['precio'] = $result['Precio'];
            $data['nombre'] = $result['NombreProducto'];
            $data["imagen_url"] = 'data:image/jpeg;base64,' . base64_encode($result['Imagen']); // Convertir BLOB a URL
            $total = $total + $result['Precio'];
            array_push($array['datos'], $data);
        }
        $array['total'] = $total;
        echo json_encode($array);
        die();
    }
}

?>