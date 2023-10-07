<script src="https://unpkg.com/html5-qrcode"></script>
<style>

    #clientSale {
        width: 100%;
        padding: 10px;
        
    }

    #clientsSale {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 550px;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }

    #clientsSale li {
        padding: 10px;
        cursor: pointer;
    }

    #clientsSale li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonClient {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}

    /* Products */
    #productSales {
        width: 100%;
        padding: 10px;
        
    }

    #productOptionSales {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 550px;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }

    #productOptionSales li {
        padding: 10px;
        cursor: pointer;
    }

    #productOptionSales li:hover {
        background-color: #f0f0f0;
    }

    #clear-buttonProducts {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}

    /* Seller */
    #seller {
        width: 100%;
        padding: 10px;
        
    }

    #sellerOptionSales {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 550px;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }

    #sellerOptionSales li {
        padding: 10px;
        cursor: pointer;
    }

    #sellerOptionSales li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonSeller {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}
    /* Responsive */


    @media all and (max-width: 768px){

      
    #clientSale {
        width: 100%;
        padding: 10px;
        
    }
      #clientsSale {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 95%;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }
  

#clientsSale li {
    padding: 10px;
    cursor: pointer;
}

#clientsSale li:hover {
    background-color: #f0f0f0;
}
#clear-buttonClient {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}
/*Responsive Product */

#productSales {
        width: 100%;
        padding: 10px;
        
    }

    #productOptionSales {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 550px;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }

    #productOptionSales li {
        padding: 10px;
        cursor: pointer;
    }

    #productOptionSales li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonProducts {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}
/*Responsive Seller */

#seller {
        width: 100%;
        padding: 10px;
        
    }

    #sellerOptionSales {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 550px;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
    }

    #sellerOptionSales li {
        padding: 10px;
        cursor: pointer;
    }

    #sellerOptionSales li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonSeller {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}

    }

