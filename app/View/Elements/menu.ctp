
<li class="nav-item"><a class="nav-link fa fa-user" aria-hidden="true" id="calendar" href="account" type="button" > Perfil</a></li>
<?php if( $user['User']['type'] == '1' || $user['User']['type'] == '4' ){ ?>    
<li class="nav-item"><a class="nav-link fa fa-id-card" aria-hidden="true" id="calendar" href="users" type="button" > Usuarios</a></li>
<?php } 
$menuRoles = $_SESSION['Role'];
if( $user['User']['type'] == '1' || $user['User']['type'] == '4' ){
    $module2 = '';
    $module3 = '';
    $module4 = '';
    $module5 = '';
    $module6 = '';
    $module7 = '';
    $module8 = '';
    $module9 = '';
    $module10 = '';
}else{
   $module2 = 'display:none';
   $module3 = 'display:none';
   $module4 = 'display:none';
   $module5 = 'display:none';
   $module6 = 'display:none';
   $module7 = 'display:none';
   $module8 = 'display:none';
   $module9 = 'display:none';
   $module10 = 'display:none';

   foreach( $menuRoles as $menuRole ){
        $moduleId = $menuRole['Role']['id_module'];
        switch($moduleId){
            case 2:
                $module2 = '';
                break;
            case 3:
                $module3 = '';
                break;
            case 4:
                $module4 = '';
                break;
            case 5:
                $module5 = '';
                break;
            case 6:
                $module6 = '';
                break;
            case 7:
                $module7 = '';
                break;
            case 8:
                $module8 = '';
                break;
            case 9:
                $module9 = '';
                break;  
            case 10:
                $module10 = '';
                break;        
        }

   }
}
   ?>
    <li class="nav-item" style="<?php echo $module10;?>"><a class="nav-link fa fa-whatsapp" aria-hidden="true" id="calendar" href="whatsapp" type="button" > Whatsapp</a></li>
    <li class="nav-item" style="<?php echo $module2;?>"><a class="nav-link fa fa-calendar" aria-hidden="true" id="calendar" href="calendario" type="button" > Calendario</a></li>
    
    <li class="nav-item" style="<?php echo $module3;?>"><a class="nav-link fa fa-scissors" aria-hidden="true" id="calendar" href="services" type="button" > Servicios</a></li>
    <li class="nav-item" style="<?php echo $module4;?>"><a class="nav-link fa fa-users" aria-hidden="true" id="calendar" href="customers" type="button" > Clientes</a></li>
    <li class="nav-item" style="<?php echo $module5;?>"><a class="nav-link fa fa-product-hunt" aria-hidden="true" id="calendar" href="products" type="button" > Productos</a></li>
    <li class="nav-item" style="<?php echo $module6;?>"><a class="nav-link fa fa-clock-o" aria-hidden="true" id="calendar" href="work" type="button" > Horas de trabajo</a></li>
    <li class="nav-item" style="<?php echo $module7;?>"><a class="nav-link fa fa-book" aria-hidden="true" id="calendar" href="expenses" type="button" > Gastos</a></li>
    <li class="nav-item" style="<?php echo $module8;?>"><a class="nav-link fa fa-usd" aria-hidden="true" id="calendar" href="sales" type="button" > Ventas</a></li>
    <li class="nav-item" style="<?php echo $module9;?>"><a class="nav-link fa fa-line-chart" aria-hidden="true" id="calendar" href="product_sales" type="button" > Reporte</a></li>
      
