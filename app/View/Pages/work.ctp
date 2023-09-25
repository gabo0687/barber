<section class="event-detail">
    <article id="profile">
      <h2>Horas de trabajo</h2>
      <ul class="nav nav-pills text-end">
       <?php if( $user['User']['type'] == '1' ){?>
       <li class="nav-item"><a class="nav-link fa fa-calendar" aria-hidden="true" id="calendar" href="calendar" type="button" > Calendario</a></li>
       <li class="nav-item"><a class="nav-link fa fa-scissors" aria-hidden="true" id="calendar" href="services" type="button" > Servicios</a></li>
       <li class="nav-item"><a class="nav-link fa fa-id-card" aria-hidden="true" id="calendar" href="users" type="button" > Usuarios</a></li>
       <li class="nav-item"><a class="nav-link fa fa-users" aria-hidden="true" id="calendar" href="customers" type="button" > Clientes</a></li>
       <li class="nav-item"><a class="nav-link fa fa-product-hunt" aria-hidden="true" id="calendar" href="products" type="button" > Productos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-clock-o" aria-hidden="true" id="calendar" href="work" type="button" > Horas de trabajo</a></li>
       <li class="nav-item"><a class="nav-link fa fa-book" aria-hidden="true" id="calendar" href="expenses" type="button" > Gastos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-line-chart" aria-hidden="true" id="calendar" href="sales" type="button" > Ventas</a></li>
       <li class="nav-item"><a class="nav-link fa fa-usd" aria-hidden="true" id="calendar" href="product_sales" type="button" > Reporte Productos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-money" aria-hidden="true" id="calendar" href="expenses_sales" type="button" > Reporte Gastos</a></li>
       <?php } 
       $days = array('mon','tue','wed','thu','fri','sat','sun');
       $dayNames = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');
       ?>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Agregar horas de trabajo</h4>
          <form action="" method="post" class="col-sm-6 offset-sm-3">
            
          <?php for( $j=1; $j<=7; $j++){ ?>
            <div class="form-group">
              <label for="accountInputUser"><?php echo $dayNames[$j-1];?></label>
              <select class="form-control" name="<?php echo $days[$j-1];?>_open" id="<?php echo $days[$j-1];?>_open"> 
                <?php 
                $time_hour = 7;
                $time_minute = '00';
                for($i=0; $i <= 29; $i++){ 
                  $time_current = $time_hour;
                  if( $time_hour < 10 ){
                    $time_hour = '0'.$time_hour;
                  }
                  if( $time_minute != 60 ){
                    ?>    
                    <option value="<?php echo $time_hour.':'.$time_minute;?>" <?php if( $work_hours[$j-1]['Workhour']['work_open'] == $time_hour.':'.$time_minute ){ echo 'selected'; }?>><?php echo $time_hour.':'.$time_minute;?></option>      
                    <?php
                  }
                  $time_hour = $time_current;
                  if( $time_minute == 30 ){
                    $time_minute = '00';
                    $time_hour = $time_hour + 1;
                  }else{
                    if( $time_minute == 60 ){
                      $time_minute = '00';
                    $time_hour = $time_hour + 1;
                    }else{
                      if( $time_minute == 00 || $time_minute == 30 ){
                        $time_minute = $time_minute +30;
                      }
                    }  
                  } 
                } 
                ?>  
              </select></br>
              <select class="form-control" name="<?php echo $days[$j-1];?>_close" id="<?php echo $days[$j-1];?>_close"> 
                <?php 
                $time_hour = 8;
                $time_minute = '00';
                for($i=0; $i <= 28; $i++){ 
                  $time_current = $time_hour;
                  if( $time_hour < 10 ){
                    $time_hour = '0'.$time_hour;
                  }
                  if( $time_minute != 60 ){
                    ?>    
                    <option value="<?php echo $time_hour.':'.$time_minute;?>" <?php if( $work_hours[$j-1]['Workhour']['work_close'] == $time_hour.':'.$time_minute ){ echo 'selected'; }?>><?php echo $time_hour.':'.$time_minute;?></option>      
                    <?php
                  }
                  $time_hour = $time_current;
                  if( $time_minute == 30 ){
                    $time_minute = '00';
                    $time_hour = $time_hour + 1;
                  }else{
                    if( $time_minute == 60 ){
                      $time_minute = '00';
                    $time_hour = $time_hour + 1;
                    }else{
                      if( $time_minute == 00 || $time_minute == 30 ){
                        $time_minute = $time_minute +30;
                      }
                    }  
                  } 
                } 
                ?>  
              </select>
             </div>
            <?php } ?>
            
            
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
    </article>
  </section>
  <script>
  


   
  </script>