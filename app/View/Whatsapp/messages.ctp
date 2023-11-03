<div class="header" style="position: -webkit-sticky; position: sticky;">
    <h3 style="color:white"><i class="fa fa-arrow-left" aria-hidden="true" onclick="backpage()"></i> <?php echo $messages[0][0]['User']['name'];?></h3>
</div>
<div class="messages" >
    <!-- Chat messages go here -->
   <?php
   $token = "EAAZAeI4i9EJ8BO9vX1BDTVNhAuoJVvkadXCx69uzQCzZBPKxAdG0HCn1zQ9noTr8AqI1YidnQ9EU2OZCtbRZAm3fI7R45wgJPuKp5ZCNBYLAKcN6XurJ766kih47eoGexANDWZCEObdQ2EGj9xsxghxRiZCZBhdZBUeMbuAWZB7dINlaTx4bZB4rIbrB28iHpzTdqTY6OmQsp3sPCpCkTS9";
   $messageResponse = '';
   $mensajeTipo = '';
   $i=0;
   $months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
   $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
   
   $to = $messages[0][0]['User']['phone'];
   foreach($messages as $message){
    $date = $message['Message']['creation_date'];
    $day  = date('w', strtotime($date));
    $year = date('Y', strtotime($date));
    $month = date('m', strtotime($date));
    $currentDay = date('d', strtotime($date));
    $dayOfTheWeek = $days[$day];
    $timeDate = date('H:i:s',strtotime($message['Message']['creation_date']));
    if( $message['Message']['message_type'] == 0 ){
    $messageWhatsapp = json_decode($message['Message']['message']);
    
    
    
    $messageText = '';
    $messageResponse = '';
    if( isset($messageWhatsapp->entry[0]->changes[0]->value->messages[0]->text) ){
        $messageText = $messageWhatsapp->entry[0]->changes[0]->value->messages[0]->text->body;
        $messageResponse = '<b>'.$messageText.'</b>';
    }else{
        if( isset($messageWhatsapp->entry[0]->changes[0]->value->messages[0]->image)){
            $idMedia = $messageWhatsapp->entry[0]->changes[0]->value->messages[0]->image->id;
            $mensajeTipo = 'imagen';
        }
        if( isset($messageWhatsapp->entry[0]->changes[0]->value->messages[0]->audio)){
            $idMedia = $messageWhatsapp->entry[0]->changes[0]->value->messages[0]->audio->id;
            $mensajeTipo = 'audio';
        }
        
        
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v13.0/".$idMedia);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $media = json_decode($server_output);
        $url = $media->url;
        $mime_type = $media->mime_type;
        curl_close($ch);

        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_USERAGENT => 'curl/7.64.1',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
            ));
            
            $response = curl_exec($curl);

            curl_close($curl);
             header('Content-Type: bitmap; charset=utf-8');
            
             
            if( $mensajeTipo == 'imagen' ){
                $file = fopen('media/'.$messages[0][0]['User']['id'].'_tmpFile'.$i.'.jpg', 'wb');
                fwrite($file, $response);
                fclose($file);
                $comprobante = 'media/'.$messages[0][0]['User']['id'].'_tmpFile'.$i.'.jpg';
                $comprobante = "'".$comprobante."'";
                $messageResponse = '<img  onclick="comprobanteShow('.$comprobante.');" src="media/'.$messages[0][0]['User']['id'].'_tmpFile'.$i.'.jpg"  width="150" height="100" data-bs-toggle="modal" data-bs-target="#modalAmpliarImagenChat"/>';
            }else{
                if( $mensajeTipo == 'audio' ){
                    $file = fopen('media/'.$messages[0][0]['User']['id'].'_tmpFile'.$i.'.ogg', 'wb');
                    fwrite($file, $response);
                    fclose($file);
                    
                  $messageResponse = '<audio id="audio" controls ><source type="audio/ogg" src="media/'.$messages[0][0]['User']['id'].'_tmpFile'.$i.'.ogg"></audio>' ;
                } 
            }
           
            
           // 
            //echo $url;
    }
    
    if( $messageResponse != '' ){ ?>
    <div class="message userwhatsapp">
        
        <p><?php echo $messageResponse;?></p>
        <p><small><?php echo $currentDay.' de '.$months[(int)$month-1].' '.$year.' </br>'.date("h:i A",strtotime($timeDate))?></small></p>
        
    </div>
    <style>
        audio { width: 150px; }
    </style>    
    <?php } 
     $i++; 
    }
     if( $message['Message']['message_type'] == 1 ){?>
     <div class="message contact">
        <p><?php echo '<b>'.$message['Message']['message'].'</b>';?></p>
        <p><small><?php echo $currentDay.' de '.$months[(int)$month-1].' '.$year.' </br>'.date("h:i A",strtotime($timeDate))?></small></p>
    </div>
     <?php
     } 
     }
      ?>
    
   
    <!-- Add more messages here -->
</div>
<div class="message-input">
    <input type="text" id="messageWhatsapp" id="messageWhatsapp" placeholder="Escribe un mensaje..." >
    <button onclick="sentMessage(<?php echo $to;?>)">Enviar</button>
</div>


<script>
    setInterval(function () {
        console.log(<?php echo '506'.$to;?>);
        loadMessagesChat(<?php echo '506'.$to;?>);
    }, 20000);
    
    
function sentMessage(to){

    var from = "50672795112";
    var text = $('#messageWhatsapp').val();
    if( text != '' ){
        $.ajax({
        type: 'POST',
        url: 'send_whatsapp',
        data: 'from=' + from + '&to='+ to + '&text='+ text,
        beforeSend: function() {

        },
        error: function() {

            alert('No hay internet');
        },
        success: function(response) {
            $('#messageWhatsapp').val('');
            $('.messages').append(response);
            $('.messages').scrollTop(1000);
        }

        }); 
    }

}
</script>



