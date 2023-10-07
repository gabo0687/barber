<script src="https://unpkg.com/html5-qrcode"></script>
<style>

    #clientSaleEdit {
        width: 100%;
        padding: 10px;
        
    }

    #clientsSaleEdit {
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

    #clientsSaleEdit li {
        padding: 10px;
        cursor: pointer;
    }

    #clientsSaleEdit li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonClientEdit {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}

    /* Products */
    #productSalesEdit {
        width: 100%;
        padding: 10px;
        
    }

    #productOptionSalesEdit {
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

    #productOptionSalesEdit li {
        padding: 10px;
        cursor: pointer;
    }

    #productOptionSalesEdit li:hover {
        background-color: #f0f0f0;
    }

    #clear-buttonProductsEdit {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}

    /* Seller */
    #sellerEdit {
        width: 100%;
        padding: 10px;
        
    }

    #sellerOptionSalesEdit {
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

    #sellerOptionSalesEdit li {
        padding: 10px;
        cursor: pointer;
    }

    #sellerOptionSalesEdit li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonSellerEdit {
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

      
    #clientSaleEdit {
        width: 100%;
        padding: 10px;
        
    }
      #clientsSaleEdit {
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
  

#clientsSaleEdit li {
    padding: 10px;
    cursor: pointer;
}

#clientsSaleEdit li:hover {
    background-color: #f0f0f0;
}
#clear-buttonClientEdit {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}
/*Responsive Product */

#productSalesEdit {
        width: 100%;
        padding: 10px;
        
    }

    #productOptionSalesEdit {
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

    #productOptionSalesEdit li {
        padding: 10px;
        cursor: pointer;
    }

    #productOptionSalesEdit li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonProductsEdit {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}
/*Responsive Seller */

#sellerEdit {
        width: 100%;
        padding: 10px;
        
    }

    #sellerOptionSalesEdit {
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

    #sellerOptionSalesEdit li {
        padding: 10px;
        cursor: pointer;
    }

    #sellerOptionSalesEdit li:hover {
        background-color: #f0f0f0;
    }
    #clear-buttonSellerEdit {
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
                            </br>
                            <span class="description">Producto:</span>

                            <div class="input-container">
          <input type="text" id="productSalesEdit" name="productSalesEdit" class="form-control" disabled>
        </div>
 
       
                            <span class="description">Cliente:</span>


                            <div class="input-container">
          <input type="text" id="clientSaleEdit" name="clientSaleEdit" class="form-control" placeholder="Escribe el nombre del cliente" readonly>
          <span id="clear-buttonClientEdit" class="">×</span>
        </div>

        <ul id="clientsSaleEdit" class="hidden">
        <?php foreach( $clients as $client ){
          $clientSelectedSale = "'".$client['User']['id'].'-'.$client['User']['name'].' | '.$client['User']['phone']."'";
           ?>
            <li style="color:black" onclick="selectClientSaleEdit(<?php echo $clientSelectedSale;?>)"><?php echo $client['User']['id'];?>-<?php echo $client['User']['name'];?> | <?php echo $client['User']['phone'];?></li>
            <?php } ?>
        </ul>
                           

                            </br>
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
                                    name="priceDiscountEdit" onkeyup="calculatePrice()" aria-describedby="emailHelp"
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

                            <div class="input-container">
                    <input type="text" id="sellerEdit" name="sellerEdit" class="form-control" placeholder="Escribe el nombre del vendedor">
                    <span id="clear-buttonSellerEdit" class="hidden">×</span>
                    </div>

                    <ul id="sellerOptionSalesEdit" class="hidden">
                    <?php foreach( $sellers as $seller ){
                    $SelectedSeller = "'".$seller['User']['id'].'-'.$seller['User']['name']."'";
                    ?>
                        <li style="color:black" onclick="selectSellerSaleEdit(<?php echo $SelectedSeller;?>)"><?php echo $seller['User']['id'];?>-<?php echo $seller['User']['name'];?></li>
                        <?php } ?>
                    </ul>

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

<script>

