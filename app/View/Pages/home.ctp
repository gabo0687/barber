<section class="home-text">
<p><span class="icon"><img src="img/layout/beard.png" alt=""></span><span class="text">Somos los🥇en Barbería💈
Profesionales en cuidado personal para caballero</span></p>
<p><span class="icon"><img src="img/layout/beard.png" alt=""></span>
<span class="text"><a taget="_blank" href="https://ul.waze.com/ul?ll=9.95966788%2C-84.07737136&navigate=yes&zoom=17&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location"><img width='30px' src="img/layout/waze.png" alt=""> San Juan Tibas, Costa Rica</a></br></br>
<a taget="_blank" href="https://api.whatsapp.com/send?phone=50684937440"><img width='30px' src="img/layout/whatsapp.png" alt=""> 8493 7440</a>
</br></br>SINPE movil </br>8493 7440 </span>
</p>

</section>

<?php 

if( isset($user['User']['type']) ){?>
    <div class="event-info-buttons"> 
        <a class="ticket-btn" data-bs-toggle="modal" data-bs-target="#compraModal" onclick="filterReservations()">💈Reservar espacio</a> 
    </div>
<?php 

if( $user['User']['type'] == 1 ){ ?>
         
<label style="color:white">Seleccione la fecha que desea consultar</label>
<input  placeholder="MM/DD/YYYY" onchange="filterBarber()" onfocus="changeDate()" oncc class="form-control" type="text" name="fecha_reserva_admin" id="fecha_reserva_admin">
</br>
<label style="color:white">Filtrar por Barbero</label>
<select class="form-control" onchange="filterBarber()" name="barbero_admin" id="barbero_admin">
    <option value="0">Todos</option>
    <?php foreach( $users as $user ){ ?>
        <option value="<?php echo $user['User']['id'];?>"><?php echo $user['User']['name'];?></option>
    <?php }?>
</select>  
<?php 
}else{
    if( $user['User']['type'] == 2 ){ ?>
<label style="color:white">Seleccione la fecha que desea consultar</label>
<input  placeholder="MM/DD/YYYY" onchange="filterBarber()" onfocus="changeDate()" class="form-control" type="text" name="fecha_reserva_admin" id="fecha_reserva_admin">

    <?php 
    }
}
}
if( isset($user['User']) ){ ?> 
</br> 
<h1 style="color:white">Citas Activas</h1> 
   
        <section class="event-list-section">
            <ul class="eventlist" id="eventlist">
               
            <?php 
            
            if( !empty($reservations) ){
            
            foreach( $reservations as $reservation ){ 
                $date = $reservation['Reservation']['reservation_date'];
                $day  = date('w', strtotime($date));
                $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                $currentDay = date('d', strtotime($date));
                $dayOfTheWeek = $days[$day];
                
                ?>
                <form name="subirArchivo" action="" method="post" enctype="multipart/form-data">
                <li>
                    <span class="event-list-item-content">
                    <div class="event-list-info">
                        <h3><?php echo $reservation['Service']['service_name'];?></h3>
                        <p>Fecha : <?php echo $dayOfTheWeek.' '.$currentDay.' de '.$months[(int)$month-1].' del '.$year;?></p>
                        <p>Hora : <?php echo $reservation['Reservation']['reservation_time'];?></p>
                        <p>Barbero : <?php echo $reservation['Barber']['name'];?></p>
                        <p>Cliente : <?php echo $reservation['User']['name'];?> <a taget="_blank" href="https://api.whatsapp.com/send?phone=506<?php echo $reservation['User']['phone'];?>&text=Hola <?php echo $reservation['User']['name'];?>!

💈 Tienes cita para corte a las <?php echo $reservation['Reservation']['reservation_time'];?> , por favor confirmar en el siguiente link: https://alofresa.com/confimar/jhakjahsd"><img width='30px' src="img/layout/whatsapp.png" alt=""></a></p>
                        <p>Tiempo : <?php echo $reservation[0]['Duration']['duration'];?> minutos</p>
                        <p>Estatus de la cita : <?php if( $reservation['Reservation']['reservation_status'] == 0 ){ echo 'Sin Confirmar'; }if( $reservation['Reservation']['reservation_status'] == 1 ){ echo 'Confirmada'; }?></p>
                        <p>Precio : ₡<?php echo number_format($reservation['Service']['price']);?></p>

                    <?php if( $reservation['Reservation']['payment_type'] != '2' && $reservation['Reservation']['payment_type'] != '1'  ){?>    
                    <p>Selecciona el tipo de pago:</p>  
                    <select class="form-control" name="tipoPago<?php echo $reservation['Reservation']['id'];?>" id="tipoPago<?php echo $reservation['Reservation']['id'];?>">
                    <option value="1">SINPE Movil</option>
                    <option value="2">Efectivo</option>
                    </select>    
                    </br> 
                    <p>Subir comprobante de pago:</p>    
                    <input type="file"  class="form-control" name="comprobante<?php echo $reservation['Reservation']['id'];?>" id="comprobante<?php echo $reservation['Reservation']['id'];?>">
                    <input type="hidden" name="idReservation" id="idReservation" value="<?php echo $reservation['Reservation']['id'];?>">
                    </br>  
                   <?php 
                        if( $reservation['Reservation']['reservation_status'] == 0 ){?>
                    <button type="button" class="btn btn-secondary" onclick="confirmAppointment(<?php echo $reservation['Reservation']['id'];?>)"><a>Confirmar Cita</a></button>
                    <?php
                         }else{?>
                    <button type="submit" class="btn btn-success"><a>Subir Comprobante</a></button>
                    <?php
                         }
                         $reservatioTime = "'".$reservation['Reservation']['reservation_time']."'";
                         $reservatioDate = "'".$reservation['Reservation']['reservation_date']."'";
                     ?>
                    <button type="button" class="btn btn-danger" onclick="cancelAppointment(<?php echo $reservation['Reservation']['id'];?>,<?php echo $reservatioTime;?>,<?php echo $reservatioDate;?>)"><a>Eliminar</a></button>
                    </div>
                    </span>
                    <?php } ?>
                </li>
                </form>
                <?php }
                }else{
                    echo '<span style="color:white">No hay Citas programadas</span>';
                } ?>
            </ul>

        </section>
<?php } ?>
<script>
   // window.scrollTo(0, document.body.scrollHeight);
   function confirmAppointment(appointmentId){
            $.ajax({
                type: 'POST', 
                url: 'confirm_appointment', 
                data: 'reservation_id='+appointmentId,
                beforeSend:function() {  
                //$('#loadingNotification').addClass('spinner-border');
                },
                error: function(){
                    
                alert('No hay internet2');    
                },
                success: function(reservation) {
                window.location.reload();
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
                
            alert('No hay internet1');    
            },
            success: function(reservation) {
            window.location.reload();
            }
            });
        } else {
        // alert("Cancel was pressed");
        }
    }

    function filterBarber(barber){
        var date_filter = $('#fecha_reserva_admin').val();
        var barber = $('#barbero_admin').val();
        if( barber == undefined ){
            barber = 0;
        }
        $.ajax({
            type: 'POST', 
            url: 'filter_barber', 
            data: 'barber='+barber+'&filter_date='+date_filter,
            beforeSend:function() {  
            //$('#loadingNotification').addClass('spinner-border');
            },
            error: function(){
                
            alert('No hay internet3');    
            },
            success: function(reservation) {
               
             $('#eventlist').html(reservation);
            }
            });
    }
  </script>
    
    
