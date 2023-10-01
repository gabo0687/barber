<section class="event-detail">
    <article id="profile">
    <h2>Clientes</h2>
      <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
      </ul>
       </br>
      <div class="form-group text-left">
      <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar cliente Nuevo</button>
      <button type="button" onclick="showEditForm()" class="btn btn-primary">Editar Cliente</button>
      </div>
      <form method="post" id="searchUser" style="display:none;" class="col-sm-6 offset-sm-3">
      <div class="form-group text-left">
      <label for="accountInputUser">Buscar cliente</label>
      <input type="text" class="form-control" id="searchCustomer" name="searchCustomer" aria-describedby="emailHelp" placeholder="Nombre/telefono">
      </div>
      <div class="form-group text-left">
      <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
      </div>
      </form>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form action="add_customer" method="post" id="createCustomer" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Agregar cliente nuevo</h4>
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="nameCustomer" name="nameCustomer" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Telefono</label>
              <input type="number" class="form-control" id="phoneCustomer" name="phoneCustomer" onblur="checkPhoneCostumers(this.value)" aria-describedby="emailHelp" placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Contraseña</label>
              <input type="password" class="form-control" id="passwordCustomer" name="passwordCustomer" aria-describedby="emailHelp" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">ultima cita</label>
              <input type="date" class="form-control" id="last_appointment" name="last_appointment" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group" id="error-passCharCustomer" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
            </div>
            <div class="form-group" id="error-phone" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-empty" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>

      <div class="list-group" id="customersList" role="tablist">
      </div>

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home_editCustomer" style="display:none;" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form action="update_customer" method="post" id="editCustomer" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Editar cliente</h4>
          <div class="form-group" style="display:none;">
              <label for="accountInputUser">id</label>
              <input type="text" class="form-control" id="idEditCustomerId" name="idEditCustomerId" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
          <div class="form-group" style="display:none;">
              <label for="accountInputUser">id</label>
              <input type="text" class="form-control" id="idEditCustomer" name="idEditCustomer" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group" style="display:none;">
              <label for="accountInputUser">id</label>
              <input type="text" class="form-control" id="EditCustomerCreationDate" name="EditCustomerCreationDate" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="nameEditCustomer" name="nameEditCustomer" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Telefono</label>
              <input type="number" class="form-control" id="phoneEditCustomer" name="phoneEditCustomer" onblur="checkPhoneEdit(idEditCustomer.value,this.value)" aria-describedby="emailHelp"  placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Estado</label>
              <select name="statusEditCustomer" id="statusEditCustomer" class="form-control">
              <option value="0">Inactivo</option>
              <option value="1">Activo</option>
              </select>
              
            </div>
            <div class="form-group" style="display:none;">
              <label for="accountInputUser">Contraseña</label>
              <input type="password" class="form-control" id="passwordEditEncryptCustomer" name="passwordEditEncryptCustomer" aria-describedby="emailHelp" placeholder="Estado">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Contraseña</label>
              <input type="password" class="form-control" id="passwordEditCustomer" name="passwordEditCustomer" aria-describedby="emailHelp" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">ultima cita</label>
              <input type="date" class="form-control" id="lastAppointmentEdit" name="lastAppointmentEdit" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group" id="error-phoneEditCustomer" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-emptyEditCustomer" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div class="form-group" id="error-passCharEditCustomer" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>  
          </form>
        </div>
      </div>
    </article>
  </section>
  <script>


    $('#searchUser').on('submit', function (e) {
      e.preventDefault();
      search();
    });

    var checkNumberCustomers = false;
    var NumberEditExist = false;

    window.scrollTo(0, document.body.scrollHeight);
    $('#myList a').on('click', function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

function showAddForm(){
  $('#createCustomer').show();
  $('#home_editCustomer').hide();
  $('#customersList').hide();
  $('#searchUser').hide();
  
}

function showEditForm(){
  $('#customersList').html('');
  $('#searchCustomer').val('');
  $('#editCustomer').hide();
  $('#createCustomer').hide();
  $('#customersList').show();
  $('#searchUser').show();
  $('#idEditCustomer').val('');
  $('#nameEditCustomer').val('');
  $('#phoneEditCustomer').val('');
  $('#passwordEditEncryptCustomer').val('');
  $('#passwordEditCustomer').val('');
  $('#lastAppointmentEdit').val('');
  $('#statusEditCustomer').val('');
  $('#home_editCustomer').hide();
  
  
}

function checkPhoneCostumers(userPhone){
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
                  checkNumberCustomers = true;
                  $('#error-phone').show();
                  $('#phoneCustomer').css('border','2px solid red');
                } else{
                  checkNumberCustomers = false;
                  $('#error-phone').hide();
                  $('#phoneCustomer').css('border','');
                }
              }
});
}