const inputFieldClientEdit = document.getElementById("clientSaleEdit");
        const clearButtonClientsEdit = document.getElementById("clear-buttonClientEdit");

        const searchInputClientsEdit = document.getElementById("clientSaleEdit");
        const dropdownListClientsEdit = document.getElementById("clientsSaleEdit");

        inputFieldClientEdit.addEventListener("input", function () {
            if (inputFieldClientEdit.value.trim() !== "") {
                clearButtonClientsEdit.classList.remove("hidden");
            } else {
                clearButtonClientsEdit.classList.add("hidden");
            }
        });

        clearButtonClientsEdit.addEventListener("click", function () {
            inputFieldClientEdit.value = "";
            clearButtonClientsEdit.classList.add("hidden");
            $('#clientSaleEdit').removeAttr('readonly');
            dropdownListClientsEdit.classList.add("hidden");
            $('#clientsSaleEdit').removeAttr('style');
            $('#clientSaleEdit').focus();
        });


        function selectClientSaleEdit(client){
          $('#clientSaleEdit').val(client);
          $('#clientsSaleEdit').hide();
          $('#clientSaleEdit').attr('readonly','readonly');
          
        }
        
        

        searchInputClientsEdit.addEventListener("input", function () {
            const filterClientsEdit = searchInputClientsEdit.value.toLowerCase();
            const optionsClientsEdit = dropdownListClientsEdit.getElementsByTagName("li");

            for (let i = 0; i < optionsClientsEdit.length; i++) {
                const optionCEdit = optionsClientsEdit[i];
                if (optionCEdit.textContent.toLowerCase().includes(filterClientsEdit)) {
                  optionCEdit.style.display = "block";
                } else {
                  optionCEdit.style.display = "none";
                }
            }

            if (filterClientsEdit === "") {
                dropdownListClientsEdit.classList.add("hidden");
            } else {
                dropdownListClientsEdit.classList.remove("hidden");
            }
        });


        /******Products****** */

        
        

        /**Barbers**** */
        const inputFieldSellerEdit = document.getElementById("sellerEdit");
        const clearButtonSellerEdit = document.getElementById("clear-buttonSellerEdit");

        const searchInputSellerEdit = document.getElementById("sellerEdit");
        const dropdownListSellerEdit = document.getElementById("sellerOptionSalesEdit");

        inputFieldSellerEdit.addEventListener("input", function () {
            if (inputFieldSellerEdit.value.trim() !== "") {
                clearButtonSellerEdit.classList.remove("hidden");
            } else {
                clearButtonSellerEdit.classList.add("hidden");
            }
        });

        clearButtonSellerEdit.addEventListener("click", function () {
            inputFieldSellerEdit.value = "";
            clearButtonSellerEdit.classList.add("hidden");
            $('#sellerEdit').removeAttr('readonly');
            dropdownListSellerEdit.classList.add("hidden");
            $('#sellerOptionSalesEdit').removeAttr('style');
            $('#sellerEdit').focus();
        });


        function selectSellerSaleEdit(client){
          $('#sellerEdit').val(client);
          $('#sellerOptionSalesEdit').hide();
          $('#sellerEdit').attr('readonly','readonly');
          
        }
        
        

        searchInputSellerEdit.addEventListener("input", function () {
            const filterSellerEdit = searchInputSellerEdit.value.toLowerCase();
            const optionsSellerEdit = dropdownListSellerEdit.getElementsByTagName("li");

            for (let i = 0; i < optionsSellerEdit.length; i++) {
                const optionSellEdit = optionsSellerEdit[i];
                if (optionSellEdit.textContent.toLowerCase().includes(filterSellerEdit)) {
                  optionSellEdit.style.display = "block";
                } else {
                  optionSellEdit.style.display = "none";
                }
            }

            if (filterSellerEdit === "") {
                dropdownListSellerEdit.classList.add("hidden");
            } else {
                dropdownListSellerEdit.classList.remove("hidden");
            }
        });


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

            var productName = res["Product"]["id"] + "-" + res["Product"]["name"] + " / " + res["Product"]["provider"] + " | " + res["Saleproduct"]["price"];
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
               productPrice = res["Saleproduct"]["price"];
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
            window.scrollTo(0, document.body.scrollHeight);
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