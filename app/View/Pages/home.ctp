<section class="home-text">
<p><span class="icon"><img src="img/layout/beard.png" alt=""></span><span class="text">Somos los🥇en Barbería💈
Profesionales en cuidado personal para caballero</span></p>
<p><span class="icon"><img src="img/layout/beard.png" alt=""></span>
<span class="text"><a taget="_blank" href="https://ul.waze.com/ul?ll=9.95966788%2C-84.07737136&navigate=yes&zoom=17&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location"><img width='30px' src="img/layout/waze.png" alt=""> San Juan Tibas, Costa Rica</a></br></br>
<a taget="_blank" href="https://api.whatsapp.com/send?phone=50684937440"><img width='30px' src="img/layout/whatsapp.png" alt=""> 8493 7440</a>
</br></br>SINPE movil </br>8493 7440 </span>
</p>

</section>

<?php if( $user != '' ){ ?>
    <div class="event-info-buttons"> 
<a class="ticket-btn" data-bs-toggle="modal" data-bs-target="#compraModal" onclick="filterReservations()">💈Reservar espacio</a> 
</div>    
<label style="color:white">Seleccione la fecha que desea consultar</label>
<input  placeholder="MM/DD/YYYY" onfocus="changeDate()" class="form-control" type="text" name="fecha_reserva_admin" id="fecha_reserva_admin">
</br>
<label style="color:white">Filtrar por Barbero</label>
<select class="form-control" name="barbero_admin" id="barbero_admin">
    <option value="0">Todos</option>
    <option value="1">Berman</option>
    <option value="2">Joss</option>
    <option value="3">Dey</option>
</select>  
<?php 
}
if( $user != '' ){ ?> 
</br> 
<h1 style="color:white">Citas Activas</h1> 
   
        <section class="event-list-section">
            <ul class="eventlist" id="eventlist">
               
            <?php foreach( $reservations as $reservation ){ 
                $date = $reservation['Reservation']['reservation_date'];
                $day  = date('w', strtotime($date));
                $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                $currentDay = date('d', strtotime($date));
                $dayOfTheWeek = $days[$day];
                
                ?>
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
                    <p>Selecciona el tipo de pago:</p>  
                    <select class="form-control" name="tipoPago" id="tipoPago">
                    <option value="0">SINPE Movil</option>
                    <option value="1">Efectivo</option>
                    </select>    
                    </br> 
                    <p>Subir comprobante de pago:</p>    
                    <input type="file"  class="form-control" name="comprobante" id="comprobante">
                    </br>  
                    <?php if( $user == 'Berman' ){ ?>
                    <button type="button" class="btn btn-success"><a>Cita finalizada</a></button>
                    <?php }else{ ?>
                    <button type="button" class="btn btn-secondary"><a>Confirmar Cita</a></button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger"><a>Cancelar Cita</a></button>
                    </div>
                    </span>
                    
                </li>
                <?php } ?>
            </ul>

        </section>
<?php } ?>
<script>
   // window.scrollTo(0, document.body.scrollHeight);
  </script>
    
    