</style>  
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
            </br>
            <div class="input-container">
          <input type="text" id="clientSale" name="clientSale" class="form-control" placeholder="Escribe el nombre del cliente">
          <span id="clear-buttonClient" class="hidden">×</span>
        </div>

        <ul id="clientsSale" class="hidden">
        <?php foreach( $clients as $client ){
          $clientSelectedSale = "'".$client['User']['id'].'-'.$client['User']['name'].' | '.$client['User']['phone']."'";
           ?>
            <li style="color:black" onclick="selectClientSale(<?php echo $clientSelectedSale;?>)"><?php echo $client['User']['id'];?>-<?php echo $client['User']['name'];?> | <?php echo $client['User']['phone'];?></li>
            <?php } ?>
        </ul>
     
          <div class="form-group text-left">
        <label for="accountInputUser">Buscar Producto:</label></br></br>
        <input type="radio" id="search_nombreSale" value="1" onclick="searchOption(this.value)" name="search_producto" checked>Por nombre
        <input type="radio" id="search_codeSale" value="2" onclick="searchOption(this.value)" name="search_producto">Por código de barras
        </br></br>
      </div>
         



            <div class="input-container">
          <input type="text" id="productSales" name="productSales"  class="form-control" placeholder="Escribe el nombre del producto">
          <span id="clear-buttonProducts" class="hidden">×</span>
        </div>

        <ul id="productOptionSales" class="hidden"  >
        <?php foreach( $products as $product ){
          $productSelected = "'".$product['Product']['id'].'-'.$product['Product']['name'].' | '.$product['Product']['provider'].' | '.$product['Product']['price']."'";
           ?>
            <li style="color:black"  onclick="selectProductSale(<?php echo $productSelected;?>)" ><?php echo $product['Product']['id'];?>-<?php echo $product['Product']['name'];?> | <?php echo $product['Product']['provider'];?>| <?php echo $product['Product']['price'];?></li>
            <?php } ?>
        </ul>
      

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
        

          <div class="input-container">
          <input type="text" id="seller" name="seller" class="form-control" placeholder="Escribe el nombre del vendedor">
          <span id="clear-buttonSeller" class="hidden">×</span>
        </div>

        <ul id="sellerOptionSales" class="hidden">
        <?php foreach( $sellers as $seller ){
          $SelectedSeller = "'".$seller['User']['id'].'-'.$seller['User']['name']."'";
           ?>
            <li style="color:black" onclick="selectSellerSale(<?php echo $SelectedSeller;?>)"><?php echo $seller['User']['id'];?>-<?php echo $seller['User']['name'];?></li>
            <?php } ?>
        </ul>

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

        const inputFieldClient = document.getElementById("clientSale");
        const clearButtonClients = document.getElementById("clear-buttonClient");

        const searchInputClients = document.getElementById("clientSale");
        const dropdownListClients = document.getElementById("clientsSale");

        inputFieldClient.addEventListener("input", function () {
            if (inputFieldClient.value.trim() !== "") {
                clearButtonClients.classList.remove("hidden");
            } else {
                clearButtonClients.classList.add("hidden");
            }
        });

        clearButtonClients.addEventListener("click", function () {
            inputFieldClient.value = "";
            clearButtonClients.classList.add("hidden");
            $('#clientSale').removeAttr('readonly');
            dropdownListClients.classList.add("hidden");
            $('#clientsSale').removeAttr('style');
            $('#clientSale').focus();
        });


        function selectClientSale(client){
          $('#clientSale').val(client);
          $('#clientsSale').hide();
          $('#clientSale').attr('readonly','readonly');
          
        }
        
        

        searchInputClients.addEventListener("input", function () {
            const filterClients = searchInputClients.value.toLowerCase();
            const optionsClients = dropdownListClients.getElementsByTagName("li");

            for (let i = 0; i < optionsClients.length; i++) {
                const optionC = optionsClients[i];
                if (optionC.textContent.toLowerCase().includes(filterClients)) {
                  optionC.style.display = "block";
                } else {
                  optionC.style.display = "none";
                }
            }

            if (filterClients === "") {
                dropdownListClients.classList.add("hidden");
            } else {
                dropdownListClients.classList.remove("hidden");
            }
        });


        /******Products****** */

        const inputFieldProducts = document.getElementById("productSales");
        const clearButtonProducts = document.getElementById("clear-buttonProducts");

        const searchInputProducts = document.getElementById("productSales");
        const dropdownListProducts = document.getElementById("productOptionSales");

        inputFieldProducts.addEventListener("input", function () {
            if (inputFieldProducts.value.trim() !== "") {
                clearButtonProducts.classList.remove("hidden");
            } else {
                clearButtonProducts.classList.add("hidden");
            }
        });

        clearButtonProducts.addEventListener("click", function () {
            inputFieldProducts.value = "";
            clearButtonProducts.classList.add("hidden");
            $('#productSales').removeAttr('readonly');
            dropdownListProducts.classList.add("hidden");
            $('#productOptionSales').removeAttr('style');
            $('#productSales').focus();
        });


        function selectProductSale(client){
          $('#productSales').val(client);
          $('#productOptionSales').hide();
          searchQuantity();
          $('#productSales').attr('readonly','readonly');
          
        }
        
        

        searchInputProducts.addEventListener("input", function () {
            const filterProducts = searchInputProducts.value.toLowerCase();
            const optionsProducts = dropdownListProducts.getElementsByTagName("li");

            for (let i = 0; i < optionsProducts.length; i++) {
                const option = optionsProducts[i];
                if (option.textContent.toLowerCase().includes(filterProducts)) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none";
                }
            }

            if (filterProducts === "") {
                dropdownListProducts.classList.add("hidden");
            } else {
                dropdownListProducts.classList.remove("hidden");
            }
        });

        /**Barbers**** */
        const inputFieldSeller = document.getElementById("seller");
        const clearButtonSeller = document.getElementById("clear-buttonSeller");

        const searchInputSeller = document.getElementById("seller");
        const dropdownListSeller = document.getElementById("sellerOptionSales");

        inputFieldSeller.addEventListener("input", function () {
            if (inputFieldSeller.value.trim() !== "") {
                clearButtonSeller.classList.remove("hidden");
            } else {
                clearButtonSeller.classList.add("hidden");
            }
        });

        clearButtonSeller.addEventListener("click", function () {
            inputFieldSeller.value = "";
            clearButtonSeller.classList.add("hidden");
            $('#seller').removeAttr('readonly');
            dropdownListSeller.classList.add("hidden");
            $('#sellerOptionSales').removeAttr('style');
            $('#seller').focus();
        });


        function selectSellerSale(client){
          $('#seller').val(client);
          $('#sellerOptionSales').hide();
          $('#seller').attr('readonly','readonly');
          
        }
        
        

        searchInputSeller.addEventListener("input", function () {
            const filterSeller = searchInputSeller.value.toLowerCase();
            const optionsSeller = dropdownListSeller.getElementsByTagName("li");

            for (let i = 0; i < optionsSeller.length; i++) {
                const optionSell = optionsSeller[i];
                if (optionSell.textContent.toLowerCase().includes(filterSeller)) {
                  optionSell.style.display = "block";
                } else {
                  optionSell.style.display = "none";
                }
            }

            if (filterSeller === "") {
                dropdownListSeller.classList.add("hidden");
            } else {
                dropdownListSeller.classList.remove("hidden");
            }
        });

     


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