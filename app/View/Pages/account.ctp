<section class="event-detail">
    <article id="profile">
      <h2>Mi Perfil</h2>
      <ul class="nav nav-pills text-end">
       <?php if( $user['User']['type'] == '1' ){?>
       <li class="nav-item"><a class="nav-link fa fa-calendar" aria-hidden="true" id="calendar" href="calendar" type="button" > Calendario</a></li>
       <li class="nav-item"><a class="nav-link fa fa-scissors" aria-hidden="true" id="calendar" href="services" type="button" > Servicios</a></li>
       <li class="nav-item"><a class="nav-link fa fa-id-card" aria-hidden="true" id="calendar" href="users" type="button" > Usuarios</a></li>
       <li class="nav-item"><a class="nav-link fa fa-users" aria-hidden="true" id="calendar" href="customers" type="button" > Clientes</a></li>
       <li class="nav-item"><a class="nav-link fa fa-product-hunt" aria-hidden="true" id="calendar" href="products" type="button" > Productos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-clock-o" aria-hidden="true" id="calendar" href="work" type="button" > Horas de trabajo</a></li>
       <li class="nav-item"><a class="nav-link fa fa-book" aria-hidden="true" id="calendar" href="expenses" type="button" > Gastos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-line-chart" aria-hidden="true" id="calendar" href="sales" type="button" > Ventas</a></li>
       <li class="nav-item"><a class="nav-link fa fa-usd" aria-hidden="true" id="calendar" href="product_sales" type="button" > Reporte Productos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-money" aria-hidden="true" id="calendar" href="expenses_sales" type="button" > Reporte Gastos</a></li>
       <?php } ?>
       
       
       
      </ul>
   
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Datos de cuenta</h4>
          <form class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Usuario</label>
              <input type="text" name="usuario_perfil" class="form-control" id="usuario_perfil" aria-describedby="emailHelp" placeholder="Usuario">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Email</label>
              <input type="email" name="email_perfil" class="form-control" id="email_perfil" aria-describedby="emailHelp" placeholder="Correo Electrónico">
            </div>
            <div class="form-group">
              <label for="accountInputPassword">Contraseña</label>
              <input type="password" name="contrasena_perfil" class="form-control" id="contrasena_perfil" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Confirmar Contraseña</label>
              <input type="password" class="form-control" id="contrasena_confirmar" placeholder="Password">
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
  <?php if( $type == 1 ){ ?>

    

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Bloquear reservaciones</h4>

          <?php if( !empty($blockReservations) ){ ?>
          <div class="list-group" id="myList" role="tablist">
          <h5>Bloqueos Activos</h5>
          <?php foreach( $blockReservations as $blockReservation ){ ?>
            <a class="list-group-item list-group-item-action block-list" data-toggle="list" id="block_<?php echo $blockReservation['id']; ?>" onclick="removeBlock(<?php echo $blockReservation['id']; ?>)" role="tab" style="color:black;"><?php echo $blockReservation['Barbero'];?> - (<?php echo $blockReservation['schedule'];?>) <?php echo $blockReservation['blockDate'];?>     <li class="nav-link fa fa-trash" ></li></a>
            
       
          <?php } ?>  
          </div>
          <?php } ?>
          
         
          <form name="block_form" id="block_form" class="col-sm-6 offset-sm-3" action="" method="post">
          <label for="barberiaBarbero"><h4>Agregar nuevo</h4></label>
            <div class="form-group">
            
              <label for="barberiaBarbero">Barberia/Barbero</label>
              <select class="form-control" name="barber_block" id="barber_block">
                <option value="0">Barberia</option>
                <?php foreach( $barbers as $barber ){?>
                  <option value="<?php echo $barber['User']['id'];?>"><?php echo $barber['User']['name'];?></option>
                <?php } ?>
              </select> 
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Fecha bloquear</label>
              <input type="date" class="form-control" id="date_block" name="date_block" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="accountInputPassword">Horario bloquear</label>
              <select class="form-control" name="schedule_block" id="schedule_block">
                <option value="0">Todo el día</option>
                <option value="1">Mañana</option>
                <option value="2">Tarde</option>
                <option value="3">Noche</option>
              </select> 
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
      <?php } ?>
    </article>
  </section>
  <script>
    
    function removeBlock(blockId){
      const response = confirm("Esta seguro que desea Eliminar?");
                
      if (response) {
      $.ajax({
                type: 'POST', 
                url: 'remove_block', 
                data: 'blockId='+blockId,
                beforeSend:function() {  
                //$('#loadingNotification').addClass('spinner-border');
                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(removedBlock) {
                  $('#block_'+removedBlock).remove();
                  var numItems = $('.block-list').length;
                  if ( numItems ==  0){
                    $('#myList').hide();
                  }
                }
            });
          }
    }
    window.scrollTo(0, document.body.scrollHeight);
  </script>