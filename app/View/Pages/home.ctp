<section class="home-text">
<p><span class="icon"><img src="img/layout/beard.png" alt=""></span><span class="text">Somos los🥇en Barbería💈
Profesionales en cuidado personal para caballero</span></p>
<p><span class="icon"><img src="img/layout/beard.png" alt=""></span>
<span class="text"><a taget="_blank" href="https://ul.waze.com/ul?ll=9.95966788%2C-84.07737136&navigate=yes&zoom=17&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location"><img width='30px' src="img/layout/waze.png" alt=""> San Juan Tibas, Costa Rica</a></br></br>
<a taget="_blank" href="https://api.whatsapp.com/send?phone=50684937440"><img width='30px' src="img/layout/whatsapp.png" alt=""> 8493 7440</a>
</br></br>SINPE movil </br>8493 7440 </span>
</p>

</section>

<?php if( $user == 'Berman' ){ ?>
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
        <section class="event-list-section">
            <ul class="eventlist" id="eventlist">
            <h1 style="color:white">Citas Activas</h1>
                <li>
                
                    <span class="event-list-item-content">
                    <div class="event-list-info">
                        <h3>Corte de pelo</h3>
                        <p>Fecha : Martes 12 de Setiembre 2023</p>
                        <p>Hora : 5:00pm</p>
                        <p>Barbero : Berman</p>
                        <p>Cliente : Gabriel Aguilar <a taget="_blank" href="https://api.whatsapp.com/send?phone=50683481182&text=Hola Gabriel Aguilar!

💈 Tienes cita para corte a las 5:00pm , por favor confirmar en el siguiente link: https://alofresa.com/confimar/jhakjahsd"><img width='30px' src="img/layout/whatsapp.png" alt=""></a></p>
                        <p>Tiempo : 1 hora</p>
                        <p>Estatus de la cita : Sin Confirmar</p>
                        <p>Precio : ₡10.000</p>
                    <p>Selecciona el tipo de pago:</p>  
                    <select class="form-control" name="tipoPago" id="tipoPago">
                    <option value="0">SINPE Movil</option>
                    <option value="1">Efectivo</option>
                    <option value="2">Transferencia</option>
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
                
            </ul>

        </section>
<?php } ?>
    
    
