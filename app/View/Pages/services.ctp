<section class="event-detail">
    <article id="profile">
      <h2>Servicios</h2>
      <div class="list-group" id="myList" role="tablist">
      <a class="list-group-item list-group-item-action active" data-toggle="list" href="#home" role="tab" style="color:black;">Agregar servicio Nuevo</a>
        <?php 

          foreach( $services as $service ){ 
            if( $service['Service']['gender'] == 1 ){
                $gender = 'Hombre';
            }else{
              if( $service['Service']['gender'] == 2 ){
                $gender = 'Mujer';
            }else{
                $gender = 'Unisex';
            } 
          }
          
        ?>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#edit" onclick="editService(<?php echo $service['Service']['id'];?>)" role="tab" style="color:black;"><?php echo $gender.' '.$service['Service']['service_name'].' ₡'.$service['Service']['price'];?></a>
      <?php } ?>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show" id="edit" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Editar servicio</h4>
          <form action="edit_service" method="post" class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="nombre_edit" name="nombre_edit" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Precio</label>
              <input type="number" class="form-control" id="precio_edit" name="precio_edit" aria-describedby="emailHelp" placeholder="Precio">
            </div>
            <?php 
            $position = 0;
            foreach( $barbers as $barber ){ ?>
            <div class="form-group">
              <label for="accountInputEmail">Duración(minutos) <?php echo $barber['User']['name'];?></label>
              <input type="number" class="form-control" id="duracion_edit<?php echo $barber['User']['id'];?>" name="duracion_edit<?php echo $barber['User']['id'];?>" aria-describedby="emailHelp" placeholder="Duración <?php echo $barber['User']['name'];?>">
              <input type="hidden" id="duracion_Id_edit<?php echo $barber['User']['id'];?>" name="duracionId_edit<?php echo $barber['User']['id'];?>" value="<?php echo $barber['User']['id'];?>">
            </div>
            <?php 
            $position++;
            } 
            ?>
            <input type="hidden" id="cantidadBarbers" name="cantidadBarbers" value="<?php echo count($barbers);?>">
            
            <div class="form-group">
              <label for="accountInputPassword">Tipo</label>
              <select name="tiposervicio_edit" class="form-control" id="tiposervicio_edit">
              <option value="1">Hombres</option>
              <option value="2">Mujeres</option>
              <option value="3">Unisex</option>
              </select>
            </div>
            <div class="form-group text-right">
            <input type="hidden" id="id_edit" name="id_edit" value="0">
              <button type="submit" class="btn btn-primary">Editar Cambios</button>
            </div>
          </form>
        </div>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Agregar servicio nuevo</h4>
          <form action="add_service" method="post" class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Precio</label>
              <input type="number" class="form-control" id="precio" name="precio" aria-describedby="emailHelp" placeholder="Precio">
            </div>
            <?php 
            $position = 0;
            foreach( $barbers as $barber ){ ?>
            <div class="form-group">
              <label for="accountInputEmail">Duración(minutos) <?php echo $barber['User']['name'];?></label>
              <input type="number" class="form-control" id="duracion<?php echo $position;?>" name="duracion<?php echo $position;?>" aria-describedby="emailHelp" placeholder="Duración <?php echo $barber['User']['name'];?>">
              <input type="hidden" id="duracionId<?php echo $position;?>" name="duracionId<?php echo $position;?>" value="<?php echo $barber['User']['id'];?>">
            </div>
            <?php 
            $position++;
            } 
            ?>
            <input type="hidden" id="cantidadBarbers" name="cantidadBarbers" value="<?php echo count($barbers);?>">
            <div class="form-group">
              <label for="accountInputPassword">Tipo</label>
              <select name="tiposervicio" class="form-control" id="tiposervicio">
              <option value="1">Hombres</option>
              <option value="2">Mujeres</option>
              <option value="3">Unisex</option>
              </select>
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
    </article>
  </section>
  <script>
    window.scrollTo(0, document.body.scrollHeight);
    $('#myList a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    });

    function editService(ServicioId){
      $.ajax({
                type: 'POST', 
                url: 'load_service', 
                data: 'idServicio='+ServicioId,
                beforeSend:function() {  

                },
                error: function(){
                    
                alert('No hay internet');    
                },
                success: function(services) {
                  const res = JSON.parse(services);
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
                  
                  $('#id_edit').val(ServicioId); 
                  $('#nombre_edit').val(nombreServicio);
                  $('#precio_edit').val(precioServicio);
                  //$('select>option>value('+generoServicio+')').prop('selected', true);
                  $('#tiposervicio_edit').val(generoServicio);
                }
	});
    }
   
  </script>