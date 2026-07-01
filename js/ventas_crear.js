

// Datos de la venta


let venta = [];

// Elementos del DOM


const inputBuscar = document.getElementById("buscar_producto");
const resultados = document.getElementById("resultados_busqueda");
const detalleVenta = document.getElementById("detalle_venta");
const totalVenta = document.getElementById("total");
const formulario = document.getElementById("form_venta");
const ventaJson = document.getElementById("venta_json");
const inputPago = document.getElementById("monto_pagado");
const btnPagoExacto = document.getElementById("btn_pago_exacto");


// Buscador

inputBuscar.addEventListener("input", buscarProductos);

function buscarProductos(){

    const texto = inputBuscar.value.toLowerCase().trim();

    resultados.innerHTML = "";

    if(texto === ""){

        resultados.style.display = "none";
        return;

    }

    const filtrados = productos.filter(producto =>
        producto.nombre.toLowerCase().includes(texto)
    );

    if(filtrados.length === 0){

        resultados.style.display = "none";
        return;

    }

    filtrados.forEach(producto=>{

        console.log(producto.nombre, producto.stock, typeof producto.stock);

    const div = document.createElement("div");

    div.className = "resultado-item";

    if(producto.stock <= 0){

    div.innerHTML =
        "<strong>" + producto.nombre + "</strong><br>" +
        "<span style='color:red;font-weight:bold;'>SIN STOCK</span>";

    div.style.opacity = "0.5";

    div.style.cursor = "not-allowed";

    div.addEventListener("click", function(e){

        e.preventDefault();

        e.stopPropagation();

        alert("Este producto no tiene existencias.");

    });

}else{

    div.innerHTML =
        "<strong>" + producto.nombre + "</strong><br>" +
        "Precio: $" + Number(producto.precio).toFixed(2) +
        "<br>Stock: " + producto.stock;

    div.addEventListener("click", function(){

        agregarProducto(producto);

    });

}

    resultados.appendChild(div);

});

resultados.style.display = "block";

}


// Agregar producto


function agregarProducto(producto){



    if(producto.stock <= 0){

        alert("No hay existencias disponibles de este producto.");

        return;

    }


    const existente = venta.find(item =>
        item.producto_id == producto.producto_id
    );

    if(existente){

    if(existente.cantidad >= existente.stock){

        alert(
            "No hay más unidades disponibles de '" +
            existente.nombre +
            "'."
        );

        return;

    }

    existente.cantidad++;

} else {

        venta.push({

            producto_id: producto.producto_id,

            nombre: producto.nombre,

            precio: Number(producto.precio),

            stock: Number(producto.stock),

            cantidad: 1

        });

    }

    inputBuscar.value = "";
    resultados.innerHTML = "";
    resultados.style.display = "none";

    actualizarTabla();

}

// Dibujar tabla


function actualizarTabla(){

    detalleVenta.innerHTML = "";

    if(venta.length === 0){

        detalleVenta.innerHTML = `
            <tr>
                <td colspan="5">
                    No hay productos agregados.
                </td>
            </tr>
        `;

        calcularTotal();

        return;

    }

    venta.forEach((producto,index)=>{

        const subtotal = producto.precio * producto.cantidad;

        detalleVenta.innerHTML += `
            <tr>

                <td>${producto.nombre}</td>

                <td>$${producto.precio.toFixed(2)}</td>

                <td>

                    <input
                        type="number"
                        min="1"
                        max="${producto.stock}"
                        value="${producto.cantidad}"
                        onchange="cambiarCantidad(${index},this.value)">

                </td>

                <td>

                    $${subtotal.toFixed(2)}

                </td>

                <td>

                    <button onclick="eliminarProducto(${index})">

                        X

                    </button>

                </td>

            </tr>
        `;

    });

    calcularTotal();

}


// Cambiar cantidad


function cambiarCantidad(indice,cantidad){

    cantidad = Number(cantidad);

    if(cantidad < 1){

        cantidad = 1;

    }

   if(cantidad > venta[indice].stock){

    alert(
        "Solo hay " +
        venta[indice].stock +
        " unidades disponibles."
    );

    cantidad = venta[indice].stock;

}

    venta[indice].cantidad = cantidad;

    actualizarTabla();

}


// Eliminar


function eliminarProducto(indice){

    venta.splice(indice,1);

    actualizarTabla();

}

// ===============================
// Total
// ===============================

function calcularTotal(){

    let total = 0;

    venta.forEach(producto=>{

        total += producto.precio * producto.cantidad;

    });

    totalVenta.innerHTML = "$" + total.toFixed(2);

}


function vaciarVenta(){

    if(venta.length === 0){

        return;

    }

    if(!confirm("¿Desea eliminar todos los productos de la venta?")){

        return;

    }

    venta = [];

    actualizarTabla();

}


// Enviar venta


formulario.addEventListener("submit", function(e){

    if(venta.length === 0){

        e.preventDefault();

        alert("Debe agregar al menos un producto.");

        return;

    }

    for(const producto of venta){

    if(producto.cantidad > producto.stock){

        e.preventDefault();

        alert(
            "El producto '" +
            producto.nombre +
            "' solo tiene " +
            producto.stock +
            " unidades disponibles."
        );

        return;

    }

    if(producto.cantidad <= 0){

        e.preventDefault();

        alert(
            "La cantidad del producto '" +
            producto.nombre +
            "' no es válida."
        );

        return;

    }

}

    const ventaEnviar = {

    monto_pagado: parseFloat(inputPago.value || 0),

    productos: venta.map(producto => ({

        producto_id: producto.producto_id,

        cantidad: producto.cantidad

    }))

};

ventaJson.value = JSON.stringify(ventaEnviar);

});
function pagoExacto(){

    const total = totalVenta.textContent
        .replace("$","")
        .trim();

    inputPago.value = total;

}
btnPagoExacto.addEventListener("click", pagoExacto);