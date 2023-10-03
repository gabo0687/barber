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
        <form method="post" id="searchSaleEdit" class="col-sm-6 offset-sm-3">
            <div class="form-group text-left">
                <label for="accountInputUser">Buscar Venta</label>
                <input type="date" class="form-control" id="searchSale" name="searchSale" aria-describedby="emailHelp"
                    placeholder="Fecha">
            </div>
            <div class="form-group text-left">
                <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">

                <div class="list-group" style="display:none;" id="saleListEdit" role="tablist">
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="home_editSales" style="display:none;" role="tabpanel"
                        aria-labelledby="nav-profile-tab">
                        <form action="update_sales" method="post" id="editSales" class="col-sm-6 offset-sm-3">
                            <div class="form-group" style="display:none;">
                                <label for="accountInputEmail">idSale</label>
                                <input type="number" class="form-control" id="idSaleEdit" name="idSaleEdit"
                                    aria-describedby="emailHelp" placeholder="Precio">
                                    <input type="number" class="form-control" id="idSaleProductEdit" name="idSaleProductEdit"
                                    aria-describedby="emailHelp" placeholder="Precio">
                                    <input type="number" class="form-control" id="idSaleCantEdit" name="idSaleCantEdit"
                                    aria-describedby="emailHelp" placeholder="Precio">
                            </div>
                            <h4 class="offset-sm-3">Editar Venta</h4>
                            <span class="description">Cliente:</span>
                            <span class="tax">

                                <input type="search" list="clientsSaleEdit" class="form-control" id="clientSaleEdit"
                                    name="clientSaleEdit" placeholder="Escribe el nombre del cliente">

                                <datalist id="clientsSaleEdit">
                                    <?php foreach ($clients as $client) { ?>
                                    <option
                                        value="<?php echo $client['User']['id']; ?>-<?php echo $client['User']['name']; ?> | <?php echo $client['User']['phone']; ?>">
                                        <?php } ?>
                                </datalist>
                            </span>
                            </br>
                            <div class="form-group text-left">
                                <label for="accountInputUser">Buscar Producto:</label></br></br>
                                <input type="radio" id="search_nombreSaleEdit" value="1"
                                    onclick="searchOption(this.value)" name="search_productoEdit" checked>Por nombre
                                <input type="radio" id="search_codeSaleEdit" value="2"
                                    onclick="searchOption(this.value)" name="search_productoEdit">Por código de barras
                                </br></br>
                            </div>
                            <span class="tax">

                                <input type="search" list="products-salesEdit" onchange="searchQuantity()"
                                    class="form-control" id="productSalesEdit" name="productSalesEdit"
                                    placeholder="Escribe el nombre del producto">

                                <datalist id="products-salesEdit">

                                    <?php foreach ($products as $product) { ?>
                                    <option id="productOptionSalesEdit" name="productOptionSalesEdit"
                                        value="<?php echo $product['Product']['id']; ?>-<?php echo $product['Product']['name']; ?> / <?php echo $product['Product']['provider']; ?> | ₡<?php echo $product['Product']['price']; ?>">
                                        <?php } ?>
                                </datalist>
                            </span>
                            </br>
                            <div class="form-group" id="scanSaleEdit" name="scanSaleEdit" style="display:none;">
                                <span onclick="scanearCodigo()" id="botonScanEdit" class="btn btn-secondary">Scanear
                                    Código de Barras</span></br></br>
                                <div id="qr-readerEdit" style="display:none;" class="form-control"></div>
                                </br>
                                <input type="hidden" class="form-control" name="codigo_barra_textEdit"
                                    id="codigo_barra_textEdit" placeholder="Código de barras" readonly>
                                <input type="hidden" class="form-control" name="codigo_barraEdit" id="codigo_barraEdit">
                            </div>
                            <div class="form-group" style="display:none;">
                                <input type="hidden" id="countAddAvaiableProductEdit" name="countAddAvaiableProductEdit"
                                    value="0">
                            </div>
                            <div class="form-group">
                                <label for="accountInputUser">Cantidad</label>
                                <select name="MaxCountAddEdit" id="MaxCountAddEdit" class="form-control"
                                    onchange="calculatePrice()">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="accountInputEmail">Descuento %</label>
                                <input type="number" class="form-control" id="priceDiscountEdit"
                                    name="priceDiscountEdit" onchange="calculatePrice()" aria-describedby="emailHelp"
                                    placeholder="Porcentaje de descuento">
                            </div>
                            <div class="form-group">
                                <label for="accountInputEmail">Precio</label>
                                <input type="number" class="form-control" id="priceAddSaleEdit" name="priceAddSaleEdit"
                                    aria-describedby="emailHelp" placeholder="Precio" disabled>
                            </div>
                            <div class="form-group" style="display:none;">
                                <label for="accountInputEmail">Precio</label>
                                <input type="number" class="form-control" id="originalPriceAddSaleEdit"
                                    name="originalPriceAddSaleEdit" aria-describedby="emailHelp" placeholder="Precio">
                            </div>
                            <div class="form-group">
                                <label for="accountInputUser">Pago</label>
                                <select name="payAddSaleEdit" id="payAddSaleEdit" class="form-control">
                                    <option value="2">Efectivo</option>
                                    <option value="1">Tarjeta</option>
                                </select>
                            </div>
                            <span class="description">Vendedor:</span>
                            <span class="tax">

                                <input type="search" list="sellersEdit" class="form-control" id="sellerEdit"
                                    name="sellerEdit" placeholder="Escribe el nombre del vendedor">

                                <datalist id="sellersEdit">
                                    <?php foreach ($sellers as $seller) { ?>
                                    <option id="sellerOptionSalesEdit" name="sellerOptionSalesEdit"
                                        value="<?php echo $seller['User']['id']; ?>-<?php echo $seller['User']['name']; ?>">
                                        <?php } ?>
                                </datalist>
                            </span>
                            </br>
                            <div class="form-group">
                                <label for="accountInputEmail">Fecha</label>
                                <input type="date" class="form-control" id="dateAddSaleEdit" name="dateAddSaleEdit"
                                    aria-describedby="emailHelp" placeholder="Fecha">
                            </div>
                            <div class="form-group">
                                <label for="accountInputEmail">Notas</label>
                                <input type="text" class="form-control" id="notesAddSaleEdit" name="notesAddSaleEdit"
                                    aria-describedby="emailHelp" placeholder="Notas">
                            </div>
                            <div class="form-group" id="error-quantitySalesEdit" style="display:none;">
                                <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span
                                        id="errorPassText"><b>No hay cantidades disponibles.</b></span></label>
                            </div>
                            <div class="form-group" id="error-emptySalesEdit" style="display:none;">
                                <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span
                                        id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
                            </div>
                            <div class="form-group text-right">
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
var lastResult, countResults = 0;
let html5QrcodeScanner = 0;

