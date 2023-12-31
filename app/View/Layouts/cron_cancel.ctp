<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>A lo fresa</title>
<link rel="icon" type="image/png" sizes="16x16"  href="img/layout/favicon-16x16.png">
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
       <div class="slider">
        
          <div class="sliderbox" id="sliderbox">
              <div class="slide"></div>            
          </div>         
          <a class="logo"></a>
          
         
         <form class="header-search">   
         <div class="event-info-buttons"> 
           <a class="ticket-btn">💈Su reservación a sido cancelada con exito!</a> 
         </div>
        </form>
      </div>
        
        
    </header>
    
    <main>
		<div id="content">

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

setTimeout(() => {

window.location.href = "../";
}, "5000");

 
var slide_images = [
    "banner1.jpg",
    "banner2.png",
    "banner3.jpg",
    "banner4.jpg"
];

$(document).ready(function(){
    var slidetotal = slide_images.length;
    var randomslide =  Math.floor((Math.random() * slidetotal));
    $("#sliderbox").find(".slide").html('<img alt="" src="../img/slider/'+slide_images[randomslide]+'">');
});
</script>


