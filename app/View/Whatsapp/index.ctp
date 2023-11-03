<style>
    /* styles.css */
/* Base styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.chat-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.sidebar {
    border-right: 1px solid #ccc;
    padding: 20px;
}

.chat-window {
    flex: 1;
    padding: 20px;
    height: auto;
}

/* Header styles */
.header img {
    width: 40px;
    height: 40px;
}

/* Sidebar styles */
.header input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 30px;
    margin-top: 10px;
}

.chat-list {
    margin-top: 20px;
    max-height: 80vh; /* Limitar la altura de la lista */
    overflow-y: auto; /* Habilitar una barra de desplazamiento vertical cuando sea necesario */
}

.chat {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Alinea los elementos al principio y al final */
    margin-bottom: 15px;
}

.chat img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.chat-info {
    margin-left: 10px;
}

.chat-info h3 {
    margin: 0;
    font-size: 18px;
}

.chat-info p {
    margin: 0;
    font-size: 14px;
    color: #888;
}

/* Chat window styles */
.header h3 {
    margin: 0;
    font-size: 24px;
}

.messages {
    margin-top: 20px;
    max-height: 80vh; /* Limitar la altura de la lista */
    overflow-y: auto; /* Habilitar una barra de desplazamiento vertical cuando sea necesario */
}

.message {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
}

.message.userwhatsapp {
    background-color: #c5e6c1;
    color: #000000;
    align-self: flex-end;
}

.message.contact {
    background-color: #ffffff;
    color: #000000;
    align-self: flex-start;
    margin-left: auto;
}

.message-input {
    display: flex;
    align-items: center;
    margin-top: 20px;
}

.message-input input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 30px;
}

.message-input button {
    background-color: #075e54;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin-left: 10px;
    cursor: pointer;
}
.message-count {
    
    background-color: #25d366;
    color: #fff;
    border-radius: 50%;
    padding: 5px 10px;
    font-size: 14px;
}

.chat-info {
    margin-left: 10px;
    flex: 1;
}

.chat-info h3 {
    margin: 0;
    font-size: 18px;
}

.chat-info p {
    margin: 0;
    font-size: 14px;
    color: #888;
}

/* Responsive styles */
@media (max-width: 768px) {
    .chat-container {
        flex-direction: column;
    }
    .sidebar, .chat-window {
        border: none;
        padding: 10px;
    }
    .chat-info h3 {
        font-size: 16px;
    }
    .chat-info p {
        font-size: 12px;
    }
}


    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="styles.css">-->
    <title>WhatsApp Web Chat</title>
</head>
<body>
    <div class="chat-container" style="background: white;">
        <div class="sidebar">
            <div class="header search">
                <img src="img/layout/whatsapp.png" alt="WhatsApp Logo">
                <input type="text" id="whatsappSearch" placeholder="Buscar...">
            </div>
            <div class="jumpLoagin" style="display:none">
                <img class="jump" style="border-radius:50%;" src="img/layout/logo.jpg" ></br></br></br></br>
                </br></br></br></br>
                <b>Cargando ...</b> 
            </div>    
            <div class="chat-list" id="chat_list">
                <!-- List of recent chats -->
                <?php foreach( $users as $user ){?>
                    <?php
                        $top = '';
                        if( $user[0] > 0 ){ $top = 'top'; } ?>    
                 <span>       
                <div class="chat <?php echo $top;?>" onclick="loadMessages(<?php echo '506'.$user['User']['phone'];?>)">
                    <img src="img/layout/logo.jpg" alt="User 1">
                    <div class="chat-info">
                        <h3 style="color:black"><?php echo $user['User']['name'];?></h3>
                        <!--<p style="color:black">Last message from User 1</p>-->
                    </div>
                    <?php if( $user[0] > 0 ){ ?>
                    <div class="message-count"><?php echo $user[0];?></div>
                    <?php } ?>
                </div>
                    </span>
                <?php } ?>
                <!-- Add more chat entries here -->
            </div>
        </div>
        <div class="chat-window" style="display:none">
         
        </div>

</div>
</body>
</html>
<style>

@keyframes jump {
  0%   {transform: translate3d(0,0,0) scale3d(1,1,1);}
  40%  {transform: translate3d(0,30%,0) scale3d(.7,1.5,1);}
  100% {transform: translate3d(0,100%,0) scale3d(1.5,.7,1);}
}
.jump {
  transform-origin: 50% 50%;
  animation: jump .8s linear alternate infinite;
  text-align: center;
  width:50%;
  height:50%;
  margin: 2em 2em 0;  vertical-align: middle; font-family: sans-serif, sans; font-weight: bold;
}

</style>

<script>


const searchInpute = document.getElementById("whatsappSearch");
        const itemList = document.getElementById("chat_list");
        const items = Array.from(itemList.getElementsByTagName("span"));

        searchInpute.addEventListener("input", function() {
            const searchTerm = searchInpute.value.toLowerCase();
            items.forEach(item => {
                const itemName = item.textContent.toLowerCase();
                if (itemName.includes(searchTerm)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });


        // Find all elements with the "highlighted" class
        const highlightedElements = document.querySelectorAll(".top");
        const elementList = document.getElementById("chat_list");

        // Loop through the highlighted elements and move them to the top
        highlightedElements.forEach(element => {
            elementList.prepend(element);
        });
    </script>

<script>
    function loadMessages(phone){
        $.ajax({
        type: 'POST',
        url: 'messages',
        data: 'from=' + phone,
        beforeSend: function() {
            $('.chat-list').hide();
            $('.search').hide();
            $('.jumpLoagin').show();
        },
        error: function() {
          alert('No hay internet');
        },
        success: function(response) {
            $('.jumpLoagin').hide();
            $('.chat-container').css('background-image', "url(https://alofresa.com/img/layout/backGround.png)");
            
            $('.chat-window').show();
            $('.chat-window').html(response);
            window.scrollTo(0, document.body.scrollHeight);
            $('.messages').scrollTop(1000);
        }

      });
    }

    function backpage(){
        window.location.reload();
    }
</script>