function checkPhoneEdit(userId,userPhone){

$.ajax({
              type: 'POST', 
              url: 'Pages/getPhoneEdit', 
              data: 'user_id='+userId+'&phone='+userPhone,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet');    
              },
              success: function(existPhone) {
                if(existPhone == 1 ){
                  event.preventDefault();
                  NumberEditExist = true;
                  $('#error-phoneEditCustomer').show();
                  $('#phoneEditCustomer').css('border','2px solid red');
                } else{
                  NumberEditExist = false;
                  $('#error-phoneEditCustomer').hide();
                  $('#phoneEditCustomer').css('border','');
                }
              }
});
}

$( "#createCustomer" ).on( "submit", function( event ) {
  
  var nombre = $('#nameCustomer').val();
  var celular = $('#phoneCustomer').val();
  var pass = $('#passwordCustomer').val();
  checkPhoneCostumers(celular);

  var updatePassError = false;
  if(pass !== ''){
    if(pass.match(/[A-Z]/) && pass.length > 8){
       updatePassError = false;
    }else{
      updatePassError = true;
    }
  }

  
  if( nombre == '' || celular == '' ||checkNumberCustomers == true || pass == '' || updatePassError == true ){
    event.preventDefault();
    $showError = false;
    if( nombre == '' ){
      $('#nameCustomer').css('border','2px solid red');
      $showError = true;
    }else{
       $('#nameCustomer').css('border','');
    }
    if( celular == '' ){
      $showError = true;
      $('#phoneCustomer').css('border','2px solid red');
    }else{
       $('#phoneCustomer').css('border','');
    }
    if( checkNumberCustomers == true ){
      $('#error-phone').show();
      $('#phoneCustomer').css('border','2px solid red');
    }else{
      $('#error-phone').hide();
      $('#phoneCustomer').css('border','');
    }
    if( pass == '' ){
      $showError = true;
      $('#passwordCustomer').css('border','2px solid red');
    }else{
       $('#passwordCustomer').css('border','');
    }

    if( (updatePassError == true) ){
      $('#passwordCustomer').css('border','2px solid red');
      $('#error-passCharCustomer').show();
    }else{
       $('#passwordCustomer').css('border','');
       $('#error-passCharCustomer').hide();
    }
    if ($showError){
      $('#error-empty').show();
    }else{
      $('#error-empty').hide();
    }
  }else{
    $('#error-empty').hide();
    $('#error-phone').hide();
    window.scrollTo(0, 0);
    $('.close').click();
    $('#customerCreated').show();
        setInterval(function() {
            $('#customerCreated').hide('2000');
          }, 2000);
        }  
});

