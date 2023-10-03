<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>A lo fresa</title>
<link rel="icon" type="image/png" sizes="16x16"  href="../img/layout/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<script type="text/javascript" src="../js/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<style>
  .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<?php
date_default_timezone_set('America/Costa_Rica');

?>
</head>

<body>
    <header>
    <div style="display:none;" id="registerUser" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Contraseña ingresada con exito! </h4>
        <p><img src="../img/icon-success.png" height="20px" width="20px" /></p>
        <hr>
      </div>
       <div class="slider">
        
          <div class="sliderbox" id="sliderbox">
              <div class="slide"></div>            
          </div>         
          <a class="logo"></a>
          
         
          
      </div>
        
        
    </header>
    
    <main>
		<div id="content">
    <form action="../save_password" method="post" id="registerForm">
        <div class="form-group">
        <label for="loginInputEmail1" style="color:white">Hola, ingresa tu nueva contraseña</label>
        </div>
      <div class="form-group">
        <label for="loginInputEmail1" style="color:white">Contraseña</label>
        <input type="password" class="form-control" name="passwordregister" id="passwordregister" aria-describedby="emailHelp" placeholder="Contraseña">
      </div>
      <div class="form-group">
        <label for="loginInputPassword1" style="color:white">Confirmar Contraseña</label>
        <input type="password" class="form-control" name="passwordregisterConfirm" id="passwordregisterConfirm"  placeholder="Confirmar Contraseña">
      </div>
        <div class="form-group text-right">                
           <input type="hidden" name="idUser" id="idUser"  value="<?php echo $userId;?>">
           <button type="button" id="registerSave" class="btn btn-primary" id="loginNumbers">Guardar</button>
        </div>
        <div class="form-group" id="noerror-passregister" style="display:none;">
          <label for="signupName" ><img src="../img/icon-error.png" height="20px" width="20px" /><span id="errorPassText" style="color:white"><b>Contraseñas no coinciden.</b></span></label>
        </div>
    </form>
			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		</main>
    <footer>
        <div>©2023 A lo Fresa</div>
        <small><a href="policies.php">Políticas de Privacidad</a> | <a href="terms.php">Términos y Condiciones de Uso</a></small>
    </footer>

   
</body>
</html>
<script>

$( "#registerSave" ).on( "click", function( event ) {
  var password = $('#passwordregister').val();
  var passwordConfirm = $('#passwordregisterConfirm').val();
  if( password != passwordConfirm || password == '' ){
    $('#noerror-passregister').show();
  }else{
    $('#registerUser').show();
    $('#noerror-passregister').hide();
    window.scrollTo(0, 0);
    $('#registerForm').submit();
  }
  

});

var slide_images = [
    "banner1.jpg",
    "banner2.png",
    "banner3.jpg",
    "banner4.jpg"
];

$(document).ready(function(){
    var slidetotal = slide_images.length;
    var randomslide =  Math.floor((Math.random() * slidetotal));
    $("#sliderbox").find(".slide").html('<img alt="" src="https://storage.googleapis.com/videos-vr/'+slide_images[randomslide]+'">');
});
</script>


