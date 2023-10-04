<script src="https://unpkg.com/html5-qrcode"></script>
<section class="event-detail">
  <article id="profile">
    <h2>Inventario</h2>
    <ul class="nav nav-pills text-end">
    <?php  echo $this->element('menu');?>
    </ul>
    </br>
    <div class="form-group text-left">
      <a href="sales" class="btn btn-primary">Agregar Venta</a>
      <a href="sales_edit" class="btn btn-primary">Editar Venta</a>
    </div>
    <form method="post" id="searchSaleEdit" style="display:none;" class="col-sm-6 offset-sm-3">
      <div class="form-group text-left">
        <label for="accountInputUser">Buscar Venta</label>
        <input type="date" class="form-control" id="searchSale" name="searchSale" aria-describedby="emailHelp" placeholder="Fecha">
      </div>
      <div class="form-group text-left">
        <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
      </div>
    </form>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
        <form action="add_sales" method="post" id="createNewSale" class="col-sm-6 offset-sm-3">
          <h4 class="offset-sm-3">Agregar venta</h4>
            <span class="description">Cliente:</span>
            <span class="tax">

              <input type="search" list="clientsSale" class="form-control" id="clientSale" name="clientSale" placeholder="Escribe el nombre del cliente">

              <datalist id="clientsSale">
                <?php foreach ($clients as $client) { ?>
                  <option  value="<?php echo $client['User']['id']; ?>-<?php echo $client['User']['name']; ?> | <?php echo $client['User']['phone']; ?>">
                  <?php } ?>
              </datalist>
            </span>
            </br>
          <div class="form-group text-left">
        <label for="accountInputUser">Buscar Producto:</label></br></br>
        <input type="radio" id="search_nombreSale" value="1" onclick="searchOption(this.value)" name="search_producto" checked>Por nombre
        <input type="radio" id="search_codeSale" value="2" onclick="searchOption(this.value)" name="search_producto">Por código de barras
        </br></br>
      </div>
          <span class="tax">

            <input type="search" list="products-sales" onchange="searchQuantity()" class="form-control" id="productSales" name="productSales" placeholder="Escribe el nombre del producto">
          
            <datalist id="products-sales">
              
             <?php foreach ($products as $product) { ?>
                <option id="productOptionSales" name="productOptionSales" value="<?php echo $product['Product']['id']; ?>-<?php echo $product['Product']['name']; ?> / <?php echo $product['Product']['provider']; ?> | ₡<?php echo $product['Product']['price']; ?>">
                <?php } ?>
            </datalist>
          </span>
          </br>
          <div class="form-group" id="scanSale" name="scanSale" style="display:none;">
            <span onclick="scanearCodigo()" id="botonScan" class="btn btn-secondary">Scanear Código de Barras</span></br></br>
              <div id="qr-reader" style="display:none;" class="form-control"></div>
              </br>
              <input type="hidden" class="form-control" name="codigo_barra_text" id="codigo_barra_text" placeholder="Código de barras" readonly>
              <input type="hidden" class="form-control" name="codigo_barra" id="codigo_barra">
            </div>
          <div class="form-group" style="display:none;">
            <input type="hidden" id="countAddAvaiableProduct" name="countAddAvaiableProduct" value="0">      
          </div>
          <div class="form-group">
            <label for="accountInputUser">Cantidad</label>
            <select name="MaxCountAdd" id="MaxCountAdd" class="form-control" onchange="calculatePrice()" >
            </select>
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Descuento %</label>
            <input type="number" class="form-control" id="priceDiscount" name="priceDiscount" onkeyup="calculatePrice()" aria-describedby="emailHelp" placeholder="Porcentaje de descuento">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Precio</label>
            <input type="number" class="form-control" id="priceAddSale" name="priceAddSale" aria-describedby="emailHelp" placeholder="Precio" disabled>
          </div>
          <div class="form-group" style="display:none;">
            <label for="accountInputEmail">Precio</label>
            <input type="number" class="form-control" id="originalPriceAddSale" name="originalPriceAddSale" aria-describedby="emailHelp" placeholder="Precio">
          </div>
          <div class="form-group">
            <label for="accountInputUser">Pago</label>
            <select name="payAddSale" id="payAddSale" class="form-control">
              <option value="2">Efectivo</option>
              <option value="1">Tarjeta</option>
            </select>
          </div>
          <span class="description">Vendedor:</span>
          <span class="tax">

            <input type="search" list="sellers" class="form-control" id="seller" name="seller" placeholder="Escribe el nombre del vendedor">

            <datalist id="sellers">
              <?php foreach ($sellers as $seller) { ?>
                <option id="sellerOptionSales" name="sellerOptionSales" value="<?php echo $seller['User']['id']; ?>-<?php echo $seller['User']['name']; ?>">
                <?php } ?>
            </datalist>
          </span>
          </br>
          <div class="form-group">
            <label for="accountInputEmail">Fecha</label>
            <input type="date" class="form-control" id="dateAddSale" name="dateAddSale" aria-describedby="emailHelp" placeholder="Fecha">
          </div>
          <div class="form-group">
            <label for="accountInputEmail">Notas</label>
            <input type="text" class="form-control" id="notesAddSale" name="notesAddSale" aria-describedby="emailHelp" placeholder="Notas">
          </div>
          <div class="form-group" id="error-quantitySales" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>No hay cantidades disponibles.</b></span></label>
          </div>
          <div class="form-group" id="error-emptySales" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
      </div>
    </div>
  </article>