$( "#editCustomer" ).on( "submit", function( event ) {
  var id = $('#idEditCustomer').val();
  var nombre = $('#nameEditCustomer').val();
  var celular = $('#phoneEditCustomer').val();
  var pass = $('#passwordEditCustomer').val();
  var cita = $('#lastAppointmenEdit').val();
  var updatePassError = false;
  checkPhoneEdit(id,celular);
  if(pass !== ''){
    if(pass.match(/[A-Z]/) && pass.length > 8){
       updatePassError = false;
    }else{
      updatePassError = true;
    }
  }

  if( NumberEditExist == true || nombre == '' || celular == '' || updatePassError == true ){ 
    event.preventDefault();
    $showError = false;
    if( nombre == '' ){
      $('#nameEditCustomer').css('border','2px solid red');
      $showError = true;
    }else{
       $('#nameEditCustomer').css('border','');
    }
    if( celular == '' ){
      $showError = true;
      $('#phoneEditCustomer').css('border','2px solid red');
    }else{
       $('#phoneEditCustomer').css('border','');
    }

    if( (updatePassError == true) ){
      $('#passwordEditCustomer').css('border','2px solid red');
      $('#error-passCharEditCustomer').show();
    }else{
       $('#passwordEditCustomer').css('border','');
       $('#error-passCharEditCustomer').hide();
    }
    if( NumberEditExist == true ){
      $('#error-phoneEditCustomer').show();
      $('#phoneEditCustomer').css('border','2px solid red');
    }else{
      $('#error-phoneEditCustomer').hide();
      $('#phoneEditCustomer').css('border','');
    }
    if ($showError){
      $('#error-emptyEditCustomer').show();
    }else{
      $('#error-emptyEditCustomer').hide();
    }
  }else{
    $('error-passCharEditCustomer').hide();
    $('#error-phoneEditCustomer').hide();
    window.scrollTo(0, 0);
    $('.close').click();
    $('#customerUpdated').show();
        setInterval(function() {
            $('#customerUpdated').hide('2000');
          }, 2000);
        }  
});


    function showEditClient(CustomerId){
      $('.list-group-item').removeClass('active');
      $('#edit_'+CustomerId).addClass('active');
      $('#home_editCustomer').show();
      $.ajax({
                type: 'POST', 
                url: 'edit_customer', 
                data: 'idCustomer='+CustomerId,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(customers) {
                  const res = JSON.parse(customers);

                    $('#idEditCustomer').val(res["User"]["id"]);
                    $('#idEditCustomerId').val(res["Customer"]["id"]);
                    $('#EditCustomerCreationDate').val(res["Customer"]["date_creation"]);
                    $('#nameEditCustomer').val(res["User"]["name"]);
                    $('#phoneEditCustomer').val(res["User"]["phone"]);
                    $('#statusEditCustomer').val(res["User"]["status"]);
                    $('#passwordEditEncryptCustomer').val(res["User"]["password"]);
                    $('#lastAppointmentEdit').val(res["Customer"]["last_appointment"]);
                }
	});
    }
    

    function search(){
      var customer = $('#searchCustomer').val();
      $('#createCustomer').hide();
      $('#customersList').show();
      $('#editCustomer').show();
      $('#home_editCustomer').hide();
      $.ajax({
                type: 'POST', 
                url: 'search_customer', 
                data: 'searchCustomer='+customer,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(customers) {
                  const res = JSON.parse(customers);
                 var idCustomer = '';
                  var nombreCustomer = '';
                  var telefonoCustomer = '';
                  var estadoCustomer = '';
                  var i = 0;
                  let list = document.getElementById("customersList");
                  var boton = '';
                  Object.entries(res).forEach((entry) => {
                    
                    idCustomer = entry[1].User.id;
                    nombreCustomer = entry[1].User.name + " / " + entry[1].User.phone;
                    boton += ' <a class="list-group-item list-group-item-action" id="edit_'+idCustomer+'" data-toggle="list" onclick="showEditClient('+idCustomer+')" role="tab" style="color:black;">'+nombreCustomer+'</a>';
                   
                    i++;
                  });
                  if(boton == ""){
                    boton += ' <a class="list-group-item list-group-item-action" id="edit_empty" data-toggle="list"  role="tab" style="color:black;">No existen clientes</a>'; 
                }
                  $('#customersList').html(boton);
                
                }
	});
    }

  </script>