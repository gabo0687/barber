<section class="event-detail">
    <article id="profile">
        <h2>Inventario</h2>
        <ul class="nav nav-pills text-end">
            <?php if ($user['User']['type'] == '1') { ?>
                <li class="nav-item"><a class="nav-link fa fa-calendar" aria-hidden="true" id="calendar" href="calendar" type="button"> Calendario</a></li>
                <li class="nav-item"><a class="nav-link fa fa-scissors" aria-hidden="true" id="calendar" href="services" type="button"> Servicios</a></li>
                <li class="nav-item"><a class="nav-link fa fa-id-card" aria-hidden="true" id="calendar" href="users" type="button"> Usuarios</a></li>
                <li class="nav-item"><a class="nav-link fa fa-users" aria-hidden="true" id="calendar" href="customers" type="button"> Clientes</a></li>
                <li class="nav-item"><a class="nav-link fa fa-product-hunt" aria-hidden="true" id="calendar" href="products" type="button"> Productos</a></li>
                <li class="nav-item"><a class="nav-link fa fa-clock-o" aria-hidden="true" id="calendar" href="work" type="button"> Horas de trabajo</a></li>
                <li class="nav-item"><a class="nav-link fa fa-book" aria-hidden="true" id="calendar" href="expenses" type="button"> Gastos</a></li>
                <li class="nav-item"><a class="nav-link fa fa-line-chart" aria-hidden="true" id="calendar" href="sales" type="button"> Ventas</a></li>
                <li class="nav-item"><a class="nav-link fa fa-usd" aria-hidden="true" id="calendar" href="product_sales" type="button"> Reporte Productos</a></li>
                <li class="nav-item"><a class="nav-link fa fa-money" aria-hidden="true" id="calendar" href="expenses_sales" type="button"> Reporte Gastos</a></li>
            <?php } ?>
        </ul>
        </br>
        <div class="form-group text-left">
            <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar Gasto</button>
            <button type="button" onclick="showEditForm()" class="btn btn-primary">Editar Gastos</button>
        </div>
        <div style="display:none;" id="userUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Usuario actualizado! </h4>
            <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
            <hr>
        </div>
        <form method="post" id="searchProductEdit" style="display:none;" class="col-sm-6 offset-sm-3">
            <div class="form-group text-left">
                <label for="accountInputUser">Buscar gasto</label>
                <input type="text" class="form-control" id="searchProduct" name="searchProduct" aria-describedby="emailHelp" placeholder="Nombre/telefono">
            </div>
            <div class="form-group text-left">
                <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-profile-tab">
                <form action="add_expenses" method="post" id="createNewProduct" class="col-sm-6 offset-sm-3">
                    <h4 class="offset-sm-3">Agregar Gastos</h4>
                    <div class="form-group">
                        <label for="accountInputUser">Nombre del gasto</label>
                        <input type="text" class="form-control" id="nameAdd" name="nameAdd" aria-describedby="emailHelp" placeholder="Nombre">
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
                    <div class="form-group" id="error-empty" style="display:none;">
                        <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
                    </div>
                    <div style="display:none;" id="productCreated" class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Gasto creado! </h4>
                        <p><img src="img/icon-success.png" height="20px" width="20px" /></p>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="list-group" style="display:none;" id="productList" role="tablist">
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="home_edit" style="display:none;" role="tabpanel" aria-labelledby="nav-profile-tab">
                <form action="update_expenses" method="post" id="editProduct" class="col-sm-6 offset-sm-3">
                    <h4 class="offset-sm-3">Editar gastos</h4>
                    <div class="form-group" style="display:none;">
                        <label for="accountInputUser">id</label>
                        <input type="text" class="form-control" id="idEdit" name="idEdit" aria-describedby="emailHelp" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="accountInputUser">Nombre del gasto</label>
                        <input type="text" class="form-control" id="nameEdit" name="nameEdit" aria-describedby="emailHelp" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="accountInputEmail">Precio</label>
                        <input type="number" class="form-control" id="priceEdit" name="priceEdit" aria-describedby="emailHelp" placeholder="Precio">
                    </div>
                    <div class="form-group">
                        <label for="accountInputUser">Pago</label>
                        <select name="payEdit" id="payEdit" class="form-control">
                            <option value="2">Efectivo</option>
                            <option value="1">Tarjeta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="accountInputEmail">Fecha del gasto</label>
                        <input type="date" class="form-control" id="dateEdit" name="dateEdit" aria-describedby="emailHelp" placeholder="Precio">
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
        $('#priceEdit').val('');
        $('#home_edit').hide();


    }

    $("#createNewProduct").on("submit", function(event) {
        var nombre = $('#nameAdd').val();
        var precio = $('#priceAdd').val();

        if (nombre == '' || precio == '') {
            event.preventDefault();
            $showError = false;
            if (nombre == '') {
                $('#nameAdd').css('border', '2px solid red');
                $showError = true;
            } else {
                $('#nameAdd').css('border', '');
            }
            if (precio == '') {
                $showError = true;
                $('#priceAdd').css('border', '2px solid red');
            } else {
                $('#priceAdd').css('border', '');
            }

            if ($showError) {
                $('#error-empty').show();
            } else {
                $('#error-empty').hide();
            }
        } else {
            $('#error-empty').hide();
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

        if (nombre == '' || price == '') {
            event.preventDefault();
            $showError = false;
            if (nombre == '') {
                $('#nameEdit').css('border', '2px solid red');
                $showError = true;
            } else {
                $('#nameEdit').css('border', '');
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
            window.scrollTo(0, 0);
            $('#error-emptyEdit').hide();
            $('.close').click();
            $('#userUpdated').show();
            setInterval(function() {
                $('#userUpdated').hide('2000');
            }, 2000);
        }
    });


    function showEditProduct(id) {
        $('.list-group-item').removeClass('active');
        $('#edit_' + id).addClass('active');
        $('#home_edit').show();
        $.ajax({
            type: 'POST',
            url: 'edit_expenses',
            data: 'idProduct=' + id,
            beforeSend: function() {

            },
            error: function() {

                alert('No hay internet');
            },
            success: function(prod) {
                const res = JSON.parse(prod);
                $('#idEdit').val(res["Expense"]["id"]);
                $('#nameEdit').val(res["Expense"]["expense_title"]);
                $('#priceEdit').val(res["Expense"]["expense_price"]);
                $('#payEdit').val(res["Expense"]["payment_type"]);
                $('#dateEdit').val(res["Expense"]["date_creation"]);


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
            url: 'search_expenses',
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
                    idProducts = entry[1].Expense.id;
                    nombreProducts = entry[1].Expense.expense_title + " | " + entry[1].Expense.date_creation;
                    boton += ' <a class="list-group-item list-group-item-action" id="edit_' + idProducts + '" data-toggle="list" onclick="showEditProduct(' + idProducts + ')" role="tab" style="color:black;">' + nombreProducts + '</a>';

                    i++;
                });
                $('#productList').html(boton);

            }
        });
    }
</script>