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
<style>
  .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

  /* Add your custom styles here */

    .searchable-dropdown {
        position: relative;
        width: 200px;
    }

    #client {
        width: 100%;
        padding: 10px;
        
    }

    #dropdown-list {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 100%;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }

    #dropdown-list li {
        padding: 10px;
        cursor: pointer;
    }

    #dropdown-list li:hover {
        background-color: #f0f0f0;
    }

    .hidden {
        display: none;
    }




.input-container {
    position: relative;
    width: 100%;
}


#clear-button {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}


</style>  
<?php
date_default_timezone_set('America/Costa_Rica');

?>
</head>

<body>
    <header>
    <div style="display:none;" id="userUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Usuario actualizado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
        <hr>
    </div>
    <div style="display:none;" id="userCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Usuario creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" />Se te ha enviado un Whatsapp por favor Confirma tu cuenta</p>
        <hr>
    </div>
    <div style="display:none;" id="saleDone" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Venta realizada con exito! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
        <br>
    </div>
    <div style="display:none;" id="productCreated" class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Producto creado! </h4>
            <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
          </div>
          <div style="display:none;" id="productUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
      <h4 class="alert-heading">Producto actualizado! </h4>
      <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      <br>
    </div>
    <div style="display:none;" id="expenseCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Gasto creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
    </div>
    <div style="display:none;" id="expenseUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Gasto actualizado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
    </div>
    <div style="display:none;" id="customerCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Cliente creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      </div>
      <div style="display:none;" id="customerUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Cliente actualizado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      </div>
      <div style="display:none;" id="profileUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Perfil actualizado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      </div>
        <div class="slider">
        
            <div class="sliderbox" id="sliderbox">
                <div class="slide"></div>            
            </div>         
                <a class="logo" href="home"></a>
                <div class="user">

                <?php 
                 
                 if(!empty($_SESSION['User'])){ 
                  $_SESSION['Messagenotification'] = $Messagenotification;
                  ?>
                 <div class="username">
                 <a class="btn btn-secondary" href="whatsapp">
                  <i class="fa fa-bell"></i>
                  <span class="badge"><?php echo $Messagenotification;?></span>
                 </a>
                  <a class="user-edit btn btn-info" href="account"><?php echo $_SESSION['User']['User']['name'];?>  <img src="img/layout/gear.svg"></a>  <a href="logout" class="logout btn btn-danger">Logout</a> </div>
                 <?php }else{ ?>
                 <div class="username"><a data-bs-toggle="modal" data-bs-target="#signup" class="btn btn-warning" style="color:white">Registrarse</a> <a data-bs-toggle="modal" data-bs-target="#login" class="btn btn-success">Login</a> </div>
                 <?php } ?>
             </div>
         <?php if(!empty($_SESSION['User'])){ ?>
         <form class="header-search">   
         <div class="event-info-buttons"> 
           <a class="ticket-btn" data-bs-toggle="modal" data-bs-target="#compraModal" onclick="filterReservations()">💈Reservar espacio</a> 
           <?php 
            $hasPermission = false;
            $menuRoles = $_SESSION['Role'];
            foreach( $menuRoles as $menuRole ){
              $moduleId = $menuRole['Role']['id_module'];
              if( $moduleId == 2 ){
                $hasPermission = true;
              }
            }
           if( $_SESSION['User']['User']['type'] == '1' || $_SESSION['User']['User']['type'] == '4' || $hasPermission ){ ?> 
           <a class="ticket-btn" id="calendar" href="calendario" type="button" >💈Vista del Calendario</a>
           </div>
          </form>
         <?php }
              } ?>

        
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
            <input type="password" class="form-control" name="loginPass" id="loginPass"  placeholder="Password">
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
            <!--<div class="form-group text-right">
                <small><a>¿Olvidó su contraseña?</a></small>
            </div>-->
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrarse/Cambio contraseña</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="saveUser" method="post" id="createUser" onsubmit="createUser()">
          <div class="form-group">
            <label for="signupName">Nombre y apellidos completos*</label>
            <input type="text" class="form-control" id="signupName" name="signupName"  placeholder="Nombre y apellidos">
          </div>
          <div class="form-group">
            <label for="signupName">Número de Celular (Whatsapp)*</label>
            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" class="form-control" id="signupPhone" name="signupPhone"  onblur="checkPhone(this.value)" placeholder="Telefono" >
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
            <input name="checkNumber" type="hidden" id="checkNumber" value="0" />
          <div class="form-group text-right">
              <input type="submit" class="btn btn-primary" value="Enviar" />
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
        <input class="form-control" type="text" onchange="filterReservations()" onfocus="changeReservationDate()" placeholder="<?php echo date('m/d/Y');?>" name="fecha_reserva" id="fecha_reserva" >
        <input type="hidden" name="user_type" id="user_type" value="<?php echo $user['User']['type'];?>">
      


        


        <?php 
        if( $user['User']['type'] == 1 || $user['User']['type'] == 2 || $user['User']['type'] == 4 ){ ?>  
          <span class="description">Cliente:</span>        
         <span class="tax">

         <div class="input-container">
          <input type="text" id="client" name="client" class="form-control" placeholder="Escribe el nombre del cliente">
          <span id="clear-button" class="hidden">×</span>
        </div>

        <ul id="dropdown-list" class="hidden">
        <?php foreach( $clients as $client ){
          $clientSelected = "'".$client['User']['id'].'-'.$client['User']['name'].' | '.$client['User']['phone']."'";
           ?>
            <li onclick="selectClient(<?php echo $clientSelected;?>)"><?php echo $client['User']['id'];?>-<?php echo $client['User']['name'];?> | <?php echo $client['User']['phone'];?></li>
            <?php } ?>
        </ul>
        </span>
        <?php } ?>
        
      <span id="clientError" style="display:none; color:red">Selecciona un cliente</br></span>
      <span id="clientFormatError" style="display:none; color:red">Debes seleccionar a un cliente de la lista</br></span>
      
      

      <span class="description">Servicio:</span>
      <span class="tax">
                      <select class="form-control" onchange="filterReservations()" name="services" id="services" multiple>
                        <?php 
                        foreach( $services as $service ){ 
                          if( $service['Service']['price'] != "0"){
                            $serviceType = '';
                            if( $service['Service']['gender'] == 1 ){ $serviceType = 'Hombre'; }
                            if( $service['Service']['gender'] == 2 ){ $serviceType = 'Mujer'; }
                            if( $service['Service']['gender'] == 3 ){ $serviceType = 'Unisex'; }
                            ?>
                          <option value="<?php echo $service['Service']['id'];?>"><?php echo $service['Service']['service_name'].' / '.$serviceType;?></option>
                          <?php 
                          }
                          } ?>
                      </select>
      </span>   
      <span class="description">Filtrar por Barbero:</span>
      <span class="tax">
                      <select class="form-control" onchange="filterReservations()" name="barber" id="barber">
                      <option value="0">Todos</option>
                      <?php foreach( $users as $barberUser ){?>
                      <option value="<?php echo $barberUser['User']['id'];?>"><?php echo $barberUser['User']['name'];?></option>
                      <?php } ?>
                      </select>
      </span>             
      <span class="description">Escoger hora:</span>
      <span class="tax">
      <select class="form-control" onchange="filterReservations()" name="reservation_time" id="reservation_time"> 
      <option value="0">Todas</option>              
      <?php 
      $time_hour = 7;
      $time_minute = '00';
      for($i=0; $i <= 30; $i++){ 
        if( $time_minute != 60 ){
        ?>    
      
        <option value="<?php echo $time_hour.':'.$time_minute;?>"><?php echo date("h:i A", strtotime($time_hour.':'.$time_minute));?></option>      
      <?php
        }
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
      </span>  
      <div id="notificaciones_check" style="display:none">
      </br>
      <span class="description" id="notificaciones_text"></span>
      </br><button type="button" class="btn btn-success" onclick="saveNotification(<?php echo $_SESSION['User']['User']['type'];?>)"><a>Guardar Notificación</a> <span class="spinner-border-sm" id="loadingNotification"></span></button>
      </br>
      
      </br>
      </div>
      <span style="color:green; display:none" id="notificationMessage"><b>Notificación guardada exitosamente!</b></span>
      <span id="notificationError" style="display:none; color:red">Debes seleccionar a un cliente de la lista para crear la notificación</br></span>
      
      </br>
      <label id="ServiceText"></label>
          <ul class="ticket-list">  
            <li id="loading" class=""></li>
          </ul>
      </div>
    </div>
  </div>
</div>

<audio id="audioWhatsapp" controls style="display:none">
<source type="audio/mp3" src="codigos/beep-beep.mp3">
</audio>
<button id="notification" onclick="whatsappMessage()">Audio</button>

</body>
</html>
<script>
    
        function triggerNotification() {
         
          if ('Notification' in window) {
        Notification.requestPermission().then(function(permission) {
          
            if (permission === 'granted') {
              let text;
              <?php if($_SESSION['newNotification'] == 1){ ?>
                if (confirm("Tienes un mensaje nuevo!") == true) {
                  text = "You pressed OK!";
                  
                } else {
                  text = "You canceled!";
                }
                alert(text);
                <?php } ?>
            } else {
                console.log('Permission denied for notifications');
            }
        });
    } else {
        console.log('This browser does not support desktop notifications.');
    }
}
setTimeout(triggerNotification, 5000);
              
            
    



  function whatsappMessage(){
    var audio = document.getElementById("audioWhatsapp");
      audio.play();
  }
 
  var loginNumber = localStorage.getItem("username");
  var loginPass   = localStorage.getItem("password");
  $('#loginNumber').val(loginNumber);
  $('#loginPass').val(loginPass);
        
        const inputField = document.getElementById("client");
        const clearButton = document.getElementById("clear-button");

        const searchInput = document.getElementById("client");
        const dropdownList = document.getElementById("dropdown-list");

        inputField.addEventListener("input", function () {
            if (inputField.value.trim() !== "") {
                clearButton.classList.remove("hidden");
            } else {
                clearButton.classList.add("hidden");
            }
        });

        clearButton.addEventListener("click", function () {
            inputField.value = "";
            clearButton.classList.add("hidden");
            $('#client').removeAttr('readonly');
            dropdownList.classList.add("hidden");
            $('#dropdown-list').removeAttr('style');
            $('#client').focus();
        });


        function selectClient(client){
          $('#client').val(client);
          $('#dropdown-list').hide();
          $('#client').attr('readonly','readonly');
          
        }
        
        

        searchInput.addEventListener("input", function () {
            const filter = searchInput.value.toLowerCase();
            const options = dropdownList.getElementsByTagName("li");

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.textContent.toLowerCase().includes(filter)) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none";
                }
            }

            if (filter === "") {
                dropdownList.classList.add("hidden");
            } else {
                dropdownList.classList.remove("hidden");
            }
        });