function scanearCodigo() {
    $('#qr-readerEdit').show();
    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-readerEdit", {
            fps: 10,
            qrbox: 250
        });
    html5QrcodeScanner.render(onScanSuccess);
    $('#html5-qrcode-anchor-scan-type-change').hide();
}

function onScanSuccess(decodedText, decodedResult) {

    ++countResults;
    lastResult = decodedText;
    // Handle on success condition with the decoded message.
    $('#codigo_barraEdit').val(decodedText);
    $('#codigo_barra_textEdit').val(decodedText);


    var audio = document.getElementById("audio");
    audio.play();
    getBarCodeInfo(decodedText);

}


function getBarCodeInfo(barCode) {
    $.ajax({
        type: 'POST',
        url: 'searchProduct_barcode',
        data: 'barcode=' + barCode,
        beforeSend: function() {

        },
        error: function() {

            alert('No hay internet');
        },
        success: function(barcode) {
        if(barcode == '[]'){
          alert("prducto no registrado");
          $('#MaxCountAddEdit').focus();
        html5QrcodeScanner.clear();
        $('#qr-readerEdit').hide();
        }else{
          const res = JSON.parse(barcode);
        $('#priceAddSaleEdit').val(res[0]["Product"]["price"]);
        var productName = res[0]["Product"]["id"]+"-"+res[0]["Product"]["name"]+" / "+res[0]["Product"]["provider"]+" | "+res[0]["Product"]["price"];
        $('#productSalesEdit').val(productName);
        html5QrcodeScanner.clear();
        searchQuantity();
        $('#qr-readerEdit').hide();
          $('#codigo_barraEdit').val('');
         $('#codigo_barra_textEdit').val('');
        $('#error-codigoEdit').show();
        window.scrollTo(0, document.body.scrollHeight);
        }
        window.scrollTo(0, document.body.scrollHeight);

      }

    });
}
</script>
<script>
let html5QrcodeScannerSearch = 0;

function searchOption(valor) {

    if (valor == 2) {
        $('#scanSaleEdit').show();
        $('#productSalesEdit').hide();
        window.scrollTo(0, document.body.scrollHeight);
    }
    if (valor == 1) {
        $('#productSalesEdit').show();
        $('#scanSaleEdit').hide();
    }

}

