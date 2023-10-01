<section class="event-detail">
  <article id="profile">
    <h2>Inventario</h2>
    <ul class="nav nav-pills text-end">
    <?php  echo $this->element('menu');?>
    </ul>
    </br>
    <div class="form-group text-left">
      <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar Venta</button>
      <button type="button" onclick="showEditForm()" class="btn btn-primary">Editar Venta</button>
    </div>
    <div style="display:none;" id="userUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
      <h4 class="alert-heading">Usuario actualizado! </h4>
      <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
      <hr>
    </div>
    <form method="post" id="searchProductEdit" style="display:none;" class="col-sm-6 offset-sm-3">
      <div class="form-group text-left">
        <label for="accountInputUser">Buscar Venta</label>
        <input type="text" class="form-control" id="searchProduct" name="searchProduct" aria-describedby="emailHelp" placeholder="Nombre">
      </div>
      <div class="form-group text-left">
        <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
      </div>
    </form>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
        <form action="add_sales" method="post" id="createNewSale" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Agregar venta</h4>
          <?php
          if ($user['User']['type'] == 1 || $user['User']['type'] == 2) { ?>
            <span class="description">Cliente:</span>
            <span class="tax">

              <input type="search" list="clients" class="form-control" id="client" name="client" placeholder="Escribe el nombre del cliente">

              <datalist id="clients">
                <?php foreach ($clients as $client) { ?>
                  <option value="<?php echo $client['User']['id']; ?>-<?php echo $client['User']['name']; ?> | <?php echo $client['User']['phone']; ?>">
                  <?php } ?>
              </datalist>
            </span>
            </br>
          <?php } ?>


          <span class="description">Producto:</span>
          <span class="tax">

            <input type="search" list="products-sales" onchange="searchQuantity()" class="form-control" id="productSales" name="productSales" placeholder="Escribe el nombre del producto">
          
            <datalist id="products-sales">
              
             <?php foreach ($products as $product) { ?>
                <option id="productOptionSales" name="productOptionSales" value="<?php echo $product['Product']['id']; ?>-<?php echo $product['Product']['name']; ?> / <?php echo $product['Product']['provider']; ?> | ₡<?php echo $product['Product']['price']; ?>">
                <?php } ?>
            </datalist>
          </span>
          </br>

          <div class="form-group">
            <label for="accountInputEmail">Cantidad disponible</label>
            <input type="number" class="form-control" id="countAddAvailable" name="countAddAvailable" aria-describedby="emailHelp" placeholder="Cantidad en stock" disabled>

            <input type="hidden" id="countAddAvaiableProduct" name="countAddAvaiableProduct" value="0">
         
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Cantidad</label>
            <input type="number" class="form-control" id="countAdd" name="countAdd" onblur="calculatePrice()" aria-describedby="emailHelp" placeholder="Cantidad">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Precio</label>
            <input type="number" class="form-control" id="priceAdd" name="priceAdd" aria-describedby="emailHelp" placeholder="Precio">
          </div>
          <div class="form-group">
            <label for="accountInputUser">Pago</label>
            <select name="payAdd" id="payAdd" class="form-control">
              <option value="2">Efectivo</option>
              <option value="1">Tarjeta</option>
            </select>
          </div>
          <span class="description">Vendedor:</span>
          <span class="tax">

            <input type="search" list="sellers" class="form-control" id="seller" name="seller" placeholder="Escribe el nombre del vendedor">

            <datalist id="sellers">
              <?php foreach ($sellers as $seller) { ?>
                <option id="sellerOption" name="sellerOption" value="<?php echo $seller['User']['id']; ?>-<?php echo $seller['User']['name']; ?>">
                <?php } ?>
            </datalist>
          </span>
          </br>
          <div class="form-group">
            <label for="accountInputEmail">Fecha</label>
            <input type="date" class="form-control" id="dateAdd" name="dateAdd" aria-describedby="emailHelp" placeholder="Fecha">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Notas</label>
            <input type="text" class="form-control" id="notesAdd" name="notesAdd" aria-describedby="emailHelp" placeholder="Notas">
          </div>
          <div class="form-group" id="error-quantity" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La cantidad es mayor a la que hay disponible.</b></span></label>
          </div>
          <div class="form-group" id="error-empty" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
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
        <form action="update_sales" method="post" id="editProduct" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Editar Ventas</h4>
          <?php
          if ($user['User']['type'] == 1 || $user['User']['type'] == 2) { ?>
            <span class="description">Cliente:</span>
            <span class="tax">

              <input type="search" list="clientsEdit" class="form-control" id="clientEdit" name="clientEdit" placeholder="Escribe el nombre del cliente">

              <datalist id="clientsEdit">
                <?php foreach ($clients as $client) { ?>
                  <option value="<?php echo $client['User']['id']; ?>-<?php echo $client['User']['name']; ?> | <?php echo $client['User']['phone']; ?>">
                  <?php } ?>
              </datalist>
            </span>
            </br>
          <?php } ?>


          <span class="description">Producto:</span>
          <span class="tax">

            <input type="search" list="productsEdit" class="form-control" id="productEdit" name="productEdit" placeholder="Escribe el nombre del producto">

            <datalist id="productsEdit">
              <?php foreach ($products as $product) { ?>
                <option id="productOptionEdit" name="productOptionEdit" value="<?php echo $product['Product']['id']; ?>-<?php echo $product['Product']['name']; ?> / <?php echo $product['Product']['provider']; ?> | ₡<?php echo $product['Product']['price']; ?>">
                <?php } ?>
            </datalist>
          </span>
          </br>

          <div class="form-group">
            <label for="accountInputEmail">Cantidad disponible</label>
            <input type="number" class="form-control" id="countAddAvailableEdit" name="countAddAvailableEdit" aria-describedby="emailHelp" placeholder="Cantidad en stock" disabled>
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Cantidad</label>
            <input type="number" class="form-control" id="countAddEdit" name="countAddEdit" onblur="calculatePrice()" aria-describedby="emailHelp" placeholder="Cantidad">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Precio</label>
            <input type="number" class="form-control" id="priceAddEdit" name="priceAddEdit" aria-describedby="emailHelp" placeholder="Precio">
          </div>
          <div class="form-group">
            <label for="accountInputUser">Pago</label>
            <select name="payAddEdit" id="payAddEdit" class="form-control">
              <option value="2">Efectivo</option>
              <option value="1">Tarjeta</option>
            </select>
          </div>
          <span class="description">Vendedor:</span>
          <span class="tax">

            <input type="search" list="sellers" class="form-control" id="sellerEdit" name="sellerEdit" placeholder="Escribe el nombre del vendedor">

            <datalist id="sellers">
              <?php foreach ($sellers as $seller) { ?>
                <option id="sellerOptionEdit" name="sellerOptionEdit" value="<?php echo $seller['User']['id']; ?>-<?php echo $seller['User']['name']; ?>">
                <?php } ?>
            </datalist>
          </span>
          </br>
          <div class="form-group">
            <label for="accountInputEmail">Fecha</label>
            <input type="date" class="form-control" id="dateAddEdit" name="dateAddEdit" aria-describedby="emailHelp" placeholder="Fecha">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Notas</label>
            <input type="text" class="form-control" id="notesAddEdit" name="notesAddEdit" aria-describedby="emailHelp" placeholder="Notas">
          </div>
          <div class="form-group" id="error-emptyEdit" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
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
  var cantProductos = 0;
  var productChange = "";
  var productPrice = 0;
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
    $('#createNewSale').show();
    $('#home_list').hide();
    $('#home_edit').hide();
    $('#productList').hide();
    $('#searchProductEdit').hide();

  }

  function showEditForm() {
    $('#productList').html('');
    $('#searchProduct').val('');
    $('#editProduct').hide();
    $('#createNewSale').hide();
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

  $("#createNewSale").on("submit", function(event) {
    var cantidad = $('#countAdd').val();
    var precio = $('#priceAdd').val();
    var SinInventario = false;

    var client = 0;
    var clientEmpty = true;
    var clientFormat = true;
    client = $('#clients').val();
    var splitClient = client.split('-');

    if ($('#clients').val() == '') {
      clientEmpty = false;
    } else {
      var splitClient = client.split('-');
    }
    if (splitClient.length < 2) {
      clientFormat = false;
    }

    if (cantidad > cantProductos) {
      SinInventario = true;
    }


    if (cantidad == '' || precio == '' || SinInventario == true || clientEmpty && clientFormat) {
      event.preventDefault();
      $showError = false;
      if (cantidad == '') {
        $showError = true;
        $('#countAdd').css('border', '2px solid red');
      } else {
        $('#countAdd').css('border', '');
      }
      if (SinInventario == true) {
        $('#countAdd').css('border', '2px solid red');
        $('#error-quantity').show();
      } else {
        $('#countAdd').css('border', '');
        ('#error-quantity').hide();
      }
      if (precio == '') {
        $showError = true;
        $('#priceAdd').css('border', '2px solid red');
      } else {
        $('#priceAdd').css('border', '');
        $('#error-passChar').hide();
      }
      if ($showError) {
        $('#error-empty').show();
      } else {
        $('#error-empty').hide();
      }
    } else {
      $('#error-empty').hide();
      $('#error-quantity').hide();
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


  function showEditProduct(id) {
    $('#edit_' + id).addClass('active');
    $('#home_edit').show();


    $.ajax({
      type: 'POST',
      url: 'edit_sales',
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
    $('#createNewSale').hide();
    $('#home_list').show();
    $('#productList').show();
    $('#editProduct').show();
    $('#home_edit').hide();

    $.ajax({
      type: 'POST',
      url: 'search_sales',
      data: 'searchProduct=' + product,
      beforeSend: function() {

      },
      error: function() {

        alert('No hay internet');
      },
      success: function(products) {
        const res = JSON.parse(products);
        var idProducts = '';

        var i = 0;
        let list = document.getElementById("productList");
        var boton = '';
        Object.entries(res).forEach((entry) => {
          idProducts = entry[1].Product.id;
          nombreProducts = entry[1].Product.name + " / " + entry[1].Product.provider;
          boton += ' <a class="list-group-item list-group-item-action" id="edit_' + idProducts + '" data-toggle="list" onclick="showEditProduct(' + idProducts + ')" role="tab" style="color:black;">' + nombreProducts + '</a>';

          i++;
        });
        $('#productList').html(boton);

      }
    });
  }

 
  function calculatePrice() {
    var cant = $('#countAdd').val();
    productPrice = productPrice * cant;
    $('#priceAdd').val(productPrice);
  }

  function searchQuantity() {

    var prod = 0;
    prod = $('#productSales').val();
    if (prod != "") {
      var splitProd = prod.split('-');

      $.ajax({
        type: 'POST',
        url: 'search_quantity',
        data: 'idProduct=' + splitProd[0],
        beforeSend: function() {

        },
        error: function() {

          alert('No hay internet');
        },
        success: function(products) {
          const res = JSON.parse(products);
          if (res != "") {
            cantProductos = res['Product']['quantity'];
            var price = "";
            price = res['Product']['price'];
            $('#countAddAvailable').val(cantProductos);

            $('#countAddAvaiableProduct').val(cantProductos);

            $('#priceAdd').val(price);
            productPrice = price;
          }


        }

      });
    } else {
      cantProductos = "";
      $('#countAddAvailable').val(cantProductos);
    }
  }
</script>