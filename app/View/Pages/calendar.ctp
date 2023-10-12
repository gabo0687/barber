<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>A lo fresa</title>
<link rel="icon" type="image/png" sizes="16x16"  href="img/layout/favicon-16x16.png">
<script type="text/javascript" src="js/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/script.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/index.global.js"></script>

<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
<script src="https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>

<style>
  .event-warning{
    --fc-event-border-color:#fff;
  }
  
  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }



/* Dropdown Button */
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

/* The search field */
#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

/* The search field when it gets focus/clicked on */
#myInput:focus {outline: 3px solid #ddd;}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  border: 1px solid #ddd;
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}

/* Add your custom styles here */

.searchable-dropdown {
        position: relative;
        width: 200px;
    }

    #reservation_client {
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



.fc .fc-scroller-harness-liquid{
        height: auto !important;
    }
    
    .fc .fc-scroller-liquid-absolute{
        position: relative !important;;
    }



</style>  
</head>
<body>
<div class="container">
<div class="page-header">
<div class="pull-left form-inline">
<div class="btn-group">
<a class="btn btn-success" href="home">Regresar a página principal</a>
<a class="btn btn-info" onclick="openCita()" style="color:white">Crear Cita</a>
</div></br></br>
<div class="btn-group">
<?php foreach( $barbers as $barber ){ ?>
  <a class="btn" style="background-color:<?php echo $barber['User']['color'];?> ; color:white"><?php echo $barber['User']['name'];?></a>
<?php } ?>
</div>
</br></br>
</div>
</div>
</div>
  <div id="calendar"></div>

        <div id="calendarModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div id="modalBody" class="modal-body">
                <span class="description"><b>Barbero:</b> </span>
                <select class="form-control"  name="barberoAppointment" id="barberoAppointment">
                  <?php foreach( $barbers as $barber ){ ?>
                    <option value="<?php echo $barber['User']['id'];?>"><?php echo $barber['User']['name'];?></option>
                    <?php } ?>
                </select></br>
                <span class="description"><b>Servicio:</b> </span><span id="appointmentService"></span></br>
                <span class="description"><b>Hora:</b> </span><span id="appointmentTime"></span></br>
                <span class="description"><b>Precio:</b> </span><span id="appointmentPrice"></span></br>
                <input type="hidden" name="appointmentId" id="appointmentId" value="0"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="editAppointment" onclick="">Editar Cita</button>
                    <button type="button" class="btn btn-default" id="CancelAppointment" onclick="">Cancelar Cita</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>
        </div>

        <div id="calendarModalAdd" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title-date"></h4>
                </div>
                <div id="modalBody" class="modal-body">
               
                <div class="dropdown">
                  
                  <span style="color:red; display:none;" id="errorCliente">Debes seleccionar a un cliente de la lista</span>
                  <span style="color:red; display:none;" id="errorClienteFormat">Debes seleccionar a un cliente de la lista</span>
                  <span style="color:red; display:none;" id="alreadytaken">Este horario ya fue reservado por alguien más, por favor cambie su elección</span>
                  
                </div>
               
                  </br>
                <span class="description">Cliente:</span>        
                <span class="tax">
                <div class="input-container">
                <input type="text" id="reservation_client" name="reservation_client" class="form-control" placeholder="Escribe el nombre del cliente">
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


                <span class="description"><b>Servicio:</b></span>
                <span class="tax">
                  <select class="form-control" name="services" id="services" multiple>
                    <?php foreach( $services as $service ){ ?>
                    <option value="<?php echo $service['Service']['id'];?>"><?php echo $service['Service']['service_name'];?></option>
                    <?php } ?>
                  </select>
                </span> 
                <span class="description"><b>Barbero:</b>
                <select class="form-control" name="barbero" id="barbero">
                <?php foreach( $users as $user ){?>
                <option value="<?php echo $user['User']['id'];?>"><?php echo $user['User']['name'];?></option>
                <?php } ?>
                </select>
                
                <span class="description"><b>Escoger hora:</b> </span>
                <select name="reservationTime" id="reservationTime" class="form-control" >
                <?php 
                  $time_hour = 7;
                  $time_minute = '00';
                  for($i=0; $i <= 60; $i++){ 
                    if( $time_minute != 60 ){
                      if( $time_hour < 10 ){
                        if(strlen($time_hour) == 2){
                          $time_hour = substr($time_hour, 1);
                        }
                        $time_hour = '0'.$time_hour;
                      }
                    ?>    
                  
                    <option value="<?php echo $time_hour.':'.$time_minute.':00';?>"><?php echo $time_hour.':'.$time_minute;?></option>      
                  <?php
                    }
                  if( $time_minute == 45 ){
                    $time_minute = '00';
                    $time_hour = $time_hour + 1;
                  }else{
                    if( $time_minute == 60 ){
                      $time_minute = '00';
                    $time_hour = $time_hour + 1;
                    }else{
                      if( $time_minute == 00 || $time_minute == 15|| $time_minute == 30 ){
                        $time_minute = $time_minute +15;
                      }
                    }  
                  } 
                  } 
                  ?>  
                </select>
              </br>
                </div>
                <div class="modal-footer">
                
                    <input type="hidden" id="reservationDate" name="reservationDate" value="" ></br>
                    <button type="button" class="btn btn-default" id="saveAppointmentButton" onclick="saveAppointment()">Guardar Cita<span class="spinner-border-sm" id="loadingReservation"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModalAdd()">Cerrar</button>
                </div>
            </div>
        </div>
        </div>