var cantProductos = 0;
var productPrice = 0;
var editCantProducto = 0;
var editCantProductoId = "A";
var cantProductosComprados = 0;
var globalDiscount = 0;
var globalPrice = 0;
$('#searchSaleEdit').on('submit', function(e) {
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
    $('#home_editSales').hide();
    $('#saleListEdit').hide();
    $('#searchSaleEdit').hide();

}

function showEditForm() {
    $('#saleListEdit').html('');
    $('#searchSale').val('');
    $('#editSales').hide();
    $('#createNewSale').hide();
    $('#home_list').show();
    $('#saleListEdit').show();
    $('#searchSaleEdit').show();
    $('#idEdit').val('');
    $('#nameEdit').val('');
    $('#countEdit').val('');
    $('#priceEdit').val('');
    $('#sellerEdit').val('');
    $('#home_editSales').hide();


}



function calculatePrice() {
    $('#priceAddSaleEdit').val('');
    var descuento = "";
    var descuento = $('#priceDiscountEdit').val();
    var cant = $('#MaxCountAddEdit').val();
    var newPrice = (productPrice * cant) - (((productPrice * cant) * (descuento / 100)));
    $('#originalPriceAddSaleEdit').val(productPrice);
    $('#priceAddSaleEdit').val(newPrice);
}

function searchQuantity() {
    var product = 0;
    product = $('#productSalesEdit').val();
        var splitProduct = product.split('-');
    
//comparar si el id del producto es el mismo que el de el edit
if(editCantProductoId == splitProduct[0]){
    $('#MaxCountAddEdit').empty();
                    var k = 0;
                        while (k < editCantProducto) {
                            k++;
                            $('#MaxCountAddEdit').append('<option onfocus="calculatePrice()" >' + k +
                                '</option>');

                        }
                        
                        $('#priceDiscountEdit').val(globalDiscount);
                        productPrice = globalPrice;
                        
                        $("#MaxCountAddEdit").val(cantProductosComprados).change();
                       
     
}else {

    var prod = 0;
    prod = $('#productSalesEdit').val();
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
                    $('#MaxCountAddEdit').empty();
                    var i = 0;
                    if (cantProductos > 0) {
                        while (i < cantProductos) {
                            i++;
                            $('#MaxCountAddEdit').append('<option onfocus="calculatePrice()" >' + i +
                                '</option>');

                        }
                        $('#priceDiscountEdit').val(0);
                        $('#countAddAvailableEdit').val(cantProductos);

                        $('#countAddAvaiableProductEdit').val(cantProductos);

                        $('#priceAddSaleEdit').val(price);
                        $('#originalPriceAddSaleEdit').val(price);
                        $('#MaxCountAddEdit').css('border', '');
                        $('#error-quantitySalesEdit').hide;
                        productPrice = price;
                    } else {
                        $('#MaxCountAddEdit').append('<option onfocus="calculatePrice()" >0</option>');
                        $('#error-quantitySalesEdit').show;

                        $('#MaxCountAddEdit').css('border', '2px solid red');
                        alert('Producto agotado en inventario');
                        $('#countAddAvailableEdit').val(0);
                        $('#countAddAvaiableProductEdit').val(0);
                    }

                }


            }

        });
    } else {
        cantProductos = "";
        $('#countAddAvailableEdit').val(cantProductos);
    }
}
}


function search() {
    var date = "";
    if ($('#searchSaleEdit').val() == '') {
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    } else {
        date = $('#searchSaleEdit').val();
    }
    $('#createNewSaleEdit').hide();
    $('#home_listEdit').show();
    $('#saleListEdit').show();
    $('#editSalesEdit').show();
    $('#home_editSalesEdit').hide();

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
            let list = document.getElementById("saleListEdit");
            var boton = '';
            Object.entries(res).forEach((entry) => {
                idSale = entry[1].Sale.id;
                nombreSales = idSale + "- Cliente: " + entry[1].User.name + " / Producto: " + entry[
                    1].Product.name;
                boton += ' <a class="list-group-item list-group-item-action" id="editSale_' +
                    idSale + '" data-toggle="list" onclick="showEditSales(' + idSale +
                    ')" role="tab" style="color:black;">' + nombreSales + '</a>';

                i++;
            });
            $('#saleListEdit').html(boton);

        }
    });
}


