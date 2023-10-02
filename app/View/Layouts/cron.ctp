<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>A lo fresa</title>
<link rel="icon" type="image/png" sizes="16x16"  href="img/layout/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<script type="text/javascript" src="../js/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<style>
  .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<?php
date_default_timezone_set('America/Costa_Rica');

?>
</head>

<body>
    <header>
       <div class="slider">
        
          <div class="sliderbox" id="sliderbox">
              <div class="slide"></div>            
          </div>         
          <a class="logo"></a>
          
         
         <form class="header-search">   
         <div class="event-info-buttons"> 
           <a class="ticket-btn" data-bs-toggle="modal" data-bs-target="#compraModal" onclick="filterReservations()">💈Reservar espacio</a> 
         </div>
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
        <input type="hidden" name="user_type" id="user_type" value="2">
        <input type="hidden" value="<?php echo $client_id;?>" id="client" name="client"> 

      <span class="description">Servicio:</span>
      <span class="tax">
                      <select class="form-control" onchange="filterReservations()" name="services" id="services">
                        <?php foreach( $services as $service ){ ?>
                        <option value="<?php echo $service['Service']['id'];?>"><?php echo $service['Service']['service_name'];?></option>
                        <?php } ?>
                      </select>
      </span>   
      <span class="description">Filtrar por Barbero:</span>
      <span class="tax">
                      <select class="form-control" onchange="filterReservations()" name="barber" id="barber">
                      <option value="0">Todos</option>
                      <?php foreach( $users as $user ){?>
                      <option value="<?php echo $user['User']['id'];?>"><?php echo $user['User']['name'];?></option>
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
      
        <option value="<?php echo $time_hour.':'.$time_minute;?>"><?php echo $time_hour.':'.$time_minute;?></option>      
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
   
     
      </br>
      <label id="ServiceText"></label>
          <ul class="ticket-list">  
            <li id="loading" class=""></li>
          </ul>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>

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
                  url: '../save_reservation', 
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

                          window.location.href = "../";
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
                url: '../load_reservations', 
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
                          if( reservationBarbers.length > 0 ){
                            responseHtml += '<li class="ticket-on-sale"><span class="number">Hora: '+reservationTime+'</span>';
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
                          $('.ticket-list').html('<h2>No hay reservaciones disponibles en ese horario por favor selecciona otra fecha</h2>');  
                        }
                      }
                  
	});
}


  function changeReservationDate(){
    $('#fecha_reserva').attr('type','date');
    setTimeout(() => {
      $('#fecha_reserva').click();
}, "500");
  
  }

 
var slide_images = [
    "banner1.jpg",
    "banner2.png",
    "banner3.jpg",
    "banner4.jpg"
];

$(document).ready(function(){
    var slidetotal = slide_images.length;
    var randomslide =  Math.floor((Math.random() * slidetotal));
    $("#sliderbox").find(".slide").html('<img alt="" src="https://storage.googleapis.com/videos-vr/'+slide_images[randomslide]+'">');
});
</script>


