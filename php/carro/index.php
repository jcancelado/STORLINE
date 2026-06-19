<?php
require_once "../conexion.php";

// Obtener el parámetro category de la URL
$categoria = isset($_GET['category']) ? $_GET['category'] : '';

// Definir la imagen de fondo por defecto
$fondoHeader = "../../img/fondos/neon-tropical-monstera-leaf-banner.jpg";

// Cambiar la imagen de fondo del header según la categoría seleccionada
if (!empty($categoria)) {
    switch ($categoria) {
        case 'Suculentas':
            $fondoHeader = "../../img/fondos/lauracardona.png";
            break;
        case 'Arreglos':
            $fondoHeader = "../../../../img/fondos/fondo-arreglos.jpg";
            break;
        case 'Carnivoras':
            $fondoHeader = "../../../../img/fondos/fondo-carnivoras.jpg";
            break;
         case 'Interior':
                $fondoHeader = "../../img/fondos/portada.jpg";
                break;
        // Agrega más casos según sea necesario para otras categorías
        default:
            // Usar el fondo por defecto
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PLANTAS</title>
    <!-- Favicon-->
    <link rel="icon" type="image" href="../../../img/ran__1_-removebg-preview.png" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <!-- Estilos CSS para el encabezado con la imagen de fondo dinámica -->
    <style>
    header {
        font-family: 'uwu.ttf';
        background: linear-gradient(to right, hsla(231, 83%, 18%, 0.856), hsla(93, 86%, 28%, 0.479)),
                    url('<?php echo $fondoHeader; ?>');
        background-size: cover;
        background-position: center;
    }
    </style>
</head>

<body>

    <a href="#" class="btn-flotante" id="btnCarrito">Carrito <span class="badge bg-success" id="carrito">0</span></a>
    <!-- Navigation-->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="index.php" class="logo-container">
                    <img class="logo-img" src="../../../../img/ran__1_-removebg-preview.png" alt="Logo">
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <a href="index.php" category="all">Todo</a>
                        <?php
                        $query = mysqli_query($cn, "SELECT * FROM categorias");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                        <a href="index.php?category=<?php echo $data['NombreCategoria']; ?>" class="nav-dick"
                            category="<?php echo $data['NombreCategoria']; ?>"><?php echo $data['NombreCategoria']; ?></a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Header-->
    <header class=" py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 id="tiendaNombre" class="display-4 fw-bolder">
                    <?php
                    // Mostrar el nombre de la categoría en mayúsculas
                    echo strtoupper($categoria);
                    ?>
                </h1>
                <p class="lead fw-normal text-white-50 mb-0">CAMBIA SU MUNDO, CAMBIA EL TUYO</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $consulta = "SELECT productos.*, categorias.CategoriaID AS CategoriaID, categorias.NombreCategoria, productos.imagen FROM productos INNER JOIN categorias ON categorias.CategoriaID = productos.CategoriaID";
                if (!empty($categoria)) {
                    $consulta .= " WHERE categorias.NombreCategoria = '$categoria'";
                }
                $query = mysqli_query($cn, $consulta);
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                <div class="col mb-5 productos" id="<?php echo $data['NombreCategoria']; ?>"
                    category="<?php echo $data['NombreCategoria']; ?>">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        <div class="badge bg-danger text-white position-absolute"
                            style="top: 0.5rem; right: 0.5rem"><?php echo ($data['Precio'] > $data['Precio_rebajado']) ? 'Oferta' : ''; ?></div>
                        <!-- Product image-->
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data["Imagen"]); ?>"
                            alt="Imagen del producto">
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?php echo $data['NombreProducto'] ?></h5>
                                <p><?php echo $data['Descripcion']; ?></p>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through"><?php echo $data['Precio'] ?></span>
                                <?php echo $data['Precio_rebajado'] ?>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto agregar"
                                    data-id="<?php echo $data['ProductoID']; ?>" href="#">Agregar</a></div>
                        </div>
                    </div>
                </div>
                <?php }
                } else { ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <p>No hay productos disponibles en esta categoría.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var links = document.querySelectorAll('.nav-link');
        links.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var categoria = link.getAttribute('category');
                document.getElementById('tiendaNombre').textContent = categoria === 'all' ? 'Todo' : categoria;
            });
        });
    });
    </script>
</body>

</html>