function reservar(reservationNumber){
 
  var reservationDate    = $('#fecha_reserva').val();
  var reservationBarber  = $("#barbero_"+reservationNumber+":checked").val();
  var reservationService = $('#service_'+reservationNumber).val();
  var reservationTime    = $('#time_'+reservationNumber).val();
  var reservationPrice    = $('#price_'+reservationNumber).val();
  
  var user_type = $('#user_type').val();
  var client = 0;
  var clientEmpty = true;
  var clientFormat = true;
  if( user_type == 1 || user_type == 2 ){
    client    = $('#client').val();
    if( $('#client').val() == '' ){
      clientEmpty = false;
    }else{
      var splitClient = client.split('-');
      if( splitClient.length < 2 )
        clientFormat = false;
      }
    
  }
  
  if( undefined != reservationBarber && clientEmpty && clientFormat ){
   
    $.ajax({
                  type: 'POST', 
                  url: 'save_reservation', 
                  data: 'reservation_date='+reservationDate+'&client='+client+'&reservation_time='+reservationTime+'&reservation_service='+reservationService+'&reservation_barber='+reservationBarber+'&reservationPrice='+reservationPrice,
                  beforeSend:function() {  
                    $('#loadingReservation'+reservationNumber).addClass('spinner-border');
                  },
                  error: function(){
                      
                  alert('No hay internet');    
                  },
                  success: function(notification) {
                    if( notification == 3 ){
                      $('#messageReservationError'+reservationNumber).hide();
                      $('#loadingReservation'+reservationNumber).removeClass('spinner-border');
                      $('#messageValidate'+reservationNumber).show();
                      $('#messageValidateTaken'+reservationNumber).hide();
                    }else{
                      if( notification == 4 ){
                        $('#messageReservationError'+reservationNumber).hide();
                        $('#loadingReservation'+reservationNumber).removeClass('spinner-border');
                        $('#messageValidate'+reservationNumber).hide();
                        $('#messageValidateTaken'+reservationNumber).show();
                        setTimeout(() => {
                          filterReservations();
                        }, "4000");
                      }else{
                        $('#loadingReservation'+reservationNumber).removeClass('spinner-border');
                        $('#messageReservation'+reservationNumber).show();
                        $('#button'+reservationNumber).hide();
                        $('#messageReservationError'+reservationNumber).hide();
                        $('#messageValidate'+reservationNumber).hide();
                        $('#messageValidateTaken'+reservationNumber).hide();
                        $('#clientError').hide();
                        $('#client').val('');
                        setTimeout(() => {
                          location.reload();
                        }, "2000");
                    }
                     
                  } 
                  }
    });
 }else{
  if( !clientFormat ){
    $('#clientFormatError').show();
    $('#compraModal').scrollTop(0);
  }else{
    $('#clientFormatError').hide();
  }

  if( !clientEmpty ){
    $('#clientError').show();
    $('#compraModal').scrollTop(0);
  }else{
    $('#clientError').hide();
  }
  if( undefined == reservationBarber ){
    $('#messageReservationError'+reservationNumber).show();
  }else{
    $('#messageReservationError'+reservationNumber).hide();
  }
  
 }
}

