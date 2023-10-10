<section class="event-detail">
    <article id="profile">
      <h2>Mi Perfil</h2>
      <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
      </ul>
   
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Datos de cuenta</h4>
          <form action="" method="post" id="saveProfile" class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Usuario</label>
              <input type="text" name="usuario_perfil" value="<?php echo $currentUser['User']['name'];?>" class="form-control" id="usuario_perfil" aria-describedby="emailHelp" placeholder="Usuario">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Teléfono</label>
              <input type="text" name="telefono_perfil" value="<?php echo $currentUser['User']['phone'];?>" class="form-control" id="telefono_perfil" aria-describedby="emailHelp" placeholder="Teléfono">
            </div>
            <div class="form-group">
              <label for="accountInputPassword">Contraseña</label>
              <input type="password" name="contrasena_perfil" class="form-control" id="contrasena_perfil" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Confirmar Contraseña</label>
              <input type="password" class="form-control" id="contrasena_confirmar" placeholder="Password">
            </div>
            <div class="form-group" id="error-number-profile" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-empty-profile" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div class="form-group" id="error-password" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Contraseñas no coinciden.</b></span></label>
            </div>
            
            <div class="form-group text-right">
             <input type="hidden" name="id_perfil" value="<?php echo $currentUser['User']['id'];?>" id="id_perfil">
             <button type="button" id="saveChanges" class="btn btn-primary"><span class="spinner-border-sm" id="loadingProfile"></span>Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
  <?php 
  $hasBlockPermission = false;
  $menuRoles = $_SESSION['Role'];
  foreach( $menuRoles as $menuRole ){
    $moduleId = $menuRole['Role']['id_module'];
    if( $moduleId == 1 ){
      $hasBlockPermission = true;
    }
  }
  if( $type == 1 || $hasBlockPermission ){ ?>

    

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
            <div class="form-group" id="blocker-error" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>No se puede ejecutar el bloqueo el usuario(s) tiene citas activas en ese horario</b></span></label>
            </div>
            <div class="form-group text-right">
                <button type="button" onclick="blockCheck()" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
      <?php } ?>
    </article>
  </section>
  <script>
    
    function blockCheck(){
      
      var barber_block= $('#barber_block').val();
      var date_block= $('#date_block').val();
      var schedule_block= $('#schedule_block').val();
      $('#blocker-error').hide();
      $.ajax({
                type: 'POST', 
                url: 'block_check', 
                data: 'barber_block='+barber_block+'&date_block='+date_block+'&schedule_block='+schedule_block,
                beforeSend:function() {  
                //$('#loadingNotification').addClass('spinner-border');
                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(response) {
                  if(response == 'no'){
                    $('#blocker-error').show();
                  }else{
                   // $("#block_form").submit();
                  }
                  
                }
            });
     }

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


    $( "#saveChanges" ).on( "click", function( event ) {
  
  var nombre = $('#usuario_perfil').val();
  var celular = $('#telefono_perfil').val();
  var contrasena_perfil = $('#contrasena_perfil').val();
  var contrasena_confirmar = $('#contrasena_confirmar').val();
  var userId = $('#id_perfil').val();

  if( contrasena_perfil != '' && contrasena_perfil != contrasena_confirmar){
    $('#error-password').show();
  }else{
    $('#error-password').hide();
      $.ajax({
                  type: 'POST', 
                  url: 'Pages/getPhoneEdit', 
                  data: 'user_id='+userId+'&phone='+celular,
                  beforeSend:function() {  
                    $('#loadingProfile').addClass('spinner-border');
                  },
                  error: function(){
                      
                  alert('No hay internet');    
                  },
                  success: function(existPhone) {
                    $('#loadingProfile').removeClass('spinner-border');
                    if(existPhone == 1 ){
                      checkNumberCustomers = true;
                      $('#error-number-profile').show();
                      $('#telefono_perfil').css('border','2px solid red');
                    } else{
                      checkNumberCustomers = false;
                      $('#error-number-profile').hide();
                      $('#telefono_perfil').css('border','');
                    }
                    if( nombre == '' || celular == '' || checkNumberCustomers == true  ){
                    
                    $showError = false;
                    if( nombre == '' ){
                      $('#usuario_perfil').css('border','2px solid red');
                      $showError = true;
                    }else{
                      $('#usuario_perfil').css('border','');
                    }
                    if( celular == '' ){
                      $showError = true;
                      $('#phoneCustomer').css('border','2px solid red');
                    }else{
                      $('#phoneCustomer').css('border','');
                    }
                  

                    
                    if ($showError){
                      $('#error-empty-profile').show();
                    }else{
                      $('#error-empty-profile').hide();
                    }
                  }else{

                        var usuario_perfil = $('#usuario_perfil').val();
                        var telefono_perfil = $('#telefono_perfil').val();
                        var id_perfil = $('#id_perfil').val();
                        var contrasena_perfil = $('#contrasena_perfil').val();
                        $.ajax({
                        type: 'POST', 
                        url: 'profile_save', 
                        data: 'id_perfil='+id_perfil+'&usuario_perfil='+usuario_perfil+'&telefono_perfil='+telefono_perfil+'&contrasena_perfil='+contrasena_perfil,
                        beforeSend:function() {  
                          $('#loadingProfile').addClass('spinner-border');
                        },
                        error: function(){
                            
                        alert('No hay internet');    
                        },
                        success: function(saveProfile) {
                          $('#loadingProfile').removeClass('spinner-border');
                          $('#error-empty-profile').hide();
                          $('#error-number-profile').hide();
                          window.scrollTo(0, 0);
                          $('#profileUpdated').show();
                          setInterval(function() {
                              $('#profileUpdated').hide('2000');
                            }, 2000);
                        }
                        });
                    
                    
                    }
                  }
    });
  }
});


    window.scrollTo(0, document.body.scrollHeight);
  </script>