</section>
<audio id="audio" controls style="display:none">
<source type="audio/mp3" src="codigos/beep-beep.mp3">
</audio>

<script>

var lastResult, countResults = 0;
let html5QrcodeScanner = 0;

function scanearCodigo(){
  $('#qr-reader').show();
  html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
$('#html5-qrcode-anchor-scan-type-change').hide();
}

function onScanSuccess(decodedText, decodedResult) {
	
        ++countResults;
        lastResult = decodedText;
        // Handle on success condition with the decoded message.
        $('#codigo_barra').val(decodedText);
        $('#codigo_barra_text').val(decodedText);

      var audio = document.getElementById("audio");
      audio.play();
      getBarCodeInfo(decodedText);
     
}


function getBarCodeInfo(barCode){
  
  $.ajax({
      type: 'POST',
      url: 'searchProduct_barcode',
      data: 'barcode=' +barCode,
      beforeSend: function() {

      },
      error: function() {

        alert('No hay internet');
      },
      success: function(barcode) {
        if(barcode == '[]'){
          alert("prducto no registrado");
          $('#MaxCountAdd').focus();
        html5QrcodeScanner.clear();
        $('#qr-reader').hide();
        }else{
          const res = JSON.parse(barcode);
        $('#priceAddSale').val(res[0]["Product"]["price"]);
        var productName = res[0]["Product"]["id"]+"-"+res[0]["Product"]["name"]+" / "+res[0]["Product"]["provider"]+" | "+res[0]["Product"]["price"];
        $('#productSales').val(productName);
        html5QrcodeScanner.clear();
        searchQuantity();
        $('#qr-reader').hide();
          $('#codigo_barra').val('');
         $('#codigo_barra_text').val('');
        $('#error-codigo').show();
        window.scrollTo(0, document.body.scrollHeight);
        }
        window.scrollTo(0, document.body.scrollHeight);

      }

    });
}