function saveNotification(UserType){
  var clientCurrent = '';
  var showError = false;
  if( UserType == 1 || UserType == 2 ){
    var CurrentUser = $('#client').val();
    var reservaUser = CurrentUser.split('-');
    clientCurrent = reservaUser[0]; 
    if( CurrentUser == '' ){
      showError = true;
    }
  }
  if( !showError ){
    $('#notificationError').hide();
    var reservationDate = $('#fecha_reserva').val();
    var reservationFilterTime = $('#reservation_time').val();
    $.ajax({
                  type: 'POST', 
                  url: 'save_notification', 
                  data: 'reservationDate='+reservationDate+'&reservationFilterTime='+reservationFilterTime+'&clientCurrent='+clientCurrent,
                  beforeSend:function() {  
                    $('#loadingNotification').addClass('spinner-border');
                  },
                  error: function(){
                      
                  alert('No hay internet');    
                  },
                  success: function(notification) {
                  
              
                    $('#loadingNotification').removeClass('spinner-border');
                    $('#notificaciones_check').hide();
                    $('#notificationMessage').show();  
                  }
    });
  }else{
    $('#notificationError').show();
  }
  
}

function filterReservations(){
  
  var reservationServices = $('#services').val();
  var reservationServicesText = $('#services option:selected').text();
  var reservationDate = $('#fecha_reserva').val();
  var reservationDateText = 'hoy';
  if( reservationDate != '' ){
    const fechaComoCadena = reservationDate+" 23:37:22"; // día lunes
    const dias = [
      'Domingo',
      'Lunes',
      'Martes',
      'Miércoles',
      'Jueves',
      'Viernes',
      'Sábado',
    ];
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    
    const numeroDia = new Date(fechaComoCadena).getDay();
    const nombreDia = dias[numeroDia];
    const numeroMes = new Date(fechaComoCadena).getMonth();
    const nombreMes = meses[numeroMes];
    const anio = new Date(fechaComoCadena).getFullYear();
    const dia = new Date(fechaComoCadena).getDate();
    

    reservationDateText = nombreDia+' '+dia+' de '+nombreMes+' '+anio;
  }
  $('#ServiceText').html('<b>Espacios para '+reservationDateText+' '+reservationServicesText+' disponibilidad más cercana:</b>');
  var reservationBarber = $('#barber').val();
  var reservationFilterTime = $('#reservation_time').val();
  $.ajax({
                type: 'POST', 
                url: 'load_reservations', 
                data: 'reservationDate='+reservationDate+'&reservationServices='+reservationServices+'&reservationBarber='+reservationBarber+'&reservationTime='+reservationFilterTime,
                beforeSend:function() {  
                  $('#loading').addClass('spinner-border');
                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(services) {
               
                  
                        $('#ServiceText').show();
                        const res = JSON.parse(services);
                        if( res.length != 0 ){
                        var reservationTime = '';
                        var reservationService = '';
                        var reservationDuration = '';
                        var reservationPrice = '';
                        var reservationBarbers = '';
                        var responseHtml = '';
                        var reservationNumber = 0;
                        var barberNumber = 0;
                        Object.entries(res).forEach((entry) => {
                          reservationTime = entry[1].Time;
                          reservationService = entry[1].Service;
                          reservationServiceId = entry[1].ServiceId;
                          reservationDuration = entry[1].Duration;
                          reservationPrice = entry[1].Price;
                          reservationBarbers = entry[1].Barbers;
                          if( reservationBarbers.length > 0 && reservationPrice > 0 ){
                            responseHtml += '<li class="ticket-on-sale"><span class="number">Hora: '+convertirHoraAMPM(reservationTime)+'</span>';
                            responseHtml += '<input type="hidden" name="time_'+reservationNumber+'" id="time_'+reservationNumber+'" value="'+reservationTime+'">';
                            
                            responseHtml += '<span class="price">Servicio: '+reservationService+'</span>';
                            responseHtml += '<input type="hidden" name="service_'+reservationNumber+'" id="service_'+reservationNumber+'" value="'+reservationServiceId+'">';
                              
                            responseHtml += '<span class="price">Tiempo: '+reservationDuration+' minutos</span>';
                            responseHtml += '<span class="price">Precio: ₡'+reservationPrice+'</span>';
                            responseHtml += '<input type="hidden" name="price_'+reservationNumber+'" id="price_'+reservationNumber+'" value="'+reservationPrice+'">';
                            responseHtml += '<span class="price">Barberos disponibles:</span></br>';
                            responseHtml += '<span class="price">';
                            Object.entries(reservationBarbers).forEach((barber) => {
                              
                              responseHtml += '<input type="radio" name="barbero_'+reservationNumber+'" id="barbero_'+reservationNumber+'" value="'+barber[1].User.id+'">'+barber[1].User.name+'</br>';
                              barberNumber++;
                            });
                            
                            responseHtml += '</br><button type="button" class="btn btn-success" id="button'+reservationNumber+'" onclick="reservar('+reservationNumber+')"><a>Reservar </a> <span class="spinner-border-sm" id="loadingReservation'+reservationNumber+'"></span></button>';
                            responseHtml += '</br><span id="messageReservation'+reservationNumber+'" class="blink_me" style="color:white; display:none">Reservación creada con exito!</span>';
                            responseHtml += '</br><span id="messageReservationError'+reservationNumber+'" class="blink_me" style="color:white; display:none">Error! Por favor selecciona un barbero</span>';
                            responseHtml += '</br><span id="messageValidate'+reservationNumber+'" class="" style="color:white; display:none">Error! el cliente ya tiene 2 reservaciones activas, si desea realizar otra reservación contactenos<a taget="_blank" href="https://api.whatsapp.com/send?phone=50684937440"><img width="30px" src="img/layout/whatsapp.png" alt=""></a></span>';
                            responseHtml += '</br><span id="messageValidateTaken'+reservationNumber+'" class="" style="color:white; display:none">Este horario ya fue reservado por alguien más, por favor cambie su elección<a taget="_blank" href="https://api.whatsapp.com/send?phone=50684937440"><img width="30px" src="img/layout/whatsapp.png" alt=""></a></span>';
                            
                            responseHtml += '</li>';
                            reservationNumber++;
                          }
                        });
                        $('#loading').removeClass('spinner-border');
                        $('.ticket-list').html(responseHtml);  
                        notificationTime(reservationFilterTime,reservationDateText);
                       }else{
                        $('#loading').removeClass('spinner-border');
                          $('#ServiceText').hide();
                          if( reservationDate == '' ){
                            const date = new Date(); 
                            let month= date.getMonth()+1; 
                            let day= date.getDate(); 
                            var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                            reservationDate = day+' de '+meses[month-1];
                          }
                          $('.ticket-list').html('<h4 style="text-align: center;">No hay reservaciones disponibles en ese horario por favor selecciona otra fecha</h4>');  
                        }
                      }
                  
	});
}

function convertirHoraAMPM(horaMilitar) {
  // Divide la cadena de la hora militar en horas y minutos
  var partesHora = horaMilitar.split(":");
  var horas = parseInt(partesHora[0]);
  var minutos = parseInt(partesHora[1]);

  // Determina si es AM o PM
  var periodo = horas < 12 ? "AM" : "PM";

  // Convierte las horas al formato de 12 horas
  if (horas > 12) {
    horas = horas - 12;
  } else if (horas === 0) {
    horas = 12;
  }

  // Formatea la hora en AM/PM
  var horaAMPM = horas.toString().padStart(2, "0") + ":" + minutos.toString().padStart(2, "0") + " " + periodo;

  return horaAMPM;
}


var checkNumber = false;
function notificationTime(time,reservationDateText){
  if( time != 0 ){
    $('#notificationMessage').hide(); 
    var time = time.split(':');
    var timeTo = parseFloat(time[0]) + 1; 
    var timeFrom = parseFloat(time[0]) -1; 
    $('#notificaciones_check').show();
    if( reservationDateText != 'hoy' ){
      reservationDateText = 'el '+reservationDateText;
    }
    $("#notificaciones_text").html('<b>Notificarme si se libera un espacio en el rango de '+timeFrom+':00 a '+timeTo+':00 para '+reservationDateText+'</b>');
  }
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

  function checkPhone(userPhone){

$.ajax({
              type: 'POST', 
              url: 'Pages/getPhone', 
              data: 'phone='+userPhone,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet8');    
              },
              success: function(existPhone) {
              
                if(existPhone == 1 ){
                  event.preventDefault();
                  checkNumber = true;
                 
                } else{
                  checkNumber = false;
                }
              }
});
}


function login(){
  var logNumber = $('#loginNumber').val();
  var logPassword = $('#loginPass').val();
  
  $.ajax({
              type: 'POST', 
              url: 'Pages/loginUser', 
              data: 'loginNumber='+logNumber+'&loginPass='+logPassword,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet');    
              },
              success: function(userExist) {
                if(userExist == 1 ){
                  localStorage.setItem("username", logNumber);
                  localStorage.setItem("password", logPassword);
                  $('#login-error').hide();
                  window.location.reload();
                } else{
                  event.preventDefault();
                  $('#login-error').show();
                }
              }
          });
}



function createUser() {
  var nombre = $('#signupName').val();
  var celular = $('#signupPhone').val();
  //var userEmail = $('#signupEmail').val();
  var userContrasena = $('#signupPassword1').val();
  var confirmContrasena = $('#signupPassword2').val();
  var mayuscula = false;
  checkPhone(celular);
  $('#checkNumber').val(checkNumber);
  if(userContrasena.match(/[A-Z]/)){
    mayuscula = true;
  }
  if( nombre == '' || celular == '' ||( userContrasena != confirmContrasena ) || userContrasena.length < 9 || mayuscula == false){
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
       $('#error-passChar').hide();
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
    setTimeout(() => {
            $('#userCreated').hide('2000');
            $('#login').show();
          }, '10000');
    
  }
  
}

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


