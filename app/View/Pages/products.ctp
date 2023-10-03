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
    
    
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
        <form action="add_product" method="post" id="createNewProduct" class="col-sm-6 offset-sm-3"  enctype="multipart/form-data">
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
            
          <span onclick="scanearCodigo()" id="botonScan" class="btn btn-secondary">Scanear Código de Barras</span></br></br>
            <label for="accountInputEmail">Codigo de Barras</label>
            <div id="qr-reader" style="display:none;" class="form-control"></div>
            </br>
            <input type="text" class="form-control" name="codigo_barra_text" id="codigo_barra_text" placeholder="Código de barras" readonly>
            <input type="hidden" class="form-control" name="codigo_barra" id="codigo_barra">
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
          <div class="form-group" id="error-codigo" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>El Código de Barras ya está ingresado, vaya a editar producto.</b></span></label>
          </div>
          <div class="form-group" id="error-passChar" style="display:none;">
            <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>La contraseña debe ser mayor a 7 caracteres y tener al menos 1 letra en Mayúscula.</b></span></label>
          </div>
          
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Guardar producto</button>
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

      checkBarCode(decodedText);

      
     
}

function checkBarCode(barcode){
  $.ajax({
      type: 'POST',
      url: 'check_barcode',
      data: 'barcode=' + barcode,
      beforeSend: function() {

      },
      error: function() {

        alert('No hay internet');
      },
      success: function(barcodeResponse) {
       if( barcodeResponse ){
        $('#codigo_barra').val('');
        $('#codigo_barra_text').val('');
        $('#error-codigo').show();
        window.scrollTo(0, document.body.scrollHeight);
       }else{
        $('#error-codigo').hide();
        $('#countAdd').focus();
        html5QrcodeScanner.clear();
        $('#qr-reader').hide();
       }


      }

    });
}


</script>


<script>

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

 
</script>
