<section class="event-detail">
    <article id="profile">
    <h2>Clientes</h2>
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
       </br>
      <div class="form-group text-left">
      <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar cliente Nuevo</button>
      <button type="button" onclick="showEditForm()" class="btn btn-primary">Editar Cliente</button>
      </div>
      <div style="display:none;" id="userUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Cliente actualizado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
        <hr>
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
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Telefono</label>
              <input type="number" class="form-control" id="phone" name="phone" onblur="checkPhone(this.value)" aria-describedby="emailHelp" placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Contraseña</label>
              <input type="text" class="form-control" id="password" name="password" aria-describedby="emailHelp" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">ultima cita</label>
              <input type="date" class="form-control" id="last_appointment" name="last_appointment" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group" id="error-passChar" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
            </div>
            <div class="form-group" id="error-phone" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-empty" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div style="display:none;" id="userCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Cliente creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
        <hr>
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
        <div class="tab-pane fade show active" id="home_edit" style="display:none;" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form action="update_customer" method="post" id="editCustomer" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Editar cliente</h4>
          <div class="form-group" style="display:none;">
              <label for="accountInputUser">id</label>
              <input type="text" class="form-control" id="idEdit" name="idEdit" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="nameEdit" name="nameEdit" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Telefono</label>
              <input type="number" class="form-control" id="phoneEdit" name="phoneEdit" onblur="checkPhoneEdit(idEdit.value,this.value)" aria-describedby="emailHelp"  placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Estado</label>
              <select name="statusEdit" id="statusEdit" class="form-control">
              <option value="0">Inactivo</option>
              <option value="1">Activo</option>
              </select>
              
            </div>
            <div class="form-group" style="display:none;">
              <label for="accountInputUser">Contraseña</label>
              <input type="text" class="form-control" id="passwordEditEncrypt" name="passwordEditEncrypt" aria-describedby="emailHelp" placeholder="Estado">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Contraseña</label>
              <input type="text" class="form-control" id="passwordEdit" name="passwordEdit" aria-describedby="emailHelp" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">ultima cita</label>
              <input type="date" class="form-control" id="lastAppointmentEdit" name="lastAppointmentEdit" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group" id="error-phoneEdit" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-emptyEdit" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div class="form-group" id="error-passChar" style="display:none;">
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

    var checkNumber = false;
    var NumberEditExist = false;

    window.scrollTo(0, document.body.scrollHeight);
    $('#myList a').on('click', function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

function showAddForm(){
  $('#createCustomer').show();
  $('#home_list').hide();
  $('#home_edit').hide();
  $('#customersList').hide();
  $('#searchUser').hide();
  
}

function showEditForm(){
  $('#customersList').html('');
  $('#searchCustomer').val('');
  $('#editCustomer').hide();
  $('#createCustomer').hide();
  $('#home_list').show();
  $('#customersList').show();
  $('#searchUser').show();
  $('#idEdit').val('');
  $('#nameEdit').val('');
  $('#phoneEdit').val('');
  $('#passwordEditEncrypt').val('');
  $('#passwordEdit').val('');
  $('#lastAppointmentEdit').val('');
  $('#statusEdit').val('');
  $('#home_edit').hide();
  
  
}

    function checkPhone(userPhone){

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
                  checkNumber = true;
                  $('#error-phone').show();
                  $('#phone').css('border','2px solid red');
                } else{
                  checkNumber = false;
                  $('#error-phone').hide();
                  $('#phone').css('border','');
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
                  $('#error-phoneEdit').show();
                  $('#phoneEdit').css('border','2px solid red');
                } else{
                  NumberEditExist = false;
                  $('#error-phoneEdit').hide();
                  $('#phoneEdit').css('border','');
                }
              }
});
}

$( "#createCustomer" ).on( "submit", function( event ) {
  
  var nombre = $('#name').val();
  var celular = $('#phone').val();
  var pass = $('#password').val();
  alert(nombre);
 
  checkPhone(celular);

  var updatePassError = false;
  if(pass !== ''){
    if(pass.match(/[A-Z]/) && pass.length > 8){
       updatePassError = false;
    }else{
      updatePassError = true;
    }
  }

  
  if( nombre == '' || celular == '' ||checkNumber == true || pass == '' || updatePassError == true ){
    event.preventDefault();
    $showError = false;
    if( nombre == '' ){
      $('#name').css('border','2px solid red');
      $showError = true;
    }else{
       $('#name').css('border','');
    }
    if( celular == '' ){
      $showError = true;
      $('#phone').css('border','2px solid red');
    }else{
       $('#phone').css('border','');
    }
    if( checkNumber == true ){
      $('#error-phone').show();
      $('#phone').css('border','2px solid red');
    }else{
      $('#error-phone').hide();
      $('#phone').css('border','');
    }
    if( pass == '' ){
      $showError = true;
      $('#password').css('border','2px solid red');
    }else{
       $('#password').css('border','');
    }

    if( (updatePassError == true) ){
      $('#password').css('border','2px solid red');
      $('#error-passChar').show();
    }else{
       $('#password').css('border','');
       $('#error-passChar').hide();
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
    $('#userCreated').show();
        setInterval(function() {
            $('#userCreated').hide('2000');
          }, 2000);
        }  
});

$( "#editCustomer" ).on( "submit", function( event ) {
  var id = $('#idEdit').val();
  var nombre = $('#nameEdit').val();
  var celular = $('#phoneEdit').val();
  var pass = $('#passwordEdit').val();
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
      $('#nameEdit').css('border','2px solid red');
      $showError = true;
    }else{
       $('#nameEdit').css('border','');
    }
    if( celular == '' ){
      $showError = true;
      $('#phoneEdit').css('border','2px solid red');
    }else{
       $('#phoneEdit').css('border','');
    }

    if( (updatePassError == true) ){
      $('#passwordEdit').css('border','2px solid red');
      $('#error-passChar').show();
    }else{
       $('#passwordEdit').css('border','');
       $('#error-passChar').hide();
    }
    if( NumberEditExist == true ){
      $('#error-phoneEdit').show();
      $('#phoneEdit').css('border','2px solid red');
    }else{
      $('#error-phoneEdit').hide();
      $('#phoneEdit').css('border','');
    }
    if ($showError){
      $('#error-emptyEdit').show();
    }else{
      $('#error-emptyEdit').hide();
    }
  }else{
    $('#error-passChar').hide();
    $('#error-phoneEdit').hide();
    window.scrollTo(0, 0);
    $('.close').click();
    $('#userUpdated').show();
        setInterval(function() {
            $('#userUpdated').hide('2000');
          }, 2000);
        }  
});


    function showEditClient(CustomerId){
      $('.list-group-item').removeClass('active');
      $('#edit_'+CustomerId).addClass('active');
      $('#home_edit').show();
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

                    $('#idEdit').val(res["User"]["id"]);
                    $('#nameEdit').val(res["User"]["name"]);
                    $('#phoneEdit').val(res["User"]["phone"]);
                    $('#statusEdit').val(res["User"]["status"]);
                    $('#passwordEditEncrypt').val(res["User"]["password"]);
                    $('#lastAppointmentEdit').val(res["Customer"]["last_appointment"]);
                }
	});
    }
    

    function search(){
      var customer = $('#searchCustomer').val();
      $('#createCustomer').hide();
      $('#home_list').show();
      $('#customersList').show();
      $('#editCustomer').show();
      $('#home_edit').hide();
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
                  $('#customersList').html(boton);
                
                }
	});
    }

  </script>