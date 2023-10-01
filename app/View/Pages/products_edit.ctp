<script src="https://unpkg.com/html5-qrcode"></script>
<section class="event-detail">
  <article id="profile">
    <h2>Inventario</h2>
    <ul class="nav nav-pills text-end">
      <?php  echo $this->element('menu');?>
    </ul>
    </br>
    <div class="form-group text-left">
      <a href="products" class="btn btn-primary">Agregar Producto</a>
      <a href="products_edit" class="btn btn-primary">Editar Producto</a>
    </div>
    
    <form method="post" id="searchProductEdit" class="col-sm-6 offset-sm-3">
      <div class="form-group text-left">
        <label for="accountInputUser">Buscar Producto</label></br></br>
        <input type="radio" id="search_nombre" value="1" onclick="searchOption(this.value)" name="search_producto" checked>Por nombre
        <input type="radio" id="search_codigo" value="2" onclick="searchOption(this.value)" name="search_producto">Por código de barras
        </br></br>
        <div id="qr-search" style="display:none" class="form-control"></div>
        <input type="text" class="form-control" id="searchProduct" name="searchProduct" aria-describedby="emailHelp" placeholder="Nombre">
      </div>
      <div class="form-group text-left">
        <button type="button" id="buttonSearch" onclick="search()" class="btn btn-primary">Buscar</button>
      </div>
    </form>
    

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
            <input type="number" class="form-control" id="countEditCurrent" value="0" name="countEditCurrent" aria-describedby="emailHelp" placeholder="Cantidad" readonly>
            <input type="hidden" id="countEdit" name="countEdit" value="0">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Nueva Cantidad</label>
            <input type="number" class="form-control" id="NewcountEdit" name="NewcountEdit" value="0" aria-describedby="emailHelp" placeholder="Cantidad">
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
<audio id="audio" controls style="display:none">
<source type="audio/mp3" src="codigos/beep-beep.mp3">
</audio>
<script>


    var resultContainer = document.getElementById('qr-reader-results');
var lastResult, countResults = 0;


let html5QrcodeScannerSearch = 0;
function searchOption(valor){
  
  if( valor == 2 ){
    $('#searchProduct').val('');
    $('#qr-search').show();
    html5QrcodeScannerSearch = new Html5QrcodeScanner(
    "qr-search", { fps: 10, qrbox: 250 });
    html5QrcodeScannerSearch.render(onScanSearchSuccess);
    $('#html5-qrcode-anchor-scan-type-change').hide();
    window.scrollTo(0, document.body.scrollHeight);
  }
  if( valor == 1 ){
    $('#searchProduct').val('');
    $('#qr-search').hide();
  }
  
}
function onScanSearchSuccess(decodedText, decodedResult) {
	
      ++countResults;
      lastResult = decodedText;
      $('#searchProduct').val(decodedText);
      var audio = document.getElementById("audio");
      audio.play();
      $('#buttonSearch').click();
      window.scrollTo(0, document.body.scrollHeight);
}

</script>


<script>

  window.scrollTo(0, document.body.scrollHeight);
  $('#myList a').on('click', function(e) {
    e.preventDefault();
    $(this).tab('show');
  });



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
    $('#countEditCurrent').val('');
    $('#priceEdit').val('');
    $('#sellerEdit').val('');
    $('#home_edit').hide();
    window.scrollTo(0, document.body.scrollHeight);

  }

  $("#editProduct").on("submit", function(event) {
    var nombre = $('#nameEdit').val();
    var count = $('#NewcountEdit').val();
    var price = $('#priceEdit').val();
   

    if (nombre == '' || count == '' || count == '0' || price == '') {
      event.preventDefault();
      $showError = false;
      if (nombre == '') {
        $('#nameEdit').css('border', '2px solid red');
        $showError = true;
      } else {
        $('#nameEdit').css('border', '');
      }
      if (count == '' || count == '0') {
        $showError = true;
        $('#NewcountEdit').css('border', '2px solid red');
      } else {
        $('#NewcountEdit').css('border', '');
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
      $('#productUpdated').show();
      setInterval(function() {
        $('#productUpdated').hide('2000');
      }, 2000);
    }
  });


  function showeditProduct(id) {
    $('.list-group-item').removeClass('active');
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
        $('#countEditCurrent').val(res["Product"]["quantity"]);
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
    if( $('#search_nombre').is(':checked') ){
      var search_producto = 1;
    }
    if( $('#search_codigo').is(':checked') ){
      var search_producto = 2;
    }
      
    $.ajax({
      type: 'POST',
      url: 'search_product',
      data: 'searchProduct=' + product +'&search_producto='+search_producto,
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
        if( boton == '' ){
          boton += ' <a class="list-group-item list-group-item-action" id="edit_empty" data-toggle="list" role="tab" style="color:black;">No existen productos</a>';

        }
        $('#productList').html(boton);
        if( $('#search_codigo').is(':checked') ){
          $('#edit_' + idProducts).click();
        }

      }
    });
  }
</script>
