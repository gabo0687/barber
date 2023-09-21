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
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Service','Duration','User','Reservation','Notification','Customer');
	public $components = array('Encrypt');
/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
public function home(){

	$user = '';
	$reservations = array();
	$reservationResponse=array();
	if(isset($_SESSION['User'])){
		$conditions = array();
		$user = $_SESSION['User'];
		if( $user['User']['type'] == 3 ){
			$conditions['Reservation.reservation_user'] = $user['User']['id'];
		}else{
			if( $user['User']['type'] == 2 ){
				$conditions['Reservation.reservation_barber'] = $user['User']['id'];
			}		
		}
		$conditions['Reservation.reservation_date >='] = date('Y-m-d');
		$conditions['Reservation.reservation_status <>'] = 2;
		$reservations = $this->Reservation->find('all',array('fields'=>
																	array('Reservation.id','Reservation.reservation_status','Reservation.reservation_date','Reservation.reservation_time',
																		  'Service.id','Service.service_name','Service.price',
																		  'Barber.id','Barber.name','Barber.color',
																		  'User.id','User.name','User.phone',
																		  ),
															 'conditions'=>
																	array($conditions),
															 'joins' =>
															 array(
																 array(
																	 'table' => 'services',
																	 'alias' => 'Service',
																	 'type' => 'inner',
																	 'foreignKey' => false,
																	 'conditions'=> array('Service.id = Reservation.reservation_service'),
																 ),
																 array(
																	'table' => 'users',
																	'alias' => 'Barber',
																	'type' => 'inner',
																	'foreignKey' => false,
																	'conditions'=> array('Barber.id = Reservation.reservation_barber')
																),
																array(
																   'table' => 'users',
																   'alias' => 'User',
																   'type' => 'inner',
																   'foreignKey' => false,
																   'conditions'=> array('User.id = Reservation.reservation_user')
															   )          
																),
															 'order'=>array('Reservation.reservation_date'=>'ASC','Reservation.reservation_time'=>'ASC')
															));
	foreach( $reservations as $reservation ){
		$duration = $this->Duration->find('first',array('fields'=>array('Duration.id','Duration.duration'),'conditions'=>array('Duration.barber'=>$reservation['Barber']['id'],'Duration.service_id'=>$reservation['Service']['id'])));
		array_push($reservation,$duration);
		array_push($reservationResponse,$reservation);
	}
	Cache::write('reservationResponse'.$_SESSION['User']['User']['id'], $reservationResponse);
	}
	
	
	$this->set('reservations',$reservationResponse);
	$this->set('user',$user);


}

public function account(){

	$user = '';
	if(isset($_SESSION['User'])){
		$user = $_SESSION['User'];
	}
	
	$this->set('user',$user);
}
public function services(){
	$user = '';
	$services = $this->Service->find('all');
	$this->set('services',$services);
	$barbers = $this->User->find('all',array('conditions'=>array(
		'OR'=> array(
					array('User.type'=>1),
					array('User.type'=>2)
					)
				)
			)
		);
	
	$this->set('barbers',$barbers);
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
	}
	$this->set('user',$user);
}
function loginUser(){

	$this->layout = 'ajax';
	$this->autoRender = false;
	$user = $_POST['loginNumber'];
	$pass = $_POST['loginPass'];
	$pass = $this->Encrypt->encrypt($pass);


	$register = $this->User->find('first', array('conditions' => array('User.phone' => $user,'User.password' => $pass,'User.status' => 1)));

		if(isset($register['User']['id'])){
			
			$_SESSION['User'] = $register;
			echo 1;
		}else{
			echo 0;
		}

}


function logout(){
	$this->autoRender = false;
	$this->Session->destroy();
	$this->redirect(array('action' => '../'));
}

