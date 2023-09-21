<section class="event-detail">
    <article id="profile">
      <h2>Clientes</h2>
      <div class="list-group" id="myList" role="tablist">
      <a class="list-group-item list-group-item-action active" data-toggle="list" href="#home" role="tab" style="color:black;">Agregar cliente Nuevo</a>
        
      
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show" id="edit" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Editar cliente</h4>
          <form action="edit_customer" method="post" class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="name_edit" name="name_edit" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Telefono</label>
              <input type="number" class="form-control" id="phone_edit" name="phone_edit" aria-describedby="emailHelp" placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">ultima cita</label>
              <input type="date" class="form-control" id="last_appointment_edit" name="last_appointment_edit" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            
            <div class="form-group">
              <label for="accountInputPassword">Estado</label>
              <select name="status_edit" class="form-control" id="status_edit">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
              </select>
            </div>
            <div class="form-group text-right">
            <input type="hidden" id="id_edit" name="id_edit" value="0">
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Agregar cliente nuevo</h4>
          <form action="add_customer" method="post" id="createCustomer" class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Telefono</label>
              <input type="number" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" onblur="checkPhone(this.value)" placeholder="Telefono">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">ultima cita</label>
              <input type="date" class="form-control" id="last_appointment" name="last_appointment" aria-describedby="emailHelp" placeholder="Fecha">
            </div>
            <div class="form-group" id="error-phone" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este numero ya esta siendo utilizado por otro usuario.</b></span></label>
            </div>
            <div class="form-group" id="error-empty" style="display:none;">
              <label for="signupName" ><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
            </div>
            <div style="display:none;" id="userCreated" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Usuario creado! </h4>
        <p><img src="img/icon-success.png" height="20px" width="20px" />Utiliza el login para ingresar al sistema</p>
        <hr>
      </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </article>
  </section>
  <script>
    var checkNumber = false;

    window.scrollTo(0, document.body.scrollHeight);
    $('#myList a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    });

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

$( "#createCustomer" ).on( "submit", function( event ) {
  var nombre = $('#name').val();
  var celular = $('#phone').val();
  var cita = $('#last_appointment').val();
  checkPhone(celular);
 
 
  if( nombre == '' || celular == '' ||checkNumber == true){
    event.preventDefault();
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
    if ($showError){
      $('#error-empty').show();
    }else{
      $('#error-empty').hide();
    }
  }else{
    window.scrollTo(0, 0);
    $('.close').click();
    $('#userCreated').show();
        setInterval(function() {
            $('#userCreated').hide('2000');
          }, 10000);
        }  
});


    function editClient(CustomerId){
      $.ajax({
                type: 'POST', 
                url: 'load_customer', 
                data: 'idCustomer='+CustomerId,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(customers) {
                  const res = JSON.parse(customers);
                  //console.log(res);
                 var idServicio = '';
                  var nombreServicio = '';
                  var precioServicio = '';
                  var generoServicio = '';
                  var i = 0;
                  Object.entries(res).forEach((entry) => {
                    idServicio = entry[1].Service.id;
                    nombreServicio = entry[1].Service.service_name;
                    precioServicio = entry[1].Service.price;
                    generoServicio = entry[1].Service.gender;
                    console.log(entry[1]);
                    $('#duracion_edit'+entry[1].Duration.barber).val(entry[1].Duration.duration);
                    $('#duracionId_edit'+entry[1].Duration.barber).val(entry[1].Duration.id);
                    i++;
                    //const [key, value] = entry;
                    //console.log(`${key}: ${value}`);
                  });
                  
                  $('#id_edit').val(CustomerId); 
                  $('#nombre_edit').val(nombreServicio);
                  $('#precio_edit').val(precioServicio);
                  //$('select>option>value('+generoServicio+')').prop('selected', true);
                  $('#tiposervicio_edit').val(generoServicio);
                }
	});
    }
   
  </script>