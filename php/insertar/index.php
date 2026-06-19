<?php 
include("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
<link rel="shortcut icon" href="../../img/ran__1_-removebg-preview.png" type="image/x-icon">
 
<script src="../Alert/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="../Alert/sweetalert.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

 <!-- ESTILO CURSOS DE PROGRAMACION -->
 <link rel="stylesheet" href="../css/style_cp.css">


<title>Insertar Datos</title>
</head>
<body>


<!-- NAVBAR -->
<!-- END NAVBAR -->

<div class="container" style="justify-content: center; margin: 0 auto; position: relative; ">

<div class="card mi_card" >

<div class="mb-4">
  <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Insertar artículo básico</p>
</div>

<form class="row g-3 needs-validation" action="insertar.php" method="POST" novalidate enctype="multipart/form-data">
<input type="hidden" name="dato" value="insertar" >
  <div class="col-md-12">
    <label for="validationCustom01" class="form-label">Nombre del producto</label>
    <input type="text" class="form-control" id="validationCustom01" name="NombreProducto"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte su nombre.
      </div>
  </div>


  <div class="col-md-12">
    <label for="validationCustom03" class="form-label">Descripción</label>
    <textarea  class="form-control" name="Descripcion"  cols="10" rows="5"></textarea>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte una descripción.
      </div>
  </div>


  

  <div class="col-md-6">
    <label for="validationCustom04" class="form-label">Precio</label>
    <input type="text" class="form-control"  name="Precio"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte el precio.
      </div>
  </div>


  <!-- imagen -->
  <h2>Subir Imagen a MySQL</h2>
    <div class="col-md-6">
        <label for="validationCustom04" class="form-label">Selecciona una imagen:</label>
        <input type="file" class="form-control" name="Imagen" accept="image/*" required>
        <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte la cantidad.
      </div>
  </div>
  
  <div class="col-md-6">
    <label for="validationCustom04" class="form-label">Cantidad</label>
    <input type="text" class="form-control"  name="Stock"  required>
    <div class="valid-feedback">
    Correcto!
    </div>
      <div class="invalid-feedback">
      Por favor, inserte la cantidad.
      </div>
  </div>
  


        <script>
                function handleFileSelect() {
                //Check File API support
                if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files; //FileList object
                var output = document.getElementById("result");
                for (var i = 0; i < files.length; i++) {
                var file = files[i];
                //Only pics
                if (!file.type.match('image')) continue;
                var picReader = new FileReader();
                picReader.addEventListener("load", function (event) { 
                var picFile = event.target;
                var div = document.createElement("div");
                div.innerHTML = "<img  class='card-img-top'  src='" + picFile.result + "'" + "title='" + picFile.name + "'/>";
                output.insertBefore(div, null);
                });
                //Read the image
                picReader.readAsDataURL(file);
                }
                } else {
                console.log("Your browser does not support File API");
                }
                }
                document.getElementById('file').addEventListener('change', handleFileSelect, false);
        </script>
<!-- end imagen -->

  

  <div class="col-12">
    <button class="btn btn-primary" type="submit">Insertar</button>
  </div>

 

</form>
</div>

</div>










<script>
(function () {
  'use strict'
  
  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>





<script type="text/javascript">
function JSalert(dato){
	swal("ACEPTADO", dato, "success");
}
</script>

<script type="text/javascript">
function JSalert_Error(dato){
  swal("ERROR", dato, "error");   
  }
</script>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

</body>
</html>









<?php 
  if(!empty($_REQUEST))
  {
if ($_REQUEST["insert"] == 'ok'){
  echo '
  <script>
    JSalert("Insertado correctamente");
  </script>
  ';
}
  }
?>