<?php
require_once "../conexion.php";


// Verificar sesión


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$tienda_id = intval($_GET["tienda_id"] ?? 0);

if ($tienda_id <= 0) {
    header("Location: ../dashboard/index.php");
    exit();
}


// Verificar tienda


$queryTienda = "
SELECT *
FROM tiendas
WHERE tienda_id = $tienda_id
AND usuario_id = $usuario_id
LIMIT 1
";

$resultTienda = mysqli_query($cn, $queryTienda);

if (mysqli_num_rows($resultTienda) == 0) {
    exit("La tienda no pertenece al usuario.");
}

$tienda = mysqli_fetch_assoc($resultTienda);


// Obtener ventas


$queryVentas = "
SELECT
    venta_id,
    fecha_creacion,
    total,
    estado_pago,
    estado
FROM ventas
WHERE tienda_id = $tienda_id
ORDER BY venta_id DESC
";

$resultVentas = mysqli_query($cn, $queryVentas);

$ventas = mysqli_fetch_all($resultVentas, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Ventas</title>

<link rel="stylesheet" href="../../css/php_ventas_index.css">

</head>

<body>

<h2>VENTAS</h2>

<p>

Tienda:

<strong>

<?php echo htmlspecialchars($tienda["nombre"]); ?>

</strong>

</p>

<p>

<a href="../dashboard/index.php">

← Regresar

</a>

|

<a href="crear.php?tienda_id=<?php echo $tienda_id; ?>">

Nueva venta

</a>

</p>

<div class="filtros">

    <input
        type="number"
        id="buscar_factura"
        placeholder="Factura #">

    <input
        type="date"
        id="buscar_fecha">

    <select id="filtro_estado">

        <option value="">Todas</option>
        <option value="ACTIVA">ACTIVA</option>
        <option value="ANULADA">ANULADA</option>

    </select>

    <select id="filtro_pago">

        <option value="">Todos los pagos</option>
        <option value="PAGADA">PAGADA</option>
        <option value="PARCIAL">PARCIAL</option>
        <option value="PENDIENTE">PENDIENTE</option>

    </select>

</div>

<br>


<table border="1" cellpadding="8" cellspacing="0">

<thead>

<tr>

<th>Factura</th>

<th>Fecha</th>

<th>Total</th>

<th>Pago</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

<?php if(count($ventas)>0){ ?>

<?php foreach($ventas as $venta){ ?>

<tr

data-factura="<?php echo $venta["venta_id"]; ?>"

data-fecha="<?php echo substr($venta["fecha_creacion"],0,10); ?>"

data-estado="<?php echo $venta["estado"]; ?>"

data-pago="<?php echo $venta["estado_pago"]; ?>"

>

<td>

<?php echo $venta["venta_id"]; ?>

</td>

<td>

<?php echo $venta["fecha_creacion"]; ?>

</td>

<td>

$<?php echo number_format($venta["total"],2); ?>

</td>

<td>

<?php echo htmlspecialchars($venta["estado_pago"]); ?>

</td>

<td>

<?php echo htmlspecialchars($venta["estado"]); ?>

</td>

<td>

<a href="ver.php?venta_id=<?php echo $venta["venta_id"]; ?>">

Ver

</a>

|

<?php if($venta["estado"]=="ACTIVA"){ ?>

<a
href="eliminar.php?venta_id=<?php echo $venta["venta_id"]; ?>"
onclick="return confirm('¿Desea anular esta venta?');">

Anular

</a>

<?php }else{ ?>

<span style="color:red;font-weight:bold;">

Anulada

</span>

<?php } ?>

</td>

</tr>

<?php } ?>

<?php }else{ ?>

<tr>

<td colspan="6">

No existen ventas registradas.

</td>

</tr>

<?php } ?>

</tbody>

</table>

<script>

const buscarFactura = document.getElementById("buscar_factura");
const buscarFecha = document.getElementById("buscar_fecha");
const filtroEstado = document.getElementById("filtro_estado");
const filtroPago = document.getElementById("filtro_pago");

const filas = document.querySelectorAll("tbody tr");

buscarFactura.addEventListener("input", filtrar);
buscarFecha.addEventListener("input", filtrar);
filtroEstado.addEventListener("change", filtrar);
filtroPago.addEventListener("change", filtrar);

function filtrar(){

    filas.forEach(fila=>{

        const factura = fila.dataset.factura;
        const fecha = fila.dataset.fecha;
        const estado = fila.dataset.estado;
        const pago = fila.dataset.pago;

        let mostrar = true;

        if(buscarFactura.value != ""){

            if(factura.indexOf(buscarFactura.value) === -1){

                mostrar = false;

            }

        }

        if(buscarFecha.value != ""){

            if(fecha != buscarFecha.value){

                mostrar = false;

            }

        }

        if(filtroEstado.value != ""){

            if(estado != filtroEstado.value){

                mostrar = false;

            }

        }

        if(filtroPago.value != ""){

            if(pago != filtroPago.value){

                mostrar = false;

            }

        }

        fila.style.display = mostrar ? "" : "none";

    });

}

</script>

</body>

</html>