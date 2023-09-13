<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>A lo fresa</title>
<link rel="icon" type="image/png" sizes="16x16"  href="img/layout/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<script type="text/javascript" src="js/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/script.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    

  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

</head>

<body>
    <header>
        <div class="slider">
        
            <div class="sliderbox" id="sliderbox">
                <div class="slide"></div>            
            </div>         
                <a class="logo" href="index.php"></a>
                <div class="user">
                    <div class="username"><?php if($user != ''){ ?><a class="user-edit" href="account"><?php echo $user;?> <img src="img/layout/gear.svg"></a> | <a class="logout" href="logout">Logout</a> <?php }else{ ?><a data-bs-toggle="modal" data-bs-target="#login">Ingreso</a><?php } ?> </div>
                </div>
                <form class="header-search">   
			       <?php if( $user != '' ){ ?>
                <div class="event-info-buttons"> 
              <a class="ticket-btn" data-bs-toggle="modal" data-bs-target="#compraModal">💈Reservar espacio</a> 
              <?php if( $user == 'Berman' ){?>
              <a class="ticket-btn" id="calendar" href="calendar" type="button" >💈Vista del Calendario</a>
              <?php } ?>
              </div>
              <?php } ?>
            </form>
        
        </div>
        
        
        
    </header>
    
    <main>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		</main>
    <footer>
        <div>©2023 A lo Fresa</div>
        <small><a href="policies.php">Políticas de Privacidad</a> | <a href="terms.php">Términos y Condiciones de Uso</a></small>
    </footer>

<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingreso</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="login" method="POST">
          <div class="form-group">
            <label for="loginInputEmail1">Email</label>
            <input type="text" name="user" class="form-control" id="loginInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="loginInputPassword1">Contraseña</label>
            <input type="password" class="form-control" id="loginInputPassword1" placeholder="Password">
          </div>
            <div class="form-group text-right">                
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup">Registro</button>
              <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
            
            <div class="form-group text-right">
                <small><a>¿Olvidó su contraseña?</a></small>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="signupInputName">Nombre de Usuario</label>
            <input type="email" class="form-control" id="signupInputName" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="signupInputEmail">Email</label>
            <input type="email" class="form-control" id="signupInputEmail" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="signupInputPassword1">Contraseña</label>
            <input type="password" class="form-control" id="signupInputPassword1" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="signupInputPassword2">Repita la Contraseña</label>
            <input type="password" class="form-control" id="signupInputPassword2" placeholder="Password">
          </div>
          <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="compraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reserva tu cita</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <label>Seleccione la fecha que deseas reservar</label>
        <input class="form-control" type="text" onfocus="changeReservationDate()" placeholder="09/12/2023" name="fecha_reserva" id="fecha_reserva">
      
        <?php if( $user == 'Berman' ){ ?>  
      <span class="description">Cliente:</span>                
      <span class="tax">

        <input type="search" list="clients" class="form-control" name="client" placeholder="Escribe el nombre del cliente">

        <datalist id="clients">
          <option value="1 - Gabriel Aguilar | +50683481182" />
          <option value="2 - Jael Mora | +50682607313" />
          <option value="3 - Eithzan Aguilar | +50683589621" />
          <option value="4 - Abigail Aguilar | +50683459127" />
        </datalist>
      </span>
      <?php } ?>

      <span class="description">Servicio:</span>
      <span class="tax">
                      <select class="form-control">
                      <option value="1">Corte de pelo</option>
                      <option value="2">Corte de pelo y barba</option>
                      </select>
      </span>   
      <span class="description">Filtrar por Barbero:</span>
      <span class="tax">
                      <select class="form-control">
                      <option value="0">Todos</option>
                      <option value="1">Berman</option>
                      <option value="2">Joss</option>
                      <option value="2">Dey</option>
                      </select>
      </span>             
      <span class="description">Escoger hora:</span>
      <span class="tax">
                      <select class="form-control" onchange="notificationTime(this.value)">               
      <?php 
      $time_hour = 8;
      $time_minute = '00';
      for($i=0; $i <= 54; $i++){ ?>    
      
        <option value="<?php echo $time_hour.':'.$time_minute;?>"><?php echo $time_hour.':'.$time_minute;?></option>      
      <?php
      if( $time_minute == 45 ){
        $time_minute = '00';
        $time_hour = $time_hour + 1;
      }else{
        $time_minute = $time_minute +15;
      } 
      } 
      ?>  
         </select>
      </span>  
      <div id="notificaciones_check" style="display:none">
      </br>
      <span class="tax">
      <input checked type="checkbox" />
      </span> 
      <span class="description" id="notificaciones_text"><b>Notificarme si se libera un espacio en el rango de 8:00 a 9:00 para el Martes 12 de Setiembre 2023</b></span>
      </br><button type="button" class="btn btn-success"><a>Guardar Notificación</a></button>
      </br>
      </div>
      </br>
      <label><b>Espacios para hoy CORTE DE PELO:</b></label>
          <ul class="ticket-list">
           
              <li class="ticket-on-sale">
                  <span class="number">Hora: 8:00</span>
                  <span class="price">Servicio: Corte de Pelo</span>
                   <span class="price">Tiempo: 1 hora</span>
                  <span class="price">Precio: ₡10.000</span>
                  <span class="price">Barberos disponibles:</span>
                  <span class="price">
                  <input type="radio" name="barbero" id="barbero1">Berman
                  <input type="radio" name="barbero" id="barbero1">Dey
                  <input type="radio" name="barbero" id="barbero1">Joss</span>
                  <button type="button" class="btn btn-secondary"><a>Reservar</a></button>
              </li>  
              <li class="ticket-on-sale">
                  <span class="number">Hora: 8:15</span>
                  <span class="price">Servicio: Corte de Pelo</span>
                   <span class="price">Tiempo: 1 hora</span>
                  <span class="price">Precio: ₡10.000</span>
                  <span class="price">Barberos disponibles:</span>
                  <span class="price">
                  <input type="radio" name="barbero" id="barbero1">Berman
                  <input type="radio" name="barbero" id="barbero1">Dey</span>
                  <button type="button" class="btn btn-secondary"><a>Reservar</a></button>
              </li>   
                
          </ul>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>

function notificationTime(time){
  $('#notificaciones_check').show();
  var time = time.split(':');
  var timeTo = parseFloat(time[0]) + 1; 
  var timeFrom = parseFloat(time[0]) -1; 
  $("#notificaciones_text").html('<b>Notificarme si se libera un espacio en el rango de '+timeFrom+':00 a '+timeTo+':00 para el Martes 12 de Setiembre 2023</b>');
}

  function changeDate(){
    $('#fecha_reserva_admin').attr('type','date');
    setTimeout(() => {
      $('#fecha_reserva_admin').click();
}, "500");
  
  }
  function changeReservationDate(){
    $('#fecha_reserva').attr('type','date');
    setTimeout(() => {
      $('#fecha_reserva').click();
}, "500");
  
  }

</script>


