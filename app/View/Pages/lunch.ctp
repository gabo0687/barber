<section class="event-detail">
    <article id="profile">
    <h2>Almuerzos</h2>
    <div style="display:none;" id="userCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Cliente creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      </div>
      <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
      </ul>
       </br>
     

      <div class="list-group" id="usersList" role="tablist">
        <?php foreach( $users as $user ){ ?>
          <a class="list-group-item list-group-item-action" id="lunch_<?php echo $user['User']['id'];?>" data-toggle="list" role="tab" style="color:black;">
          <?php echo $user['User']['name'];?>
          <select name="time_<?php echo $user['User']['id'];?>" id="time_<?php echo $user['User']['id'];?>" class="form-control">
            <option value="45">45 min</option>
            <option value="60">60 min</option>
          </select>
          <input type="button" onclick="save_lunch(<?php echo $user['User']['id'];?>)" class="btn btn-primary" value="Guardar">
          </a>
          <?php } ?>
      </div>
        </br>
        <?php $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
        $months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $date = date('Y-m-d');
        $day  = date('w', strtotime($date));
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $currentDay = date('d', strtotime($date));
        $dayOfTheWeek = $days[$day];  ?>
      <h2>Almuerzos de hoy </br> <?php echo $dayOfTheWeek.' '.$currentDay.' de '.$months[(int)$month-1].' del '.$year;?></h2>
      <div class="list-group" id="lunchList" role="tablist">
        <?php 
        
        foreach( $lunches as $lunch ){
         
          $dateStart = $lunch['Lunch']['date_start'];
          $timeStart  = date('H:i:s', strtotime($dateStart));
          

          $dateEnd = $lunch['Lunch']['date_end'];
          $timeEnd  = date('H:i:s', strtotime($dateEnd));
          
          ?>
          <a class="list-group-item list-group-item-action" id="lunchs" data-toggle="list" role="tab" style="color:black;"><?php echo '<b>'.$lunch['User']['name'].'</b></br><b>Inicia:</b> '.date("h:i A", strtotime($timeStart)).'</br><b>Finaliza:</b> '.date("h:i A", strtotime($timeEnd));?></a>
        <?php  } ?>  
          
        </div>  
    </article>
  </section>

  <script>
    function save_lunch(userId){
      var time = $('#time_'+userId).val();
      $.ajax({
        type: 'POST',
        url: 'save_lunch',
        data: 'userId=' + userId +'&time=' + time,
        beforeSend: function() {

        },
        error: function() {
          alert('No hay internet');
        },
        success: function(response) {
          window.location.reload();
        }

      });
    }
   </script> 
