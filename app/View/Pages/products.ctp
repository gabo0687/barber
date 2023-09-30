<section class="event-detail">
  <article id="profile">
    <h2>Inventario</h2>
    <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
    </ul>
    </br>
    <div class="form-group text-left">
      <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar Producto</button>
      <button type="button" onclick="showEditForm()" class="btn btn-primary">Editar Producto</button>
    </div>
    <div style="display:none;" id="userUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
      <h4 class="alert-heading">Usuario actualizado! </h4>
      <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      <hr>
    </div>
    <form method="post" id="searchProductEdit" style="display:none;" class="col-sm-6 offset-sm-3">
      <div class="form-group text-left">
        <label for="accountInputUser">Buscar Producto</label>
        <input type="text" class="form-control" id="searchProduct" name="searchProduct" aria-describedby="emailHelp" placeholder="Nombre">
      </div>
      <div class="form-group text-left">
        <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
      </div>
    </form>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
        <form action="add_product" method="post" id="createNewProduct" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Agregar Producto</h4>
          <div class="form-group">
            <label for="accountInputUser">Nombre del producto</label>
            <input type="text" class="form-control" id="nameAdd" name="nameAdd" aria-describedby="emailHelp" placeholder="Nombre">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Precio</label>
            <input type="number" class="form-control" id="priceAdd" name="priceAdd" aria-describedby="emailHelp" placeholder="Precio">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Cantidad en inventario</label>
            <input type="number" class="form-control" id="countAdd" name="countAdd" aria-describedby="emailHelp" placeholder="Cantidad">
          </div>
          <div class="form-group">
            <label for="accountInputUser">Provedor</label>
            <input type="text" class="form-control" id="sellerAdd" name="sellerAdd" aria-describedby="emailHelp" placeholder="Provedor">
          </div>
          <div class="form-group" id="error-color" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Este Color ya esta siendo utilizado por otro usuario.</b></span></label>
          </div>
          <div class="form-group" id="error-empty" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
          </div>
          <div class="form-group" id="error-passChar" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
          </div>
          <div style="display:none;" id="productCreated" class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Cliente creado! </h4>
            <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Guardar producto</button>
          </div>
        </form>
      </div>
    </div>

    <div class="list-group" style="display:none;" id="productList" role="tablist">
    </div>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="home_edit" style="display:none;" role="tabpanel" aria-labelledby="nav-profile-tab">
        <form action="update_product" method="post" id="editProduct" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Editar Producto</h4>
          <div class="form-group" style="display:none;">
            <label for="accountInputUser">id</label>
            <input type="text" class="form-control" id="idEdit" name="idEdit" aria-describedby="emailHelp" placeholder="Nombre">
          </div>
          <div class="form-group">
            <label for="accountInputUser">Nombre del producto</label>
            <input type="text" class="form-control" id="nameEdit" name="nameEdit" aria-describedby="emailHelp" placeholder="Nombre">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Precio</label>
            <input type="number" class="form-control" id="priceEdit" name="priceEdit" aria-describedby="emailHelp" placeholder="Precio">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Cantidad en inventario</label>
            <input type="number" class="form-control" id="countEdit" name="countEdit" aria-describedby="emailHelp" placeholder="Cantidad">
          </div>
          <div class="form-group">
            <label for="accountInputUser">Provedor</label>
            <input type="text" class="form-control" id="sellerEdit" name="sellerEdit" aria-describedby="emailHelp" placeholder="Provedor">
          </div>
          <div class="form-group" id="error-emptyEdit" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
          </div>
          <div class="form-group" id="error-passChar" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
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
  $('#searchProductEdit').on('submit', function(e) {
    e.preventDefault();
    search();
  });


  window.scrollTo(0, document.body.scrollHeight);
  $('#myList a').on('click', function(e) {
    e.preventDefault();
    $(this).tab('show');
  });

  function showAddForm() {
    $('#createNewProduct').show();
    $('#home_list').hide();
    $('#home_edit').hide();
    $('#productList').hide();
    $('#searchProductEdit').hide();

  }

  function showEditForm() {
    $('#productList').html('');
    $('#searchProduct').val('');
    $('#editProduct').hide();
    $('#createNewProduct').hide();
    $('#home_list').show();
    $('#productList').show();
    $('#searchProductEdit').show();
    $('#idEdit').val('');
    $('#nameEdit').val('');
    $('#countEdit').val('');
    $('#priceEdit').val('');
    $('#sellerEdit').val('');
    $('#home_edit').hide();


  }

  $("#createNewProduct").on("submit", function(event) {
    var nombre = $('#nameAdd').val();
    var cantidad = $('#countAdd').val();
    var precio = $('#priceAdd').val();

    if (nombre == '' || cantidad == '' || precio == '') {
      event.preventDefault();
      $showError = false;
      if (nombre == '') {
        $('#nameAdd').css('border', '2px solid red');
        $showError = true;
      } else {
        $('#nameAdd').css('border', '');
      }
      if (cantidad == '') {
        $showError = true;
        $('#countAdd').css('border', '2px solid red');
      } else {
        $('#countAdd').css('border', '');
      }
      if (precio == '') {
        $showError = true;
        $('#priceAdd').css('border', '2px solid red');
      } else {
        $('#priceAdd').css('border', '');
      }

      if ((updatePassError == true)) {
        $('#passwordAdd').css('border', '2px solid red');
        $('#error-passChar').show();
      } else {
        $('#passwordAdd').css('border', '');
        $('#error-passChar').hide();
      }
      if ($showError) {
        $('#error-empty').show();
      } else {
        $('#error-empty').hide();
      }
    } else {
      $('#error-empty').hide();
      $('#error-phone').hide();
      window.scrollTo(0, 0);
      $('.close').click();
      $('#productCreated').show();
      setInterval(function() {
        $('#productCreated').hide('2000');
      }, 2000);
    }
  });

  $("#editProduct").on("submit", function(event) {
    var nombre = $('#nameEdit').val();
    var count = $('#countEdit').val();
    var price = $('#priceEdit').val();

    if (nombre == '' || count == '' || price == '') {
      event.preventDefault();
      $showError = false;
      if (nombre == '') {
        $('#nameEdit').css('border', '2px solid red');
        $showError = true;
      } else {
        $('#nameEdit').css('border', '');
      }
      if (count == '') {
        $showError = true;
        $('#countEdit').css('border', '2px solid red');
      } else {
        $('#countEdit').css('border', '');
      }
      if (price == '') {
        $showError = true;
        $('#priceEdit').css('border', '2px solid red');
      } else {
        $('#priceEdit').css('border', '');
      }
      if ($showError) {
        $('#error-emptyEdit').show();
      } else {
        $('#error-emptyEdit').hide();
      }
    } else {
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


  function showeditProduct(id) {
    $('#edit_' + id).addClass('active');
    $('#home_edit').show();


    $.ajax({
      type: 'POST',
      url: 'edit_product',
      data: 'idProduct=' + id,
      beforeSend: function() {

      },
      error: function() {

        alert('No hay internet');
      },
      success: function(prod) {
        const res = JSON.parse(prod);
        $('#idEdit').val(res["Product"]["id"]);
        $('#nameEdit').val(res["Product"]["name"]);
        $('#countEdit').val(res["Product"]["quantity"]);
        $('#priceEdit').val(res["Product"]["price"]);
        $('#sellerEdit').val(res["Product"]["provider"]);


      }

    });
  }


  function search() {
    var product = $('#searchProduct').val();
    $('#createNewProduct').hide();
    $('#home_list').show();
    $('#productList').show();
    $('#editProduct').show();
    $('#home_edit').hide();

    $.ajax({
      type: 'POST',
      url: 'search_product',
      data: 'searchProduct=' + product,
      beforeSend: function() {

      },
      error: function() {

        alert('No hay internet');
      },
      success: function(products) {
        const res = JSON.parse(products);
        var idProducts = '';
        var nombreProducts = '';

        var i = 0;
        let list = document.getElementById("productList");
        var boton = '';
        Object.entries(res).forEach((entry) => {
          idProducts = entry[1].Product.id;
          nombreProducts = entry[1].Product.name + " / " + entry[1].Product.provider;
          boton += ' <a class="list-group-item list-group-item-action" id="edit_' + idProducts + '" data-toggle="list" onclick="showeditProduct(' + idProducts + ')" role="tab" style="color:black;">' + nombreProducts + '</a>';

          i++;
        });
        $('#productList').html(boton);

      }
    });
  }
</script>
