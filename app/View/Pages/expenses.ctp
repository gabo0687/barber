<section class="event-detail">productCreated
    <article id="profile">
        <h2>Inventario</h2>
        <ul class="nav nav-pills text-end">
        <?php  echo $this->element('menu');?>
        </ul>
        </br>
        <div class="form-group text-left">
            <button type="button" onclick="showAddForm()" class="btn btn-primary">Agregar Gasto</button>
            <button type="button" onclick="showEditForm()" class="btn btn-primary">Editar Gastos</button>
        </div>

        <form method="post" id="searchExpenseEdit" style="display:none;" class="col-sm-6 offset-sm-3">
            <div class="form-group text-left">
                <label for="accountInputUser">Buscar Gasto</label>
                <input type="text" class="form-control" id="searchExpense" name="searchExpense" aria-describedby="emailHelp" placeholder="Nombre">
            </div>
            <div class="form-group text-left">
                <button type="button" onclick="search()" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="homeExpense" role="tabpanel" aria-labelledby="nav-profile-tab">
                <form action="add_expenses" method="post" id="createNewExpense" class="col-sm-6 offset-sm-3">
                    <h4 class="offset-sm-3">Agregar Gastos</h4>
                    <div class="form-group">
                        <label for="accountInputUser">Nombre del gasto</label>
                        <input type="text" class="form-control" id="nameAddExpense" name="nameAddExpense" aria-describedby="emailHelp" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="accountInputEmail">Precio</label>
                        <input type="number" class="form-control" id="priceAddExpense" name="priceAddExpense" aria-describedby="emailHelp" placeholder="Precio">
                    </div>
                    <div class="form-group">
                        <label for="accountInputUser">Pago</label>
                        <select name="payAddExpense" id="payAddExpense" class="form-control">
                            <option value="2">Efectivo</option>
                            <option value="1">Tarjeta</option>
                        </select>
                    </div>
                    <div class="form-group" id="error-emptyExpense" style="display:none;">
                        <label for="signupName"><img src="img/icon-error.png" height="20px" width="20px" /><span id="errorPassText"><b>Los campos en rojo no pueden ir vacios.</b></span></label>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="list-group" style="display:none;" id="expenseList" role="tablist">
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="homeExpense_edit" style="display:none;" role="tabpanel" aria-labelledby="nav-profile-tab">
                <form action="update_expenses" method="post" id="editExpense" class="col-sm-6 offset-sm-3">
                    <h4 class="offset-sm-3">Editar gastos</h4>
                    <div class="form-group" style="display:none;">
                        <label for="accountInputUser">id</label>
                        <input type="text" class="form-control" id="idEditExpense" name="idEditExpense" aria-describedby="emailHelp" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="accountInputUser">Nombre del gasto</label>
                        <input type="text" class="form-control" id="nameEditExpense" name="nameEditExpense" aria-describedby="emailHelp" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="accountInputEmail">Precio</label>
                        <input type="number" class="form-control" id="priceEditExpense" name="priceEditExpense" aria-describedby="emailHelp" placeholder="Precio">
                    </div>
                    <div class="form-group">
                        <label for="accountInputUser">Pago</label>
                        <select name="payEditExpense" id="payEditExpense" class="form-control">
                            <option value="2">Efectivo</option>
                            <option value="1">Tarjeta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="accountInputEmail">Fecha del gasto</label>
                        <input type="date" class="form-control" id="dateEditExpense" name="dateEditExpense" aria-describedby="emailHelp" placeholder="Precio">
                    </div>
                    <div class="form-group" id="error-emptyExpenseEdit" style="display:none;">
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
    $('#searchExpenseEdit').on('submit', function(e) {
        e.preventDefault();
        search();
    });


    window.scrollTo(0, document.body.scrollHeight);
    $('#myList a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    function showAddForm() {
        $('#createNewExpense').show();
        $('#homeExpense_edit').hide();
        $('#expenseList').hide();
        $('#searchExpenseEdit').hide();

    }

    function showEditForm() {
        $('#expenseList').html('');
        $('#searchExpense').val('');
        $('#editExpense').hide();
        $('#createNewExpense').hide();
        $('#expenseList').show();
        $('#searchExpenseEdit').show();
        $('#idEditExpense').val('');
        $('#nameEditExpense').val('');
        $('#priceEditExpense').val('');
        $('#homeExpense_edit').hide();


    }

    $("#createNewExpense").on("submit", function(event) {
        var nombre = $('#nameAddExpense').val();
        var precio = $('#priceAddExpense').val();

        if (nombre == '' || precio == '') {
            event.preventDefault();
            $showError = false;
            if (nombre == '') {
                $('#nameAddExpense').css('border', '2px solid red');
                $showError = true;
            } else {
                $('#nameAddExpense').css('border', '');
            }
            if (precio == '') {
                $showError = true;
                $('#priceAddExpense').css('border', '2px solid red');
            } else {
                $('#priceAddExpense').css('border', '');
            }

            if ($showError) {
                $('#error-emptyExpense').show();
            } else {
                $('#error-emptyExpense').hide();
            }
        } else {
            $('#error-emptyExpense').hide();
            window.scrollTo(0, 0);
            $('.close').click();
            $('#expenseCreated').show();
            setInterval(function() {
                $('#expenseCreated').hide('2000');
            }, 2000);
        }
    });

    $("#editExpense").on("submit", function(event) {
        var nombre = $('#nameEditExpense').val();
        var count = $('#countEdit').val();
        var price = $('#priceEditExpense').val();

        if (nombre == '' || price == '') {
            event.preventDefault();
            $showError = false;
            if (nombre == '') {
                $('#nameEditExpense').css('border', '2px solid red');
                $showError = true;
            } else {
                $('#nameEditExpense').css('border', '');
            }
            if (price == '') {
                $showError = true;
                $('#priceEditExpense').css('border', '2px solid red');
            } else {
                $('#priceEditExpense').css('border', '');
            }
            if ($showError) {
                $('#error-emptyExpenseEdit').show();
            } else {
                $('#error-emptyExpenseEdit').hide();
            }
        } else {
            window.scrollTo(0, 0);
            $('#error-emptyExpenseEdit').hide();
            $('.close').click();
            $('#expenseUpdated').show();
            setInterval(function() {
                $('#expenseUpdated').hide('2000');
            }, 2000);
        }
    });


    function showEditExpense(id) {
        $('.list-group-item').removeClass('active');
        $('#edit_' + id).addClass('active');
        $('#homeExpense_edit').show();
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
                //res["Expense"]["date_creation"];
                $('#idEditExpense').val(res["Expense"]["id"]);
                $('#nameEditExpense').val(res["Expense"]["expense_title"]);
                $('#priceEditExpense').val(res["Expense"]["expense_price"]);
                $('#payEditExpense').val(res["Expense"]["payment_type"]);
                $('#dateEditExpense').val(res["Expense"]["date_creation"]);

            }

        });
    }

    function formatDay(date){
        var myArray = date.split("-");
        var year = myArray[0];
        var month = myArray[1];
        var day = myArray[2];

        var weekday = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
        var months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"];
        var fulldate = day+'/'+month+'/'+year
        var a = new Date(date+" 23:00:00");
        var numDia = a.getDay();
        var dayNameExpense = (weekday[numDia]);
        var dayExpense = a.getDate();
        var monthExpense = (months[a.getMonth()]);
        var yearExpense = a.getFullYear(); 
        var fullDateExpense = dayNameExpense+', '+dayExpense+' de '+monthExpense+ ' del '+yearExpense;
        return fullDateExpense;
    }

    function search() {
        var product = $('#searchExpense').val();
        $('#createNewExpense').hide();
        $('#expenseList').show();
        $('#editExpense').show();
        $('#homeExpense_edit').hide();

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
                let list = document.getElementById("expenseList");
                var boton = '';
                Object.entries(res).forEach((entry) => {
                    var dayFormat = '';
                    dayFormat = formatDay( entry[1].Expense.date_creation);
                    idProducts = entry[1].Expense.id;
                    nombreProducts = entry[1].Expense.expense_title + " | " + dayFormat;
                    boton += ' <a class="list-group-item list-group-item-action" id="edit_' + idProducts + '" data-toggle="list" onclick="showEditExpense(' + idProducts + ')" role="tab" style="color:black;">' + nombreProducts + '</a>';

                    i++;
                });
                if(boton == ""){
                    boton += ' <a class="list-group-item list-group-item-action" id="edit_empty" data-toggle="list"  role="tab" style="color:black;">No existen gastos</a>'; 
                }
                $('#expenseList').html(boton);

            }
        });
    }
</script>