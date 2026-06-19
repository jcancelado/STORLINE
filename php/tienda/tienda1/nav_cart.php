<?php 
if(isset($_SESSION['carrito'])){
    $carrito_mio = $_SESSION['carrito'];

    // Inicializamos la cantidad total
    $total_cantidad = 0;

    // Contamos la cantidad de productos en el carrito
    for ($i = 0; $i < count($carrito_mio); $i++) {
        if (isset($carrito_mio[$i]) && $carrito_mio[$i] != NULL) { 
            // Asumo que cada producto tiene una clave 'cantidad'
            if (isset($carrito_mio[$i]['cantidad'])) {
                $total_cantidad += $carrito_mio[$i]['cantidad'];
            }
        }
    }

    // Mostramos la cantidad total en el ícono del carrito
    $totalcantidad = $total_cantidad;
} else {
    // Si no hay carrito, inicializamos la cantidad total a 0
    $totalcantidad = 0;
}
?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark " style="background: linear-gradient(to right, white, white, #97e4db, #c87fff);">
    <div class="container-fluid">
        <a class="titulomitienda" href="#">Mi galería</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_cart" style="color: #c87fff; font-size: 40px; background: linear-gradient(to right, #00d0ff, #97e4db, #c87fff);-webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; cursor:pointer;">
                        <i class="fas fa-shopping-cart"></i> <?php echo $totalcantidad; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->
