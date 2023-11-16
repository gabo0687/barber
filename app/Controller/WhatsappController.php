<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class WhatsappController extends AppController
{

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array('Message');
	public $components = array('Encrypt');
	/**
	 * Displays a view
	 *
	 * @return CakeResponse|null
	 * @throws ForbiddenException When a directory traversal attempt.
	 * @throws NotFoundException When the view file could not be found
	 *   or MissingViewException in debug mode.
	 */

	function beforeFilter()
	{
		parent::beforeFilter();
	}
    public function checksession($moduleId)
	{
		if (!isset($_SESSION['User'])) {
			$this->redirect(array('controller' => 'pages','action' => 'home'));
		}else{
			if( $moduleId != 1 && $_SESSION['User']['User']['type'] != 1 && $_SESSION['User']['User']['type'] != 4){
				$permission = $this->checkRole( $moduleId );
				if( !$permission ){
					$this->redirect(array('controller' => 'pages','action' => 'home'));
				}
			}
			
		}
	}
    public function checkRole( $moduleId ){
		$roles = $_SESSION['Role'];
		foreach( $roles as $role ){
			if( $moduleId == $role['Role']['id_module'] ){
				return true;
			}
		}
		return false;
	}
    public function index(){
        $this->checksession(6);
        $this->layout = 'message';

        $_SESSION['newNotification'] = 0;
        $users = $this->User->find('all',array('fields'=>array('User.id','User.name','User.phone'),'order'=>array('User.name ASC')));
        $user_reponse = array();
        foreach( $users as $user ){
            $phone = '506'.$user['User']['phone'];
            $count = $this->Message->find('count',array('fields'=>array('Message.id'),'conditions'=>array('Message.from'=>$phone,'Message.new_message'=>1)));
            array_push($user , $count);
            array_push($user_reponse, $user);
        }
        $this->set('users',$user_reponse);
        
    }
    public function messages(){
        $this->layout = 'ajax';
        $from = $_POST['from'];
        $messages = $this->Message->find('all',array('fields'=>array('Message.from','Message.creation_date','Message.message','Message.tipomensaje'),'conditions'=>array('Message.from'=>$from),
        'order'=> array('Message.id ASC')));
        $response = array();
        
        $this->clearNotificationUser($from);

        foreach( $messages as $message ){
            $phone = $message['Message']['from'];
            $number = substr($phone, 3);
            $user = $this->User->find('first',array('fields'=>array('User.id','User.name','User.phone'),'conditions'=>array('User.phone'=>trim($number))));
            array_push($message, $user);
            array_push($response, $message);
        }
        $this->set('messages',$response);
    }

    public function clearNotificationUser($phone){
        $count = $this->Message->find('count',array('fields'=>array('Message.id'),'conditions'=>array('Message.from'=>$phone,'Message.new_message'=>1)));
         
        $this->Message->query("update messages as messages set messages.new_message = 0 where messages.from =".$phone);

        $current_notification = $_SESSION['Messagenotification'] - $count;
        $_SESSION['Messagenotification'] = $current_notification;
        $this->Messagenotification->id = 1;
        $update['Messagenotification']['notification'] = $current_notification; 
        $this->Messagenotification->save($update);

       
    }

    public function webhook(){
        $this->layout = 'ajax';
		$this->autoRender = false;
        $requestDataJson = file_get_contents('php://input');
        //$message = '{"object":"whatsapp_business_account","entry":[{"id":"143565672172795","changes":[{"value":{"messaging_product":"whatsapp","metadata":{"display_phone_number":"50672795112","phone_number_id":"135413842992132"},"contacts":[{"profile":{"name":"Gabo"},"wa_id":"50683481182"}],"messages":[{"from":"50683481182","id":"wamid.HBgLNTA2ODM0ODExODIVAgASGCA4NjQxRjExQUQxOEZGRjA2NDZGMzVBM0Y2M0FCNTY4RgA=","timestamp":"1698866304","type":"audio","audio":{"mime_type":"audio\/ogg; codecs=opus","sha256":"MfDigrEBd3vmIDgvFyI0M0losjHmpFKo62jQ\/GSnu4w=","id":"162781593529753","voice":true}}]},"field":"messages"}]}]}';
        $requestData = json_decode($requestDataJson, true);
        $from = $requestData['entry'][0]['changes'][0]['value']['messages'][0]['from'];
        $this->Message->create();
        $data['Message']['message'] = $requestDataJson;
        $data['Message']['from'] = $from;
        $data['Message']['new_message'] = 1;
        $data['Message']['tipomensaje'] = '0';
        $data['Message']['creation_date'] = date('Y-m-d H:i:s');
        $this->Message->save($data);

        $current_notification = $_SESSION['Messagenotification'] + 1;
        $this->Messagenotification->id = 1;
        $update['Messagenotification']['notification'] = $current_notification; 
        $this->Messagenotification->save($update);
        $_SESSION['newNotification'] = 1;
        /*echo $requestData;
        var_dump($requestData);
        echo 'end';
        die;
        $hubVerifyToken = "phpmaster_token";
        $accessToken = 'EAAZAeI4i9EJ8BO9vX1BDTVNhAuoJVvkadXCx69uzQCzZBPKxAdG0HCn1zQ9noTr8AqI1YidnQ9EU2OZCtbRZAm3fI7R45wgJPuKp5ZCNBYLAKcN6XurJ766kih47eoGexANDWZCEObdQ2EGj9xsxghxRiZCZBhdZBUeMbuAWZB7dINlaTx4bZB4rIbrB28iHpzTdqTY6OmQsp3sPCpCkTS9';
        if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hub_challenge']) && isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] === $hubVerifyToken){
            echo $_GET['hub_challenge'];
            echo '<pre>';
            var_dump($_SERVER);
            var_dump($_GET);
            exit;
        }*/
        
    }
    
    public function send_whatsapp(){
        $this->layout = 'ajax';
		$this->autoRender = false;
		$ch = curl_init();
		$token = "EAAZAeI4i9EJ8BO9vX1BDTVNhAuoJVvkadXCx69uzQCzZBPKxAdG0HCn1zQ9noTr8AqI1YidnQ9EU2OZCtbRZAm3fI7R45wgJPuKp5ZCNBYLAKcN6XurJ766kih47eoGexANDWZCEObdQ2EGj9xsxghxRiZCZBhdZBUeMbuAWZB7dINlaTx4bZB4rIbrB28iHpzTdqTY6OmQsp3sPCpCkTS9";
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v18.0/135413842992132/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);

        $from = $_POST['from'];
        $to   = '506'.$_POST['to'];
        $text = $_POST['text'];
        $data = array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
				'to' => $to,
				'type' => 'text',
				'text' => array(
                    'preview_url' => false,
                    'body' => $text
                )
        );
        $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			//var_dump($server_output);
			curl_close($ch);
            $response = '';
            $this->Message->create();
            $dataN['Message']['message'] = $text;
            $dataN['Message']['from'] = $to;
            $dataN['Message']['new_message'] = 0;
            $dataN['Message']['tipomensaje'] = '1';
            $dataN['Message']['creation_date'] = date('Y-m-d H:i:s');
            if($this->Message->save($dataN)){
                $months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
                $date = date('Y-m-d H:i:s');
                $day  = date('w', strtotime($date));
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $currentDay = date('d', strtotime($date));
                $dayOfTheWeek = $days[$day];
                $timeDate = date('H:i:s',strtotime(date('Y-m-d H:i:s')));
                $response = '<div class="message contact"><p><b>'.$text.'</b></p>';
                $response.= '<p><small>'.$currentDay.' de '.$months[(int)$month-1].' '.$year.' </br>'.date("h:i A",strtotime($timeDate)).'</small></p></div>';
                
            } 

            return $response;
    }

    function start_whatsapp(){
        $this->layout = 'ajax';
		$this->autoRender = false;
        $ch = curl_init();
		$token = "EAAZAeI4i9EJ8BO9vX1BDTVNhAuoJVvkadXCx69uzQCzZBPKxAdG0HCn1zQ9noTr8AqI1YidnQ9EU2OZCtbRZAm3fI7R45wgJPuKp5ZCNBYLAKcN6XurJ766kih47eoGexANDWZCEObdQ2EGj9xsxghxRiZCZBhdZBUeMbuAWZB7dINlaTx4bZB4rIbrB28iHpzTdqTY6OmQsp3sPCpCkTS9";
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v17.0/135413842992132/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);

		$phone = $_POST['to'];
			$data = array();
			$data = array(
				'messaging_product' => 'whatsapp',
				'to' => '506'.$phone,
				'type' => 'template',
				'template' => array(
						'name' => 'hello',
						 'language' => array( 'code' => 'es_MX')
						)
			);
			$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			//var_dump($server_output);
			curl_close($ch);
			$response = '';
            $this->Message->create();
            $dataN['Message']['message'] = $_POST['text'];
            $dataN['Message']['from'] = '506'.$_POST['to'];
            $dataN['Message']['new_message'] = 0;
            $dataN['Message']['tipomensaje'] = '5';
            $dataN['Message']['creation_date'] = date('Y-m-d H:i:s');
            if($this->Message->save($dataN)){
                $months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
                $date = date('Y-m-d H:i:s');
                $day  = date('w', strtotime($date));
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $currentDay = date('d', strtotime($date));
                $dayOfTheWeek = $days[$day];
                $timeDate = date('H:i:s',strtotime(date('Y-m-d H:i:s')));
                $response = '<div class="message contact"><p><b>Hola buenas, como estas?</b></p>';
                $response.= '<p><small>'.$currentDay.' de '.$months[(int)$month-1].' '.$year.' </br>'.date("h:i A",strtotime($timeDate)).'</small></p></div>';
                
            } 

            return $response;
		
    }

    function limitTimeMessages(){
        $message = $this->Message->find('first',array('conditions'=>array('Message.from'=>$_POST['phone']),'order'=>array('Message.id desc')));
        
    }
}