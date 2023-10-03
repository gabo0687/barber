<section class="event-detail">
    <article id="profile">
    <h2>Usuarios</h2>
    <div style="display:none;" id="userCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Cliente creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      </div>
      <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
      </ul>
       </br>
      <div class="form-group text-left">
      <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar Usuario</button>
      <button type="button" onclick="showEditForm(); search();" class="btn btn-primary">Editar Usuario</button>
      </div>
      
      <form method="post" id="searchUserEdit" style="display:none;" class="col-sm-6 offset-sm-3">
      <div class="form-group text-left">
      <label for="accountInputUser">Buscar Usuario</label>
      <input type="text" class="form-control" id="searchUser" name="searchUser" aria-describedby="emailHelp" placeholder="Nombre/telefono">
      </div>
      <div class="form-group text-left">
      <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
      </div>
      </form>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form action="add_user" method="post" id="createNewUser" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Agregar usuario nuevo</h4>
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="nameAdd" name="nameAdd" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Teléfono</label>
              <input type="number" class="form-control" id="phoneAdd" name="phoneAdd" onkeyup="checkPhoneUsers(this.value)" aria-describedby="emailHelp" placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Contraseña</label>
              <input type="password" class="form-control" id="passwordAdd" name="passwordAdd" aria-describedby="emailHelp" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Tipo</label>
              <select name="typeAdd" id="typeAdd" class="form-control">
              <option value="2">Barber</option>
              <option value="1">Admin</option>
              </select>
              </div>
            <div class="form-group">
              <label for="accountInputEmail">Color</label>
              <input type="color" class="form-control" id="colorAdd" name="colorAdd" onblur="checkColor(this.value)" aria-describedby="emailHelp" placeholder="color">
            </div>

            <h4>Roles</h4>
            <div class="form-group">
              <input type="checkbox" id="role1" name="role1">
              <label for="accountInputEmail">Bloquear reservaciones</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role2" name="role2">
              <label for="accountInputEmail">Calendario</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role3" name="role3">
              <label for="accountInputEmail">Servicios</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role4" name="role4">
              <label for="accountInputEmail">Clientes</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role5" name="role5">
              <label for="accountInputEmail">Productos</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role6" name="role6">
              <label for="accountInputEmail">Horas de trabajo</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role7" name="role7">
              <label for="accountInputEmail">Gastos</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role8" name="role8">
              <label for="accountInputEmail">Ventas</label>
            </div>
            <div class="form-group">
              <input type="checkbox" id="role9" name="role9">
              <label for="accountInputEmail">Reporte General</label>
            </div>
            
            <h4>Servicios</h4>
            <div class="form-group" id="servicesList" name="servicesList" role="tablist">
            </div>

            <div class="form-group" id="error-phone" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-color" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este Color ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-empty" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div class="form-group" id="error-passChar" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
            </div>
            <div class="form-group text-right">
              <button type="button" id="createUserNew" class="btn btn-primary">Guardar Barbero</button>
            </div>
          </form>
        </div>
      </div>

      <div class="list-group" id="usersList" role="tablist">
      </div>

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home_edit" style="display:none;" role="tabpanel" aria-labelledby="nav-profile-tab">
          <form action="update_user" method="post" id="editUser" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Editar usuario</h4>
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
              <input type="number" class="form-control" id="phoneEdit" name="phoneEdit" onkeyup="checkPhoneEdit(idEdit.value,this.value)" aria-describedby="emailHelp"  placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Estado</label>
              <select name="statusEdit" id="statusEdit" class="form-control">
              <option value="0">Inactivo</option>
              <option value="1">Activo</option>
              </select>
              <div class="form-group">
              <label for="accountInputUser">Tipo</label>
              <select name="typeEdit" id="typeEdit" class="form-control">
              <option value="2">Barber</option>
              <option value="1">Admin</option>
              </select>
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Color</label>
              <input type="color" class="form-control" id="colorEdit" name="colorEdit" onblur="checkColorEdit(this.value,idEdit.value)" aria-describedby="emailHelp" placeholder="color">
            </div>
            <div class="form-group" style="display:none;">
              <label for="accountInputUser">Contraseña</label>
              <input type="password" class="form-control" id="passwordEditEncrypt" name="passwordEditEncrypt" aria-describedby="emailHelp" placeholder="Estado">
            </div>
            <div class="form-group">
              <label for="accountInputUser">Contraseña</label>
              <input type="password" class="form-control" id="passwordEdit" name="passwordEdit" aria-describedby="emailHelp" placeholder="Contraseña">
            </div>
            <div class="form-group" id="error-colorEdit" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este Color ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <h4>Roles</h4>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit1" name="roleEdit1">
              <label for="accountInputEmail">Bloquear reservaciones</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit2" name="roleEdit2">
              <label for="accountInputEmail">Calendario</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit3" name="roleEdit3">
              <label for="accountInputEmail">Servicios</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit4" name="roleEdit4">
              <label for="accountInputEmail">Clientes</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit5" name="roleEdit5">
              <label for="accountInputEmail">Productos</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit6" name="roleEdit6">
              <label for="accountInputEmail">Horas de trabajo</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit7" name="roleEdit7">
              <label for="accountInputEmail">Gastos</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit8" name="roleEdit8">
              <label for="accountInputEmail">Ventas</label>
            </div>
            <div class="form-group">
              <input type="checkbox" class="uncheckRole" id="roleEdit9" name="roleEdit9">
              <label for="accountInputEmail">Reporte General</label>
            </div>
            <h4>Servicios</h4>
            <div class="form-group" id="servicesEditList" name="servicesEditList" role="tablist">
            </div>

            

            <div class="form-group" id="error-phoneEdit" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-emptyEdit" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div class="form-group" id="error-passCharEdit" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
            </div>
            <div class="form-group text-center">
              <button type="button" id="editUserButton" class="btn btn-primary">Editar</button>
            </div>  
          </form>
        </div>
      </div>
    </article>
  </section>
  <script>

