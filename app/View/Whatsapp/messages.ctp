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
   foreach($messages as $message){

    $messageWhatsapp = json_decode($message['Message']['message']);
    
//echo '<pre>';
  //  var_dump($messageWhatsapp);

    $messageText = '';
    $messageResponse = '';
    if( isset($messageWhatsapp->entry[0]->changes[0]->value->messages[0]->text) ){
        $messageText = $messageWhatsapp->entry[0]->changes[0]->value->messages[0]->text->body;
        $messageResponse = $messageText;
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
                $messageResponse = '<img src="media/'.$messages[0][0]['User']['id'].'_tmpFile'.$i.'.jpg" width="150" height="100" alt="embedded folder icon"/>';
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
        
    </div>
    <style>
        audio { width: 150px; }
    </style>    
    <?php } 
     $i++;
     } ?>
    <!--<div class="message contact">
        <p>I'm good, thanks for asking!</p>
    </div>-->
   
    <!-- Add more messages here -->
</div>
<div class="message-input">
    <input type="text" placeholder="Escribe un mensaje...">
    <button>Enviar</button>
</div>
