<!DOCTYPE html>
<html>
<head>
  <title>Página Principal</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
      text-align: center;
      color: #333333;
    }
    
    .options {
      display: flex;
      flex-direction: column;
      margin-top: 20px;
    }
    
    .option {
      margin-bottom: 10px;
      padding: 10px;
      background-color: #eeeeee;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    
    .option:hover {
      background-color: #dddddd;
    }
    
    .option a {
      text-decoration: none;
      color: #333333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Seleccione una opción:</h1>
    <div class="options">
      <div class="option">
        <a href="seccion_orquidea.html">Orquídeas</a>
      </div>
      <div class="option">
        <a href="seccion_suculenta.html">Suculentas</a>
      </div>
      <div class="option">
        <a href="seccion_rosa.html">Rosas</a>
      </div>
      <div class="option">
        <a href="seccion_tulipan.html">Tulipanes</a>
      </div>
      <div class="option">
        <a href="seccion_girasol.html">Girasoles</a>
      </div>
    </div>
  </div>
</body>
</html>