function showColor(){
    $('#color').show();
}
    $('#searchUserEdit').on('submit', function (e) {
      e.preventDefault();
      search();
    });

    searchServices();
    var checkNumberUsers = false;
    var NumberEditExist = false;
    var existColor = false;
    var existColorEdit = false;

    window.scrollTo(0, document.body.scrollHeight);
    $('#myList a').on('click', function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

function showAddForm(){
    searchServices();
  $('#createNewUser').show();
  $('#home_list').hide();
  $('#home_edit').hide();
  $('#usersList').hide();
  $('#searchUserEdit').hide();
  
}

function showEditForm(){
  $('#usersList').html('');
  $('#searchUser').val('');
  $('#editUser').hide();
  $('#createNewUser').hide();
  $('#home_list').show();
  $('#usersList').show();
  $('#searchUserEdit').show();
  $('#idEdit').val('');
  $('#nameEdit').val('');
  $('#phoneEdit').val('');
  $('#passwordEditEncrypt').val('');
  $('#passwordEdit').val('');
  $('#lastAppointmentEdit').val('');
  $('#statusEdit').val('');
  $('#home_edit').hide();
  
  
}

    function checkPhoneUsers(userPhone){
      $('#error-phone').hide();
      if( userPhone != '' ){
        return $.ajax({
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
                  $('#error-phone').show();
                  $('#phoneAdd').css('border','2px solid red');
                  checkNumberUsers = true;
                } else{
                  $('#error-phone').hide();
                  
                  $('#phoneAdd').css('border','');
                  checkNumberUsers = false;
                  
                }
              }
            });
      } 

}

function checkPhoneEdit(userId,userPhone){
  if(userPhone != '' ){
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
}


function checkColor(userColor){
$.ajax({
              type: 'POST', 
              url: 'Pages/getColor', 
              data: 'color='+userColor,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet');    
              },
              success: function(colorFound) {
                if(colorFound == 1 ){
                  event.preventDefault();
                  existColor = true;
                  $('#error-color').show();
                  $('#colorAdd').css('border','2px solid red');
                } else{
                    existColor = false;
                  $('#error-color').hide();
                  $('#colorAdd').css('border','');
                }
              }
});
}