public function add_service(){
	$this->layout = 'ajax';
	if ($this->request->is('post')) {
		$this->Service->create();
		$data['Service']['service_name'] = $_POST['nombre'];
		$data['Service']['price'] = $_POST['precio'];
		$data['Service']['gender'] = $_POST['tiposervicio'];
		$data['Service']['date_creation'] = date('Y-m-d');
		if($this->Service->save($data)){
		$serviceId = $this->Service->getLastInsertID();
		$cantidadBarbers = $_POST['cantidadBarbers'];
		for($i=0; $i < $cantidadBarbers;$i++ ){
			$this->Duration->create();
			$data['Duration']['duration'] = $_POST['duracion'.$i];
			$data['Duration']['barber'] = $_POST['duracionId'.$i];
			$data['Duration']['service_id'] = $serviceId;
			$this->Duration->save($data);
		}
		

		$this->redirect(array('action' => '../services'));
		}
	}
}

public function load_service(){
	$this->autoRender = false;
	$this->layout = 'ajax';
	$idServicio = $_POST['idServicio'];

	$servicio = $this->Service->find('all',array(
	'fields' => array('Duration.id','Duration.duration','Duration.barber','Duration.service_id','Service.id','Service.service_name','Service.price','Service.gender'),
	'conditions'=>array('Service.id'=>$idServicio),
	'joins' =>
		array(
			array(
				'table' => 'durations',
				'alias' => 'Duration',
				'type' => 'inner',
				'foreignKey' => false,
				'conditions'=> array('Duration.service_id = Service.id')
			)          
			),
	'recursive' => 2	
	));

	echo json_encode($servicio);
}

public function edit_service(){
	$this->layout = 'ajax';
	if ($this->request->is('post')) {
		
		$this->Service->id = $_POST['id_edit'];
		$data['Service']['service_name'] = $_POST['nombre_edit'];
		$data['Service']['price'] = $_POST['precio_edit'];
		$data['Service']['gender'] = $_POST['tiposervicio_edit'];
		if($this->Service->save($data)){
		//$serviceId = $this->Service->getLastInsertID();
		$serviceId = $_POST['id_edit'];
		$cantidadBarbers = $_POST['cantidadBarbers'];
		$this->Duration->query('delete from durations where service_id='.$serviceId);
		$barbers = $this->User->find('all',array(
			'fields'=>array('User.id'),
			'conditions'=>array(
			'OR'=> array(
						array('User.type'=>1),
						array('User.type'=>2)
						)
					)
				)
			);
		foreach( $barbers as $barber ){
		
			$this->Duration->create();
			$data['Duration']['duration'] = $_POST['duracion_edit'.$barber['User']['id']];
			$data['Duration']['barber'] = $_POST['duracionId_edit'.$barber['User']['id']];
			$data['Duration']['service_id'] = $serviceId;
			$this->Duration->save($data);
			
		}
		
		
		$this->redirect(array('action' => '../services'));
		}
	}
}