function showEditSales(id) {
    $('.list-group-item').removeClass('active');
    $('#editSale_' + id).addClass('active');
    $('#home_editSales').show();


    $.ajax({
        type: 'POST',
        url: 'edit_sales',
        data: 'idSale=' + id,
        beforeSend: function() {

        },
        error: function() {

            alert('No hay internet');
        },
        success: function(editSale) {
            const res = JSON.parse(editSale);
                editCantProducto = "";
               editCantProductoId = "";
               cantProductosComprados = 0;
            $('#idSaleEdit').val(res["Sale"]["id"]);
            $('#idSaleProductEdit').val(res["Saleproduct"]["id"]);
            
            $('#countAddAvaiableProductEdit').val(res["Product"]["quantity"]);
            $('#payAddSaleEdit').val(res["Saleproduct"]["payment_type"]);
            $('#notesAddSaleEdit').val(res["Saleproduct"]["notes"]);
            globalDiscount = (res["Saleproduct"]["discount"]) * 100;
            $('#priceDiscountEdit').val(globalDiscount);
            $('#dateAddSaleEdit').val(res["Saleproduct"]["sale_date"]);

            var productName = res["Product"]["id"] + "-" + res["Product"]["name"] + " / " + res["Product"]["provider"] + " | " + res["Product"]["price"];
            $('#productSalesEdit').val(productName);
            var clientName = res["User"]["id"] + "-" + res["User"]["name"] + " | " + res["User"]["phone"];
            $('#clientSaleEdit').val(clientName);
            var sellerName = res["Seller"]["id"] + "-" + res["Seller"]["name"];
            $('#sellerEdit').val(sellerName);

            var cantProductosInventario = res['Product']['quantity'];
             cantProductosComprados = res['Saleproduct']['quantity'];
            var cantProductosEdit = cantProductosInventario + cantProductosComprados;
            $('#idSaleCantEdit').val(cantProductosEdit);
            $('#MaxCountAddEdit').empty();
            var i = 0;
            if (cantProductosEdit > 0) {
                while (i < cantProductosEdit) {
                    i++;
                    $('#MaxCountAddEdit').append('<option onfocus="calculatePrice()" >' + i + '</option>');
                }
               $("#MaxCountAddEdit").val(cantProductosComprados).change();
               productPrice = 0;
               productPrice = res["Product"]["price"];
               globalPrice = productPrice;
               editCantProducto = cantProductosEdit;
               editCantProductoId = res["Product"]["id"] ;
               calculatePrice();
               //validar que si cambia de producto, y vuelve al mismo, mantener mismo stock

                $('#error-quantitySalesEdit').hide;
            } else {
                $('#MaxCountAddEdit').append('<option onfocus="calculatePrice()" >0</option>');
                $('#error-quantitySalesEdit').show;

                $('#MaxCountAddEdit').css('border', '2px solid red');
                alert('Producto agotado en inventario');
                $('#countAddAvailableEdit').val(0);
                $('#countAddAvaiableProductEdit').val(0);
            } 

        }

    });
}

$("#editSales").on("submit", function(event) {
    var client = 0;
    var clientEmpty = true;
    var clientFormat = true;
    client = $('#clientSaleEdit').val();
    var splitClient = client.split('-');

    if ($('#clientSaleEdit').val() == '') {
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
    product = $('#productSalesEdit').val();
    var splitProduct = product.split('-');

    if ($('#productSalesEdit').val() == '') {
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
    seller = $('#sellerEdit').val();
    var splitSeller = seller.split('-');

    if ($('#sellerEdit').val() == '') {
        sellerEmpty = false;
    } else {
        var splitSeller = seller.split('-');
    }
    if (splitSeller.length < 2) {
        sellerFormat = false;
    }

    inventory = $('#MaxCountAddEdit').val();

    if (!clientEmpty && !clientFormat || !productEmpty && !productFormat || !sellerEmpty && !sellerFormat || inventory == 0) {
        event.preventDefault();
        $showError = false;
        if (!clientEmpty && !clientFormat) {
            $('#clientSaleEdit').css('border', '2px solid red');
            $showError = true;
        } else {
            $('#clientSaleEdit').css('border', '');
        }
        if (!productEmpty && !productFormat) {
            $('#productSalesEdit').css('border', '2px solid red');
            $showError = true;
        } else {
            $('#productSalesEdit').css('border', '');
        }
        if (!sellerEmpty && !sellerFormat) {
            $('#sellerEdit').css('border', '2px solid red');
            $showError = true;
        } else {
            $('#sellerEdit').css('border', '');
        }
        if (inventory == 0) {
            $('#MaxCountAddEdit').css('border', '2px solid red');
            $('#error-quantitySalesEdit').show;
        } else {
            $('#MaxCountAddEdit').css('border', '');
            $('#error-quantitySalesEdit').hide;
        }

        if ($showError) {
            $('#error-emptySalesEdit').show();
        } else {
            $('#error-emptySalesEdit').hide();
        }
    } else {
        $('#error-emptySalesEdit').hide();
        $('#error-quantitySalesEdit').hide;
        $('#clientSaleEdit').css('border', '');
        $('#productSalesEdit').css('border', '');
        $('#sellerEdit').css('border', '');
        window.scrollTo(0, 0);
        $('.close').click();
        $('#saleDone').show();
        setInterval(function() {
            $('#saleDone').hide('2000');
        }, 2000);
    }
});
</script>