function checkColorEdit(userColor,userId){
$.ajax({
              type: 'POST', 
              url: 'Pages/getColorEdit', 
              data: 'color='+userColor+'&user_id='+userId,
              beforeSend:function() {  

              },
              error: function(){
                  
              alert('No hay internet');    
              },
              success: function(ColEditFound) {
                if(ColEditFound == 1 ){
                  event.preventDefault();
                  existColorEdit = true;
                  $('#error-colorEdit').show();
                  $('#colorEdit').css('border','2px solid red');
                } else{
                    existColorEdit = false;
                  $('#error-colorEdit').hide();
                  $('#colorEdit').css('border','');
                }
              }
});
}


$( "#createUserNew" ).on( "click", function(  ) {
  
  var nombre = $('#nameAdd').val();
  var celular = $('#phoneAdd').val();
  var color = $('#colorAdd').val();
  var pass = $('#passwordAdd').val();
  //password
  
  checkColor(color);

  var updatePassError = false;
  if(pass !== ''){
    if(pass.match(/[A-Z]/) && pass.length > 8){
       updatePassError = false;
    }else{
      updatePassError = true;
    }
  }else{
    updatePassError = true;
  }

  if( nombre == '' || celular == '' || existColor == true || updatePassError == true || checkNumberUsers == true ){
  
    $showError = false;
    if( nombre == '' ){
      $('#nameAdd').css('border','2px solid red');
      $showError = true;
    }else{
       $('#nameAdd').css('border','');
    }

    if( celular == '' ){
      $showError = true;
      $('#phoneAdd').css('border','2px solid red');
    }else{
        $('#phoneAdd').css('border','');
    }

    if( existColor == true ){
      $('#error-color').show();
      $('#colorAdd').css('border','2px solid red');
    }else{
      $('#error-color').hide();
      $('#colorAdd').css('border','');
    }
    if( pass == '' ){
      $showError = true; 
    }

    if( (updatePassError == true) ){
      $('#passwordAdd').css('border','2px solid red');
      $('#error-passChar').show();
    }else{
       $('#passwordAdd').css('border','');
       $('#error-passChar').hide();
    }

    if ($showError){
      $('#error-empty').show();
    }else{
      $('#error-empty').hide();
    }
  }else{
    $('#createNewUser').submit();
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

$( "#editUserButton" ).on( "click", function( ) {
  var id = $('#idEdit').val();
  var nombre = $('#nameEdit').val();
  var celular = $('#phoneEdit').val();
  var pass = $('#passwordEdit').val();
  var col = $('#colorEdit').val();
  var updatePassError = false;

  checkPhoneEdit(id,celular);

  checkColorEdit(col,id);

  if(pass !== ''){
    if(pass.match(/[A-Z]/) && pass.length > 8){
       updatePassError = false;
    }else{
      updatePassError = true;
    }
  }

  if( existColorEdit == true || nombre == '' || celular == '' || updatePassError == true || NumberEditExist == true ){ 
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
      $('#error-passCharEdit').show();
    }else{
       $('#passwordEdit').css('border','');
       $('#error-passCharEdit').hide();
    }
    if( existColorEdit == true ){
      $('#error-colorEdit').show();
      $('#colorEdit').css('border','2px solid red');
    }else{
      $('#error-colorEdit').hide();
      $('#colorEdit').css('border','');
    }
    if ($showError){
      $('#error-emptyEdit').show();
    }else{
      $('#error-emptyEdit').hide();
    }
  }else{
    $('#editUser').submit();
    $('#error-passCharEdit').hide();
    $('#error-phoneEdit').hide();
    window.scrollTo(0, 0);
    $('.close').click();
    $('#userUpdated').show();
        setInterval(function() {
            $('#userUpdated').hide('2000');
          }, 2000);
        }  
});


    function showEditUser(UserId){
      
      $('.list-group-item').removeClass('active');
      $('#edit_'+UserId).addClass('active');
      $('#home_edit').show();
      
     
      $.ajax({
                type: 'POST', 
                url: 'edit_user', 
                data: 'idUser='+UserId,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(users) {
                  const res = JSON.parse(users);
                    $('#idEdit').val(res["User"]["id"]);
                    $('#nameEdit').val(res["User"]["name"]);
                    $('#phoneEdit').val(res["User"]["phone"]);
                    $('#statusEdit').val(res["User"]["status"]);
                    $('#typeEdit').val(res["User"]["type"]);
                    $('#passwordEditEncrypt').val(res["User"]["password"]);
                    $('#colorEdit').val(res["User"]["color"]);
                    searchDuration(UserId);
                    var moduleId = 0;
                    $( ".uncheckRole" ).prop( "checked", false );
                    Object.entries(res[0]).forEach((role) => {
                      moduleId = role[1].Role.id_module;
                      $( "#roleEdit"+moduleId ).prop( "checked", true );
                    });
                    window.scrollTo(0, document.body.scrollHeight);
                }
               
	});
    }
    

    function search(){
      
      var user = $('#searchUser').val();
      $('#createNewUser').hide();
      $('#home_list').show();
      $('#usersList').show();
      $('#editUser').show();
      $('#home_edit').hide();
      
      $.ajax({
                type: 'POST', 
                url: 'search_user', 
                data: 'searchUser='+user,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(users) {
                  const res = JSON.parse(users);
                 var idUsers = '';
                  var nombreUsers = '';
                  var idType = '';
                  
                  var i = 0;
                  let list = document.getElementById("usersList");
                  var boton = '';
                  Object.entries(res).forEach((entry) => {
                    idUsers = entry[1].User.id;
                    if(entry[1].User.type == 2){
                        idType = "Barbero";
                    }else{
                        idType = "Administrador";
                    }
                    nombreUsers = entry[1].User.name + " / " + entry[1].User.phone + " / " + idType;
                    boton += ' <a class="list-group-item list-group-item-action" id="edit_'+idUsers+'" data-toggle="list" onclick="showEditUser('+idUsers+')" role="tab" style="color:black;">'+nombreUsers+'</a>';
                   
                    i++;
                  });
                  $('#usersList').html(boton);
                  window.scrollTo(0, document.body.scrollHeight);
                }
	});
    }

    function searchServices(){
      $.ajax({
                type: 'POST', 
                url: 'search_Services', 
                //data: 'searchService',
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(service) {
                  const res = JSON.parse(service);
                 var idService = '';
                  var nameService = '';
                  
                  var i = 0;
                  let list = document.getElementById("servicesList");
                  var boton = '';
                  Object.entries(res).forEach((entry) => {
                    idService = entry[1].Service.id;
                    nameService = entry[1].Service.service_name;
                   
                    //nombreUsers = entry[1].User.name + " / " + entry[1].User.phone + " / " + idType;

                    boton +=' <label for="accountInputEmail">'+nameService+'</label> <input type="number" class="form-control" id="inputService_'+idService+'" name="inputService_'+idService+'" aria-describedby="emailHelp" placeholder="duracion"> </br>';
                   
                    //boton += ' <a class="form-control" id="services_'+idService+'" name="services_'+idService+' ">'+nameService+'</a> <input type="number" class="form-control" id="inputService_'+idService+'" name="inputService_'+idService+'" aria-describedby="emailHelp" placeholder="duracion">';
                   
                    i++;
                  });
                  $('#servicesList').html(boton);
                
                }
	});
    }

    function searchDuration(idBarber){
        
        
      $.ajax({
                type: 'POST', 
                url: 'search_duration', 
                data: 'searchDuration='+idBarber,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(service) {
                  const res = JSON.parse(service);
                 var idService = '';
                  var nameService = '';
                  var duration = '';
                  var i = 0;
                  let list = document.getElementById("servicesEditList");
                  var boton = '';
                  Object.entries(res).forEach((entry) => {
                    idService = entry[1].Service.id;
                    nameService = entry[1].Service.service_name;
                    duration = entry[1].Duration.duration;
                    //nombreUsers = entry[1].User.name + " / " + entry[1].User.phone + " / " + idType;

                    boton +=' <label for="accountInputEmail">'+nameService+'</label> <input type="number" value="'+duration+'" class="form-control" id="inputEditService_'+idService+'" name="inputEditService_'+idService+'" aria-describedby="emailHelp" placeholder="duracion"> </br>';
                   
                    //boton += ' <a class="form-control" id="services_'+idService+'" name="services_'+idService+' ">'+nameService+'</a> <input type="number" class="form-control" id="inputService_'+idService+'" name="inputService_'+idService+'" aria-describedby="emailHelp" placeholder="duracion">';
                   
                    i++;
                  });
                  $('#servicesEditList').html(boton);
                
                }
	});

    }



  </script>