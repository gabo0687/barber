<section class="event-detail">
    <article id="profile">
      <h2>Mi Perfil</h2>
      <ul class="nav nav-pills text-end">
       <?php if( $user['User']['type'] == '1' ){?>
       <li class="nav-item"><a class="nav-link fa fa-calendar" aria-hidden="true" id="calendar" href="calendar" type="button" > Calendario</a></li>
       <li class="nav-item"><a class="nav-link fa fa-scissors" aria-hidden="true" id="calendar" href="services" type="button" > Servicios</a></li>
       <li class="nav-item"><a class="nav-link fa fa-id-card" aria-hidden="true" id="calendar" href="users" type="button" > Usuarios</a></li>
       <li class="nav-item"><a class="nav-link fa fa-users" aria-hidden="true" id="calendar" href="customers" type="button" > Clientes</a></li>
       <li class="nav-item"><a class="nav-link fa fa-product-hunt" aria-hidden="true" id="calendar" href="products" type="button" > Productos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-clock-o" aria-hidden="true" id="calendar" href="work" type="button" > Horas de trabajo</a></li>
       <li class="nav-item"><a class="nav-link fa fa-book" aria-hidden="true" id="calendar" href="expenses" type="button" > Gastos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-line-chart" aria-hidden="true" id="calendar" href="sales" type="button" > Ventas</a></li>
       <li class="nav-item"><a class="nav-link fa fa-usd" aria-hidden="true" id="calendar" href="product_sales" type="button" > Reporte Productos</a></li>
       <li class="nav-item"><a class="nav-link fa fa-money" aria-hidden="true" id="calendar" href="expenses_sales" type="button" > Reporte Gastos</a></li>
       <?php } ?>
       
       
       
      </ul>
   
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <h4 class="offset-sm-3">Datos de cuenta</h4>
          <form class="col-sm-6 offset-sm-3">
            <div class="form-group">
              <label for="accountInputUser">Usuario</label>
              <input type="email" class="form-control" id="accountInputUser" aria-describedby="emailHelp" placeholder="Usuario">
            </div>
            <div class="form-group">
              <label for="accountInputEmail">Email</label>
              <input type="email" class="form-control" id="accountInputEmail" aria-describedby="emailHelp" placeholder="Correo Electrónico">
            </div>
            <div class="form-group">
              <label for="accountInputPassword">Contraseña</label>
              <input type="password" class="form-control" id="accountInputPassword" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="accountInputPassword2">Confirmar Contraseña</label>
              <input type="password" class="form-control" id="accountInputPassword2" placeholder="Password">
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
      </div>
    </article>
  </section>
  <script>
    window.scrollTo(0, document.body.scrollHeight);
  </script>