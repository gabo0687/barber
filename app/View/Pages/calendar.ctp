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

<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
<script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>

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

</style>
</head>
<body>
<div class="container">
<div class="page-header">
<div class="pull-left form-inline">
<div class="btn-group">
<a class="btn btn-success" href="home">Regresar a página principal</a></br>
<a class="btn btn-warning">Berman</a>
<a class="btn btn-info">Joss</a>
<a class="btn btn-success">Dey</a>
</div>
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
                <span class="description"><b>Barbero:</b> </span><span id="appointmentTitle"></span></br>
                <span class="description"><b>Servicio:</b> </span><span id="appointmentService"></span></br>
                <span class="description"><b>Hora:</b> </span><span id="appointmentTime"></span></br>
                <span class="description"><b>Precio:</b> </span><span id="appointmentPrice"></span></br>
                <input type="hidden" name="appointmentId" id="appointmentId" value="0"/>
                </div>
                <div class="modal-footer">
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
                <span class="tax">
                <div class="dropdown">
                  <button onclick="myFunction()" class="dropbtn">Clientes</button></br>
                  <span style="color:red; display:none;" id="errorCliente">Debes seleccionar a un cliente de la lista</span>
                  <span style="color:red; display:none;" id="errorClienteFormat">Debes seleccionar a un cliente de la lista</span>
                  <span style="color:red; display:none;" id="alreadytaken">Este horario ya fue reservado por alguien más, por favor cambie su elección</span>
                  
                    
                  <div id="myDropdown" class="dropdown-content">
                  <input autofocus class="form-control" type="text" name="reservation_client_text" id="reservation_client_text" placeholder="Buscar.." value="" onkeyup="filterFunction()">
                  
                    <input type="hidden"  name="reservation_client" id="reservation_client" value="">
                    <?php foreach( $clients as $client ){ 
                      $user_name = "'".$client['User']['name'].' | '.$client['User']['phone']."'";
                      ?>
                    <a onclick="reservationClient(<?php echo $client['User']['id'];?>,<?php echo $user_name;?>)"><?php echo $client['User']['name'].' | '.$client['User']['phone'];?></a>
                    <?php } ?>
                  </div>
                </div>
                </span></br>
                </br>
                <span class="tax" id="clienteUser"></span>
                </br>
                <span class="description"><b>Servicio:</b></span>
                <span class="tax">
                  <select class="form-control" name="services" id="services">
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
                  $time_hour = 8;
                  $time_minute = '00';
                  for($i=0; $i <= 28; $i++){ 
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

setInterval(function () { loadReservations(); }, 10000);

function cleanUsers(){
  $('#reservation_client_text').val('');
  $('#reservation_client').val('');
  $('#clienteUser').html('');
  
}
function reservationClient(user_id,user_text){
  $('#reservation_client_text').val(user_text);
  $('#reservation_client').val(user_id);
  $('#clienteUser').html('<b>Cliente: '+user_text+'</b>');
  myFunction();
}

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
 // $('#reservation_client_text').show();
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("reservation_client_text");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
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
        // var title = prompt('Event Title:');
        /*var title ='asd';
          if (title) {
            calendar.addEvent({
              title: title,
              start: arg.start,
              end: arg.end,
              allDay: arg.allDay
            })
          }*/
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
          //alert(arg.event.groupId);
          /*if (confirm('Are you sure you want to delete this event?')) {
            arg.event.remove()
          }*/
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
  function loadAppointment(appointmentId,reservation_time,reservation_date){
    //alert(appointmentId);
   
    $('#CancelAppointment').attr('onclick','cancelAppointment('+appointmentId+',"'+reservation_time+'","'+reservation_date+'")');
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
                 
                  $('#appointmentService').html(res.Service.service_name);
                  $('#appointmentTitle').html(res.Barber.name);
                  $('#appointmentTime').html(res.Reservation.reservation_time);
                  $('#appointmentPrice').html(res.Service.price);
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
                } else {
                   // alert("Cancel was pressed");
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
  var client = $('#reservation_client_text').val();
  var splitClient = client.split('|');
  if( splitClient.length < 2 ){
    $('#errorClienteFormat').hide();
  }else{
    $.ajax({
                  type: 'POST', 
                  url: 'save_reservation_calendar', 
                  data: 'reservation_date='+reservationDate+'&reservation_client='+reservation_client+'&reservation_time='+reservationTime+'&reservation_service='+reservationService+'&reservation_barber='+reservationBarber,
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