</body>
</html>
<script>

function openCita(){
  $('#calendarModalAdd').modal("show");
}

function selectClient(client){
          $('#reservation_client').val(client);
          $('#dropdown-list').hide();
          $('#reservation_client').attr('readonly','readonly');
        }
        
        const searchInput = document.getElementById("reservation_client");
        const dropdownList = document.getElementById("dropdown-list");

        const inputField = document.getElementById("reservation_client");
        const clearButton = document.getElementById("clear-button");


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
            $('#reservation_client').removeAttr('readonly');
            dropdownList.classList.add("hidden");
            $('#dropdown-list').removeAttr('style');
            $('#reservation_client').focus();
        });

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


setInterval(function () { loadReservations(); }, 10000);

function cleanUsers(){
  
  $('#reservation_client').val('');
  
}
function reservationClient(user_id,user_text){
  $('#reservation_client').val(user_id);
  myFunction();
}

var calendar = '';

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next',
          center: 'title',
          right: 'timeGridDay'
        },
        initialDate: '<?php echo date('Y-m-d');?>',
        initialView: 'timeGridDay',
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        select: function(arg) {
          const fechaComoCadena = arg.start; // día lunes
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
          const timeReservation = new Date(fechaComoCadena).getTime();
          var reservationDate = formatDate(new Date(timeReservation));
          var reservationTime = formatTime(new Date(timeReservation));
          $('#reservationDate').val(reservationDate);
          $('#reservationTime').val(reservationTime);
          //fecha_reserva
          reservationDateText = nombreDia+' '+dia+' de '+nombreMes+' '+anio;
          $('#modal-title-date').html('Cita '+reservationDateText);
          cleanUsers();

          $('#calendarModalAdd').modal("show");
          
          calendar.unselect()
        },
        eventClick: function(arg) {
          $('#modal-title').html('Cita '+arg.event.title);
          const fechaComoCadena = arg.event.start; // día lunes
                
          const timeReservation = new Date(fechaComoCadena).getTime();
          var reservationDate = formatDate(new Date(timeReservation));
          var reservationTime = formatTime(new Date(timeReservation));
          var reservation_time = reservationTime;
          var reservation_date = reservationDate;
          loadAppointment(arg.event.groupId,reservation_time,reservation_date);
          $('#appointmentId').val(arg.event.groupId);
          
          
          $('#calendarModal').modal("show");
         
        },
        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events
        events: 'events'
      });

      calendar.render();
  });

  


  function loadReservations(){
    
   $.ajax({
                type: 'POST', 
                url: 'events', 
                data: 'reservationDate=0',
                beforeSend:function() {  
                  //$('#loadingNotification').addClass('spinner-border');
                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(reservation_events) {
                  calendar.refetchEvents();
                  //$('#calendar').fullCalendar('refetchEvents');
                }
	});
  }
  

</script>
<script>
  function editarAppointment(appointmentId){

    const response = confirm("Esta seguro que quiere Editar la cita?");
    if (response) {
      
      var barberId = $('#barberoAppointment').val();

      $.ajax({
        type: 'POST', 
        url: 'edit_appointment', 
        data: 'reservation_id='+appointmentId+'&barberId='+barberId,
        beforeSend:function() {  
          //$('#loadingNotification').addClass('spinner-border');
        },
        error: function(){
            
        alert('No hay internet');    
        },
        success: function(reservation) {
          window.location.reload();
        }
      });
    }
  }

  function loadAppointment(appointmentId,reservation_time,reservation_date){
    
   
    $('#CancelAppointment').attr('onclick','cancelAppointment('+appointmentId+',"'+reservation_time+'","'+reservation_date+'")');
    $('#editAppointment').attr('onclick','editarAppointment('+appointmentId+')');
    $.ajax({
            type: 'POST', 
            url: 'load_appointment', 
            data: 'reservation_id='+appointmentId,
            beforeSend:function() {  
              //$('#loadingNotification').addClass('spinner-border');
            },
            error: function(){
                
            alert('No hay internet');    
            },
            success: function(reservation) {
              const res = JSON.parse(reservation);
              
              $('#appointmentService').html(res[0]);
              $('#barberoAppointment').val(res.Barber.id);
              $('#appointmentTime').html(res.Reservation.reservation_time);
              $('#appointmentPrice').html(res.Reservation.reservation_price);
            }
	        });
  }

  

  function cancelAppointment(appointmentId,reservation_time,reservation_date){

        const response = confirm("Esta seguro que quiere Eliminar la cita?");
        
        if (response) {
          $.ajax({
            type: 'POST', 
            url: 'cancel_appointment', 
            data: 'reservation_id='+appointmentId+'&reservation_time='+reservation_time+'&reservation_date='+reservation_date,
            beforeSend:function() {  
              //$('#loadingNotification').addClass('spinner-border');
            },
            error: function(){
                
            alert('No hay internet');    
            },
            success: function(reservation) {
              window.location.reload();
            }
          });
        }
            
    
  }
  function closeModal(){
 
    
   $('#calendarModal').modal("hide");
    
  }
  function closeModalAdd(){
    
    $('#calendarModalAdd').modal("hide");
    location.reload();
  }
 
  function padTo2Digits(num) {
  return num.toString().padStart(2, '0');
}

function formatDate(date) {
  return (
    [
      date.getFullYear(),
      padTo2Digits(date.getMonth() + 1),
      padTo2Digits(date.getDate()),
    ].join('-')
  );
}
function formatTime(date) {
  return (
    [
      padTo2Digits(date.getHours()),
      padTo2Digits(date.getMinutes()),
      padTo2Digits(date.getSeconds()),
    ].join(':')
  );
}

function saveAppointment(){
 
 var reservationDate    = $('#reservationDate').val();
 var reservationBarber  = $("#barbero").val();
 var reservationService = $('#services').val();
 var reservationTime    = $('#reservationTime').val();
 var reservation_client = $('#reservation_client').val();

 if( reservation_client != '' ){
  var client = $('#reservation_client').val();
  var splitClient = client.split('-');
  if( splitClient.length < 2 ){
    $('#errorClienteFormat').hide();
  }else{
    $.ajax({
                  type: 'POST', 
                  url: 'save_reservation_calendar', 
                  data: 'reservation_date='+reservationDate+'&reservation_client='+splitClient[0]+'&reservation_time='+reservationTime+'&reservation_service='+reservationService+'&reservation_barber='+reservationBarber,
                  beforeSend:function() {  
                    $('#saveAppointmentButton').prop('disabled', true);
                    $('#loadingReservation').addClass('spinner-border');
                  },
                  error: function(){
                      
                  alert('No hay internet');    
                  },
                  success: function(response) {
                    
                    if( response == 4 ){
                      $('#alreadytaken').show();
                      $('#errorCliente').hide();
                      $('#errorClienteFormat').hide();
                      $('#saveAppointmentButton').prop('disabled', false);
                      $('#loadingReservation').removeClass('spinner-border');
                    }else{
                      $('#alreadytaken').hide();
                      $('#errorCliente').hide();
                      $('#errorClienteFormat').hide();
                      setTimeout(() => {
                        
                      $('#saveAppointmentButton').prop('disabled', false);
                        location.reload();
                      }, '3000'); 
                    }
                    
                    
                    
                  }
    });
}
 }else{
  $('#errorCliente').show();
 }
}
  </script>
