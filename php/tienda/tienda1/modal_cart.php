<!-- MODAL CARRITO -->
<link rel="stylesheet" href="../../css/estilos_carro/carro1.css">

<div class="modal fade" id="modal_cart" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="button" id="exampleModalLabel">Mi carrito</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php
        include("../../conexion.php");
      ?>

      <div class="modal-body">
        <div>
          <div class="p-2">
            <ul class="list-group mb-3">
              <?php
              if(isset($_SESSION['carrito'])){
                $total = 0;
                foreach($_SESSION['carrito'] as $producto){
                  if($producto != NULL){
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                      <div class="row col-12" >
                        <div class="col-6 p-0"><h6 class="my-0">Cantidad: <?php echo isset($producto['cantidad']) ? $producto['cantidad'] : 0; ?>
 : <?php echo $producto['NombreProducto']; ?></h6></div>
                        <div class="col-6 p-0"  style="text-align: right; color: #000000;" >
                          $<span class="text-muted"  style="text-align: right; color: #000000;"><?php echo $producto['Precio'] * $producto['cantidad'];  ?> </span>
                        </div>
                      </div>
                    </li>
                    <?php
                    $total += ($producto['Precio'] * $producto['cantidad']);
                  }
                }
              }
              ?>
              <li class="list-group-item d-flex justify-content-between">
                <span  class="totalcop">Total (COP)</span>
                <strong  style="text-align: left; color: #000000;">$<?php echo $total; ?></strong>
              </li>
            </ul>
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <a type="button" class="btn btn-primary" href="../Carrito de compra paso 1/borrarcarro.php">Vaciar carrito</a>
        <a type="button" class="btn btn-success" href="../Carrito de compra paso 2/index.php">Continuar pedido</a>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL CARRITO -->
