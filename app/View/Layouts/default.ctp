<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>A lo fresa</title>
    
<script type="text/javascript" src="js/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/script.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    

  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">

</head>

<body>
    <header>
        <div class="slider">
        
            <div class="sliderbox" id="sliderbox">
                <div class="slide"></div>            
            </div>         
                <a class="logo" href="index.php"></a>
                <div class="user">

                <?php 
                 
                 if(!empty($_SESSION['User'])){ ?>
                 <div class="username"><?php echo $_SESSION['User']['User']['name'];?> |  <a href="logout" class="logout">Logout</a> </div>
                 <?php }else{ ?>
                 <div class="username"> <a data-bs-toggle="modal" data-bs-target="#signup">Registrarse</a> | <a data-bs-toggle="modal" data-bs-target="#login">Login</a> </div>
                 <?php } ?>
             </div>
         <?php if(!empty($_SESSION['User'])){ ?>     
         <form class="header-search">   
           <div class="event-info-buttons"> 
           <a class="ticket-btn" data-bs-toggle="modal" data-bs-target="#compraModal">💈Reservar espacio</a> 
           <a class="ticket-btn" id="calendar" href="calendar" type="button" >💈Vista del Calendario</a>
           </div>
         </form>
         <?php } ?>

        
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
        <form>
          <div class="form-group">
            <label for="loginInputEmail1">Telefono</label>
            <input type="number" class="form-control" name="loginNumber" id="loginNumber" aria-describedby="emailHelp" placeholder="Ingrese su numero de Telefono">
          </div>
          <div class="form-group">
            <label for="loginInputPassword1">Contraseña</label>
            <input type="password" class="form-control" name="loginPassw" id="loginPass"  placeholder="Password">
          </div>
            <div class="form-group text-right">                
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup">Registro</button>
              <button type="button" class="btn btn-primary" id="loginNumbers" onclick="login()">Login</button>
            </div>
            <div class="form-group" id="noerror-mail" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este correo no existe, por favor registrese.</b></span></label>
            </div>
            <div class="form-group" id="login-error" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Usuario o contraseña invalidos.</b></span></label>
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
        <h5 class="modal-title" id="exampleModalLabel">Registrarse</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="signup" method="post" id="createUser">
          <div class="form-group">
            <label for="signupName">Nombre Completo*</label>
            <input type="text" class="form-control" id="signupName" name="signupName"  placeholder="Nombre">
          </div>
          <div class="form-group">
            <label for="signupName">Número de Celular*</label>
            <input type="number" class="form-control" id="signupPhone" name="signupPhone"  placeholder="Telefono" onblur="checkPhone(this.value)">
          </div>
          <div class="form-group">
          <label for="signupGender">Genero*</label>
            <select name="signupGender" id="cars">
              <option value="1">Maculino</option>
              <option value="2">Femenino</option>
              <option value="3">indefinido</option>
            </select>
          </div>
          <div class="form-group">
            <label for="signupName">Contraseña*</label>
            <input type="password" class="form-control" id="signupPassword1" name="signupPassword1" placeholder="Contraseña">
          </div>
          <div class="form-group">
            <label for="signupName">Repita la Contraseña*</label>
            <input type="password" class="form-control" id="signupPassword2" name="signupPassword2" placeholder="Contraseña">
          </div>
          </br>
            <div class="form-group" id="error-pass" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Las contraseñas no coinciden.</b></span></label>
            </div>
            <div class="form-group" id="error-mail" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-passChar" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
            </div>
            <div class="form-group" id="error-empty" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
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
        <input class="form-control" type="text" onfocus="changeReservationDate()" placeholder="MM/DD/YYYY" name="fecha_reserva" id="fecha_reserva">
       
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
                      <select class="form-control">               
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
      </br>
      <label><b>Espacios para hoy CORTE DE PELO:</b></label>
          <ul class="ticket-list">
           
              <li class="ticket-on-sale">
                  <span class="number">Hora: 8:00</span>
                  <span class="price">Servicio: Corte de Pelo</span>
                   <span class="price">Tiempo: 1 hora</span>
                  <span class="price">Precio: ₡10.000</span>
                  <span class="price">Barberos disponibles:</span>
                  <span class="price"><input type="radio" name="barbero" id="barbero1">Joss</span>
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

  function login(){
  var logNumber = $('#loginNumber').val();
  var logPassword = $('#loginPass').val();
  $.ajax({
              type: 'POST', 
              url: 'Pages/login', 
              data: 'loginNumber='+logNumber+'&loginPass='+logPassword,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet');    
              },
              success: function(userExist) {
                if(userExist == 1 ){
                  $('#login-error').hide();
                  window.location.reload();
                } else{
                  event.preventDefault();
                  $('#login-error').show();
                }
              }
          });
}

function checkPhone(userPhone){

$.ajax({
              type: 'POST', 
              url: 'Pages/getPhone', 
              data: 'phone='+userPhone,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet');    
              },
              success: function(existPhone) {
                if(existPhone == 1 ){
                  event.preventDefault();
                  $('#error-mail').show();
                  $('#signupPhone').css('border','2px solid red');
                } else{
                  $('#error-mail').hide();
                  $('#signupPhone').css('border','');
                }
              }
});
}

$( "#createUser" ).on( "submit", function( event ) {
  var nombre = $('#signupName').val();
  var celular = $('#signupPhone').val();
  var genero = $('#signupGender').val();
  //var userEmail = $('#signupEmail').val();
  var userContrasena = $('#signupPassword1').val();
  var confirmContrasena = $('#signupPassword2').val();
  var mayuscula = false;
  checkPhone(celular);
 
  if(userContrasena.match(/[A-Z]/)){
    mayuscula = true;
  }

  if( nombre == '' || celular == '' || genero == '' ||( userContrasena != confirmContrasena ) || userContrasena.length < 9 || mayuscula == false){
    event.preventDefault();
    
    if( userContrasena != confirmContrasena ){
      $('#error-pass').show();
      $('#signupPassword2').css('border','2px solid red');
      $('#signupPassword1').css('border','2px solid red');
    }else{
      $('#error-pass').hide();
      $('#signupPassword2').css('border','');
      $('#signupPassword1').css('border','');
    }
    $showError = false;
    if( nombre == '' ){
      $('#signupName').css('border','2px solid red');
      $showError = true;
    }else{
       $('#signupName').css('border','');
    }
    if( genero == '' ){
      $('#signupGender').css('border','2px solid red');
      $showError = true;
    }else{
       $('#signupGender').css('border','');
    }
    if( celular == '' ){
      $showError = true;
      $('#signupPhone').css('border','2px solid red');
    }else{
       $('#signupPhone').css('border','');
    }
    if( (userContrasena.length < 9) || (mayuscula == false) ){
      $('#signupPassword1').css('border','2px solid red');
      $('#error-passChar').show();
    }else{
       $('#signupPassword1').css('border','');
       $('#error-passChar').show();
    }
    if ($showError){
      $('#error-empty').show();
    }else{
      $('#error-empty').hide();
    }
  }else{
    window.scrollTo(0, 0);
    $('.close').click();
    $('#userCreated').show();
        setInterval(function() {
            $('#userCreated').hide('2000');
            $('#login').show();
          }, 10000);
    
  }
  
});

var input = document.getElementById("loginPass");
input.addEventListener("keypress", function(event) {
  // If the user presses the "Enter" key on the keyboard
  if (event.key === "Enter") {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("loginNumbers").click();
  }
});

</script>