</script>
<script>
  
  function searchOption(valor){
  
  if( valor == 2 ){
    $('#scanSale').show();
    $('#productSales').hide();
    window.scrollTo(0, document.body.scrollHeight);
  }
  if( valor == 1 ){
    $('#productSales').show();
    $('#scanSale').hide();
  }
  
}

  var cantProductos = 0;
  var productOriginalPrice= "";
  var productPrice = 0;
 /* $('#searchSaleEdit').on('submit', function(e) {
    e.preventDefault();
    search();
  });
*/

  window.scrollTo(0, document.body.scrollHeight);
  $('#myList a').on('click', function(e) {
    e.preventDefault();
    $(this).tab('show');
  });

  function showAddForm() {
    $('#createNewSale').show();
    $('#home_list').hide();
    $('#home_editSales').hide();
    $('#saleList').hide();
    $('#searchSaleEdit').hide();

  }

  function showEditForm() {
    $('#saleList').html('');
    $('#searchSale').val('');
    $('#editSales').hide();
    $('#createNewSale').hide();
    $('#home_list').show();
    $('#saleList').show();
    $('#searchSaleEdit').show();
    $('#idEdit').val('');
    $('#nameEdit').val('');
    $('#countEdit').val('');
    $('#priceEdit').val('');
    $('#sellerEdit').val('');
    $('#home_editSales').hide();


  }

  
 
  function calculatePrice() {
    $('#priceAddSale').val('');
    var descuento = $('#priceDiscount').val();
    var cant = $('#MaxCountAdd').val();
    var newPrice = (productPrice * cant)-(((productPrice * cant) * descuento)/100);
    $('#priceAddSale').val(newPrice);
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
            $('#MaxCountAdd').empty();
            var i = 0;
            if(cantProductos > 0 ){
              while (i < cantProductos) {
              i++;
              $('#MaxCountAdd').append('<option onfocus="calculatePrice()" >'+i+'</option>');
            
               }

            $('#countAddAvailable').val(cantProductos);

            $('#countAddAvaiableProduct').val(cantProductos);

            $('#priceAddSale').val(price);
            $('#originalPriceAddSale').val(price);
            $('#MaxCountAdd').css('border', '');
            $('#error-quantitySales').hide;
            productPrice = price;
            calculatePrice();
            } else{
              $('#MaxCountAdd').append('<option onfocus="calculatePrice()" >0</option>');
              $('#error-quantitySales').show;
              
              $('#MaxCountAdd').css('border', '2px solid red');
              alert('Producto agotado en inventario');
              $('#countAddAvailable').val(0);
              $('#countAddAvaiableProduct').val(0);
            }
  
          }


        }

      });
    } else {
      cantProductos = "";
      $('#countAddAvailable').val(cantProductos);
    }
  }


  function search() {
  
    var date = $('#searchSale').val();
    
    $('#createNewSale').hide();
    $('#home_list').show();
    $('#saleList').show();
    $('#editSales').show();
    $('#home_editSales').hide();

    $.ajax({
      type: 'POST',
      url: 'search_sales',
      data: 'searchSales=' + date,
      beforeSend: function() {

      },
      error: function() {

        alert('No hay internet');
      },
      success: function(products) {
        const res = JSON.parse(products);
        var idProducts = '';

        var i = 0;
        let list = document.getElementById("saleList");
        var boton = '';
        Object.entries(res).forEach((entry) => {
          idSale = entry[1].Sale.id;
          nombreSales = idSale+ "- Cliente: " + entry[1].User.name + " / Producto: "+ entry[1].Product.name;
          boton += ' <a class="list-group-item list-group-item-action" id="editSale_' + idSale + '" data-toggle="list" onclick="showEditSales(' + idSale + ')" role="tab" style="color:black;">' + nombreSales + '</a>';

          i++;
        });
        $('#saleList').html(boton);

      }
    });
  }


 

  $("#createNewSale").on("submit", function(event) {
    var client = 0;
    var clientEmpty = true;
    var clientFormat = true;
    client = $('#clientSale').val();
    var splitClient = client.split('-');

    if ($('#clientSale').val() == '') {
      clientEmpty = false;
    } else {
      var splitClient = client.split('-');
    }
    if (splitClient.length < 2) {
      clientFormat = false;
    }

    var product = 0;
    var productEmpty = true;
    var productFormat = true;
    product = $('#productSales').val();
    var splitProduct = product.split('-');

    if ($('#productSales').val() == '') {
      productEmpty = false;
    } else {
      var splitProduct = product.split('-');
    }
    if (splitProduct.length < 2) {
      productFormat = false;
    }

    var seller = 0;
    var sellerEmpty = true;
    var sellerFormat = true;
    seller = $('#seller').val();
    var splitSeller = seller.split('-');

    if ($('#seller').val() == '') {
      sellerEmpty = false;
    } else {
      var splitSeller = seller.split('-');
    }
    if (splitSeller.length < 2) {
      sellerFormat = false;
    }

    inventory = $('#MaxCountAdd').val(); 
    if (!clientEmpty && !clientFormat || !productEmpty && !productFormat || !sellerEmpty && !sellerFormat || inventory == 0 ) {
      event.preventDefault();
      $showError = false;
      if(!clientEmpty && !clientFormat){
        $('#clientSale').css('border', '2px solid red');
        $showError = true;
      }else{
        $('#clientSale').css('border', '');
      }
      if(!productEmpty && !productFormat){
        $('#productSales').css('border', '2px solid red');
        $showError = true;
      }else{
        $('#productSales').css('border', '');
      }
      if(!sellerEmpty && !sellerFormat){
        $('#seller').css('border', '2px solid red');
        $showError = true;
      }else{
        $('#seller').css('border','');
      }
      if(inventory == 0){
        $('#MaxCountAdd').css('border', '2px solid red');
        $('#error-quantitySales').show;
      }else{
        $('#MaxCountAdd').css('border','');
        $('#error-quantitySales').hide;
      }

      if ($showError) {
        $('#error-emptySales').show();
      } else {
        $('#error-emptySales').hide();
      }
    } else {
      $('#error-emptySales').hide();
      $('#error-quantitySales').hide;
      $('#clientSale').css('border', '');
      $('#productSales').css('border', '');
      $('#seller').css('border','');
      window.scrollTo(0, 0);
      $('.close').click();
      $('#saleDone').show();
      setInterval(function() {
        $('#saleDone').hide('2000');
      }, 2000);
    }
  });

  
  $("#editSales").on("submit", function(event) {
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
        $('#error-emptySalesEdit').show();
      } else {
        $('#error-emptySalesEdit').hide();
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
</script>