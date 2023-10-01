<section class="event-detail">
    <article id="profile">
      <h2>Reporte General</h2>
      <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
      </ul>
</br>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          
          <form action="" method="post" class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Desde:</label>
              <input type="date" name="desde_reporte" class="form-control" id="desde_reporte" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Hasta:</label>
              <input type="date" name="hasta_reporte" class="form-control" id="hasta_reporte" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Generar reporte</button>
            </div>
            <div class="form-group">
              <label for="accountInputPassword"><b><h3>Del <?php echo $dateFromFormat;?> </br>Al <?php echo $dateToFormat;?></h3></label>
            </div>
            <h4 class="offset-sm-2">Ventas de servicios</h4>
            <div class="form-group">
              <label for="accountInputPassword">Total: ₡<?php if($resevationsTotal[0][0]['ctotal'] != null){ echo number_format($resevationsTotal[0][0]['ctotal']); }else{ echo 0;}?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Efectivo: ₡<?php if($cashTotal[0][0]['ctotal'] != null){ echo number_format($cashTotal[0][0]['ctotal']); }else{ echo '0';}?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Banco: ₡<?php if($bankTotal[0][0]['ctotal'] != null){ echo number_format($bankTotal[0][0]['ctotal']); }else{ echo 0;}?></label>
            </div>
          </form>
        </div>
      </div>
  

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form class="col-sm-6 offset-sm-3">
            <h4 class="offset-sm-2">Ventas de Productos</h4>
            <div class="form-group">
              <label for="accountInputPassword">Total: ₡<?php echo number_format($productsTotal);?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Efectivo: ₡<?php echo number_format($cashProduct);?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Banco: ₡<?php echo number_format($bankProduct);?></label>
            </div>
          </form>
        </div>
      </div>

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form class="col-sm-6 offset-sm-3">
            <h4 class="offset-sm-2">Gastos</h4>
            <div class="form-group">
              <label for="accountInputPassword">Total: ₡<?php if($expensesTotal[0][0]['ctotal'] != null){ echo number_format($expensesTotal[0][0]['ctotal']); }else{ echo 0;}?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Efectivo: ₡<?php if($cashExpenses[0][0]['ctotal'] != null){ echo number_format($cashExpenses[0][0]['ctotal']); }else{ echo 0;}?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Banco: ₡<?php if($bankExpenses[0][0]['ctotal'] != null){ echo number_format($bankExpenses[0][0]['ctotal']); }else{ echo 0;}?></label>
            </div>
          </form>
        </div>
      </div>
      <h2 class="offset-sm-2"></h2>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form class="col-sm-6 offset-sm-3">
            <h3 class="offset-sm-3">Total General</h3>
            <div class="form-group">
              <label for="accountInputPassword">Total: ₡<?php echo number_format($generaTotal);?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Efectivo: ₡<?php echo number_format($cashGeneral);?></label>
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Banco: ₡<?php echo number_format($bankGeneral);?></b></label>
            </div>
          </form>
        </div>
      </div>

      
    </article>
  </section>
  <script>
    window.scrollTo(0, document.body.scrollHeight);
  </script>