function saveUser(){
	$this->layout = 'ajax';
	$this->autoRender =false;
	if ($this->request->is('post')) {
		//Initialize
		$nombreUsuario = $_POST['signupName'];
		$celular = $_POST['signupPhone'];
		//$userEmail = $_POST['signupEmail'];
		$userContrasena = $_POST['signupPassword1'];
		//Save user
		$this->User->create();
		$data['User']['name'] = $nombreUsuario;
		$data['User']['phone'] = $celular;
		//$data['User']['email'] = trim($userEmail);
		$data['User']['type'] = 3;
		$data['User']['status'] = 1;
		$data['User']['creation_date'] = date('Y-m-d H:i:s');
		if($userContrasena != ''){
			$pass = $this->Encrypt->encrypt($userContrasena);
			$data['User']['password'] = $pass;
		}
		
		if($this->User->save($data)){
			sleep(10);
				$this->redirect(array('action' => '../'));
			}else{
				$this->redirect(array('action' => '../error'));
			}
			
		}
		
	}

	public function getPhone(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$storedPhone = $this->User->find('first',array('conditions'=>array('User.phone'=>$_POST['phone'],'User.status'=>1)));
    	if(empty($storedPhone)){
			echo 0;
		} else {
			echo 1;
		}
	}

	public function load_reservations(){
		$this->layout = 'ajax';
		$this->autoRender = false;

		if( $_POST['reservationDate'] == '' ){
			$reservationDate = date('Y-m-d');		
		}else{
		   $reservationDate = $_POST['reservationDate'];
		}
		$reservationServices = $_POST['reservationServices'];
		$reservationBarber	 = $_POST['reservationBarber'];
		
		
		$reservationTime 	 = $_POST['reservationTime'];
		
		$reservations = $this->Reservation->find('all',array('conditions'=>array(
																'Reservation.reservation_date'=>$reservationDate,
																'Reservation.reservation_status <>'=>2
																),
																'order'=>array('Reservation.reservation_time'=>'ASC')
															));
	
		$reservationsAvailable = $this->load_reservation_available($reservations,$reservationServices,$reservationBarber,$reservationTime);													
		
		echo json_encode($reservationsAvailable);
		

	}

	public function load_reservation_available($reservations,$reservationService,$filterBarber,$reservationTime){
	
		$timeLists = $this->time_open();
		$reservationsResponse =array();
		
		foreach( $timeLists as $timeList ){
			
			$reservationAvailable =array();

			if($reservationTime != 0 ){
				if( strtotime($timeList) >= strtotime($reservationTime) ){
					$reservationAvailable = $this->reservationsFilter($timeList,$reservations,$reservationService,$filterBarber,$reservationTime);
				}
			}else{
				$reservationAvailable = $this->reservationsFilter($timeList,$reservations,$reservationService,$filterBarber,$reservationTime);
			}
			if( !empty($reservationAvailable) ){
				array_push($reservationsResponse,$reservationAvailable);
			}
		}
		return $reservationsResponse;
		
	}

	public function reservationsFilter($timeList,$reservations,$reservationService,$filterBarber,$reservationTime){
		
		$barbers = $this->load_barbers();
		$service = $this->load_service_reservation($reservationService);
		
		$reservationsResponse =array();
		$reservationBarbers =array();
		$timeCompare = strtotime($timeList); 
		foreach( $reservations as $reservation ){
			$timeReservation = strtotime($reservation['Reservation']['reservation_time']);
			$barberReservation = $reservation['Reservation']['reservation_barber'];
			if( $timeReservation == $timeCompare ){
				foreach( $barbers as $barber ){
					if( $barberReservation == $barber['User']['id'] ){
						array_push($reservationBarbers , $barber);
					}	
				}	
			}
		}	
		$reservationBarberResponse =array();
			if( !empty($reservationBarbers) ){
				if( $filterBarber != 0 ){
					foreach( $barbers as $barberResponse){
						$barberExist = false;
						foreach( $reservationBarbers as $barberReservation ){
							if( $barberResponse['User']['id'] == $barberReservation['User']['id'] ){
								$barberExist = true;
							}
						}
						if( $barberExist == false && $filterBarber == $barberResponse['User']['id'] ){
							/**
							 * Validar si el babero da el servicio o no
							 */
							$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
							if( $validateBarberService ){
								array_push($reservationBarberResponse , $barberResponse);
							}
							
						}
						
					}
				}else{
					
					foreach( $barbers as $barberResponse){
						$barberExist = false;
						foreach( $reservationBarbers as $barberReservation ){
							if( $barberResponse['User']['id'] == $barberReservation['User']['id'] ){
								$barberExist = true;
							}
						}
						if( $barberExist == false ){
							$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
							if( $validateBarberService ){
								array_push($reservationBarberResponse , $barberResponse);
							}
						}
						
					}
				}
				
				$reservationAvailable =array('Time'=>$timeList,'Service'=>$service['Service']['service_name'],'ServiceId'=>$service['Service']['id'],'Duration'=>$service['Duration']['duration'],'Price'=>$service['Service']['price'],
									'Barbers'=>$reservationBarberResponse);
				
			}else{
				if( $filterBarber != 0 ){
					foreach( $barbers as $barberResponse){
						if( $filterBarber == $barberResponse['User']['id'] ){
							$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
							if( $validateBarberService ){
								array_push($reservationBarberResponse , $barberResponse);
							}
						}
					}
					$reservationAvailable =array('Time'=>$timeList,'Service'=>$service['Service']['service_name'],'ServiceId'=>$service['Service']['id'],'Duration'=>$service['Duration']['duration'],'Price'=>$service['Service']['price'],
									'Barbers'=>$reservationBarberResponse);
				}else{
					foreach( $barbers as $barberResponse){
						$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
							if( $validateBarberService ){
								array_push($reservationBarberResponse , $barberResponse);
							}
					}
					$reservationAvailable =array('Time'=>$timeList,'Service'=>$service['Service']['service_name'],'ServiceId'=>$service['Service']['id'],'Duration'=>$service['Duration']['duration'],'Price'=>$service['Service']['price'],
									'Barbers'=>$reservationBarberResponse);
				}
				
			}
			return $reservationAvailable;
	}
	public function validateBarberService($service, $barber){
		$validateService = $this->Duration->find('first',array('conditions'=>array('Duration.service_id'=>$service,'Duration.barber'=>$barber)));
		
		if( $validateService['Duration']['duration'] == '' || $validateService['Duration']['duration'] == '0' ){
			return false;
		}
			return true;
		
	}

	public function time_open(){
		$time_return = array();
		$time_hour = 8;
		$time_minute = '00';
		for($i=0; $i <= 28; $i++){ 
		  	if( $time_minute != 60 ){
		  		array_push($time_return,$time_hour.':'.$time_minute);      
			}
			if( $time_minute == 30 ){
				$time_minute = '00';
				$time_hour = $time_hour + 1;
			}else{
				if( $time_minute == 60 ){
					$time_minute = '00';
					$time_hour = $time_hour + 1;
				}else{
					if( $time_minute == 00 || $time_minute == 30 ){
						$time_minute = $time_minute +30;
					}
				}  
			} 
		}  
		return $time_return;
	}

	public function load_barbers(){
		$users = $this->User->find('all',array(
			'fields' => array('User.id','User.name'),
			'conditions'=>array(
			'OR'=> array(
						array('User.type'=>1),
						array('User.type'=>2)
						)
					)
				)
			);
			return $users;
	}

	public function load_service_reservation($idServicio){
		$service = $this->Service->find('first',array(
			'fields' => array('Duration.id','Duration.duration','Duration.barber','Duration.service_id','Service.id','Service.service_name','Service.price','Service.gender'),
			'conditions'=>array('Service.id'=>$idServicio),
			'joins' =>
				array(
					array(
						'table' => 'durations',
						'alias' => 'Duration',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions'=> array('Duration.service_id = Service.id')
					)          
					),
			'recursive' => 2	
			));
		return $service;

	}

	public function save_notification(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Notification->create();
		if( $_POST['reservationDate'] == '' ){
			$reservationDate = date('Y-m-d'); 
		}else{
			$reservationDate = $_POST['reservationDate'];
		}	
		$data['Notification']['reservation_date'] = $reservationDate;
		$data['Notification']['reservation_time'] = $_POST['reservationFilterTime'];
		$data['Notification']['user_id'] = $_SESSION['User']['User']['id'];
		$data['Notification']['notification_type'] = 2;
		$data['Notification']['date_creation'] = date('Y-m-d H:i:s');
		if($this->Notification->save($data)){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function save_reservation(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		if( $_POST['reservation_date'] == '' ){
			$reservationDate = date('Y-m-d'); 
		}else{
			$reservationDate = $_POST['reservation_date'];
		}
		if( $_POST['client'] != 0 ){
			$client = explode('-',$_POST['client']);
			$reservationUser = $client[0];
			
		}else{
			$reservationUser = $_SESSION['User']['User']['id'];
		}
		/**
		 * Validar no más de 2 reservaciones activas
		 */
		$validateReservation = $this->validateReservations($reservationUser);
		/**
		 * Validar si alguien más tomó la cita
		 */
		$reservationTaken = $this->reservationTaken($_POST['reservation_barber'],$_POST['reservation_time'],$reservationDate);
		if( $validateReservation && $reservationTaken ){

			$this->Reservation->create();
			$data['Reservation']['reservation_date'] = $reservationDate;
			$data['Reservation']['reservation_time'] = $_POST['reservation_time'];
			$data['Reservation']['reservation_user'] = $reservationUser;
			$data['Reservation']['reservation_service'] = $_POST['reservation_service'];
			$data['Reservation']['reservation_barber'] = $_POST['reservation_barber'];
			$data['Reservation']['creation_date'] = date('Y-m-d H:i:s');
			if($this->Reservation->save($data)){
				$this->Customer->query('delete from customers where user_id='.$reservationUser);
				$this->Customer->create();
				$data['Customer']['last_appointment'] = $reservationDate;
				$data['Customer']['user_id'] = $reservationUser;
				$data['Customer']['fecha_creacion'] = date('Y-m-d H:i:s');
				$this->Customer->save($data);
				Cache::clear();
				echo 1;
			}else{
				echo 0;
			}
		}else{
			if( !$reservationTaken ){
				echo 4;	
			}else{
				echo 3;	
			}
			
		}
	}

	public function reservationTaken($reservation_barber,$reservation_time,$reservationDate){
		$reservationTaken = $this->Reservation->find('first',array('conditions'=>array('Reservation.reservation_barber'=>$reservation_barber,'Reservation.reservation_time'=>$reservation_time,'Reservation.reservation_date'=>$reservationDate,'Reservation.reservation_status <>'=>2)));
		if(!empty($reservationTaken)){
			return false;
		}else{
			return true;
		}
	}

	public function save_reservation_calendar(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		if( $_POST['reservation_date'] == '' ){
			$reservationDate = date('Y-m-d'); 
		}else{
			$reservationDate = $_POST['reservation_date'];
		}
		/**
		 * Validar si alguien más tomó la cita
		 */
		$reservationTaken = $this->reservationTaken($_POST['reservation_barber'],$_POST['reservation_time'],$reservationDate);
		if( $reservationTaken ){
		$this->Reservation->create();
		$data['Reservation']['reservation_date'] = $reservationDate;
		$data['Reservation']['reservation_time'] = $_POST['reservation_time'];
		$data['Reservation']['reservation_user'] = $_POST['reservation_client'];
		$data['Reservation']['reservation_service'] = $_POST['reservation_service'];
		$data['Reservation']['reservation_barber'] = $_POST['reservation_barber'];
		$data['Reservation']['creation_date'] = date('Y-m-d H:i:s');
		if($this->Reservation->save($data)){
			$this->Customer->query('delete from customers where user_id='.$_POST['reservation_client']);
			$this->Customer->create();
			$data['Customer']['last_appointment'] = $reservationDate;
			$data['Customer']['user_id'] = $_POST['reservation_client'];
			$data['Customer']['fecha_creacion'] = date('Y-m-d H:i:s');
			$this->Customer->save($data);
			Cache::clear();
			echo 1;
		}else{
			echo 0;
		}
		}else{
			Cache::clear();
			echo 4;
		}
	}
    

	 public function reservation_events(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$events= array();
		$reservations = Cache::read('reservationResponse'.$_SESSION['User']['User']['id']);
		if( !$reservations ){

			$this->reservations();
			$reservations = Cache::read('reservationResponse'.$_SESSION['User']['User']['id']);
			
		}
		foreach( $reservations as $reservation ){
			$reservationId = $reservation['Reservation']['id'];
			$reservationdate = $reservation['Reservation']['reservation_date'];
			$reservationtimeStart = $reservation['Reservation']['reservation_time'];
			
			$time= date('H:i:s',strtotime($reservationtimeStart));
			$duration = $reservation[0]['Duration']['duration'];
			$duration = strval($duration);
			$sumarTime = strtotime('+'.$duration.' minute',strtotime($time));
			$reservationtimeEnd= date('H:i:s',$sumarTime);
			
			$userId = $reservation['User']['id'];
			$userName = $reservation['User']['name'];
			$service = $reservation['Service']['service_name'];
			$barberName = $reservation['Barber']['name'];
			$barbercolor = $reservation['Barber']['color'];
			
			$event = array('groupId'=>$reservationId,'id'=>$service,'title'=>$userName,'start'=>$reservationdate.'T'.$reservationtimeStart,'end'=>$reservationdate.'T'.$reservationtimeEnd,'color'=>$barbercolor);
			array_push($events , $event);
		}
		echo json_encode($events);
	 }
	public function calendar(){
		$this->layout = 'ajax';
		$events= array();
		$reservations = Cache::read('reservationResponse'.$_SESSION['User']['User']['id']);
		if( !$reservations ){

			$this->reservations();
			$reservations = Cache::read('reservationResponse'.$_SESSION['User']['User']['id']);
			
		}
		foreach( $reservations as $reservation ){
			$reservationId = $reservation['Reservation']['id'];
			$reservationdate = $reservation['Reservation']['reservation_date'];
			$reservationtimeStart = $reservation['Reservation']['reservation_time'];
			
			$time= date('H:i:s',strtotime($reservationtimeStart));
			$duration = $reservation[0]['Duration']['duration'];
			$duration = strval($duration);
			$sumarTime = strtotime('+'.$duration.' minute',strtotime($time));
			$reservationtimeEnd= date('H:i:s',$sumarTime);
			
			$userId = $reservation['User']['id'];
			$userName = $reservation['User']['name'];
			$service = $reservation['Service']['service_name'];
			$barberName = $reservation['Barber']['name'];
			$barbercolor = $reservation['Barber']['color'];
			
			$event = array('groupId'=>$reservationId,'id'=>$service,'title'=>$userName,'start'=>$reservationdate.'T'.$reservationtimeStart,'end'=>$reservationdate.'T'.$reservationtimeEnd,'color'=>$barbercolor);
			array_push($events , $event);
		}
		$this->set('events',$events);
	}

	public function reservations(){
		$conditions['Reservation.reservation_status <>'] = 2;
		
		$reservations = $this->Reservation->find('all',array('fields'=>
																	array('Reservation.id','Reservation.reservation_status','Reservation.reservation_date','Reservation.reservation_time',
																		  'Service.id','Service.service_name','Service.price',
																		  'Barber.id','Barber.name','Barber.color',
																		  'User.id','User.name','User.phone',
																		  ),
															 'conditions'=>
																	array($conditions),
															 'joins' =>
															 array(
																 array(
																	 'table' => 'services',
																	 'alias' => 'Service',
																	 'type' => 'inner',
																	 'foreignKey' => false,
																	 'conditions'=> array('Service.id = Reservation.reservation_service'),
																 ),
																 array(
																	'table' => 'users',
																	'alias' => 'Barber',
																	'type' => 'inner',
																	'foreignKey' => false,
																	'conditions'=> array('Barber.id = Reservation.reservation_barber')
																),
																array(
																   'table' => 'users',
																   'alias' => 'User',
																   'type' => 'inner',
																   'foreignKey' => false,
																   'conditions'=> array('User.id = Reservation.reservation_user')
															   )          
																),
															 'order'=>array('Reservation.reservation_date'=>'ASC','Reservation.reservation_time'=>'ASC')
															));
		$reservationResponse = array();													
		foreach( $reservations as $reservation ){
			$duration = $this->Duration->find('first',array('fields'=>array('Duration.id','Duration.duration'),'conditions'=>array('Duration.barber'=>$reservation['Barber']['id'],'Duration.service_id'=>$reservation['Service']['id'])));
			array_push($reservation,$duration);
			array_push($reservationResponse,$reservation);
		}
		
		Cache::write('reservationResponse'.$_SESSION['User']['User']['id'], $reservationResponse);
		
	}
	public function customers(){
		$user = '';
		$customers = $this->Customer->find('all');
		$this->set('customers',$customers);
		$userCustomers = $this->User->find('all',array('conditions'=>array(
			'OR'=> array(
						array('User.type'=>3),
						)
					)
				)
			);
		
		$this->set('userCustomers',$userCustomers);
		if(isset($_SESSION['user'])){
			$user = $_SESSION['user'];
		}
		$this->set('user',$user);
	}

	
public function load_customer(){
	$this->autoRender = false;
	$this->layout = 'ajax';
	$idCustomer = $_POST['idCustomer'];
	//seria bueno agregar el barbero en customers, para saber quien fue el ultimo barbero que atendio a un cliente
	$customer = $this->User->find('all',array(
	'fields' => array('Customer.user_id','Customer.last_appointment','User.user_id','User.name','User.phone','User.status'),
	'conditions'=>array('.id'=>$idCustomer),
	'joins' =>
		array(
			array(
				'table' => 'customers',
				'alias' => 'Customer',
				'type' => 'inner',
				'foreignKey' => false,
				'conditions'=> array('User.id = Customer.user_id')
			)          
			),
	'recursive' => 2	
	));

	echo json_encode($customer);
}

public function add_customer(){
	$this->layout = 'ajax';
	if ($this->request->is('post')) {
		$this->User->create();
		$data['User']['name'] = $_POST['name'];
		$data['User']['phone'] = $_POST['phone'];
		$data['User']['type'] = 3;
		$data['User']['status'] = 1;
		$data['User']['creation_date'] = date('Y-m-d');
		if($this->User->save($data)){
		$userId = $this->User->getLastInsertID();
		$last_appointment = $_POST['last_appointment'];
		
			$this->Customer->create();
			$data['Customer']['last_appointment'] = $last_appointment;
			$data['Customer']['user_id'] = $userId;
			$this->Customer->save($data);

		$this->redirect(array('action' => '../customers'));
		}
	}
}

public function edit_customer(){
	$this->layout = 'ajax';
	if ($this->request->is('post')) {
		
		$this->User->id = $_POST['id_edit'];
		$data['User']['name'] = $_POST['name_edit'];
		$data['User']['phone'] = $_POST['phone_edit'];
		$data['User']['status'] = $_POST['status_edit'];
		$this->Customer->user_id = $_POST['id_edit'];
		$datac['Customer']['last_appointment'] = $_POST['last_appointment_edit'];
		if($this->Customer->save($datac)){
		
		$this->redirect(array('action' => '../customers'));
		}
	}
}

	function validateReservations($reservationUser){
		
		$activeReservations = $this->Reservation->find('all',array('conditions'=>array('Reservation.reservation_user'=>$reservationUser,'Reservation.reservation_status <>'=>2,'Reservation.reservation_date >= '=>date('Y-m-d'))));
		
		if( count($activeReservations) < 2 ){
			return true;
		}else{
			return false;
		}
	}

	function cancel_appointment(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$appointmentId = $_POST['reservation_id'];
		$appointmentId = $_POST['reservation_id'];
		$this->Reservation->id = $appointmentId;
		$data['Reservation']['reservation_status'] = 2;
		if($this->Reservation->save($data)){
			Cache::clear();
		}
		
	}

	function confirm_appointment(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$appointmentId = $_POST['reservation_id'];
		$this->Reservation->id = $appointmentId;
		$data['Reservation']['reservation_status'] = 1;
		if($this->Reservation->save($data)){
			Cache::clear();
		}
	}

	function load_appointment(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$appointmentId = $_POST['reservation_id'];
		$conditions['Reservation.id'] = $appointmentId;
		$conditions['Reservation.reservation_status <>'] = 2;
		$reservation = $this->Reservation->find('first',array('fields'=>
																	array('Reservation.id','Reservation.reservation_status','Reservation.reservation_date','Reservation.reservation_time',
																		  'Service.id','Service.service_name','Service.price',
																		  'Barber.id','Barber.name','Barber.color',
																		  ),
															 'conditions'=>
																	array($conditions),
															 'joins' =>
															 array(
																 array(
																	 'table' => 'services',
																	 'alias' => 'Service',
																	 'type' => 'inner',
																	 'foreignKey' => false,
																	 'conditions'=> array('Service.id = Reservation.reservation_service'),
																 ),
																array(
																   'table' => 'users',
																   'alias' => 'Barber',
																   'type' => 'inner',
																   'foreignKey' => false,
																   'conditions'=> array('Barber.id = Reservation.reservation_barber')
															   )          
																)
															));
		echo json_encode($reservation);
		
	}

	

}
